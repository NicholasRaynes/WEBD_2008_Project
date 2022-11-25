<?php
 
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
                    <label class="form-label" for="verify_password">Re-enter Password</label>
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