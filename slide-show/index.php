<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Liaison Project Manager</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/header.css">
	<link href="favicon.ico" rel="shortcut icon">

</head>
<body onload="slide()">

<script>
function slide(){
	var divs = $('div[id^="project-"]').hide(),
    i = 0;

	(function cycle() { 

    divs.eq(i).fadeIn(600)
              .delay(5000)
              .fadeOut(600, cycle);

    i = ++i % divs.length;

	})();
}
</script>


<div class="main_container">

	<h2>Welcome to <a href="../web/"><span>Liaison Technologies</span></a>!</h2>

	<?php
		require_once('../config/Config.php');
       	 $config = Config::getConfig("db");
       	 try {
            		$db = new PDO($config['dsn'], $config['username'], $config['password']);
        	} catch (Exception $ex) {
            		die('error connecting to server');
        	}

		$query = "SELECT * FROM projects WHERE deleted = 0 AND status = 'CURRENT'";
		$result = $db->query($query) or die("Could not retrieve projects");
		$rows = mysql_num_rows($result);


		if($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$rowCounter = 1;
			do {	

				?>
				<div class="container" id="project-$rowCounter">
					<div id="form">
						<h4><?php echo " ".$row['title'] ?> </h2><br />

						<span><label>Description:</label>
						<h2><?php echo $row['description'] ?></h2> <br /></span>


						<label>Completion Target:</label>
						<h2><?php echo date('F d, Y', strtotime($row['due_on'])); ?></h2><br />

					<?php	$query2 = "SELECT name from employee, worksOn where eid = id AND pid = $row[id]";
						$result2 = $db->query($query2) or die("Could not retrieve projects");
						$employees = '';
						while($row2 = $result2->fetch(PDO::FETCH_ASSOC)) 
						{
							$employees .= "$row2[name], ";
						}
						$employees = substr($employees,0,-1);
						$employees = substr($employees,0,-1); ?>

						<label>Team Members:</label>
						<h2><?php echo $employees ?></h2><br />
						
					</br>
					</div>
				</div>

			<?php
				$rowCounter++;
			} while($row = $result->fetch(PDO::FETCH_ASSOC));
		}
		else {
			?>
			<div class="box">
				<div class="inner">
					<span>
						<?php	echo "no projects found";?>
					</span>
				</div>
			</div>
			<?php
		}
		$db = null;
	?>

		</br>
		<a href="http://www.liaison.com">
			<img id="logo" src="css/images/logo.png" height="77" width="200" style="vertical-align:middle;" title="Liaison Technologies Home"/>
		</a>
	

	<script type="text/javascript" src="js/jquery.js"></script>
	
</body>

</html>
