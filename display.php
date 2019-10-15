<?php
	
	include 'employee.php';
	include 'salary.php';
	include 'hourly.php';
	include 'commission.php';
	include 'salarycommission.php';

	$salary = new Salary (2000);
	$showSalaryEmployees = $salary->display();
	echo $showSalaryEmployees;
	$totalSalary = $salary->totalSalary();
	echo $totalSalary;
	echo "<hr/>";


	$hourly = new Hourly('paid $40 per hour', 'Hourly Employee', '42 hours worked this week', '2 hour bonus');
	$showHourlyEmployees = $hourly->display();
	echo $showHourlyEmployees;
	$totalSalary = $hourly->totalSalary();
	echo $totalSalary;
	echo "<hr/>";


	$commission = new Commission (5, 10000);
	$showCommissionEmployees = $commission->display();
	echo $showCommissionEmployees;
	$totalSalary = $commission->totalSalary();
	echo $totalSalary;
	echo "<hr/>";


	$salaryCommission = new salaryCommission('paid $1200 per week and a % of sales','Salary Commission Employee',
						 '3400 sales made this week', '10% Bonus added to salary this week');
	$showSalaryCommissionEmployees = $salaryCommission->display();
	echo $showSalaryCommissionEmployees;
	$totalSalary = $salaryCommission->totalSalary();
	echo $totalSalary;
	echo "<hr/>";