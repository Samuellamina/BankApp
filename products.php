<?php
	
	abstract class Product 
	{
		/*private $price;
		private $type;
		private $title;
*/

		protected $price;
		protected $type;
		protected $title;

		/*public function __construct ($price, $title, $type)
		{	
			$this->price = $price;
			$this->type = $type;
			$this->title = $title;
		}
*/
		public function setType($type)
		{
			$this->type = $type;
		}

		public function setPrice ($price)
		{
			$this->price = $price;
		}

		public function setTitle ($title)
		{
			$this->title = $title;
		}

		public function getTitle()
		{
			return $this->title;
		}

		public function getType()
		{
			return $this->type;
		}

		public function getPrice()
		{
			return $this->price;
		}

		/*public function display() {
			$str = '';
			$str .= '<ul><li>'.$this->type.'</li>';
			$str .= '<li>'.$this->price.'</li>';
			$str .= '<li>'.$this->title.'</li></ul>';

			return $str;
		}*/

		abstract public function display();
	}