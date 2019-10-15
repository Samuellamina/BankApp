<?php
	session_start();

	// check if user is logged in...
	if(!isset($_SESSION['customer_id'])) {
		header("Location: index.php");
	}

	$customer_name = $_SESSION['firstname'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>dashboard</title>
</head>
<body>

	<ul>
		<li><a href="transfers.php">transfer funds</a></li>
		<li><a href="logout.php">logout</a></li>
	</ul>
	<h2><?php echo'welcome '.$customer_name;
 ?></h2>

</body>
</html>