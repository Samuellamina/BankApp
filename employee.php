<?php

	abstract class Employee
		{
			protected $salary;
			protected $type;

			public function setType($type)
			{
				$this->type = $type;
			}

			public function setSalary ($salary)
			{
				$this->salary = $salary;
			}

			public function getType()
			{
				return $this->type;
			}

			public function getSalary()
			{
				return $this->salary;
			}

			abstract public function display();
			abstract public function totalSalary();
		}