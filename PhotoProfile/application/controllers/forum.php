<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forum extends CI_Controller
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
		$data['title'] = 'Forum';        
		$data['validated'] = $this->check_isValidated();        
		$data['addlHeadData'] = '';        
		
		$data['categoryInfo'] = $this->forum_model->GetCategoryInfo();
		$data['topicInfo'] = $this->forum_model->GetTopicInfo();
		$data['postInfo'] = $this->forum_model->GetPostInfo();
		$data['recentPostInfo'] = $this->forum_model->GetRecentPostInfo();
		
		//loop to get last post dates for each category
		
		for($i=1; $i<count($data['categoryInfo'])+1; $i++)
		{
			$lastPost = $this->forum_model->GetLastPostInfo($i);

			$lastPostInfo[] = $lastPost['cat_group'];
			$lastPostInfo[] = $lastPost['post_date'];
			
		}

		$data['lastPostInfo'] = $lastPostInfo;
		
		
		$this->load->view('templates/header', $data);        
		$this->load->view('forum', $data);        
		$this->load->view('templates/footer', $data);    
	}

	public function topic($catId =1)
	{
		$data['title'] = 'Topics' . $catId;
		$data['addlHeadData'] = '';
		$data['validated'] = $this->check_isValidated();
		$data['msg'] = '';

		$data['categoryInfo'] = $this->forum_model->GetTopicPerCategoryInfo($catId);
		$data['topicInfo'] = $this->forum_model->GetTopicInfo();
		$data['topicListInfo'] = $this->forum_model->GetTopicListInfo($catId);
		$data['postInfo'] = $this->forum_model->GetPostInfo();
		$data['recentPostInfo'] = $this->forum_model->GetRecentPostInfo();
		
		//loop to get last post dates per topic
		
		for($i=1; $i<count($data['categoryInfo'])+1; $i++)
		{
			$lastPost = $this->forum_model->GetLastTopicPostInfo($i);

			$lastPostInfo[] = $lastPost['post_topic'];
			$lastPostInfo[] = $lastPost['post_date'];
			
		}
		
		$data['lastPostInfo'] = $lastPostInfo;
		
		$this->load->view('templates/header', $data);
		$this->load->view('topic', $data);
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