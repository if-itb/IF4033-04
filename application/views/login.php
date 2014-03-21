<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('asset');?>/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('asset');?>/css/login.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">
      <form method="post" action="<?php echo $url_login?>" class="form-signin" role="form">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="email" name="email" class="form-control" placeholder="Email address" maxlength="100" required autofocus>
        <input type="password" name="password" class="form-control" placeholder="Password" maxlength="100" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p><a href="<?php echo $url_reset?>">Lupa password?</p>
      </form>
    </div> <!-- /container -->
  </body>
</html>
