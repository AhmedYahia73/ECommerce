
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand text-warning brand" href="#">ECommerce</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="app-nav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link text-light" href="Dashboard.php"><i class="fas fa-home mx-1"></i>Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="Categories.php?do=Manage"><i class="fas fa-arrows-alt mx-1"></i>Categories</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-light" href="items.php?do=Manage"><i class="fas fa-cart-arrow-down mx-1"></i>Items</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-light" href="members.php?do=Manage"><i class="fas fa-users mx-1"></i>Members</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-light" href="comments.php?do=Manage"><i class="fas fa-comments mx-1"></i>Comments</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-light" href="statistics.php?do=Manage"><i class="fas fa-chart-line mx-1"></i>Statistics</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link text-light" href="../index.php"><i class="fab fa-shopify mx-1"></i>Visit Shop</a>
      </li>
    </ul>
  </div>
  <div class="navStyle">
  <a class="nav-link py-1 text-light bg-success dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
          <?php echo $_SESSION["userName"]; ?>
        </a>
        <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
          <a class="dropdown-item text-light" href="members.php?do=Edit&userID=<?php echo $_SESSION['ID'] ?>">Edit Profile</a>
          <a class="dropdown-item text-light" href="#">Settings</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-light" href="logout.php">Logout</a>
        </div>
  </div>
</nav>