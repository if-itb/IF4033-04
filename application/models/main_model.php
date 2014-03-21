<?php
define('PW_SALT','(+3%_');
class Main_model extends CI_Model{
    function  __construct() {
        parent::__construct();
    }
		
		function check_login($email,$password){
			//cek apakah terdapat user dengan email yang diberikan
			//jika ada ambil id dan saltnya
			$this->db->select('id,password,salt');
			$this->db->where('email',$email);
			if($query = $this->db->get('login')->row()){
				if($query->password == $this->encrypt->sha1($password.$query->salt))
				{
					$this->sucess_attempt($email);
					$this->session->set_userdata('email',$email);		
					return 1;
				}else
				{	
					$this->failed_attempt($email);
					return 0;
				}	
			}else 
			{
				$this->failed_attempt($email);
				return 0;
			}
		}
		
		function check_attempt($email){
			//periksa percobaan login sebelumnya
			$this->db->select('id,attempt,last_attempt');
			$this->db->where('email',$email);	
			if($query = $this->db->get('login_attempt')->row())
			{
				//jika terdapat percobaan login sebelumnya periksa attempt
				if($query->attempt > 5){
					//jika attempt lebih besar dari 5 periksa last_attempt apakah sudah 5 menit
					if($this->db->query("SELECT timestamp(DATE_SUB(NOW(), INTERVAL 500 SECOND)) >= timestamp('".$query->last_attempt."') as result")->row()->result)
					{
						//jika sudah 5 menit clear attempt
						$this->sucess_attempt($email);
						return 1;	
					}else return 0; //jika belum 5 menit return false					
				}
				//jika attempt lebih kecil dari 5 return true
				return 1;	
			}else{
				$data = array(
					 'email' => $email 
				);
				$this->db->insert('login_attempt', $data); 
			}
			return 1; //jika tidak terdapat percobaan login return true
		}
		
		function failed_attempt($email){
			$this->db->where('email',$email);
			$this->db->set('attempt','attempt+1',FALSE);
			$this->db->set('last_attempt','now()',FALSE);
			$this->db->update('login_attempt');
		}
		
		function sucess_attempt($email){
			$this->db->where('email',$email);
			$this->db->set('attempt','0',FALSE);
			$this->db->set('last_attempt','now()',FALSE);
			$this->db->update('login_attempt');
		}
		
		function waiting_time($email){
			$this->db->select('last_attempt');
			$this->db->where('email',$email);	
			$last_attempt = $this->db->get('login_attempt')->row()->last_attempt;
			$waiting_time = $this->db->query("SELECT UNIX_TIMESTAMP(DATE_ADD('$last_attempt',INTERVAL 500 SECOND)) - UNIX_TIMESTAMP(NOW()) as waiting_time")->row()->waiting_time;
			return $waiting_time;
		}
		
		function get_folder($email){
			$this->db->select('id,salt');
			$this->db->where('email',$email);
			$query = $this->db->get('login')->row();
			return 'upload/'.$query->id.$query->salt;
		}

		function checkEmail($email)
		{
			$error = array('status'=>false,'userID'=>0);
			if (isset($email) && trim($email) != '') {
				//email telah dimasukkan
				$this->db->select('id');
				$this->db->where('email',trim($email));
				$query = $this->db->get('login');
				$numRows = $query->num_rows();
				$userID = $query->row();
				if ($numRows >= 1) return array('status'=>true,'userID'=>$userID);
				
			} else {
				//masukan kosong;
				return $error;
			}
		}

		function sendPasswordEmail($email)
		{
			$this->db->select('id,name,password');
			$this->db->where('email',$email);
			$query = $this->db->get('login');
			$userID= $query->row()->id;
			$pword= $query->row()->password;
			$uname= $query->row()->name;
			$expFormat = mktime(date("H")+1, date("i"), date("s"), date("m")  , date("d"), date("Y"));
			$expDate = date("Y-m-d H:i:s",$expFormat);
			$key = md5($email . rand(0,10000) .$expDate . PW_SALT);
			$data = array(
			   'userId' => $userID ,
			   'key' => $key ,
			   'expDate' => $expDate
			);
			if ($query = $this->db->insert('recovery',$data))
			{
				$passwordLink = "<a href=\"http://localhost/kpi/index.php/main/reset_pass?a=recover&email=" . $key . "&u=" . urlencode(base64_encode($userID)) . "\">http://localhost/kpi/index.php/main/reset_pass?a=recover&email=" . $key . "&u=" . urlencode(base64_encode($userID)) . "</a>";
				$message = "Halo $uname,\r\n";
				$message .= "Silahkan klik link berikut untuk reset password Anda:\r\n";
				$message .= "-----------------------\r\n";
				$message .= "$passwordLink\r\n";
				$message .= "-----------------------\r\n";
				$message .= "Yakinkan untuk mengcopy keseluruhan link ke browser Anda. Link akan kadaluarsa dalam waktu 1 jam untuk kepentingan keamanan\r\n\r\n";
				$message .= "Jika Anda tidak merasa mencoba mengubah password, abaikan email ini.\r\n\r\n";
				$message .= "Terimakasih,\r\n";
				$message .= "-- IDJ Team";
				$headers = "From: Our Site <webmaster@localhost.com> \n";
				$headers .= "To-Sender: \n";
				$headers .= "X-Mailer: PHP\n"; // mailer
				$headers .= "Reply-To: webmaster@localhost.com\n"; // Reply address
				$headers .= "Return-Path: webmaster@localhost.com\n"; //Return Path for errors
				$headers .= "Content-Type: text/html; charset=iso-8859-1"; //Enc-type
				$subject = "Reset Password";
					require("phpmailer/class.phpmailer.php");
				$mail = new PHPMailer();
				$mail->IsSMTP();                                      // set mailer to use SMTP
				$mail->Host = "smtp.gmail.com";  // specify main and backup server
				$mail->SMTPSecure = "tls";
				$mail->Port       = 587;
				$mail->SMTPAuth = true;     // turn on SMTP authentication
				$mail->Username = "iqbalmuhammad.18@gmail.com";  // SMTP username
				$mail->Password = "!8Atryuasdf"; // SMTP password
				$mail->From = "iqbalmuhammad.18@gmail.com";
				$mail->FromName = "Muhammad Iqbal";
				$mail->AddAddress($email);
				$mail->AddReplyTo("iqbalmuhammad.18@gmail.com", "Information");
				$mail->WordWrap = 50;                                 // set word wrap to 50 characters
				$mail->IsHTML(true);                                  // set email format to HTML
				$mail->Subject = $subject;
				$mail->Body    = $message;
				$mail->AltBody = "This is the body in plain text for non-HTML mail clients";
				if(!$mail->Send())
				{
				   echo "Message could not be sent. <p>";
				   echo "Mailer Error: " . $mail->ErrorInfo;
				   exit;
				}
				return str_replace("\r\n","<br/ >",$message);
			
			}
		}

		function checkEmailKey($key,$userID)
		{
			$curDate = date("Y-m-d H:i:s");
			$this->db->select('userId');
			$this->db->where('key',$key);
			$this->db->where('userId',$userID);
			$this->db->where('expDate >=', $curDate);
			$query = $this->db->get('recovery');
			$numRows = $query->num_rows();
			$userID = $query->row();
			if ($numRows > 0 && $userID != '')
			{
				return array('status'=>true,'userID'=>$userID);
			}
			return false;
		}

		function updateUserPassword($userID,$password,$key)
		{
			if ($this->Main_model->checkEmailKey($key,$userID) === false) return false;
			$password = md5(trim($password) . PW_SALT);
			$data = array(
               'password' => $password
            );
			$this->db->where('id',$userID);
			if ($query = $this->db->update('login',$data))
			{	
				$this->db->where('key',$key);
				$this->db->delete('recovery');
			}
		}

		function getEmail($userID)
		{
			$this->db->select('email');
			$this->db->where('id',$userID);
			if ($query = $this->db->get('login')->row())
			{
				$uname = $query->row();
				return $uname;
			}
		}
	}		
?>