<?php
namespace Test\Controllers;

use System\Mvc\View\View;

class Home
{
	public function index()
	{
		return new View('test');
	}
}