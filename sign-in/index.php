<?php
session_start();
if(isset($_SESSION['name'])) {
    header("Location: Home/web/");
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Liaison Project Manager</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link href="favicon.ico" rel="shortcut icon">

	<script type="text/javascript" src="js/login_form.js"></script>
</head>
<body>

<div class="main_container">

	<h2>Welcome to the <span>Liaison Technologies Project Manager</span>!</h2>
	<div class="container">
		<div id="form">
			<form id="ajax-login-form" method="POST">
			<fieldset class="info_fieldset">
				<div id="note" />
				<div id="fields">
					<input class="textbox" type="text" name="user" value="" placeholder="Username" /><br />
					<input class="textbox" type="password" name="password" value="" placeholder="Password" autocomplete="off"/><br />
					<input class="button" type="submit" value="Sign in" />
					<input class="button" type="submit" name="back" value="Back" />
				</div>
			</fieldset>
			</form>
		</div>
	</div>

	<div class="image">
		<a href="http://www.liaison.com">
			<img id="logo" src="css/images/logo.png" height="77" width="200" style="vertical-align:middle;" title="Liaison Technologies Home"/>
		</a>
	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	
</body>

</html>

<?php
  if(isset($_POST['back'])) {
      header("Location: ../web/");
  }

  if(isset($_POST['user']) && isset($_POST['password'])) {
	require_once('../config/Config.php');
        $config = Config::getConfig("db");
        try {
            $db = new PDO($config['dsn'], $config['username'], $config['password']);
        } catch (Exception $ex) {
            die('error connecting to server');
        }
      $uName = $_POST['user'];
      $pswd = $_POST['password'];
      $query = "SELECT * FROM user WHERE userName = '$uName' AND password = '$pswd'";
      $result = $db->query($query) or die("error editing project");
      if($row = $result->fetch(PDO::FETCH_ASSOC)) {
	     $_SESSION['name'] = $row[displayName].'-'.$row[permission];
	     $db = null;
	     header("Location: ../web");
      }
      else {
	 echo 'invalid username/password';
	 $db = null;
      }
  }
?>
