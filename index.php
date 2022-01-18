<?php
ob_start("ob_gzhandler");
    session_start();
    include "./includes/template/init.php";
    styleFile("index.css");
    if(isset($_GET["itemID"]) && is_numeric($_GET["itemID"]) && isset($_GET["do"]) && $_GET["do"]=="info"){
        $stmt = $con->prepare("SELECT *, items.Status AS itemStatus, comments.Date AS comDate from items
        LEFT JOIN comments
        ON  items.ID = comments.itemID 
        join login
        ON items.Member_ID = login.userID
        WHERE items.ID = ?");
        $stmt->execute(array($_GET["itemID"]));
        $rows = $stmt->fetchAll();

        
        $stmt1 = $con->prepare("SELECT *, comments.Date AS comDate from comments
        join login
        ON comments.MemberID = login.userID
        WHERE comments.itemID = ?
        ORDER BY ID DESC");
        $stmt1->execute(array($_GET["itemID"]));
        $rows1 = $stmt1->fetchAll();



        $stmt2 = $con->prepare("SELECT SUM(comments.Rating)/COUNT(comments.Rating) AS totalRating from items
        LEFT JOIN comments
        ON  items.ID = comments.itemID 
        WHERE items.ID = ? LIMIT 1");
        $stmt2->execute(array($_GET["itemID"]));
        $rows2 = $stmt2->fetchAll();
        $myImg = empty($item["Image"]) || $item["Image"] == "NULL" ? "./layout/images/Products/DefaultImg.svg" : $item["Image"] ; 
       ?>
        <div>
            <div class="d-flex Top">
                <div class="Left">
                <img src="<?php echo $myImg; ?>" />
                </div>
                <div class="Right px-3 py-1">
                    <p>
                    <span class="text-primary text-left">Product :- </span>
                    <span class="text-left"><?php echo $rows[0]["Name"] ?></span>
                    </p>
                    <p>
                    <span class="text-primary text-left">Description :- </span>
                    <span class="text-left"><?php echo $rows[0]["Description"] ?></span>
                    </p>
                    <p>
                    <span class="text-primary text-left">Price :- </span>
                    <span class="text-left"><?php echo $rows[0]["Price"] ?></span>
                    </p>
                    <p>
                    <span class="text-primary text-left">Country :- </span>
                    <span class="text-left"><?php echo $rows[0]["CountryMade"] ?></span>
                    </p>
                    <p>
                    <span class="text-primary text-left">Status :- </span>
                    <span class="text-left"><?php echo $rows[0]["itemStatus"] ?></span>
                    </p>
                    <p>
                    <span class="text-primary text-left">Member :- </span>
                    <span class="text-left"><?php echo $rows[0]["userName"] ?></span>
                    </p>
                    <p>
                    <span class="text-primary text-left">Phone :- </span>
                    <span class="text-left"><?php echo $rows[0]["Phone"] ?></span>
                    </p>
                    <?php
                    
    for($i=0; $i<5; $i++){
        if(is_numeric($rows2[0]["totalRating"]) ){
            if(intval($rows2[0]["totalRating"]) > $i){
                echo "<i class='fas fa-star text-warning'></i>";
            }
            else{
                echo "<i class='far fa-star text-warning'></i>";
            }
        }else{
            echo "<i class='far fa-star text-warning'></i>";
        }
        }
                    ?>
                </div>
            </div>
            <div class="Divs p-2">
            <div class="container">
            <div class="comments">
            <h4 class="text-center">Comments</h4>
                <?php
                if(empty($rows1)){
                    echo "
                    <div class='comment p-2 m-3'><h4 class='text-center text-info p-5'>There Is No Comment</h4></div>";
                }
                foreach($rows1 as $row){
                    $userImg =empty($row["userImg"])? "<i class='fas fa-user mx-2'></i>" : "<img class = 'mx-2 userImg' src='". $row["userImg"]."' />";
                    ?>
            <div class="comment p-2 m-3">
                <?php echo $userImg; ?>
                    <span class="text-primary"><?php echo $row["userName"] . " :- "; ?></span>
                    <span><?php echo $row["Comment"]; ?></span>
                    <div class="d-flex justify-content-between align-items-end">
        <span class="text-muted mx-5 my-2">
        <?php echo $row["comDate"]; ?>
        </span>
        <span><?php
    for($i=0; $i<5; $i++){
        if(is_numeric($row["Rating"]) ){
            if(intval($row["Rating"]) > $i){
                echo "<i class='fas fa-star text-warning'></i>";
            }
            else{
                echo "<i class='far fa-star text-warning'></i>";
            }
        }else{
            echo "<i class='far fa-star text-warning'></i>";
        }
        }
        ?>
        </span>
                    </div>
            </div>
                    <?php
                }
                ?>
            </div>
        </div></div></div>
        <?php
    } else{
    $items = isset($_GET["userName"])? GetItems("items.*, login.Phone, login.userName", "items 
    JOIN login 
    ON login.userID = items.Member_ID WHERE Name LIKE ?","AddDate", array('%'.$_GET["userName"].'%')) :
     GetItems("items.*, login.Phone, login.userName", "items 
     JOIN login 
     ON login.userID = items.Member_ID WHERE 1 = ?","AddDate", array(1));
    if(!empty($items)){
        ?>
        <div class="container">
    <h3 class=" text-primary text-center m-4">Products</h3>
        <form action="index.php" method="GET">
        <div class="d-flex justify-content-center align-items-center">
        <div class="formSearch input-group  align-items-end">    
        <input type="text" name = "userName" class="form-control" placeholder="Search About Member">
        <input type="submit" value="Search" class="btn btn-outline-primary py-2 px-3 ml-3" placeholder="Search">
        </div></div>
        </form>
            <div class="rows d-flex justify-content-start align-items-start">
            <?php
            foreach($items as $item){
                $myImg = empty($item["Image"]) || $item["Image"] == "NULL" ? "./layout/images/Products/DefaultImg.svg" : $item["Image"] ; 
                $Rating = GetItems("SUM(comments.Rating)/COUNT(comments.Rating) AS totalRating",
                "items LEFT JOIN comments ON items.ID = comments.itemID
                 WHERE comments.itemID = ? "
                 ,"items.Name", array(intval($item["ID"])))[0]["totalRating"];
          ?>
          <div class="col-sm-4 col-md-6 col-lg-4 ">
          <a class="linkCard" href="?do=info&itemID=<?php echo $item["ID"] ?>">
          <div class="py-4 px-2">
<div class="card">
  <img src="<?php echo $myImg; ?>" class="card-img-top" alt="Product">
  <div class="card-body">
    <h5 class="card-title"><?php echo $item["Name"]; ?></h5>
    <p class="card-text"><?php echo $item["Description"] ?></p>
    <p class="card-text"><?php echo "<div class='text-center'><span class='text-primary'>Member :- "
    ."</span>".$item["userName"]."</div>" ?></p>
    <p class="card-text text-center"><?php echo "<div class = 'd-flex justify-content-between align-items-center'>
    <div><span class='text-primary'>Price :</span> ".$item["Price"]."$</div>" 
    ."<div><span class='text-primary'>Phone :- </span>".$item["Phone"]."</div></div>"; ?></p>
    <p class="card-text d-flex align-items-center justify-content-between">
        <small class="text-muted borderL"><?php echo "Made In ".$item["CountryMade"] ?></small>
        <small class="text-muted borderL"><?php echo "Status : ".$item["Status"]?></small>
    <small class="text-muted"><?php echo "Date :  ".$item["AddDate"] ?></small></p>
   <?php 
   for($i=0; $i<5; $i++){
       if(is_numeric($Rating) ){
           if(intval($Rating) > $i){
               echo "<i class='fas fa-star text-warning'></i>";
           }
           else{
               echo "<i class='far fa-star text-warning'></i>";
           }
       }else{
           echo "<i class='far fa-star text-warning'></i>";
       }
       }
   ?>
  </div>
</div></div>
          </a>
          </div>
            <?php
            }
            ?>
</div>
        </div>
<?php
    }
    }
include "./includes/template/footer.inc.php";
ob_end_flush();
?>