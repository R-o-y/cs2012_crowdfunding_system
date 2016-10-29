<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sign Up</title>
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
                  <div class="panel-heading"><h3 class="panel-title"><strong>Sign Up </strong></h3></div>
                  <div class="panel-body">
                      <?php
                      $msg = '';
                      if (isset($_POST['signup']) && !empty($_POST['email'])
                          && !empty($_POST['password'])
                      		&& !empty($_POST['is_admin']) && !empty($_POST['name'])) {

                          $user = new User($_POST);
                          $result = $user->addUser();
                          
                          if ($result == false) {
                              $msg = 'Account has been registered!';
                          } else {
                              $_SESSION['valid'] = true;
                              $_SESSION['timeout'] = time();
                              $_SESSION['email'] = $user->getEmail();
                              $_SESSION['username'] = $user->getName();
                              header("Location: ./?_page=home");
                          }

                      }

                      ?>
                      <form role="form" action = "<?php echo url(['_page'=>'signup']); ?>" method = "post">
                          <div class="form-group">
                              <label for="exampleInputName1">Name</label>
                              <input type="name" class="form-control" id="exampleInputName1" name = "name" placeholder="Enter name" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputEmail1">Email</label>
                              <input type="email" class="form-control" id="exampleInputEmail1" name = "email" placeholder="Enter email" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPassword1">Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword1" name = "password" placeholder="Password" required>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputIsAdmin">Admin?&nbsp(t / f)</label>
                              <input type="is_admin" class="form-control" id="exampleInputIsAdmin1" name = "is_admin" placeholder="f" required>
                          </div>
                          <p><span style="color:red"><?php echo $msg; ?></span></p>
                          <button type="submit" class="btn btn-default btn-sm" name="signup">Sign Up</button>
                      </form>

                  </div>
              </div>
          </div>
      </div>
      <?php require('pages/_footer.php'); ?>
  </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  </body>
</html>