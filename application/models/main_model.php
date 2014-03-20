<?php
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
					return 1;
				}else return 0;
			}else return 0;
		}
}		
?>