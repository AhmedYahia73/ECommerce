<?php
ob_start("ob_gzhandler");
session_start();
    if(isset($_SESSION['userName'])){
        include "./includes/template/init.php";
        styleFile("Dashboard.css");
        $x=9;
    //__________________________________________________________
        ?>
        <div class="container cont1">
            <h2 class="text-center text-primary m-4">Dashboard</h2>
            <div class="row">
                <div class="col-sm-3">
                    <div class="boxs box-1 d-flex align-items-center p-4">
                        <i class="fas fa-users ic"></i>
                        <div>
                    Total Members
                    <p><a href="members.php?do=Manage"> <?php echo GetCount($con,"userID" ,"login", "groupID !",1); ?></a></p>
                </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="boxs box-2 d-flex align-items-center p-4">
                    <i class="fas fa-user-plus ic"></i>
                    <div>
                    Pending Members
                    <p><a href="members.php?do=Manage&red=1"> <?php echo GetCount($con,"userID" ,"login", "redStatus",1); ?></a></p>
                </div>
                </div></div>
                <div class="col-sm-3">
                    <div class="boxs box-3 d-flex align-items-center p-4">
                    <i class="fas fa-tags ic"></i>
                    <div>
                    Total Items
                    <p><a href="Items.php?do=Manage"> <?php echo GetCount($con, "ID", "items", 1, 1) ; ?> </a></p>
                </div>
                </div></div>
                <div class="col-sm-3">
                    <div class="boxs box-4 d-flex align-items-center p-4">
                    <i class="fas fa-comments ic"></i>
                    <div>
                    Total Comments
                    <p><a href="comments.php?do=Manage"> <?php echo GetCount($con, "ID", "comments", 1, 1 ); ?></a></p>
                </div>
                </div></div>
            </div>
        </div>
        <div class="container cont2 mt-4">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fas fa-user-secret mx-2"></i>Latest 5 Registerd Users
                    </div>
                        <div class="panel-body">
                            <ul class='ulItems'>
                            <?php 
                            $i=0;
                        foreach(GetItems($con, "userName, userID, redStatus", "login", "userID") as $items){
                            $i++;
                            echo "<li class='d-flex align-items-center justify-content-between'>".$items["userName"]."<div>";
                            if( $items["redStatus"]==1){
                            echo "<a href='members.php?do=act&userID= ".$items['userID']."' class='btn btn-primary m-1'><i class='far fa-star mr-2'></i>Active</a>
                            <a href='members.php?do=Edit&userID=". $items["userID"] ."' class='btn btn-success m-1'><i class='fa fa-edit mr-2'></i>Edit</a></div></li>";
                        }else{
                            echo "
                            <a href='members.php?do=Edit&userID=". $items["userID"] ."' class='btn btn-success m-1'><i class='fa fa-edit mr-2'></i>Edit</a></div></li>";
                        }}
                        if($i==0){
                            echo "
                            <div>There's No Record To Show
                            </div>" ;
                        }
                        ?></ul> </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fas fa-user-secret mx-2"></i>Latest 5 Registerd Items</div>
                        <div class="panel-body">
                            <ul class='ulItems'>
                            <?php 
                            $i=0;
                        foreach(GetItems($con, "ID, Name, Approve", "items", "ID") as $items){
                            echo "<li class='d-flex align-items-center justify-content-between'>".$items["Name"]."<div class = 'text-left'>";
                            if(intval($items["Approve"]) == 0){
                                echo "<a href='Items.php?do=Approve&ID=".intval($items['ID'])."' class='btn btn-primary m-1'>
                                <i class='far fa-star mr-2'></i>Approve</a>" ;}
                            echo "
                            <a href='Items.php?do=Edit&ID=". $items["ID"] ."' class='btn btn-success m-1'><i class='fa fa-edit mr-2 '></i>Edit</a>";
                            echo "</div></li>";
                            $i++;
                            }
                            if($i==0){
                                echo "
                                <div>There's No Record To Show
                                </div>" ;
                            }
                        ?></ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
        <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading"><i class="fas fa-user-secret mx-2"></i>Latest 5 Comments</div>
                        <div class="panel-body">
                            <ul class='ulItems'>
                            <?php 
                            $i=0;
                        foreach(GetItems($con, "ID, Comment, Status", "comments", "ID") as $items){
                            $i++;
                            echo "<li class='d-flex align-items-center justify-content-between'>".$items["Comment"]."<div class = 'text-left'>";
                            if(intval($items["Status"]) == 0){
                                echo "
                                <a href='comments.php?do=Approve&ID=". intval($items['ID']) ."' class='btn m-1 btn-primary py-1'>
                                <i class='far fa-star mr-2'></i>Approve</a></div>" ;}else{
                            echo "<a href='comments.php?do=Hide&ID=".intval($items['ID'])."' class='m-1 btn btn-secondary px-4 py-1'><i class='fas fa-minus-circle mr-2'></i>Hide</a></div>";
                            }
                        }
                            if($i==0){
                                echo "
                                <div>There's No Record To Show
                                </div>" ;
                            }
                        ?></ul>
                    </div>
                </div>
            </div>
        </div></div>
        <?php
    //___________________________________________________________
    include "./includes/template/footer.inc.php";
    }else{
        header('Location: index.php');
        exit();
    }
    ob_end_flush();
?>