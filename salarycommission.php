<?php

	class SalaryCommission extends Employee
		{
			private $bonusTotal;
			private $salesMade;

			public function __construct ($salary, $type, $sales, $bonus)
			{
				$this->bonusTotal = $bonus;
				$this->salary = $salary;
				$this->type = $type;
				$this->salesMade = $sales;

			}

			public function totalSalary() {
				$total = $sales * 100;
				return $total;
			}

			public function display() {
				$str = '';
				$str .= '<ul><li>'.$this->type.'</li>';
				$str .= '<li>'.$this->salary.'</li>';
				$str .= '<li>'.$this->salesMade.'</li>';
				$str .= '<li>'.$this->bonusTotal.'</li></ul>';

				return $str;
			}
		}