<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Log in</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Bootstrap -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  
  <div class="container">
      <ol class="breadcrumb">
          <li><a href="<?php echo url(['_page'=>'home']) ?>">Home</a></li>
          <li class="active">User Access</li>
      </ol> 
      <div class="row">
          <div class="col-md-4 col-md-offset-4" style="">
              <div class="panel panel-default">
                  <div class="panel-heading"><h3 class="panel-title"><strong>Log In </strong></h3></div>
                  <div class="panel-body">
                      <?php
                      $msg = '';
                      if (isset($_POST['login']) && !empty($_POST['email'])
                          && !empty($_POST['password'])) {

                          $user = User::checkValidity($_POST['email'], $_POST['password']);

                          if ($user == null) {
                              $msg = 'Wrong email or password';
                          } else {
                              $_SESSION['valid'] = true;
                              $_SESSION['timeout'] = time();
                              $_SESSION['email'] = $user->getEmail();
                              $_SESSION['username'] = $user->getName();
                              header("Location: ./?_page=home");
                          }
                      }

                      ?>
                      <form role="form" action = "<?php echo url(['_page'=>'login']); ?>" method = "post">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Email</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" name = "email" placeholder="Enter email" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPassword1">Password <a href="<?php echo url(['_page'=>'reset']); ?>">(forgot password)</a></label>
                              <input type="password" class="form-control" id="exampleInputPassword1" name = "password" placeholder="Password" required>
                          </div>
                          <p><span style="color:red"><?php echo $msg; ?></span></p>
                          <div class="checkbox">
                              <label>
                                  <input type="checkbox" value="remember-me"> Remember me
                              </label>
                          </div>
                          <button type="submit" class="btn btn-default btn-sm" name="login">Log in</button>
                      </form>

                  </div>
              </div>
              <div class="bottom text-center">
                  New here ? <a href="<?php echo url(['_page'=>'signup']) ?>"><b>Join Us</b></a>
              </div>
          </div>
      </div>
      <?php require('pages/_footer.php'); ?>
  </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  </body>
</html>