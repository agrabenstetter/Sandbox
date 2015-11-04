<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Policy extends CI_Controller {

    function index(){
        $data['title'] = 'Privacy Policy';
        $data['validated'] = $this->check_isValidated();
        $data['addlHeadData'] = '';
        $this->load->view('templates/header', $data);
        $this->load->view('privacy_policy', $data);
        $this->load->view('templates/footer', $data);
    }
	
	function privacy(){
        $data['title'] = 'Privacy Policy';
        $data['validated'] = $this->check_isValidated();
        $data['addlHeadData'] = '';
        $this->load->view('templates/header', $data);
        $this->load->view('privacy_policy', $data);
        $this->load->view('templates/footer', $data);
    }
	
	function terms(){
        $data['title'] = 'Terms Of Use';
        $data['validated'] = $this->check_isValidated();
        $data['addlHeadData'] = '';
        $this->load->view('templates/header', $data);
        $this->load->view('terms_of_use', $data);
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