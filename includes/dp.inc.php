<?php 
	# declare connection constants...
	define('DBNAME', 'Banking');
	define('DBUSER', 'root');
	define('DBPASS', 'DAMILARE8');

	try {
		# prepare a PDO instance...
		$conn = new PDO ('mysql:host=localhost;dbname='.DBNAME, DBUSER, DBPASS); 

		# set verbase error modes...
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

	} catch (PDOexception $e) {
		echo $e->getMessage();
	}
