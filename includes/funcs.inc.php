<?php

	function errorMessage($field, $errorL)
	{
		if (array_key_exists($field, $errorL)) {
			return $errorL[$field];
		}
	}

	function Login ($mail, $dbconn, $pass)
		{

		$isLogin = false;

		$stmt = $dbconn->prepare("SELECT * FROM customer WHERE email = :e");
		$stmt->bindparam(":e", $mail);
		$stmt->execute();

		if ($stmt->rowCount() !=1) {
			return [$isLogin];
		}
			
		$record = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!password_verify($pass, $record['password'])) {
				return [$isLogin];
		}

		$isLogin = true;

		return [$isLogin, $record];
	}

	function listBeneficiaries($dbconn, $custID) {

		$result;

		$stmt = $dbconn->prepare('SELECT * FROM beneficiary WHERE customer_id = :id');
		$stmt->bindparam(':id', $custID);
		$stmt->execute();

		while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$result .= '<option value="'.$record['accnumber'].'">'.$record['firstname'].' '.$record['lastname'].''.$record['accnumber'].'</option>';
		}

			return $result;
	}

	function isPINcorrect($dbconn, $custID, $pin) {
		$result = false;

		$stmt = $dbconn->prepare('SELECT pin FROM account WHERE customer_id=:id AND pin=:p');
		$stmt->execute([
			':id' => $custID,
			':p' => $pin
		]);

		if ($stmt->rowCount() == 1) {
			$result = true; 
		}

		return $result;
	}

	function transferFrom($customer, $beneficiary, $amount, $dbconn)
	{	
		$balance = getCustomerBalance($dbconn, $customer);
		$check = isBalanceSufficient($balance, $amount);
		
		if ($check) {
			settleCustomers($dbconn, $amount, $customer, $beneficiary);
			header("Location: transfers.php?message=Success");
			exit();
		} else {
			header("Location: transfers.php?message=Insufficient funds");
			exit();
		}

	}

	function getCustomerBalance($dbconn, $customer)
	{
		$result;

		$stmt = $dbconn->prepare('SELECT * FROM account WHERE customer_id = :id');
		$stmt->bindparam(':id', $customer);
		$stmt->execute();

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$customerBalance = $result['balance'];
		return $customerBalance;

	}

	function isBalanceSufficient($customerBalance, $amount)
	{
		$result = false;

		if ($customerBalance < $amount) {
			return $result;
		} else {
			$result = true;
		}

		return $result;
	}

	function settleCustomers($dbconn, $amount, $customer, $beneficiary)
	{
		$stmt = $dbconn->prepare('UPDATE account SET balance = balance - :amount WHERE customer_id=:id');
		$stmt->execute([
			':id'=>$customer,
			':amount'=>$amount
		]);

		$stmt1= $dbconn->prepare('UPDATE account SET balance = balance + :amount WHERE accnumber=:ac');
		$stmt1->execute([
			':ac'=>$beneficiary,
			':amount'=>$amount
		]);
	}

	function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
        mt_rand( 0, 0xffff ),
        mt_rand( 0, 0x0fff ) | 0x4000,
        mt_rand( 0, 0x3fff ) | 0x8000,
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    	);
	}

	function makeAuthToken($dbconn) {
		$transactionID = gen_uuid();
		$token = mt_rand(100000, 999999);
		$token_hash = password_hash($token, PASSWORD_BCRYPT);

		saveToken($dbconn, $transactionID, $token_hash);

		return [$transactionID, $token];
	}

	function saveToken($dbconn, $transactionID, $token_hash)
	{
		$stmt = $dbconn->prepare('INSERT INTO authorization(transaction_id, token) VALUES (:tid, :tkn)');
		$stmt->execute([
			':tid'=>$transactionID,
			':tkn'=>$token_hash
		]);
	}

	function isTokenValid($transactionID, $dbconn, $token)
		{

		$isValid = false;

		$stmt = $dbconn->prepare("SELECT * FROM authorization WHERE transaction_id = :tid");
		$stmt->bindparam(":tid", $transactionID);
		$stmt->execute();

		if ($stmt->rowCount() !=1) {
			header("Location: error.php");
		}
			
		$record = $stmt->fetch(PDO::FETCH_ASSOC);

		return password_verify($token, $record['token']);
	}

	function getCustomerID ($accNum, $dbconn) {

		$details;

		$stmt = $dbconn->prepare('SELECT * FROM account WHERE accnumber = :ac');
		$stmt->bindparam(':ac', $accNum);
		$stmt->execute();

		$record = $stmt->fetch(PDO::FETCH_ASSOC);
		$details = $record['id'];
		return $details;
	}

	function getCustomerData ($accNum, $dbconn) {
		$data = getCustomerID($accNum, $dbconn);

		$stmt = $dbconn->prepare('SELECT * FROM customer WHERE id = :id');
		$stmt->bindparam(':id', $data);
		$stmt->execute();

		$record = $stmt->fetch(PDO::FETCH_ASSOC);
		return [$record['firstname'], $record['lastname']];

	}

	function addBeneficiary ($custID, $accNum, $dbconn)
	{
		$customerData = getCustomerData ($accNum, $dbconn);
		$firstname = $customerData[0];
		$lastname = $customerData[1];

		$stmt = $dbconn->prepare('INSERT INTO beneficiary(customer_id, firstname, lastname, accnumber) VALUES (:cid, :fn, :ln, :ac)');
		$stmt->execute([
			':cid'=>$custID,
			':fn'=>$firstname,
			':ln'=>$lastname,
			':ac'=>$accNum
		]);
	}



	