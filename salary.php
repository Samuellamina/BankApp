<?php

	class Salary extends Employee
		{
			const weeklyPay = 1000;

			public function __construct ()
			{
				$this->type = 'Salary Employee';
			}

			public function totalSalary() {
				$this->salary = self::$weeklyPay;
				return $this->salary;
			}
			public function display() {
				$str = '<ul><li>'.$this->type.'</li></ul>';
				return $str;
			}
		}