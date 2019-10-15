<?php

	class Hourly extends Employee
		{
			const workHours = 40;
			protected $overtime;
			protected $rate;
			private $hoursWorked;

			public function __construct ($hours, $rate)
			{
				$this->hoursWorked = $hours;
				$this->type = 'Hourly Employee';
				$this->rate = $rate;

			}

			public function totalSalary() {
				if ($this->hoursWorked > self::$workHours) {
					$this->overtime = $this->hours - self::$workHours;
					$this->salary = ($this->rate * self::$workHours) + ($this->rate * $this->overtime);
				} else {
					$this->salary = $this->rate * self::$workHours;
				}

				return $this->salary;
			}

			public function display() {
				$str = '';
				$str .= '<ul><li>'.$this->type.'</li>';
				$str .= '<li>'.$this->salary.'</li>';
				$str .= '<li>'.$this->hours.'</li>';
				$str .= '<li>'.$this->bonusTotal.'</li></ul>';

				return $str;
			}
		}