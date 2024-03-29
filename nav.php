<?php
  @session_start();

  $search_categories_query = "SELECT * FROM categories";
  $search_categories_statement = $db->prepare($search_categories_query);
  $search_categories_statement->execute();
?>

<link rel="stylesheet" type="text/css" href="styles.css">
<script src="https://kit.fontawesome.com/d4de3d3a72.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php"><i class="fa-solid fa-basketball" style="color:orange"></i> HoopsPlus+</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php"><i class="fa-solid fa-house"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="nba_stats.php"><i class="fa-solid fa-database"></i> NBA Stats</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="fan_forum.php"><i class="fa-solid fa-list"></i> Fan Forum</a>
      </li>
      <?php if (isset($_SESSION['user_id']) && $_SESSION['access'] >= 1): ?>
        <li class="nav-item">
          <a class="nav-link" href="creator_hub.php"><i class="fa-solid fa-door-open"></i> Creator Hub</a>
        </li>
      <?php endif; ?>
      <?php if (isset($_SESSION['user_id']) && $_SESSION['access'] == 2): ?>
        <li class="nav-item">
          <a class="nav-link" href="admin_hub.php"><i class="fa-solid fa-wrench"></i> Admin Hub</a>
        </li>
      <?php endif; ?>
      <li>
        <form method="post" action="index.php">
          <div class="input-group">
            <input name="search" class="form-control rounded" aria-describedby="search-addon" />
            <button type="submit" class="btn btn-outline-primary">Search</button>
          </div>
        </form>
      </li>
      <?php if (!isset($_SESSION['user_id'])): ?>
        <li class="nav-item" id="login_link">
          <a class="nav-link" href="login.php"><i class="fa-solid fa-user"></i> Login</a>
        </li>
      <?php endif; ?>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li class="nav-item" id="logout_link">
          <a class="nav-link" href="logout.php"><i class="fa-solid fa-user"></i> Logout</a>
        </li>
      <?php endif; ?>
    </ul>
    </div>
  </div>
</nav>
