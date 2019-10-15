<?php

	class Commission extends Employee
		{
			private $sales;
			protected $rate;

			public function __construct ($rate, $sales)
			{
				$this->rate = $rate;
				$this->type = 'Commission Employee';

			}

			public function totalSalary() {
				$this->salary = ($this->rate / 100) * $this->sales;
				return $this->salary;
			}

			public function display() {
				$str = '<ul><li>'.$this->type.'</li></ul>';
				return $str;
			}	
		}