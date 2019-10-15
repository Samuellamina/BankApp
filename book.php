<?php

	class Book extends Product
	{
		private $pageCount;
		

		public function __construct ($price, $title, $type, $pages)
		{
			# call an overidden constructor ...
			//parent::__construct($price, $title, $type);
			$this->pageCount = $pages;
			$this->price = $price;
			$this->type = $type;
			$this->title = $title;

		}

		/*public function setPageCount($pages)
		{
			$this->pageCount = $pages;
		}*/

		public function display() {
			$str = '';
			$str .= '<ul><li>'.$this->type.'</li>';
			$str .= '<li>'.$this->pageCount.'</li>';
			$str .= '<li>'.$this->price.'</li>';
			$str .= '<li>'.$this->title.'</li></ul>';

			return $str;
	}
}