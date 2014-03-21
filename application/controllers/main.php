<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	function  __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->model('Main_model');
	}
	
	public function index()
	{
		if($this->session->userdata('email')){
			redirect(site_url('main/home'));
		}else
		{
			$data['url_login'] = site_url().'/main/check_login';
			$data['url_reset'] = site_url().'/main/reset_pass';
			$this->load->view('login',$data);
		}
	}
	
	public function home(){
		if($this->session->userdata('email')){
			echo "welcome";	
		} else redirect(site_url());
	}
	
	function check_login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		//cek attempt
		if($this->Main_model->check_attempt($email)){
			if($this->Main_model->check_login($email,$password)){
				$this->session->set_userdata('email',$email);	
			}				
		}
		else{
			$this->session->set_flashdata("message","failed more than 5 attempt please wait for ".$this->Main_model->waiting_time($email)."s");
		}
		redirect(site_url());
	}
	
	function logout(){
		$this->session->sess_destroy();
		redirect(site_url());
	}

	public function reset_pass()
	{
		$data['url_reset'] = site_url().'/main/reset_pass';
		$this->load->view('reset',$data);
	}
	
	public function upload()
	{
		$data['url_upload'] = site_url().'/main/proses_upload';			
		$this->load->view('upload',$data);
	}
	
	public function proses_upload()
	{
		$file = $this->input->post('file');
		$file = $_FILES['file']['name'];
		if ($_FILES['file']["error"] > 0)
		{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
		}
		else
		{
		if (file_exists("upload/" . $_FILES["file"]["name"]))
			{
			echo $_FILES["file"]["name"] . " already exists. ";
			}
		else
			{
			move_uploaded_file($_FILES["file"]["tmp_name"],
			"upload/" . $_FILES["file"]["name"]);
			}
		}
	}
	
}