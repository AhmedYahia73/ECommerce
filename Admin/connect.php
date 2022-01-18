<?php
    $dsn='mysql:local=localhost;port=3308;dbname=shop';
    $user='root';
    $pass='';
    $option=array(
        PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES utf8',
    );
    try{
        $con=new PDO($dsn,$user,$pass,$option);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Failed ".$e->getMessage();
    }
?>