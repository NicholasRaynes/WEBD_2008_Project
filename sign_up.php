<?php
  session_start();

  require('connect.php');

  if(isset($_POST['sign_up']))
  {
    $username = filter_input(INPUT_POST, 'register_username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'register_email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'register_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $verify_password = filter_input(INPUT_POST, 'verify_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);
    $default_access_level = 0;

    $existing_users_query = "SELECT * FROM users WHERE username=:username";
    $existing_users_statement = $db->prepare($existing_users_query);
    $existing_users_statement->bindValue(':username', $username);
    $existing_users_statement->execute();

    if($existing_users_statement->rowCount() > 0 || empty($username) || empty($email) || $password != $verify_password)
    {
      echo "<script>alert('Please enter valid values for all fields, and ensure your password entries match.');</script>";
    }
    else
    {
      $add_user_query = "INSERT INTO users (username, password, email, access_level) VALUES (:username, :password_hashed, :email, :default_access_level)";

      $add_user_statement = $db->prepare($add_user_query);

      $add_user_statement->bindValue(':username', $username);
      $add_user_statement->bindValue(':password_hashed', $password_hashed);
      $add_user_statement->bindValue(':email', $email);
      $add_user_statement->bindValue(':default_access_level', $default_access_level);

      $add_user_statement->execute();

      echo "<script>alert('You have successfully registered!.');</script>";
      header('Refresh:1; url=login.php');
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <title>Register</title>
</head>
<body>
  <div class="container-fluid py-5 h-100" style="margin-left: -100px">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="row g-0">
          <div class="col-md-6 col-lg-7 d-flex align-items-center">
            <div class="card-body p-5 p-lg-7 text-black">
                <form method="post" action="sign_up.php">
                  <div class="d-flex align-items-center mb-3 pb-1">
                    <span class="h1 fw-bold mb-0">Sign Up</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign up for a new account</h5>

                  <div class="form-outline mb-4">
                    <input name="register_username" id="register_username" class="form-control form-control-lg" />
                    <label class="form-label" for="register_username">Username</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input name="register_email" id="register_email" class="form-control form-control-lg">
                    <label class="form-label" for="register_email">Email</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input name="register_password" type="password" id="register_password" class="form-control form-control-lg" />
                    <label class="form-label" for="register_password">Password</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input name="verify_password" type="password" id="verify_password" class="form-control form-control-lg" />
                    <label class="form-label" for="verify_password">Verify password</label>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit" name="sign_up" value="sign_up">Sign Up</button>
                  </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>