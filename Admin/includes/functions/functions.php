<?php
// Check Items is found
function Check($con, $select, $from, $val){
    $stmt = $con->prepare("SELECT $select FROM $from WHERE $select = :users");
    $stmt->execute(array('users' => $val));
    $count = $stmt->rowCount();
    return $count == 0 ? true : false;
}

// Get Items
function GetItems($con, $select, $from, $order, $num =5){
    $stmt = $con->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $num");
    $stmt->execute(array());
    return $stmt->fetchAll();
}

// Insert Items
function Insert($state, $con, $user, $email, $full, $pass, $Phone, $reg = false){
    if($state){
        $stmt = $con->prepare("INSERT INTO login(userName, email, fullName, password, Date, Phone)
        VALUES (:users, :email, :fullName, :pass, now(), :Phone)");
        $stmt->execute(array(
            'users' => $user,
            'email' => $email,
            'fullName' => $full,
            'pass' => sha1($pass),
            'Phone' => $Phone
        ));
        if(!$reg){
            Redirected("<div class='alert alert-success m-4'>You Insert 1 Records</div>",3, "members.php?do=Manage");
        }
        }else{
            if($reg){
                Redirected("<div class='alert alert-danger m-4'>You Can't Regester Please Try Again</div>",3, "Register.php");
            }else{
            Redirected("<div class='alert alert-danger m-4'>You Can't Insert UserName UserName Is recorded Please Change UserName</div>",3, "members.php?do=Manage");
        }
    }
}

// Count of Users
function GetCount($con, $col ,$tbl, $cond, $val){
    $stmt = $con->prepare("SELECT COUNT($col) FROM $tbl WHERE $cond= :val");
    $stmt->execute(array('val' => $val));
    $count = $stmt->fetchColumn();
    return $count;
}
// Times of Login Users
function GetSum($con, $col ,$tbl, $cond, $val, $val2 = array()){
    $stmt = $con->prepare("SELECT SUM($col) AS SUMUSERS FROM $tbl WHERE $cond= $val");
    $stmt->execute($val2);
    $Sum = $stmt->fetchAll();
    return $Sum[0]["SUMUSERS"];
}

function CountRed($con, $col,$tbl){
    $stmt = $con->prepare("SELECT COUNT($col) FROM $tbl WHERE redStatus = 1");
    $stmt->execute(array());
    $count = $stmt->fetchColumn();
    return $count;
}

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