<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	function  __construct() {
		parent::__construct();
		$this->load->helper(array('url','date','form','directory'));
		$this->load->library(array('encrypt','session'));
		$this->load->model('Main_model');
	}
	
	public function index()
	{
		//periksa apakah sudah login
		if($this->session->userdata('email')){
			//halaman upload
			$folder = $this->Main_model->get_folder($this->session->userdata('email'));
			$data['map'] = directory_map($folder);	
			$data['url_upload'] = site_url().'/main/upload';
			$data['url_folder'] = $folder;
			$data['url_logout'] = site_url().'/main/logout';
			$this->load->view('upload',$data);
		}else
		{
			//halaman login
			$data['url_login'] = site_url().'/main/check_login';
			$data['url_reset'] = site_url().'/main/reset_pass';
			$this->load->view('login',$data);
		}
	}
	
	function check_login(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		//cek attempt
		if($this->Main_model->check_attempt($email)){
			$this->Main_model->check_login($email,$password);
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

	public function reset_pass(){
		$data['url_reset'] = site_url('main/send_forgot_mail');
		$this->load->view('reset',$data);
	}
	
	public function reset_password($token){
		if($this->Main_model->check_token($token)){
			echo 
			"<p>reset password</p>
			<form method='post' action='".site_url('main/update_password')."'>
				<input type='hidden' name='token' value='".$token."'/>
				<input type='password' name='password'>
				<button type='submit'>submit</button>
			</form>";
		}
		else{
			echo "invalid token";
		}
	}
	
	public function update_password(){
		$password = $this->input->post('password');
		$token = $this->input->post('token');
		$this->Main_model->update_password($token,$password);
		redirect(site_url());
	}
	
	public function send_forgot_mail(){
		$email = $this->input->post('email');
		if($token = $this->Main_model->generate_forgot_token($email)){
			$message = "<a href='".site_url('main/reset_password/'.$token)."'>reset password</a>";
			$this->send_mail($email,$message);
		}
		$this->session->set_flashdata('reset_message','check your email');
		redirect(site_url('main/reset_pass'));
	}
	
	public function upload(){
		if($this->session->userdata('email')){
			$folder = $this->Main_model->get_folder($this->session->userdata('email'));
			$dir = FCPATH.'/'.$folder;
			if (!file_exists($dir)) {
					mkdir($dir, 0777, true);
			}
			$config['upload_path'] = $folder;
			$config['allowed_types'] = '*';
			$config['max_size']	= '10000';
			$config['overwrite']	= TRUE;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload())
			{
				$this->session->set_flashdata('upload_error',$this->upload->display_errors());
			}
		}
		redirect(site_url());
	}
	
	public function send_mail($email,$message){
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'tugaskpi1@gmail.com', // change it to yours
			'smtp_pass' => '100%aman', // change it to yours
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
			'wordwrap' => TRUE
		);

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('dedy.berastagi@gmail.com'); // change it to yours
		$this->email->to($email);// change it to yours
		$this->email->subject('Reset Password');
		$this->email->message($message);
		if($this->email->send())
		{
			echo 'Email sent';
		}
		else
		{
			show_error($this->email->print_debugger());
		}
	}
	
}