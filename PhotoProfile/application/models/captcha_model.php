<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Captcha_Model extends CI_Model{
        
		public function __construct(){
            $this->load->database();
        }
		
		public function InsertCaptcha($captchadata){
			$query = $this->db->insert_string('captcha', $captchadata);
			$this->db->query($query);
		}
	}
?>