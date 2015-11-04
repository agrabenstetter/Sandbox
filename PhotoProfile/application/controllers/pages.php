<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
  class Pages extends CI_Controller{
      public function index(){
          $this->load->view('welcome_message');
      }
      
      public function view($page = 'home')
      {
          if(!file_exists('application/views/'.$page.'.php'))
          {
              show_404();
          }
          
          $data['title'] = ucfirst($page);
          
          $this->load->view('templates/header', $data);
          $this->load->view('pages/'.$page, $data);
          $this->load->view('templates/footer', $data);
      }
  }
?>
