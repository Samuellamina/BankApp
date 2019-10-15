<?php
	session_start();

	include 'includes/dp.inc.php';
	include 'includes/funcs.inc.php';

	$errors=[];


	if(array_key_exists('submit', $_POST)) {

		if (!empty($_POST['email'])) {
			$e = $_POST['email'];
		} else {
			$errors['email'] = "please enter your email";
		}

		if (!empty($_POST['password'])) {
			$p = $_POST['password'];
		} else {
			$errors['password'] = "please enter your password";
		}

		# if no errors exist...
		if (empty($errors)) {
			
			$check = Login($e, $conn, $p);

			if($check[0]) {
				$record = $check[1];
				
				$_SESSION['customer_id'] = $record['id'];
				$_SESSION['firstname'] = $record['firstname'];

				$pay = $p;
				header("Location: dashboard.php?pay=".$pay);

			} else {
				header("Location: index.php?msg='username or password is incorrect'");
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<style type="text/css">
		.wrapper {
			width: 760px;
			margin: 0 15%;
		}

		form div {
			position: relative;
			padding-top: 20px;
		}

		.err {
			position: absolute;
			color: red;
			left: 6%;
			top: 0;
		}

	</style>
</head>
<body>
	<div class="wrapper">
		<h1 id="register-label">Login</h1>
		<hr>
		<form id="register" method="POST" action="index.php">
			
			<?php
				if (isset($_GET['msg'])) {
					echo '<p>'.$_GET['msg'].'</p>';
				}
			?>

			<div>
				<?php
					if (array_key_exists('email', $errors)) {
						echo '<span class=err>please enter your email</span>';
					}
				?>
				<label>Email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php
					if (array_key_exists('password', $errors)) {
						echo '<span class=err>please enter your password</span>';
					}
				?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>

			<input type="submit" name="submit" value="login">
		</form>
	</div>
</body>
</html>