<!DOCTYPE html PUBLIC “-//W3C//DTD HTML 4.01//EN”
“http://www.w3.org/TR/html4/strict.dtd”>
<?php 
session_start(); 
if ($_SESSION['email']==''){

header("Location: index.php");

}

?>
<html lang=”en”>
<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″>
	<link   href="public_html/css/bootstrap.min.css" rel="stylesheet">
	<link   href="public_html/css/custom.css" rel="stylesheet">
		<link   href="public_html/css/navbar-fixed-top.css" rel="stylesheet">
	
	<!--<link   href="public_html/css/bootply.css" rel="stylesheet">-->
	
	
<title><?php echo $title ?></title>
</head>
<body role="document">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="public_html/js/bootstrap.min.js"></script>
		<script src="public_html/js/bootstrap-filestyle.min.js"></script>
		
		
	<!-----NAVBAR---->
<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="games.php">TFG</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Juegos</a></li>
            <li><a href="#about">Ranking</a></li>
            <li><a href="#contact">Contacto</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Nav header</li>
                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="./"><?php echo $_SESSION['email'];?></a></li>
			 <li><a href="logout.php">Salir</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
	<!-----CONTAINER---->
	
	<div class="container">
		<div class="page-header">
			<h1><?php echo $title ?><small>Subtext for header</small></h1>
		</div>
		