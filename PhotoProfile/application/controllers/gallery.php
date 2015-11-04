<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gallery extends CI_Controller
{   
    public function __construct()
    {
        parent::__construct();
        //load validation library
        $this->load->library('form_validation');
        
        $this->load->model('forum_model');
        $this->load->model('member_model');
		$this->load->library('encrypt');
		$this->load->library('session');    
    } 

	public function index()
	{        
		$data['title'] = 'Gallery';        
		$data['validated'] = $this->check_isValidated();        
		$data['addlHeadData'] = '';        
		
		//Load Page
		$this->load->view('templates/header', $data);        
		$this->load->view('gallery', $data);        
		$this->load->view('templates/footer', $data);    
	}
	
	public function check_isValidated()
	{		
		if(!$this->session->userdata('validated'))
		{
			return false;
		}		
		else
		{
			return true;
		}	
	}
}
?>