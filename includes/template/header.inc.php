<!DOCTYPE html>
<html lang="en">
<?php
include "./includes/functions/functions.php";
function styleFile($File){
echo "
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Admin</title>
    <link rel='stylesheet' href='./Admin/layout/css/bootstrap.min.css'>
    <link rel='stylesheet' href='./Admin/layout/css/all.min.css'>
    <link rel='stylesheet' href='./Admin/layout/css/jquery-ui.css'>
    <link rel='stylesheet' href='./Admin/layout/css/jquery.selectBoxIt.css'>
    <link rel='stylesheet' href='./layout/css/stylecss.css'>
    <link rel='stylesheet' href='./layout/css/".$File."'>
</head>
<body>
<nav class='navbar navbar-expand-lg navbar-dark bg-dark'>
  <a class='navbar-brand text-warning brand' href='#'>ECommerce</a>
  <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#app-nav' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
    <span class='navbar-toggler-icon'></span>
  </button>

  <div class='collapse navbar-collapse' id='app-nav'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item active'>
        <a class='nav-link text-light' href='index.php'><i class='fab fa-shopify mx-1'></i>Products</a>
      </li>
      <li class='nav-item'>
        <a class='nav-link text-light' href='Admin/index.php'><i class='fas fa-sign-in-alt mx-1'></i>Sign In</a>
      </li>
    </ul>
  </div>
  <div class='navStyle'>
  <a class='nav-link py-1 text-light dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-expanded='false'>
          Categories
        </a>
        <div class='dropdown-menu bg-dark' aria-labelledby='navbarDropdown'>";
        foreach(GetItems("*", "categories", "Name") as $item){
         echo "
          <a class='nav-link text-light' href='categories.php?CatID=".$item["ID"]."'>".$item["Name"]."</a>
          "; }
          echo "
  </div>
</nav>
";
}
?>