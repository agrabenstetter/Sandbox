<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact extends CI_Controller {

	public function index()
	{
		$data['title'] = 'Contact';
        $data['validated'] = $this->check_isValidated();
        $data['addlHeadData'] = '';
		//$data['msg'] = $msg;
        $this->load->view('templates/header', $data);
        $this->load->view('contact', $data);
        $this->load->view('templates/footer', $data);
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('content', 'Inquiry', 'trim|required|xss_clean');

		if($this->form_validation->run() == TRUE) {
				$message = 'Name:'.$this->input->post('name').', Email:'.$this->input->post('email').', Message:'.$this->input->post('content');
				mail('mrwii81@gmail.com', 'Contact Inquiry', $message);
				$this->load->view('contact_submit');
		} 
		else {
				$errors = validation_errors();
				//$errorDisplay = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>".$errors."</p></div>"; // validation_errors();
				//$this->index($errorDisplay);
				echo $errors;
		}
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