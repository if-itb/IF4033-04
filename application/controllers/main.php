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
<<<<<<< HEAD
		
		$this->load->view('login',$data);
	}
		
=======
		$data['url_reset'] = site_url().'/main/reset_pass';
		$this->load->view('login',$data);
	}

	public function reset_pass()
	{
		$data['url_reset'] = site_url().'/main/reset_pass';
		$this->load->view('reset',$data);
	}
	
>>>>>>> 2e94832fb23b11a5aa6e3026f948da3ad760974c
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
	
	public function upload()
	{
		$data['url_upload'] = site_url().'/main/proses_upload';
				
		$this->load->view('upload',$data);
	}
	
	public function proses_upload()
	{
		$file = $this->input->post('file');
		
		$file = $_FILES['file']['name'];
	
	//upload
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