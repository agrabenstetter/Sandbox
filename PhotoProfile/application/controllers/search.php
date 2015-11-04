<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		//load validation library
		$this->load->library('form_validation');
		
        $this->load->model('search_model');
		$this->load->model('image_model');
		$this->load->model('member_model');
		$this->load->library('pagination');
    }

    public function index()
    {
         
          
		  $data['title'] = 'Search';
		  $data['addlHeadData'] = '';
		  $data['validated'] = $this->check_isValidated();
		  $data['msg'] = '';
		  
		  $data['phoTypes'] = $this->member_model->GetPhotographerTypes();
		  
          $this->load->view('templates/header', $data);
          $this->load->view('search', $data);
          $this->load->view('templates/footer', $data);
    }
	
	public function browseCategory($catId)
	{
		$data['addlHeadData'] = '';
		$data['msg'] = '';
		$data['validated'] = $this->check_isValidated();
		$data['phoTypes'] = $this->member_model->GetPhotographerTypes();
		$data['results'] =  $this->search_model->getMembersByCategory($catId);
		
		if(!empty($data['results']))
		{
			foreach($data['results'] as $result_item){
				$memberProfileImageAlbum = $this->image_model->GetMemberProfileImageAlbumIdOnly($result_item['userId']);
				$data['profilePhoto'][] = $this->image_model->GetMemberProfileImage($result_item['userId'], $memberProfileImageAlbum);
			}
			
			$this->load->view('templates/header', $data);
			$this->load->view('search_results', $data);
			$this->load->view('templates/footer', $data);
		}
		else
		{
			$msg = '<h2 style="color: red;">No results based on search criteria</h2>';
			$data['msg'] = $msg;
			
			$this->load->view('templates/header', $data);
			$this->load->view('search_results', $data);
			$this->load->view('templates/footer', $data);
		}
	}
    
    public function viewResults()
    {
		$data['addlHeadData'] = '';
		$data['validated'] = $this->check_isValidated();
		$data['msg'] = '';
		
		$milesFrom = $this->input->post('milesFrom');
		$zipcode = $this->input->post('location');
		$minPrice = $this->input->post('minPrice');
		$maxPrice = $this->input->post('maxPrice');
		$chargeType = $this->input->post('photoChargeType');
		
		//setting validation rules before running the validation routine
		$this->form_validation->set_rules('milesFrom', 'Miles Within', 'numeric|grater_than[0]');
		$this->form_validation->set_rules('location', 'Postal Code', 'exact_length[5]|numeric');
		
		//check postalcode exists
		if ($zipcode != ''){
			$result = $this->search_model->checkPostalCode($zipcode);
		}
		else{
			$result = 1;
		}
			
		//running validation routine, if all is well than complete viewResults() otherwise show the validation errors.
		if(($this->form_validation->run() == TRUE) && $result != 0){
			if(is_null($zipcode) or $zipcode == ''){
				$zipcode = NULL;
			}
			
			$photographerTypes = array();
			
			if($this->input->post('photoCat') != false){
				foreach($this->input->post('photoCat') as $checked){
					$photographerTypes[] = $checked;
				}
			}
			
			$data['results'] = $this->search_model->get_searchResults($milesFrom, $zipcode, $minPrice, $maxPrice, $chargeType, $photographerTypes);
			$data['phoTypes'] = $this->member_model->GetPhotographerTypes();
			$data['zip'] = $this->input->post('location');
			$data['title'] = 'Search Results';
			
			if(!empty($data['results']))
			{
				foreach($data['results'] as $result_item)
				{
					$memberProfileImageAlbum = $this->image_model->GetMemberProfileImageAlbumIdOnly($result_item['userId']);
					$data['profilePhoto'][] = $this->image_model->GetMemberProfileImage($result_item['userId'], $memberProfileImageAlbum);
				}

				$this->load->view('templates/header', $data);
				$this->load->view('search_results', $data);
				$this->load->view('templates/footer', $data);
			}
			else
			{
				$msg = '<h2 style="color: red;">No results based on search criteria</h2>';
				$data['msg'] = $msg;
				
				$this->load->view('templates/header', $data);
				$this->load->view('search_results', $data);
				$this->load->view('templates/footer', $data);
			}
		}
		else{
			$msg = '<h2 style="color: red;">Search criteria is not valid</h2>';
			$data['msg'] = $msg;
			$data['phoTypes'] = $this->member_model->GetPhotographerTypes();

			$this->load->view('templates/header', $data);
			$this->load->view('search', $data);
			$this->load->view('templates/footer', $data);
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