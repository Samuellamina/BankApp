<?php
	session_start();
	
	include 'includes/dp.inc.php';
	include 'includes/funcs.inc.php';

	$errors = [];

	if(array_key_exists('submit', $_POST)) {
		/*var_dump($_POST);
		exit();*/

		# be sure that one of the beneficiary option is uded...
		if(empty($_POST['accnumber']) && ($_POST['beneficiary'] == 0)) {
			$errors['accnumber'] = "you must enter an account number or select a beneficiary";
		}

		if(!empty($_POST['accnumber']) && ($_POST['beneficiary'] != 0)) {
			$errors['accnumber'] = "only one beneficiary account should be provided";
		}

		if(empty($_POST['pin'])) {
			$errors['pin'] = "enter your pin";
		} else {
			$check = isPINcorrect($conn, $_SESSION['customer_id'], $_POST['pin']);

			if (!$check) {
				$errors['pin'] = "incorrect PIN";
			}
		}

		if (!empty($_POST['amount'])) {

			$amountToSend = $_POST['amount'];	
		} else {
			$errors['amount'] = "enter an amount";
		}

		if (!empty($_POST['addbeneficiary'])) {

			$addBeneficiary = $_POST['addbeneficiary'];

		}// else { $addBeneficiary = false; }

		if(empty($errors)) {

			$beneficiary = (empty($_POST['accnumber'])) ? $_POST['beneficiary'] : $_POST['accnumber'];
			
			$data = makeAuthtoken($conn);
			$_SESSION['token'] = $data[1];
			$payload = 'amt='.$amountToSend.'&tid='.$data[0].'&beneficiary='.$beneficiary.'&add='.$addBeneficiary;
			header('Location: authorization.php?'.$payload);
		} else {
			/*var_dump($errors);*/
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Transfer</title>
</head>
<body>
	<form action="transfers.php" method="POST">
		<?php
			if (isset($_GET['message'])) {
				echo '<h3>'.$_GET['message'].'</h3>';
			}
		?>
		<div>
			<input type="text" name="accnumber" placeholder="Receiver's Bank Account">
			<input type="checkbox" name="addbeneficiary" value="add"><label>Add as beneficiary</label>

		</div>
		<div>
			<select name="beneficiary">
				<option value="0">Select Beneficiary</option>
				<?php
					$beneficiaryList = listBeneficiaries($conn, $_SESSION['customer_id']);
					echo $beneficiaryList;
				?>
			</select>
			<?php 
				if (isset($errors))
					echo errorMessage('accnumber', $errors); ?>
		</div>
		<div>
			<input type="text" name="amount" placeholder="Amount">
			<?php 
				if (isset($errors))
					echo errorMessage('amount', $errors); ?>
		</div>
		<div>
			<input type="password" name="pin" placeholder="pin">
			<?php 
				if (isset($errors))
					echo errorMessage('pin', $errors); ?>
		</div>
		<div>
			<input type="submit" name="submit" value="Send">
		</div>

	</form>
</body>
</html>