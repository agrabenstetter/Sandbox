<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		//load libraries/models here
		$this->load->model('search_model');
		$this->load->model('image_model');
		$this->load->model('member_model');
    }

    public function index()
    { 
		  $data['title'] = 'Home';
		  $data['addlHeadData'] = '
		  <script type="text/javascript" src="http://photographerprofile.com/js/jquery-photostack.js"></script>
		  <script type="text/javascript" src="http://photographerprofile.com/js/jquery-coin-slider.min.js"></script>
		  ';
		  $data['validated'] = $this->check_isValidated();
		  
		  $filldepth = 3;
		  $featuredPhotographer = 2;
		  
		  $data['newMembers'] = $this->search_model->getNewestMembers($filldepth);
		  $data['featuredPhotographer'] = $this->search_model->getFeaturedPhotographer($featuredPhotographer);
		  $data['featuredPhotos'] = $this->image_model->GetFeaturedImages($featuredPhotographer);
		  
		  foreach($data['newMembers'] as $result){
			$albumID = $this->image_model->GetMemberProfileImageAlbumIdOnly($result['userID']);
			$data['imageFile'][] = $this->image_model->GetMemberProfileImage($result['userID'], $albumID);
		  }
		  

          $this->load->view('templates/header', $data);
          $this->load->view('home', $data);
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