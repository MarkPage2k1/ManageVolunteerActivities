<?php 
    require_once "./mvc/core/redirect.php";
    $redirect = new redirect();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>
    <base href="http://localhost/ManageVolunteerActivities/">

    <!-- Bootstrap -->
    <link href="public/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="public/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="public/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="public/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="public/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="auth/login" method="post">
              <h1>Login Form</h1>
              <div>
                <input type="text" name="username" value="<?= $data['datas'] != null ? $data['datas']['username'] : ''?>" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="password" name="password" value="<?= $data['datas'] != null ? $data['datas']['password'] : ''?>" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-primary">Login</button>
                <label for="remember">Ghi nho mat khau va tai khoan</label>
                <input type="checkbox" name="remember" id="remember" <?= $data['datas'] != null ? isset($data['datas']['remember']) ? 'checked' : '' : ''?>>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <?php if(isset($_SESSION['error'])) {?>
                  <h4 class="text-danger"> <?= $redirect->setFlash('error'); ?> </h4>
                <?php } ?>
                <p class="change_link">New to site?
                  <a href="http://localhost/ManageVolunteerActivities/auth/index.php#signup" class="to_register"> Create Account </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" />
              </div>
              <div>
                <button class="btn btn-primary" type="submit" name="btn_signup">signup</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="http://localhost/ManageVolunteerActivities/auth/index.php#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
