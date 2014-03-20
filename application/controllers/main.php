<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	function  __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('encrypt');
		$this->load->model('Main_model');
	}
	
	public function index()
	{
		$data['url_login'] = site_url().'/main/check_login';
		$this->load->view('login',$data);
	}
	
	function check_login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if($this->Main_model->check_login($email,$password)){
			echo "SUCESS";
		}
		else{
			redirect(site_url());
		}	
	}
	
}