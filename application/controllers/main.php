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
		$data['url_reset'] = site_url().'/main/reset_pass';
		$this->load->view('login',$data);
	}

	public function reset_pass()
	{
		$data['url_reset'] = site_url().'/main/reset_pass';
		$this->load->view('reset',$data);
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