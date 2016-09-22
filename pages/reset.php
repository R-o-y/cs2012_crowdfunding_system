<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Reset Password</title>
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

  <ol class="breadcrumb">
    <li><a href="<?php echo url(['_page'=>'home']) ?>">Home</a></li>
    <li class="active">User Access</li>
  </ol>

  <div class="container">
    <div class="col-md-4 col-md-offset-4" style="">
      <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title"><strong>Password Reset</strong></h3></div>
        <div class="panel-body">
        <?php
            $msg = '';
            $changed=false;
             if (isset($_POST['reset']) && !empty($_POST['email']) 
               && !empty($_POST['password'])) {

               $user = User::getUserByEmail($_POST['email']);
              if ($user == null) {
                  $msg='No such email in database';
               }else {           
                  $changed=$user->setPass($_POST['password']); 
                  $msg='Password changed successfully';  
               }
            }
            
         ?>
          <form role="form" action = "<?php echo url(['_page'=>'reset']); ?>" method = "post">
            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="email" class="form-control" id="exampleInputEmail1" name = "email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">New Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name = "password" placeholder="New Password" required>
            </div>
            
            <button type="submit" class="btn btn-default btn-sm" name = "reset">Reset</button>
            <p><span style="color:red"><?php echo $msg; ?></span></p>
            <?php
             if($changed) {
              $address=url(['_page'=>'login']);  
              echo "<p> Go back to <a href="."\"".$address."\"><b>login</b></a></p>";
             }
             ?>
            
          </form>          
        </div>
      </div>
      
    </div>
  </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

  </body>
</html>