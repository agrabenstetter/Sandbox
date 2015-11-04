<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class News extends CI_Controller {

    function index(){
        $data['title'] = 'News';
        $data['validated'] = $this->check_isValidated();
        $data['addlHeadData'] = '';
        $this->load->view('templates/header', $data);
        $this->load->view('news', $data);
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