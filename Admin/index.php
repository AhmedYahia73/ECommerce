<?php
ob_start("ob_gzhandler");
    session_start();
    $noNav='';
    if(isset($_SESSION['userName'])){
        header('Location: Dashboard.php');
    }elseif(isset($_SESSION['user'])){
        header('Location: ../user/index.php');
    }
    include "./includes/template/init.php";
    styleFile("");
    echo "<div class='data'>Admin Name :- ahmed <br />
    Password :- 123456789 <br />
    User Name :- ahmedy<br />
    Password :- 123456789 </div>";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $userName =$_POST['userName'];
        $pass=$_POST['pass'];
        filter_var($userName, FILTER_SANITIZE_STRING);
        $password=sha1($pass);
        $stmt = $con->prepare("SELECT userName, password, userID FROM login WHERE userName = ? AND password = ? AND groupID = 1 LIMIT 1");
        $stmt->execute(array($userName , $password ));
        $count = $stmt->rowCount();
        $row = $stmt->fetch();
        if($count==1){
            $_SESSION['userName'] = $userName;
            $_SESSION['ID']=$row["userID"];
            header('Location: Dashboard.php');
            exit();
        }else{
            $userName =$_POST['userName'];
            $pass=$_POST['pass'];
            filter_var($userName, FILTER_SANITIZE_STRING);
            $password=sha1($pass);
            $stmt = $con->prepare("SELECT userName, password, userID FROM login WHERE userName = ? AND password = ? LIMIT 1");
            $stmt->execute(array($userName , $password ));
            $count = $stmt->rowCount();
            $row = $stmt->fetch();
            if($count==1){
                $_SESSION['user'] = $userName;
                $_SESSION['userID']=$row["userID"];
    
                //__________________________________________________________________________________________________
               
                $stmt = $con->prepare("SELECT * FROM statistics WHERE userID = ? AND DATE_FORMAT(addDate, '%y-%m') = DATE_FORMAT(NOW(), '%y-%m') ");
                $stmt->execute(array(intval($row["userID"])));
                $count = $stmt->rowCount();
                
                $stmt = $con->prepare("SELECT groupID FROM login WHERE userID = ?");
                $stmt->execute(array(intval($row["userID"])));
                $groupID = $stmt->fetch();
                if($count == 0 && intval($groupID["groupID"]) != 1){
                    $stmt = $con->prepare("insert into statistics(userID, addDate, times) values(?, now(), 1);");
                    $stmt->execute(array(intval($row["userID"])));
                }else{
                    if(intval($groupID["groupID"]) != 1){
                    $stmt = $con->prepare("UPDATE statistics SET times = (times + 1) WHERE userID = ? AND DATE_FORMAT(addDate, '%y-%m') = DATE_FORMAT(NOW(), '%y-%m')");
                    $stmt->execute(array(intval($row["userID"])));}
            }
            header('Location: ../user/index.php');
            exit();
        }
    }
    }
?>
<div class="myDiv">
<div class="myDiv0">
<h4 class="text-center mb-5 text-info mainTitle mb-4">Login</h4>
<form class="log" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
    <input class="form-control" type="text" name="userName" placeholder="User Name" autocomplete="off" />
    <input class="form-control"  type="password" name="pass" placeholder="Password" autocomplete="new-password" />
    <input class="btn myBtn btn-outline-primary btn-block" type="submit" value="Login" />
    <a class="btn myBtn btn-outline-success btn-block" href="../Register.php">Create New Account</a>
    <a class="btn myBtn btn-outline-info btn-block" href="../index.php">Home</a>
</form>
</div>
</div>
<?php
    include "./includes/template/footer.inc.php";
    ob_end_flush();
?>