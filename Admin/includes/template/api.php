<?php
function api($arr){
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=UTF-8");
header("Access-Control-Allow-Methods:*");
header("Access-Control-Max-Age:3600");
header("Access-Control-Allow-Headers:*");
echo json_encode($arr);
}
?>