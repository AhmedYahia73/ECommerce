<?php
ob_start("ob_gzhandler");
session_start();
if(isset($_SESSION['userName'])){
    include "./includes/template/init.php";
    styleFile("comments.css");
    $do = isset($_GET["do"])? $_GET["do"] : "?do=Manage";
    if($do == "Manage" || $do == ""){
        ?>
        <div class="container">

        <h3 class=" text-primary text-center m-4">Manage Comments</h3>
        <div class=" d-flex align-items-center justify-content-center">
    <form method="GET">
<div class="input-group align-items-end mb-4">
  <input type="text" name = "element" class="form-control" placeholder="Search">
  <input type="hidden" name="do" value="Manage">
  <div class="input-group-append mx-2">
    <select name="searchBy" class="btn btn-outline-dark p-2">
    <option class="btn-light" value="member">Search By</option>
    <option class="btn-light" value="member">Member</option>
    <option class="btn-light" value="item">Item</option>
    </select>
  </div>  
  <input type="submit" value="Search" class="btn btn-outline-primary p-2 px-4" placeholder="Search">
</div>
    </form></div>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tr class="bg-dark text-light">
                    <td>#ID</td>
                    <td>Member</td>
                    <td>Items</td>
                    <td>Comment</td>
                    <td>Date</td>
                    <td>Options</td>
                </tr>
                <?php
                if(isset($_GET["searchBy"]) && $_GET["searchBy"] == "member"){
                    filter_var($_GET["element"], FILTER_SANITIZE_STRING);
                    filter_var($_GET["searchBy"], FILTER_SANITIZE_STRING);
                    $stmt=$con->prepare("SELECT comments.*, items.Name AS Item_Name, login.userName AS Member_Name 
                    FROM comments 
                    JOIN login 
                    ON comments.MemberID = login.userID 
                    JOIN items 
                    ON comments.itemID = items.ID WHERE login.userName LIKE ? ORDER BY comments.Status");
                    $stmt->execute(array('%'.$_GET["element"].'%'));
                }elseif(isset($_GET["searchBy"]) && $_GET["searchBy"] == "item"){
                    $stmt=$con->prepare("SELECT comments.*, items.Name AS Item_Name, login.userName AS Member_Name 
                    FROM comments 
                    JOIN login 
                    ON comments.MemberID = login.userID 
                    JOIN items 
                    ON comments.itemID = items.ID WHERE items.Name LIKE ?  ORDER BY comments.Status");
                    $stmt->execute(array('%'.$_GET["element"].'%'));
                }else{
                    $stmt=$con->prepare("SELECT comments.*, items.Name AS Item_Name, login.userName AS Member_Name 
                    FROM comments 
                    JOIN login 
                    ON comments.MemberID = login.userID 
                    JOIN items 
                    ON comments.itemID = items.ID ORDER BY comments.Status");
                    $stmt->execute();
                }
                    $myData = $stmt->fetchAll();
                for($i=0; $i<count($myData); $i++){
                    ?>
                <tr class=" op">
                    <td><?php echo $myData[$i]['ID']; ?></td>
                    <td><?php echo $myData[$i]["Member_Name"]; ?></td>
                    <td><?php echo $myData[$i]["Item_Name"]; ?></td>
                    <td class="px-1"><?php echo $myData[$i]["Comment"]; ?></td>
                    <td><?php echo $myData[$i]["Date"]; ?></td>
                    <td class="p-0  bgBtn">
                        <div class="text-center">
                            <?php if($myData[$i]["Status"] == 0){?>
                                <a href="?do=Approve&ID=<?php echo intval($myData[$i]['ID']); ?>" class='btn m-1 btn-primary '><i class='far fa-star mr-2'></i>Approve</a></div>
                        <?php }else {?>
                        
                            <a href="?do=Hide&ID=<?php echo intval($myData[$i]['ID']); ?>" class='m-1 btn btn-secondary '><i class='fas fa-minus-circle mr-2'></i>Hide</a></div>
                            <?php } ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        
    </div>
    <?php 
    }
     else if($do == "Approve"){

        $ID = isset($_GET["ID"]) && is_numeric($_GET["ID"]) ? intval($_GET["ID"]) : 0;
        if($ID ==0){
            Redirected("<div class='alert alert-danger m-4'>ID Is Wrong</div>", 3, "comments.php?do=Manage");
        }else{
        $stmt = $con->prepare("UPDATE comments SET Status = 1 WHERE ID = ?");
        $stmt->execute(array($ID));
        Redirected("<div class='alert alert-success m-4'>You Approve Comment Success</div>", 3, "comments.php?do=Manage");
    }}
    else if($do == "Hide"){
        $ID = isset($_GET["ID"]) && is_numeric($_GET["ID"]) ? intval($_GET["ID"]) : 0;
        if($ID ==0){
            Redirected("<div class='alert alert-danger m-4'>ID Is Wrong</div>", 3, "comments.php?do=Manage");
        }else{
        $stmt = $con->prepare("UPDATE comments SET Status = 0 WHERE ID = ?");
        $stmt->execute(array($ID));
        Redirected("<div class='alert alert-success m-4'>You Hide Comment Success</div>", 3, "comments.php?do=Manage");
    }
}else{
    Redirected("<div class='alert alert-danger m-4'>Comment Is Wrong</div>", 3, "comments.php?do=Manage");
}

}else{
    Redirected("<div class='alert alert-danger m-4'>You Must Login</div>", 3);
}



include "./includes/template/footer.inc.php";
ob_end_flush();
?>