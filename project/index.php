<?php
require_once('/resources/config.php');
require_once(LIBRARY_PATH . "/templateFunctions.php");

?>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>TFG</title>



	<link   href="public_html/css/bootstrap.min.css" rel="stylesheet">
	<link   href="public_html/css/signin.css" rel="stylesheet">
	<link   href="public_html/css/custom.css" rel="stylesheet">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="public_html/js/bootstrap.min.js"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


  <body>

    <div class="container-fluid">
	
		
				<form class="form-signin" method="post" action="dataLogin.php">
					<h2 class="form-signin-heading">Login</h2>
					<label for="inputEmail" class="sr-only">Email</label>
					<input type="email" name="inputEmail" class="form-control" placeholder="Email" required="" autofocus="">
					<label for="inputPassword" class="sr-only">Contraseña</label>
					<input type="password" name="inputPassword" class="form-control" placeholder="Password" required="">
					<div class="checkbox">
					  <label>
						<input type="checkbox" value="remember-me"> Recordar contraseña
					  </label>
					</div>
					<button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
				</form>
		 
	  

    </div> <!-- /container -->


<script type="text/javascript">
$(function(){
   $(".close").click(function(){
      $("#alertError").alert('close');
   });
});  

</script>   


</body>
</html>
