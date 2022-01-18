<?php
ob_start("ob_gzhandler");
    session_start();
    include "./includes/template/init.php";
    styleFile("categories.css");
if(isset($_GET["CatID"]) && is_numeric($_GET["CatID"])){
    $items = GetItems("*, items.ID AS itemsID, items.Name AS itemsName, items.Description AS itemsDes", "items LEFT JOIN categories ON items.Cat_ID = categories.ID
    LEFT JOIN login ON login.userID = items.Member_ID
     WHERE categories.ID = ? ","items.Name", array(intval($_GET["CatID"])));
    

    if(!empty($items)){
        ?>
        <div class="container">
            <div class="row">
            <?php
            foreach($items as $item){
                $stmt2 = $con->prepare("SELECT SUM(comments.Rating)/COUNT(comments.Rating) AS totalRating from items
                LEFT JOIN comments
                ON  items.ID = comments.itemID 
                WHERE items.ID = ? LIMIT 1");
                $stmt2->execute(array($item["itemsID"]));
                $rows2 = $stmt2->fetchAll();
                $myImg = empty($item["Image"]) || $item["Image"] == "NULL" ? "./layout/images/Products/DefaultImg.svg" : $item["Image"] ; 

          ?>
           <div class="col-sm-4 col-md-6 col-lg-4 ">
           <a class="linkCard" href="index.php?do=info&itemID=<?php echo $item["itemsID"] ?>">
           <div class="py-4 px-2"> <div class="card">
   <img src="<?php echo $myImg; ?>" class="card-img-top" alt="Product">
   <div class="card-body">
     <h5 class="card-title"><?php echo $item["itemsName"]; ?></h5>
     <p class="card-text"><?php echo $item["itemsDes"] ?></p>
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
   </div>
 </div>
           </a>
            <?php
            }
            ?></div>
           </div>
        <?php
    }else{
        Redirected("<div class = 'alert alert-danger m-4'>Category Is Empty</div>", 3);
    }
}else{
    Redirected("<div class = 'alert alert-danger m-4'>Category Is Not Found</div>", 3);
}

include "./includes/template/footer.inc.php";
ob_end_flush();
?>