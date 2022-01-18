<!DOCTYPE html>
<html lang="en">
<?php
function styleFile($File){
echo
"
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Admin</title>
    <link rel='stylesheet' href='./layout/css/bootstrap.min.css'>
    <link rel='stylesheet' href='./layout/css/all.min.css'>
    <link rel='stylesheet' href='./layout/css/jquery-ui.css'>
    <link rel='stylesheet' href='./layout/css/jquery.selectBoxIt.css'>
    <link rel='stylesheet' href='./layout/css/stylecss.css'>
    <link rel='stylesheet' href='./layout/css/".$File."'>
</head>
<body>";
}
?>