<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BrlegalHome extends CI_Controller {

	public function index()
	{
		//echo 'Home CGPERT';
		$this->template->load('templates/template_main-blue','brlegal/brlegal_home');
		//$this->load->view('template_main-blue','cgpert_home');
	}
}
