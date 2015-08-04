<?php
namespace App\Controllers;

use System\Mvc\View\View;

class Home
{
	public function index()
	{
		return new View('test');
	}
}