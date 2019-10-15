<?php

	session_start();
	var_dump($_SESSION);
	var_dump($_GET);

	include 'includes/dp.inc.php';
	include 'includes/funcs.inc.php';

	$customer = $_SESSION['customer_id'];
	$checkToken = $_SESSION['token'];
	/*$transactionid = $_SESSION['transaction_id'];
	$beneficiary = $_SESSION['beneficiary'];
	$amount = $_SESSION['amount'];*/

	if (isset($_GET['amt']) && isset($_GET['tid']) && isset($_GET['beneficiary'])) {
		$transactionid = $_GET['tid'];
		$beneficiary = $_GET['beneficiary'];
		$amount = $_GET['amt'];
	}


	$errors = [];

	if (array_key_exists('submit', $_POST)) {
		
		if (!empty($_POST['inputtoken'])) {

			$token = $_POST['inputtoken'];

		} else {
			$errors ['inputtoken'] = "please input a token";
		}

		if (empty($errors))
		{
			$check = isTokenValid($transactionid, $conn, $_POST['inputtoken']);
			if($check) {

				if (!isset($_GET['add'])) {
					
					transferFrom($customer, $beneficiary, $amount, $conn);
					} else {

						addBeneficiary ($customer, $beneficiary, $conn);
						transferFrom($customer, $beneficiary, $amount, $conn);
					}

				
			} else {
			echo "token is incorrect";
		}	
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Authorization</title>
</head>
<body>
	<form action="<?php echo 'authorization.php?amt='.$_GET['amt'].'&tid='.$_GET['tid'].'
	&beneficiary='.$_GET['beneficiary'].'&add='.$_GET['add'];  ?>"	method="POST">
		<div>
			<input type="text" name="inputtoken" placeholder="input the token sent to you">
			<?php 
				if (isset($errors))
					echo errorMessage('inputtoken', $errors); ?>
		</div>
		<div>
			<input type="submit" name="submit" value="authorize">
		</div>

	</form>
</body>
</html>