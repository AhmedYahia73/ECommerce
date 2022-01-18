<?php
ob_start("ob_gzhandler");
session_start();
if(isset($_SESSION["userName"])){
    include "./includes/template/init.php";
    styleFile("items.css");
    $do = isset($_GET["do"])? $_GET["do"] : "?do=Manage";
    if($do == "Manage"){
        ?>
        <div class="container">
            <h3 class=" text-primary text-center m-4">Manage Items</h3>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <tr class="bg-dark text-light">
                    <td>#ID</td>
                    <td>Name</td>
                    <td>Description</td>
                    <td>Price</td>
                    <td>Adding Date</td>
                    <td>Category</td>
                    <td>Member</td>
                    <td>Options</td>
                    <td>Comments</td>
                </tr>
                <?php
                    $stmt=$con->prepare("SELECT items.*,
                    categories.Name AS Cat_Name, login.userName AS Member_Name
                    FROM items 
                    JOIN categories ON items.Cat_ID = categories.ID 
                    JOIN login ON items.Member_ID = login.userID");
                    $stmt->execute();
                    $myData = $stmt->fetchAll();
                for($i=0; $i<count($myData); $i++){
                    ?>
                <tr class=" op">
                    <td><?php echo $myData[$i]['ID']; ?></td>
                    <td><?php echo $myData[$i]["Name"]; ?></td>
                    <td><?php echo $myData[$i]["Description"]; ?></td>
                    <td><?php echo $myData[$i]["Price"]; ?></td>
                    <td><?php echo $myData[$i]["AddDate"]; ?></td>
                    <td><?php echo $myData[$i]["Cat_Name"]; ?></td>
                    <td><?php echo $myData[$i]["Member_Name"]; ?></td>
                    <td class="p-0  bgBtn">
                        <div class="text-left">
                            <?php if(!isset($_GET["I"]) || !is_numeric($_GET["I"])){?>
                        <a href="?do=Edit&ID=<?php echo $myData[$i]["ID"]; ?>" class="btn btn-success mx-1"><i class="fa fa-edit mr-1"></i>Edit</a>
                        <a href="?do=Manage&I=<?php echo $i; ?>" class="btn btn-danger m-1"><i class="fas fa-trash-alt mr-1"></i>Delete</a>
                        <?php if(intval($myData[$i]['Approve']) == 0 ){
                            echo "<a href='?do=Approve&ID=".intval($myData[$i]['ID'])."' class='btn my-2 approveBtn btn-primary '>
                            <i class='far fa-star mr-1'></i>Approve</a></div>" ;}
                            
                         }else {?>
                         </div>
                        <div class="per d-flex align-items-center justify-content-center align-items-center">
                            <div class="chi text-left text-left p-3 bg-light">
                                <h4>Are You Sure That Delete Item = <?php echo $myData[intval($_GET["I"])]["Name"]; ?> ?</h4>
                                <div>
                        <a href="?do=Del&ID=<?php echo $myData[intval($_GET["I"])]["ID"]; ?>" class="btn btn-primary m-2">Delete</a>
                        <a href="?do=Manage" class="btn btn-primary m-2">Cancel</a>
                                </div>
                            </div></div><?php } ?>
                    </td>
                    <td class="p-0  bgBtn">
                        <a href="comments.php?do=Manage&searchBy=item&element=<?php echo $myData[$i]["Name"];?>" class="btn showBtn m-2 btn-primary"><i class="fas fa-comments mx-1"></i>Comments</a>
                    </td>
                </tr>
                <?php } ?>
            </table>
        </div>
        
        <a class="btn btn-primary" href="?do=Add">Add New Item<i class="fa fa-plus ml-2"></i></a>
    </div>
    <?php }
    elseif($do == "Add"){
        ?>
<div class="container mt-5">
        <form method="POST" action="?do=Insert" class="form-horizontal m-auto">
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <div class="control-lable col-sm-2"></div>
                <div class="col-sm-10 col-md-5">
            <h3 class="text-center text-primary">Add New Items</h3>
            </div>
            </div>
            <!--Start Feild-->
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <label class="control-lable col-sm-2">Name</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="text" name="Name" class="form-control" required="required" />
                <span class="asterisk mt-3">*</span>
            </div>
            </div>
            <!--Start Feild-->
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <label class="control-lable col-sm-2">Description</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="text" name="Description" class="form-control" required="required" />
                <span class="asterisk mt-3">*</span>
            </div>
            </div>
            <!--Start Feild-->
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <label class="control-lable col-sm-2">Price</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="text" name="Price" class="form-control" required="required" />
                <span class="asterisk mt-3">*</span>
            </div>
            </div>
            <!--Start Feild-->
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <label class="control-lable col-sm-2">Country</label>
                <div class="col-sm-10 col-md-5 myDivs">
                <input type="text" name="Country" class="form-control" required="required" />
                <span class="asterisk mt-3">*</span>
            </div>
            </div>
            <!--Start Feild-->
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <label class="control-lable col-sm-2">Status</label>
                <div class="col-sm-10 col-md-5 myDivs">
                    <select class="form-control" name="Status">
                        <option value="...">...</option>
                        <option value="New">New</option>
                        <option value="Like New">Like New</option>
                        <option value="Used">Used</option>
                        <option value="Old">Old</option>
                    </select>
            </div>
            </div>
            <!--Start Feild-->
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <label class="control-lable col-sm-2">Member Name</label>
                <div class="col-sm-10 col-md-5 myDivs">
                    <select class="form-control" name="Member">
                        <option value="...">...</option>
                        <?php 
                            $stmt = $con->prepare("SELECT userName, userID FROM login");
                            $stmt->execute();
                            $rows = $stmt->fetchAll();
                            for($i = 0; $i < count($rows); $i++){
                                echo "
                                <option value=".$rows[$i]['userID'].">".$rows[$i]["userName"]."</option>";
                            }
                        ?>
                    </select>
            </div>
            </div>
            <!--Start Feild-->
            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <label class="control-lable col-sm-2">Category Name</label>
                <div class="col-sm-10 col-md-5 myDivs">
                    <select class="form-control" name="Cat">
                        <option value="...">...</option>
                        <?php 
                            $stmt = $con->prepare("SELECT Name, ID FROM categories");
                            $stmt->execute();
                            $rows = $stmt->fetchAll();
                            for($i = 0; $i < count($rows); $i++){
                                echo "
                                <option value=".$rows[$i]['ID'].">".$rows[$i]["Name"]."</option>";
                            }
                        ?>
                    </select>
            </div>
            </div>
            

            <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                <div class="col-sm-2"></div>
                <div class="col-sm-10 col-md-5">
                <input type="submit" value="Add Items" class="px-3 btn btn-primary addBtn"  />
            </div>
            </div>
        </form>

        </div>
        <?php
    }elseif($do == "Insert"){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $Name = $_POST["Name"];
            $Des = $_POST["Description"];
            $Price = $_POST["Price"];
            $Country = $_POST["Country"];
            $Status = $_POST["Status"];
            $Member = intval($_POST["Member"]);
            $Cat = intval($_POST["Cat"]);
            filter_var($Name, FILTER_SANITIZE_STRING);
            filter_var($Des, FILTER_SANITIZE_STRING);
            filter_var($Price, FILTER_SANITIZE_STRING);
            filter_var($Member, FILTER_SANITIZE_STRING);
            filter_var($Cat, FILTER_SANITIZE_STRING);
            filter_var($Country, FILTER_SANITIZE_STRING);
            filter_var($Status, FILTER_SANITIZE_STRING);
            echo "<h3 class='text-center text-primary'>Add New Members</h3>";
            echo "<div class='container'>";
            $str = "";
            if(empty($Name)){
                $str .= "<div class='alert alert-danger m-3'>Name Is Empty You Must Fill It</div>";
            }
            if(empty($Member) || $Member == "..."){
                $str .= "<div class='alert alert-danger m-3'>Member Name Is Empty You Must Fill It</div>";
            }
            if(empty($Cat) || $Cat == "..."){
                $str .= "<div class='alert alert-danger m-3'>Category Name Is Empty You Must Fill It</div>";
            }
            if(empty($Des)){
            $str .= "<div class='alert alert-danger m-3'>Description Is Empty You Must Fill It</div>";
            }
            if(empty($Price)){
            $str .= "<div class='alert alert-danger m-3'>Price Is Empty You Must Fill It</div>";
            }
            if(!is_numeric($Price)){
            $str .= "<div class='alert alert-danger m-3'>Price Must Be Number</div>";
            }
            if(empty($Country)){
            $str .= "<div class='alert alert-danger m-3'>Country Is Empty You Must Fill It</div>";
            }
            if(empty($Status) || $Status == "..."){
            $str .= "<div class='alert alert-danger m-3'>Status Is Empty You Must Fill It</div>";
            }
            if($str != ""){
                Redirected($str, 3, "?do=Add");
            }else{
                $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, AddDate, CountryMade, Status, Cat_ID, Member_ID) 
                VALUES(:Name, :Description, :Price, NOW(), :CountryMade, :Status, :CatID, :MemberID)");
                $stmt->execute(array(
                    'Name'=> $Name,
                    'Description'=> $Des,
                    'Price'=> $Price,
                    'CountryMade'=> $Country,
                    'Status'=> $Status,
                    'CatID'=> $Cat,
                    'MemberID'=> $Member,
                ));
                Redirected("<div class='alert alert-success m-3'>You Add Items Success</div>", 3, "?do=Add");
           
        }
            echo "</div>";
        }
        
    }elseif($do == "Edit"){
        $id = !empty($_GET["ID"]) && isset($_GET["ID"]) && is_numeric($_GET["ID"]) ? intval($_GET["ID"]) : 0 ;
        $stmt = $con->prepare("SELECT * FROM items WHERE ID = :id LIMIT 1");
        $stmt->execute(array(
            'id'=>$id
        ));
        $row = $stmt->fetch();
        $Name = $row["Name"];
        $des = $row["Description"];
        $Price = $row["Price"];
        $Country = $row["CountryMade"];
        $Status = $row["Status"];
        $CatID = $row["Cat_ID"];
        $MemberID = $row["Member_ID"];
        ?>
        <div class="container mt-5">
                <form method="POST" action="?do=Update" class="form-horizontal m-auto">
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <div class="control-lable col-sm-2"></div>
                        <div class="col-sm-10 col-md-5">
                    <h3 class="text-center text-primary">Edit Items</h3>
                    </div>
                    </div>
                    <!--Start Feild-->
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <label class="control-lable col-sm-2">Name</label>
                        <div class="col-sm-10 col-md-5 myDivs">
                        <input type="text" value="<?php echo $Name ?>" name="Name" class="form-control" required="required" />
                        <input type="hidden" value="<?php echo $id ?>" name="ID"/>
                        <span class="asterisk mt-3">*</span>
                    </div>
                    </div>
                    <!--Start Feild-->
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <label class="control-lable col-sm-2">Description</label>
                        <div class="col-sm-10 col-md-5 myDivs">
                        <input type="text" value="<?php echo $des ?>" name="Description" class="form-control" required="required" />
                        <span class="asterisk mt-3">*</span>
                    </div>
                    </div>
                    <!--Start Feild-->
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <label class="control-lable col-sm-2">Price</label>
                        <div class="col-sm-10 col-md-5 myDivs">
                        <input type="text" value="<?php echo $Price ?>" name="Price" class="form-control" required="required" />
                        <span class="asterisk mt-3">*</span>
                    </div>
                    </div>
                    <!--Start Feild-->
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <label class="control-lable col-sm-2">Country</label>
                        <div class="col-sm-10 col-md-5 myDivs">
                        <input type="text" value="<?php echo $Country ?>" name="Country" class="form-control" required="required" />
                        <span class="asterisk mt-3">*</span>
                    </div>
                    </div>
                    <!--Start Feild-->
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <label class="control-lable col-sm-2">Status</label>
                        <div class="col-sm-10 col-md-5 myDivs">
                            <select class="form-control" name="Status">
                            <?php $arr = array(); 
                            $arr[] = "New";
                            $arr[] = "Like New";
                            $arr[] = "Used";
                            $arr[] = "Old";
                            for($i=0 ;$i<count($arr) ;$i++){
                                if($Status == $arr[$i]){
                                    echo "<option selected value = '$arr[$i]'>$arr[$i]</option>";
                                }else{
                                    echo "<option value='$arr[$i]'>$arr[$i]</option>";
                                }
                            }
                            ?>
                            </select>
                    </div>
                    </div>
                    <!--Start Feild-->
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <label class="control-lable col-sm-2">Member</label>
                        <div class="col-sm-10 col-md-5 myDivs">
                            <select class="form-control" name="Member">
                            <?php 
                            $stmt = $con->prepare("SELECT userID, userName FROM login");
                            $stmt->execute(array());
                            $arr = $stmt->fetchAll();
                            for($i=0 ;$i<count($arr) ;$i++){
                                if($MemberID == $arr[$i]["userID"]){
                                    echo "<option selected value = ".$arr[$i]['userID'].">".$arr[$i]["userName"]."</option>";
                                }else{
                                    echo "<option value = ".$arr[$i]['userID'].">".$arr[$i]["userName"]."</option>";
                                }
                            }
                            ?>
                            </select>
                    </div>
                    </div>
                    <!--Start Feild-->
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <label class="control-lable col-sm-2">Category</label>
                        <div class="col-sm-10 col-md-5 myDivs">
                            <select class="form-control" name="Cat">
                            <?php 
                            $stmt = $con->prepare("SELECT ID, Name FROM categories");
                            $stmt->execute(array());
                            $arr = $stmt->fetchAll();
                            for($i=0 ;$i<count($arr) ;$i++){
                                if($CatID == $arr[$i]["ID"]){
                                    echo "<option selected value = ".$arr[$i]['ID'].">".$arr[$i]["Name"]."</option>";
                                }else{
                                    echo "<option value = ".$arr[$i]['ID'].">".$arr[$i]["Name"]."</option>";
                                }
                            }
                            ?>
                            </select>
                    </div>
                    </div>
                    
        
                    <div class="form-group form-group-lg d-flex align-items-center justify-content-center mt-1">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10 col-md-5">
                        <input type="submit" value="Edit Items" class="px-3 btn btn-primary addBtn"  />
                    </div>
                    </div>
                </form>
        
                </div>
        <?php
    }elseif($do == "Update"){
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $Name = $_POST["Name"];
            $id = $_POST["ID"];
            $Des = $_POST["Description"];
            $Price = $_POST["Price"];
            $Country = $_POST["Country"];
            $Status = $_POST["Status"];
            $Member = $_POST["Member"];
            $Cat = $_POST["Cat"];
            filter_var($Name, FILTER_SANITIZE_STRING);
            filter_var($id, FILTER_SANITIZE_STRING);
            filter_var($Price, FILTER_SANITIZE_STRING);
            filter_var($Cat, FILTER_SANITIZE_STRING);
            filter_var($Member, FILTER_SANITIZE_STRING);
            filter_var($Des, FILTER_SANITIZE_STRING);
            filter_var($Country, FILTER_SANITIZE_STRING);
            filter_var($Status, FILTER_SANITIZE_STRING);
            $str = "";
            echo "
            <div class='form-group form-group-lg d-flex align-items-center justify-content-center mt-1'>
                <div class='control-lable col-sm-2'></div>
                <div class='col-sm-10 col-md-5'>
            <h3 class='text-center text-primary'>Edit Items</h3>
            </div>
            </div>";
            if(empty($id) || !is_numeric($id)){
                $str .= "<div class='alert alert-danger m-4'>Items Id Is Wrong</div>";
            }
            if(empty($Name)){
                $str .= "<div class='alert alert-danger m-4'>Name Must Not Empty</div>";
            }
            if(empty($Des)){
                $str .= "<div class='alert alert-danger m-4'>Description Must Not Empty</div>";
            }
            if(empty($Price)){
                $str .= "<div class='alert alert-danger m-4'>Price Must Not Empty</div>";
            }
            if(!is_numeric($Price)){
                $str .= "<div class='alert alert-danger m-4'>Price Must Be Number</div>";
            }
            if(empty($Country)){
                $str .= "<div class='alert alert-danger m-4'>Country Must Not Empty</div>";
            }
            if(empty($Status) || $Status == "..."){
                $str .= "<div class='alert alert-danger m-4'>Status Must Not Empty</div>";
            }
            if($str == ""){
                $check = Check($con, "ID", "items", $id);
                if(!$check){
                    $stmt = $con->prepare("UPDATE `items` SET Name = :Name, Description = :Des,
                    Price = :Price, CountryMade = :Country ,Status = :Status, Cat_ID = :Cat, Member_ID = :Member
                     WHERE ID = :ID");
                    $stmt->execute(array(
                        'Name'=> $Name,
                        'Des'=> $Des,
                        'Price'=> $Price,
                        'Country'=> $Country,
                        'Status'=> $Status,
                        'Cat'=> $Cat,
                        'Member'=> $Member,
                        'ID'=> $id,
                    ));
                    Redirected("<div class='alert alert-success m-4'>You Edit Items Success</div>" , 3 , "?do=Edit&ID=$id");
                }else{
                    Redirected("<div class='alert alert-danger m-4'>Items Id Is Wrong<</div>" , 3 , "?do=Edit&ID=$id");
                }

            }else{
                Redirected($str , 3 , "?do=Edit&ID=$id");
            }
        }
        
    }elseif($do == "Del"){
            $id = $_GET["ID"];
            $stmt = $con->prepare("DELETE FROM items WHERE ID = :id");
            filter_var($id, FILTER_SANITIZE_STRING);
            $stmt->execute(array('id'=>$id));
            Redirected("<div class='alert alert-success m-4'>Item Is Deleted Success</div>" , 3 , "?do=Manage");
    }elseif($do == "Approve"){
        $id = isset($_GET["ID"]) && is_numeric($_GET["ID"]) ? intval($_GET["ID"]) : 0;
        $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE ID = :id");
        $stmt->execute(array('id'=>$id));
        Redirected("<div class='alert alert-success m-4'>Item Is Approve Success</div>" , 3 , "items.php?do=Manage");
    }else{
        Redirected("<div class='alert alert-danger m-4'>URL NOT FOUND</div>",3, "items.php?do=Manage");
    }
    include "./includes/template/footer.inc.php";
}
ob_end_flush();
?>