<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {


	public function index()
	{
		echo "Welcome to Developer Support API";
	}
	public function bye()
	{
		echo "Bye";
	}
}
