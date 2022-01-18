<?php
ob_start("ob_gzhandler");
session_start();
if(isset($_SESSION["userName"])){
include "./includes/template/init.php";
include "./connect.php";
styleFile("Dashboard.css");
$do = isset($_GET["do"]) ? $_GET["do"] : "Manage";
if($do=="Manage" ){
?>
<div class="container">
    <h3 class=" text-primary text-center m-4">Members</h3>
<div class="table-responsive">
    <table class="table table-bordered text-center">
        <tr class="bg-dark text-light">
            <td>#ID</td>
            <td>UserName</td>
            <td>Phone</td>
            <td>Email</td>
            <td>Full Name</td>
            <td>Reg. Date</td>
            <td>Options</td>
            <td>Comments</td>
        </tr>
        <?php
        if(isset($_GET["red"]) && $_GET["red"]== 1){
            $stmt=$con->prepare("SELECT * FROM login WHERE groupID != 1 AND redStatus = 1");
            $stmt->execute();
            $myData = $stmt->fetchAll();
        for($i=0; $i<count($myData); $i++){
            ?>
        <tr class=" op">
            <td><?php echo $myData[$i]['userID']; ?></td>
            <td><?php echo $myData[$i]["userName"]; ?></td>
            <td><?php echo $myData[$i]["Phone"]; ?></td>
            <td><?php echo $myData[$i]["email"]; ?></td>
            <td><?php echo $myData[$i]["fullName"]; ?></td>
            <td><?php echo $myData[$i]["Date"]; ?></td>
            <td class="p-0  bgBtn">

                    <?php if(!isset($_GET["I"]) || !is_numeric($_GET["I"])){?>
                <a href="?do=Edit&userID=<?php echo $myData[$i]["userID"]; ?>" class="btn btn-success mx-1"><i class="fa fa-edit mr-2"></i>Edit</a>
                <a href="?do=Manage&I=<?php echo $i; ?>" class="btn btn-danger m-2"><i class="fas fa-trash-alt mr-2"></i>Delete</a>
                <a href='?do=act&userID=<?php echo $myData[$i]["userID"]; ?>"' class='btn btn-primary m-2'><i class='far fa-star mr-2'></i>Active</a>
                <?php }else {?>
                <div class="per d-flex align-items-center justify-content-center align-items-center">
                    <div class="chi text-left p-3 bg-light">
                        <h4>Are You Sure That Delete UserName= <?php echo $myData[intval($_GET["I"])]["userName"]; ?> ?</h4>
                        <div>
                <a href="?do=Del&userID=<?php echo $myData[intval($_GET["I"])]["userID"]; ?>" class="btn btn-primary m-2">Delete</a>
                <a href="?do=Manage" class="btn btn-primary m-2">Cancel</a>
                        </div>
                    </div></div><?php } ?>
            </td>
            <td>
                <a href="comments.php?do=Manage&searchBy=member&element=<?php echo $myData[$i]["userName"];?>" class="btn btn-primary">Comments</a>
            </td>
        </tr>
    </table>
</div>

<a class="btn btn-primary" href="?do=Add">Add New Members<i class="fa fa-plus ml-2"></i></a>
</div>
        <?php } } else{
            $stmt=$con->prepare("SELECT * FROM login WHERE groupID != 1");
            $stmt->execute();
            $myData = $stmt->fetchAll();
        for($i=0; $i<count($myData); $i++){
            if(intval($myData[$i]["redStatus"])==1){
            ?>
        <tr class=" op">
            <?php } else{ echo "<tr>";} ?>
            <td><?php echo $myData[$i]['userID']; ?></td>
            <td><?php echo $myData[$i]["userName"]; ?></td>
            <td><?php echo $myData[$i]["Phone"]; ?></td>
            <td><?php echo $myData[$i]["email"]; ?></td>
            <td><?php echo $myData[$i]["fullName"]; ?></td>
            <td><?php echo $myData[$i]["Date"]; ?></td>
            <td class="p-0 bgBtn">
                    <?php if(!isset($_GET["I"]) || !is_numeric($_GET["I"])){?>
                <a href="?do=Edit&userID=<?php echo $myData[$i]["userID"]; ?>" class="btn btn-success mx-1"><i class="fa fa-edit mr-2"></i>Edit</a>
                <a href="?do=Manage&I=<?php echo $i; ?>" class="btn btn-danger m-2"><i class="fas fa-trash-alt mr-2"></i>Delete</a>
                <?php
                if( $myData[$i]["redStatus"]==1){
                echo "<a href='?do=act&userID= ".$myData[$i]['userID']."' class='btn btn-primary m-2'><i class='far fa-star mr-2'></i>Active</a>";}}else {?>
                
                <div class="per d-flex align-items-center justify-content-center align-items-center">
                    <div class="chi text-left p-3 bg-light">
                        <h4>Are You Sure That Delete UserName= <?php echo $myData[intval($_GET["I"])]["userName"]; ?> ?</h4>
                        <div>
                <a href="?do=Del&userID=<?php echo $myData[intval($_GET["I"])]["userID"]; ?>" class="btn btn-primary m-2">Delete</a>
                <a href="?do=Manage" class="btn btn-primary m-2">Cancel</a>
                        </div>
                    </div></div><?php  } ?>
            </td>
            <td>
                <a href="comments.php?do=Manage&searchBy=member&element=<?php echo $myData[$i]["userName"];?>" class="btn btn-primary">Comments</a>
            </td>
        </tr>
        <?php }?>
    </table>
</div>

<a class="btn btn-primary" href="?do=Add">Add New Members<i class="fa fa-plus ml-2"></i></a>
</div>
<?php }

}elseif($do=="act"){
if(isset($_GET["userID"]) && is_numeric($_GET["userID"])){
    $userID1 = intval($_GET["userID"]);
    $check = Check($con, "userID","login", $userID1);
    if(!$check){
    $stmt = $con->prepare("UPDATE login SET redStatus = 0 WHERE userID = :userID1");
    $stmt->execute(array('userID1'=>$userID1));
    Redirected("<div class='alert alert-success m-4'>You Activate User Success</div>",3, "members.php?do=Manage");
}else{
    Redirected("<div class='alert alert-danger m-4'>User Not Found</div>",3, "members.php?do=Manage");
}
}
}
elseif($do=="Del"){?>
    <h3 class=" text-primary text-center m-4">Delete Members</h3>
    <?php
$userID = isset($_GET["userID"]) && is_numeric($_GET["userID"]) ? intval($_GET["userID"]) : 0;
$stmt=$con->prepare("DELETE FROM login WHERE userID = :user AND groupID != 1");
$stmt->execute(array('user'=>$userID));
$count = $stmt->rowCount();
if($count==0){
    Redirected("<div class='alert alert-danger m-4'>User Not Found</div>",3, "members.php?do=Manage");
}else{
    Redirected("<div class='alert alert-success m-4'>You Delete User Success</div>",3, "members.php?do=Manage");
}
}
elseif($do=="Add"){
?>
<div class="container mt-5">
<form method="POST" action="?do=Insert" class="form-horizontal m-auto">
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <div class="control-lable col-sm-2"></div>
        <div class="col-sm-10 col-md-5">
    <h3 class="text-center text-primary">Add Members</h3>
    </div>
    </div>
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">userName</label>
        <div class="col-sm-10 col-md-5 myDivs">
        <input type="text" name="user" class="form-control" required="required" />
        <span class="asterisk mt-3">*</span>
    </div>
    </div>
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">Password</label>
        <div class="col-sm-10 col-md-5">
        <input type="password" minlength="8" name="pass" class="form-control myPass" autocomplete="new-password" />
        <span class="asterisk mt-3">*</span>
        <div class="icon">
        <i class="show-pass fa fa-eye"></i>
    </div>
    </div>
    </div>
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">Email</label>
        <div class="col-sm-10 col-md-5 myDivs">
        <input type="email" name="email" class="form-control"  required="required" />
        <span class="asterisk mt-3">*</span>
    </div>
    </div>
    
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">Full Name</label>
        <div class="col-sm-10 col-md-5 myDivs">
        <input type="text" name="full" class="form-control"  required="required" />
        <span class="asterisk mt-3">*</span>
    </div>
    </div>
    
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">Phone</label>
        <div class="col-sm-10 col-md-5 myDivs">
        <input type="text" name="phone" class="form-control"  required="required" />
        <span class="asterisk mt-3">*</span>
    </div>
    </div>
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <div class="col-sm-2"></div>
        <div class="col-sm-10 col-md-5">
        <input type="submit" value="Add Members" class="px-3 btn btn-primary addBtn"  required="required" />
    </div>
    </div>
</form>

</div>
<?php
}elseif($do=="Insert"){
    
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $user=$_POST['user'];
    $email=$_POST['email'];
    $full=$_POST['full'];
    $pass=$_POST['pass'];
    $Phone=$_POST['phone'];
    $arr = array();
    if(strlen($user)<4){
        $arr[] = "<div class='mx-4 alert alert-danger'>UserName Length Must Be More Than 4 Character</div>";
    }
    if(strlen($Phone) < 9 || !is_numeric( $Phone)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Phone Number Is Wrong</div>";
    }
    if(empty($Phone)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Phone Can't Be Empty</div>";
    }
    if(strlen($user)>21){
        $arr[] = "<div class='mx-4 alert alert-danger'>UserName Length Must Be Less Than 20 Character</div>";
    }
    if(empty($user)){
        $arr[] = "<div class='mx-4 alert alert-danger'>UserName Can't Be Empty</div>";
    }
    if(empty($email)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Email Can't Be Empty</div>";
    }
    if(empty($full)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Full Name Can't Be Empty</div>";
    }
    if(empty($pass)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Password Can't Be Empty</div>";
    }
    if(strlen($pass)<8){
        $arr[] = "<div class='mx-4 alert alert-danger'>Password Must Be More Than 8 Characters</div>";
    }
    if(!empty($arr)){
        $str = "<h3 class=' text-primary text-center mt-1 '>Update Members</h3>";
        foreach($arr as $items){
            $str .=  $items;
        }
        Redirected($str, 3, "members.php?do=Manage");
    }else{
        $state = Check($con, "userName", "login",$user);
        Insert($state, $con, $user, $email, $full, $pass, $Phone);
}
}else{
Redirected("<div class='alert alert-danger m-4'>You Can't Insert The Data</div>",3, "members.php?do=Manage");
}
}
elseif($do=="Edit"){
$id = isset($_GET['userID'])&&is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;
$stmt = $con->prepare("SELECT * FROM login WHERE userID = ? LIMIT 1");
$stmt->execute(array($id));
$row = $stmt->fetch();
$count = $stmt->rowCount();
if($count>0){
?>
<div class="container mt-5">
<form method="POST" action="?do=Update" class="form-horizontal m-auto">
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <div class="control-lable col-sm-2"></div>
        <div class="col-sm-10 col-md-5">
    <h3 class="text-center text-primary">Edit Members</h3>
    </div>
    </div>
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">userName</label>
        <div class="col-sm-10 col-md-5 myDivs">
        <input type="text" value="<?php echo $row['userName'] ?>" name="user" class="form-control" required="required" />
        <span class="asterisk mt-3">*</span>
    </div>
    </div>
        <input type="hidden" value="<?php echo $id?>" name="userID" />
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">Password</label>
        <div class="col-sm-10 col-md-5">
        <input type="password" name="pass" class="form-control myPass" autocomplete="new-password" />
        <input type="hidden" value="<?php echo $row['password'] ?>" name="oldPass" />
        <div class="icon">
        <i class="show-pass fa fa-eye"></i>
    </div>
    </div>
    </div>
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">Email</label>
        <div class="col-sm-10 col-md-5 myDivs">
        <input type="email" value="<?php echo $row['email'] ?>" name="email" class="form-control"  required="required" />
        <span class="asterisk mt-3">*</span>
    </div>
    </div>
    
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">Full Name</label>
        <div class="col-sm-10 col-md-5 myDivs">
        <input type="text" name="full" value="<?php echo $row['fullName'] ?>" class="form-control"  required="required" />
        <span class="asterisk mt-3">*</span>
    </div>
    </div>
    
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <label class="control-lable col-sm-2">Phone</label>
        <div class="col-sm-10 col-md-5 myDivs">
        <input type="text" name="phone" value="<?php echo $row['Phone'] ?>" class="form-control"  required="required" />
        <span class="asterisk mt-3">*</span>
    </div>
    </div>
    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
        <div class="col-sm-2"></div>
        <div class="col-sm-10 col-md-5">
        <input type="submit" value="Save" class="px-3 btn btn-primary"  required="required" />
    </div>
    </div>
</form>

</div>
<?php
}else{
    Redirected("<div class='alert alert-danger m-4'>Error User Not Found</div>",3, "members.php?do=Edit&userID=$id");
}
}elseif($do=="Update"){
if($_SERVER["REQUEST_METHOD"]=="POST"){
$id=$_POST['userID'];
$user=$_POST['user'];
$email=$_POST['email'];
$full=$_POST['full'];
$Phone=$_POST['phone'];
filter_var($id, FILTER_SANITIZE_STRING);
filter_var($user, FILTER_SANITIZE_STRING);
filter_var($email, FILTER_SANITIZE_STRING);
filter_var($full, FILTER_SANITIZE_STRING);
filter_var($Phone, FILTER_SANITIZE_STRING);
$arr = array();
if(strlen($user)<4){
    $arr[] = "<div class='alert alert-danger'>UserName Length Must Be More Than 4 Character</div>";
}
if(strlen($user)>21){
    $arr[] = "<div class='alert alert-danger'>UserName Length Must Be Less Than 20 Character</div>";
}
if(strlen($Phone)<9 || !is_numeric($Phone)){
    $arr[] = "<div class='alert alert-danger'>Phone Number Is Wrong</div>";
}
if(empty($user)){
    $arr[] = "<div class='alert alert-danger'>UserName Can't Be Empty</div>";
}
if(empty($email)){
    $arr[] = "<div class='alert alert-danger'>Email Can't Be Empty</div>";
}
if(empty($Phone)){
    $arr[] = "<div class='alert alert-danger'>Phone Can't Be Empty</div>";
}
if(empty($full)){
    $arr[] = "<div class='alert alert-danger'>Full Name Can't Be Empty</div>";
}
if(!empty($arr)){
    $str = "<h3 class=' text-primary text-center mt-1 '>Update Members</h3>";
    for($i=0 ;$i<count($arr);$i++){
        $str .= "<div class='alert alert-danger m-4'><?php echo $arr[$i]; ?></div>";
    }
    Redirected($str, 3, "members.php?do=Edit&userID=$id");
}else{
    $stmt = $con->prepare("SELECT * FROM login WHERE userID = :users");
    $stmt->execute(array('users' => $id));
    $count = $stmt->rowCount();
    $stmt1 = $con->prepare("SELECT * FROM login WHERE userName = :users AND userID != :userID");
    $stmt1->execute(array('users' => $user,
                            'userID' => $id
                            ));
    $count1 = count($stmt1->fetchAll());
    if($count==1&&$count1==0){
$pass=empty($_POST['pass']) ? $_POST['oldPass'] : sha1($_POST['pass']);
$stmt = $con->prepare("UPDATE login SET userName = ?, email = ?, fullName = ?, PASSWORD = ?, Phone = ? WHERE userID = ?");
$stmt->execute(array($user, $email, $full, $pass, $Phone, $id));
$count = $stmt->rowCount();
$str= "<div class='alert alert-success m-4'>You Update $count Records</div>";
    Redirected($str,3, "members.php?do=Edit&userID=$id");
}else{
    Redirected("<div class='alert alert-danger m-4'>You Can't Change The Data UserName</div>",3, "members.php?do=Edit&userID=$id");
}
}
}else{
Redirected("<div class='alert alert-danger m-4'>You Can't Change The Data</div>",3, "members.php?do=Edit&userID=$id");
}
}
include "./includes/template/footer.inc.php";
}else{
header("Location: index.php");
exit();
}
ob_end_flush();
?>