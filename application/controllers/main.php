<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	function  __construct() {
		parent::__construct();
		$this->load->helper('url');
	}
	
	public function index()
	{
		$data['url_login'] = site_url().'/main/check_login';
		$this->load->view('login',$data);
	}
	
	function check_login(){
		echo "test";
	}
	
}