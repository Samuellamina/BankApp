<?php

	include 'products.php';
	include 'book.php';

	/*// create a new instance
	$prod = new Product(140, 'Fall Apart', 'Book');

	$prod->setType('Book');
	$prod->setTitle('measuring time');
	$prod->setPrice(500);

	//$prod->title = "things afall apart";
	$show = $prod->display();

	echo $show;*/
	echo '<hr/>';

	$book = new Book(150, 'memeory in time', 'Book', 10000);

	/*$book->setTitle("Memory In Time");
	$book->setType("Book");
	$book->setPrice(150);*/

	$bookshow = $book->display();
	echo $bookshow;
