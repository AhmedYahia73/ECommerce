<?php
ob_start("ob_gzhandler");
session_start();
if(isset($_SESSION["userName"])){
    $do = isset($_GET["do"]) ? $_GET["do"] : "Manage";
    include "./includes/template/init.php";
    include "./includes/template/api.php";
    styleFile("Statistics.css");
    if($do == "Manage"){
    $arr1 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-1')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-1')"): 0;
    $arr2 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-2')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-2')"): 0;
    $arr3 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-3')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-3')"): 0;
    $arr4 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-4')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-4')"): 0;
    $arr5 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-5')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-5')"): 0;
    $arr6 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-6')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-6')"): 0;
    $arr7 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-7')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-7')"): 0;
    $arr8 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-8')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-8')"): 0;
    $arr9 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-9')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-9')"): 0;
    $arr10 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-10')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-10')"): 0;
    $arr11 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-11')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-11')"): 0;
    $arr12 = is_numeric(GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-12')"))? GetSum($con, "times", "statistics", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-12')"): 0;
    echo "<div class='dataHideen'> ". $arr1.','. $arr2.','. $arr3.','. $arr4.','
    . $arr5.','. $arr6.','. $arr7.','. $arr8.','. $arr9.','. $arr10.','. $arr11.','. $arr12."</div>";
    ?>
    <div class="container">
    <h3 class=" text-primary text-center m-4">The Rate of Visiting Members This Year</h3>
        <form action="statistics.php" method="GET">
        <div class="d-flex align-items-center justify-content-center">
        <div class="formSearch input-group align-items-end ">    
        <input type="text" name = "userName" class="form-control" placeholder="Search About Member">
        <input type="hidden" name = "do" value="search">
        <input type="submit" value="Search" class="btn btn-outline-primary ml-3 px-4 py-2" placeholder="Search">
        </div>
        </div>
        </form>
    <canvas id="myChart" ></canvas>
    </div>


<?php
}elseif($do == "search"){
$arr1 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-1') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-1') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr2 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-2') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-2') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr3 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-3') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-3') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr4 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-4') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-4') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr5 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-5') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-5') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr6 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-6') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-6') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr7 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-7') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-7') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr8 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-8') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-8') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr9 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-9') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ","DATE_FORMAT(NOW(), '%y-9') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr10 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-10') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-10') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr11 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-11') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-11') AND login.userName = ? ", array($_GET["userName"])): 0;
$arr12 = is_numeric(GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-12') AND login.userName = ? ", array($_GET["userName"])))? GetSum($con, "statistics.times", "statistics JOIN login ON statistics.userID = login.userID", "DATE_FORMAT(addDate, '%y-%m') ", "DATE_FORMAT(NOW(), '%y-12') AND login.userName = ? ", array($_GET["userName"])): 0;
echo "<div class='dataHideen'> ". $arr1.','. $arr2.','. $arr3.','. $arr4.','
. $arr5.','. $arr6.','. $arr7.','. $arr8.','. $arr9.','. $arr10.','. $arr11.','. $arr12."</div>";
?>
<div class="container">
<h3 class=" text-primary text-center m-4">The Rate of Visiting Members This Year</h3>
<form action="?do=search" method="GET">
<div class="d-flex align-items-center justify-content-center">
<div class="formSearch d-flex align-items-center">    
<input type="text" name = "userName" class="form-control" placeholder="Search About Member">
<input type="submit" value="Search" class="btn btn-outline-primary ml-3" placeholder="Search">
</div>
</div>
</form>
<canvas id="myChart" ></canvas>
</div>
<?php
}
    echo "
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.min.js'></script>
    <script src='./layout/js/chart.js'></script>
    ";
    
include "./includes/template/footer.inc.php";
}else{
    Redirected("<div class='alert alert-danger m-4'>You Must Login<div>", 3);
}

ob_end_flush();
?>