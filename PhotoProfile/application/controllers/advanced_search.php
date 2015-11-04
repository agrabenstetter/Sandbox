<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advanced_Search extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('search_model');
    }
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *         http://example.com/index.php/welcome
     *    - or -  
     *         http://example.com/index.php/welcome/index
     *    - or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
         
          
		  $data['title'] = 'Search';
		  
          $this->load->view('templates/header', $data);
          $this->load->view('advanced_search', $data);
          $this->load->view('templates/footer', $data);
    }
    
    public function viewResults()
    {
		//$formData = $this->input->post('');
		
		$milesFrom = $this->input->post('milesFrom');
		$zipcode = $this->input->post('location');
		$minPrice = $this->input->post('minPrice');
		$maxPrice = $this->input->post('maxPrice');
		
        $data['results'] = $this->search_model->get_searchResults($milesFrom, $zipcode, $minPrice, $maxPrice);
        $data['title'] = 'Search Results';
		
		$data['distance'] = $this->input->post('milesFrom');
        
        $this->load->view('templates/header', $data);
        $this->load->view('search_results', $data);
        $this->load->view('templates/footer', $data);
        
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */