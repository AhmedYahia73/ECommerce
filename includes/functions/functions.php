<?php
// Get Records
function GetItems( $select, $table, $order, $val = array()){
    global $con;
    $stmt = $con->prepare("SELECT $select FROM $table ORDER BY $order");
    $stmt->execute($val);
    return $stmt->fetchAll();
}

// Redirected

function Redirected($mes, $sec, $link="index.php"){
    echo "
    <div class='container'>
    $mes
    <div class='alert alert-primary m-4'>You Will Redirecte To Home Page After $sec Seconds</div>
    </div>
    ";
    header("REFRESH: $sec; URL= $link");
    exit();
}
?>