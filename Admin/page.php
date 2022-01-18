<?php
    //Manage - Edit - Update - Add - -Insert - Delete - Stats
    $do = isset($_GET['do']) ? $do = $_GET['do'] : $do = "Manage";
        if($do =="Edit"){
            echo "E";
        }elseif($do =="Update"){
            echo "U";
        }elseif($do =="Add"){
            echo "A";
        }elseif($do =="Insert"){
            echo "I";
        }elseif($do =="Delete"){
            echo "D";
        }elseif($do =="Stats"){
            echo "S";
        }elseif($do =="Manage"){
            echo "Manage";
        }else{
            echo "Error";
        }
?>