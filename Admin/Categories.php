<?php
ob_start("ob_gzhandler");
session_start();
if(isset($_SESSION["userName"])){
    include "./includes/template/init.php";
    styleFile("Categories.css");
    $do = isset($_GET["do"]) ? $_GET["do"] : "Manage";

    if($do=="Manage" ){
        ?>
        <div class="container">
            <h3 class=" text-primary text-center m-4">Categories</h3>
            <div class="m-2 mb-4 d-flex align-items-center justify-content-center">
                <?php
                if(isset($_GET["order"]) && $_GET["order"]=="DESC"){
                 echo "<a href='?do=Manage&order=ASC' class='btn order btn-primary ml-4'>Change Order</a></div>";
                }else{
                    echo "<a href='?do=Manage&order=DESC' class='btn order btn-primary ml-4'>Change Order</a></div>";
                }
            ?>
        <div class="table-responsive">
        <table class="table table-bordered text-center">
            <tr class="bg-dark text-light">
                <td>#ID</td>
                <td>Categories Name</td>
                <td>Description</td>
                <td>Ord.</td>
                <td>Vesible</td>
                <td>Allow Comment</td>
                <td>Allow Ads</td>
                <td>Options</td>
            </tr>
            <?php
                $ord =isset($_GET["order"]) && $_GET["order"]=="DESC" ?"DESC" : "ASC";
                $stmt=$con->prepare("SELECT * FROM categories ORDER BY orderring $ord");
                $stmt->execute();
                $myData = $stmt->fetchAll();
            for($i=0; $i<count($myData); $i++){
                    ?><tr>
                <td><?php echo $myData[$i]["ID"]; ?></td>
                <td><?php echo $myData[$i]["Name"]; ?></td>
                <td><?php echo $myData[$i]["Description"]; ?></td>
                <td><?php echo $myData[$i]["Orderring"]; ?></td>
                <td><?php echo intval($myData[$i]["Vesibility"]) == 1 ? "Yes": "No" ;?></td>
                <td><?php echo intval($myData[$i]["AllowComments"]) == 1 ? "Yes": "No" ;?></td>
                <td><?php echo intval($myData[$i]["AllowAds"]) == 1 ? "Yes": "No" ;?></td>
                <td class="p-0 bgBtn">
                    <?php if(!isset($_GET["I"]) || !is_numeric($_GET["I"])){?>
                    <a href="?do=Edit&ID=<?php echo $myData[$i]["ID"]; ?>" class="btn btn-success mx-1"><i class="fa fa-edit mr-2"></i>Edit</a>
                    <a href="?do=Manage&I=<?php echo $i; ?>" class="btn btn-danger m-2"><i class="fas fa-trash-alt mr-2"></i>Delete</a>
                    <?php }else {?>
                    <div class="per d-flex justify-content-center align-items-center">
                        <div class="chi text-left p-3 bg-light">
                            <h4>Are You Sure That Delete Category Name = <?php echo $myData[intval($_GET["I"])]["Name"]; ?> ?</h4>
                            <div>
                    <a href="?do=Del&ID=<?php echo $myData[intval($_GET["I"])]["ID"]; ?>" class="btn btn-primary m-2">Delete</a>
                    <a href="?do=Manage" class="btn btn-primary m-2">Cancel</a>
                            </div>
                        </div></div><?php } ?>
                    </td>
                </tr>
                <?php }?>
            </table>
        </div>
        
        <a class="btn btn-primary" href="?do=Add">Add New Categories<i class="fa fa-plus ml-2"></i></a>
    </div>
        <?php }
    elseif($do=="Del"){?>
            <h3 class=" text-primary text-center m-4">Delete Categories</h3>
            <?php
        $ID = isset($_GET["ID"]) && is_numeric($_GET["ID"]) ? intval($_GET["ID"]) : 0;
        $stmt=$con->prepare("DELETE FROM categories WHERE ID = :user");
        $stmt->execute(array('user'=>$ID));
        $count = $stmt->rowCount();
        if($count==0){
            Redirected("<div class='alert alert-danger m-4'>Category Not Found</div>",3, "Categories.php?do=Manage");
        }else{
            Redirected("<div class='alert alert-success m-4'>You Delete Category Success</div>",3, "Categories.php?do=Manage");
        }
    }
    elseif($do=="Add"){
        ?>
        <div class="container mt-5">
        <form method="POST" action="?do=Insert" class="form-horizontal m-auto">
            <div class="form-group form-group-lg d-flex justify-content-center align-items-center mt-4">
                <div class="control-lable col-sm-2"></div>
                <div class="col-sm-10 col-md-5">
            <h3 class=" text-primary text-center">Add Categories</h3>
            </div>
            </div>
            <div class="form-group form-group-lg d-flex justify-content-center align-items-center mt-4">
                <label class="control-lable col-sm-2">Category Name</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="text" name="Name" class="form-control" required="required" />
                <span class="asterisk mt-3">*</span>
            </div>
            </div>
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-4">
                <label class="control-lable col-sm-2">Description</label>
                <div class="col-sm-10 col-md-5">
                <input type="text" name="Description" class="form-control" />
            </div>
            </div>
            <div class="form-group form-group-lg d-flex justify-content-center mt-4">
                <label class="control-lable col-sm-2">ordering</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="number" name="Orderring" class="form-control" />
           </div>
            </div>
            
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-3">
                <label class="control-lable col-sm-2">Visible</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="radio" value="1" name="Vesibility" id="y" class=""  required="required" checked/> 
                <label for="y">Yes</label>
                <input value="0" id="n" type="radio" name="Vesibility" class="ml-4"  required="required" /> 
                <label for="n">No</label>
           </div>
            </div>
            
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-3">
                <label class="control-lable col-sm-2">Allow Commenting</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="radio" value="1" name="AllowComments" id="cy" class=""  required="required" checked/> 
                <label for="cy">Yes</label>
                <input value="0" id="cn" type="radio" name="AllowComments" class="ml-4"  required="required" /> 
                <label for="cn">No</label>
           </div>
            </div>
            
            <div class="form-group form-group-lg d-flex justify-content-center mt-3">
                <label class="control-lable col-sm-2">Allow Ads</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="radio" value="1" name="AllowAds" id="ay" class=""  required="required" checked/> 
                <label for="ay">Yes</label>
                <input value="0" id="an" type="radio" name="AllowAds" class="ml-4"  required="required" /> 
                <label for="an">No</label>
           </div>
            </div>


            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-4">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 col-md-5">
                <input type="submit" value="Add Categories" class="px-3 btn btn-primary addBtn"  required="required" />
            </div>
            </div>
        </form>

        </div>
        <?php
    }elseif($do=="Insert"){
         
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $name=$_POST['Name'];
            $des=$_POST['Description'];
            $order=$_POST['Orderring'];
            $vesibile=$_POST['Vesibility'];
            $comment=$_POST['AllowComments'];
            $ads=$_POST['AllowAds'];
            filter_var($name, FILTER_SANITIZE_STRING);
            filter_var($des, FILTER_SANITIZE_STRING);
            filter_var($order, FILTER_SANITIZE_STRING);
            filter_var($vesibile, FILTER_SANITIZE_STRING);
            filter_var($comment, FILTER_SANITIZE_STRING);
            filter_var($ads, FILTER_SANITIZE_STRING);
            $des = empty($des) ? null : $des;
            $order = empty($order) ? null : $order;
            if(empty($name)){
                $str = "<h3 class='text-primary text-center mt-4 '>Update Categories</h3><div class='alert m-4 alert-danger'>Category Can't Be Empty</div>";
                Redirected($str, 3, "Categories.php?do=Manage");
            }else{
                $state = Check($con, "Name", "categories",$name);
                if($state){
                $stmt = $con->prepare("INSERT INTO categories(Name, Description, Orderring, Vesibility, AllowComments, AllowAds) VALUES (:name, :des, :ord, :ves, :comment, :ads)");
                $stmt->execute(array(
                    'name' => $name,
                    'des' => $des,
                    'ord' => $order,
                    'ves' => $vesibile,
                    'comment' => $comment,
                    'ads' => $ads
                ));
                    Redirected("<div class='alert alert-success m-4'>You Insert 1 Records</div>",3, "Categories.php?do=Manage");
                 
                }else{
                    Redirected("<div class='alert alert-danger m-4'>You Can't Insert Categories Name Categories Name Is recorded Please Change Categories Name</div>",3, "Categories.php?do=Manage");
                }
        }
    }else{
        Redirected("<div class='alert alert-danger m-4'>You Can't Insert The Data</div>",3, "Categories.php?do=Manage");
    }
    }
    elseif($do=="Edit"){
        $id = isset($_GET['ID'])&&is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ? LIMIT 1");
        $stmt->execute(array($id));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count>0){
        ?>
        <div class="container mt-5">
        <form method="POST" action="?do=Update" class="form-horizontal m-auto">
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-4">
                <div class="control-lable col-sm-2"></div>
                <div class="col-sm-10 col-md-5">
            <h3 class=" text-primary text-center">Edit Categories</h3>
            </div>
            </div>
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-4">
                <label class="control-lable col-sm-2">Category Name</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="hidden" value="<?php echo $row["ID"] ?>" name="ID" />
                <input type="text" value="<?php echo $row["Name"] ?>" name="Name" class="form-control" required="required" />
                <span class="asterisk mt-3">*</span>
            </div>
            </div>
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-4">
                <label class="control-lable col-sm-2">Description</label>
                <div class="col-sm-10 col-md-5">
                <input type="text" name="Description" value="<?php echo $row["Description"] ?>" class="form-control"  />
            </div>
            </div>
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-4">
                <label class="control-lable col-sm-2">ordering</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="number" value="<?php echo $row["Orderring"] ?>" name="Orderring" class="form-control" />
           </div>
            </div>
            
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-3">
                <label class="control-lable col-sm-2">Visible</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <?php if($row["Vesibility"]==1){?>
                <input type="radio" value="1" name="Vesibility" id="y" class=""  required="required" checked /> 
                <label for="y">Yes</label>
                <input value="0" id="n" type="radio" name="Vesibility" class="ml-4"  required="required" /> 
                <label for="n">No</label>
                <?php }else{?>
                <input type="radio" value="1" name="Vesibility" id="y" class=""  required="required" /> 
                <label for="y">Yes</label>
                <input value="0" id="n" type="radio" name="Vesibility" class="ml-4"  required="required" checked /> 
                <label for="n">No</label>
                <?php } ?>
           </div>
            </div>
            
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-3">
                <label class="control-lable col-sm-2">Allow Commenting</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <?php if($row["Vesibility"]==1){?>
                <input type="radio" value="1" name="AllowComments" id="cy" class=""  required="required" checked/> 
                <label for="cy">Yes</label>
                <input value="0" id="cn" type="radio" name="AllowComments" class="ml-4"  required="required" /> 
                <label for="cn">No</label>
                <?php }else{?>
                <input type="radio" value="1" name="AllowComments" id="cy" class=""  required="required"/> 
                <label for="cy">Yes</label>
                <input value="0" id="cn" type="radio" name="AllowComments" class="ml-4"  required="required" checked/> 
                <label for="cn">No</label>
                <?php } ?>
           </div>
            </div>
            
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-3">
                <label class="control-lable col-sm-2">Allow Ads</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <?php if($row["Vesibility"]==1){?>
                <input type="radio" value="1" name="AllowAds" id="ay" class=""  required="required" checked/> 
                <label for="ay">Yes</label>
                <input value="0" id="an" type="radio" name="AllowAds" class="ml-4"  required="required" /> 
                <label for="an">No</label>
                <?php }else{?>
                <input type="radio" value="1" name="AllowAds" id="ay" class=""  required="required" /> 
                <label for="ay">Yes</label>
                <input value="0" id="an" type="radio" name="AllowAds" class="ml-4"  required="required" checked/> 
                <label for="an">No</label>
                <?php } ?>
           </div>
            </div>


            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-4">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 col-md-5">
                <input type="submit" value="Update Categories" class="px-3 btn btn-primary addBtn" />
            </div>
            </div>
        </form>

        </div>
        <?php
        }else{
            Redirected("<div class='alert alert-danger m-4'>Error Category Not Found</div>",3, "categories.php?do=Manage");
        }
    }elseif($do=="Update"){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
        $id=$_POST['ID'];
        $name=$_POST['Name'];
        $des=$_POST['Description'];
        $order=$_POST['Orderring'];
        $ves=$_POST['Vesibility'];
        $comment=$_POST['AllowComments'];
        $ads=$_POST['AllowAds'];
        $arr = array();
        filter_var($id, FILTER_SANITIZE_STRING);
        filter_var($name, FILTER_SANITIZE_STRING);
        filter_var($des, FILTER_SANITIZE_STRING);
        filter_var($order, FILTER_SANITIZE_STRING);
        filter_var($ves, FILTER_SANITIZE_STRING);
        filter_var($comment, FILTER_SANITIZE_STRING);
        filter_var($ads, FILTER_SANITIZE_STRING);
        if(empty($name)){
            $arr[] = "Category Name Can't Be Empty";
        }
        if(!empty($arr)){
           $str = "<h3 class='text-primary text-center mt-4 '>Update Category</h3>";
            for($i=0 ;$i<count($arr);$i++){
               $str += "<div class='alert alert-danger m-4'><?php echo $arr[$i]; ?></div>";
            }
            Redirected($str, 3, "Categories.php?do=Edit&ID=$id");
        }else{
            $stmt = $con->prepare("SELECT * FROM categories WHERE ID = :id");
            $stmt->execute(array('id' => $id));
            $count = $stmt->rowCount();
            $stmt1 = $con->prepare("SELECT * FROM categories WHERE Name = :Name AND ID != :ID");
            $stmt1->execute(array('Name' => $name,
                                    'ID' => $id
                                   ));
            $count1 = count($stmt1->fetchAll());
            if($count==1&&$count1==0){
                $order = is_numeric($order) && !empty($order) ? $order : null;
                $des = empty($des) ? null : $des;
        $stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ?, Orderring = ?, Vesibility = ?, AllowComments = ?, AllowAds = ? WHERE ID = ?");
        $stmt->execute(array($name, $des, $order, $ves, $comment, $ads, $id));
        $count = $stmt->rowCount();
         $str= "<div class='alert alert-success m-4'>You Update $count Records</div>";
         Redirected($str,3, "Categories.php?do=Edit&ID=$id");
        }else{
            Redirected("<div class='alert alert-danger m-4'>You Can't Change The Data Category Name</div>",3, "Categories.php?do=Edit&ID=$id");
        }
    }
}else{
    Redirected("<div class='alert alert-danger m-4'>You Can't Change The Data</div>",3, "Categories.php?do=Edit&ID=$id");
}
    }
    include "./includes/template/footer.inc.php";
}else{
    header("Location: index.php");
    exit();
}
ob_end_flush();
?>