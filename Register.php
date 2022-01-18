<?php
ob_start("ob_gzhandler");
session_start();
?>
<?php
include "./includes/template/header.inc.php";
include "./Admin/connect.php";
styleFile("register.css");
if($_SERVER["REQUEST_METHOD"] == 'POST'){
    $userName = isset($_POST["userName"]) && !empty($_POST["userName"])? $_POST["userName"] : null;
    $fullName = isset($_POST["fullName"]) && !empty($_POST["fullName"])? $_POST["fullName"] : null;
    $email = isset($_POST["email"]) && !empty($_POST["email"])? $_POST["email"] : null;
    $pass = isset($_POST["pass"]) && !empty($_POST["pass"])? $_POST["pass"] : null;
    $conPass = isset($_POST["conPass"]) && !empty($_POST["conPass"])? $_POST["conPass"] : null;
    $Phone = isset($_POST["phone"]) && !empty($_POST["phone"])? $_POST["phone"] : null;
    filter_var($userName, FILTER_SANITIZE_STRING);
    filter_var($fullName, FILTER_SANITIZE_STRING);
    filter_var($email, FILTER_SANITIZE_STRING);
    filter_var($pass, FILTER_SANITIZE_STRING);
    filter_var($conPass, FILTER_SANITIZE_STRING);
    filter_var($Phone, FILTER_SANITIZE_STRING);
    $arr = array();
    if(strlen($userName)<4){
        $arr[] = "<div class='mx-4 alert alert-danger'>UserName Length Must Be More Than 4 Character</div>";
    }
    if(strlen($userName)>21){
        $arr[] = "<div class='mx-4 alert alert-danger'>UserName Length Must Be Less Than 20 Character</div>";
    }
    if(empty($userName)){
        $arr[] = "<div class='mx-4 alert alert-danger'>UserName Can't Be Empty</div>";
    }
    if(empty($fullName)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Full Name Can't Be Empty</div>";
    }
    if(empty($email)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Email Can't Be Empty</div>";
    }
    if(empty($pass)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Password Can't Be Empty</div>";
    }
    if(strlen($pass)<8){
        $arr[] = "<div class='mx-4 alert alert-danger'>Password Must Be More Than 8 Characters</div>";
    }
    if($pass != $conPass){
        $arr[] = "<div class='mx-4 alert alert-danger'> Confirm Password Is Wrong</div>";
    }
    if(strlen($Phone) < 9 || !is_numeric( $Phone)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Phone Number Is Wrong</div>";
    }
    if(empty($Phone)){
        $arr[] = "<div class='mx-4 alert alert-danger'>Phone Can't Be Empty</div>";
    }
    if(!empty($arr)){
        $str = "<h3 class=' text-primary text-center mt-1 '>Ecommerce</h3>";
        foreach($arr as $items){
          $str .=  $items;
        }
        Redirected($str, 3, "Admin/index.php");
    }else{
        $state = Check($con, "userName", "login",$userName);
        Insert($state, $con, $userName, $email, $fullName, $pass, $Phone, true);
        ?>
        <form action="Admin/index.php" method="POST">
            <input type="hidden" name="userName" value="<?php echo $userName; ?>" />
            <input type="hidden" name="pass" value="<?php echo $pass; ?>" />
            <input type="submit" />
        </form>
        <script>
        document.getElementsByTagName("form")[0].submit();
        </script>
<?php }
}
?>
<div class="d-flex justify-content-center align-items-center p-5">
<div class="px-5 py-3 divForm">
<h4 class="text-center text-primary m-3">Make New Account</h4>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
  <div class="form-group">
    <input name="userName" type="text" class="form-control" placeholder="Enter Your userName" required>
  </div>
  
  <div class="form-group">
    <input name="fullName" type="text" class="form-control" placeholder="Full Name" required>
  </div>

  <div class="form-group">
    <input name="email" type="email" class="form-control" placeholder="Email" required>
  </div>

<div class="form-group">
  <input name="pass" type="password" class="form-control" placeholder="Password" required>
</div>


<div class="form-group">
    <input name="conPass" type="password" class="form-control" placeholder="Confirm Password" required>
  </div>
  
  <div class="form-group">
    <input name="phone" type="text" class="form-control" placeholder="Phone" required>
  </div>


  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>
</div>
<?php
include "./includes/template/footer.inc.php";
ob_end_flush();
?>