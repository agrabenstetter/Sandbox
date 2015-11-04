<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Member_Model extends CI_Model{
        public function __construct(){
            $this->load->database();
			$this->load->library('encrypt');
        }
	
		public function AddMember($memberData){
			$this->db->insert('members', $memberData);
			return $this->db->insert_id();
		}
		
		public function UpdateMember($memberId, $memberData){
			$this->db->where('userId', $memberId); 
			$this->db->update('members', $memberData);
			return true;
		}
		
		public function AddMemberType($memberId, $memberTypeId){
			$memberData = array(
				'memberId' => $memberId,
				'memberTypeId' => $memberTypeId
			);

			$this->db->insert('member_member_type', $memberData); 
			return $this->db->insert_id();
		}
		
		public function AddMemberProfile($profileData){
			
			$this->db->insert('member_profiles', $profileData);
			return $this->db->insert_id();
		}
		
		public function UpdateMemberProfile($memberId, $profileData){
			$this->db->where('memberId', $memberId);
			$this->db->update('member_profiles', $profileData);
			return true;
		}
		
		public function AddPhotographerType($type){
			$this->db->insert('member_photographerTypes', $type); 
			return $this->db->insert_id();
		} 
		
		public function AddConfirmationInfo($confirmInfo){					
		
			$this->db->insert('confirmUser', $confirmInfo);						
			return $this->db->insert_id();				
		}
		
		public function AddMemberRatings($ratingInfo){
			$this->db->insert('member_reviews',$ratingInfo);
			return $this->db->insert_id();
		}
		
		public function ClearPhotographerType($memberId){
			$this->db->delete('member_photographerTypes', array('memberId' => $memberId));
		}
		
		public function GetMemberDetails($memberId){
			$query = $this->db->get_where('members', array('userId' => $memberId),1,0);
			
			return $query->row_array();
		}
		
		public function GetMemberProfile($memberId){
			$query = $this->db->get_where('member_profiles', array('memberId' => $memberId),1,0);
			
			return $query->row_array();
		}
		
		public function GetMemberSpecialties($memberId){
			$query = $this->db->get_where('member_photographerTypes', array('memberId' => $memberId),100,0);
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}
			return $rows;
		}
		
		public function GetMemberRatings($memberId){
			$rows = array();
			$query = $this->db->get_where('member_reviews', array('memberId' => $memberId), 10, 0);
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}
			return $rows;
		}
        
        public function GetMemberType($memberId){
            $rows = array();
            
            $this->db->select('*');
            $this->db->from('member_types');
            $this->db->join('member_member_type', 'member_member_type.memberTypeId = member_types.typeId');
            $this->db->where('member_member_type.memberId = ' . $memberId);
            $query = $this->db->get();
            
            return $query->row();
        }
		
		public function GetMemberRatingCount($memberId){
			$rows = array();
			$count = 0;
			$query = $this->db->get_where('member_reviews', array('memberId' => $memberId), 1000, 0);
			
			return $query->num_rows();
		}
		
		public function GetPhotographerTypes(){
			$rows = array();
			$query = $this->db->get('photographer_type');
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}
			return $rows;
		}
		
		public function ValidateUserLogin(){
			$username = $this->security->xss_clean($this->input->post('username'));
			$password = $this->security->xss_clean($this->input->post('password'));
			
			$this->db->where('username', $username);
			
			$query = $this->db->get('members');
			
			if($query->num_rows() == 1)
			{
				$row = $query->row();
				if($this->encrypt->decode($row->password) == $password)
				{
					$data = array(
						'userId' => $row->userId,
						'username' => $row->username,
						'firstName' => $row->firstName,
						'lastName' => $row->lastName,
						'validated' => true,
						'verified' => $row->isAccountVerified
					);
					$this->session->set_userdata($data);
					return true;
				}
				return false;
			}
			return false;
		}
		
		public function ConfirmUserLogin($username){
			
			$this->db->where('username', $username);;
			
			$query = $this->db->get('members');
			
			if($query->num_rows() == 1)
			{
				$row = $query->row();
				$data = array(
					'userId' => $row->userId,
					'username' => $row->username,
					'firstName' => $row->firstName,
					'lastName' => $row->lastName,
					'validated' => true,
					'verified' => $row->isAccountVerified
				);
				$this->session->set_userdata($data);
				return true;
			}
			return false;
		}
		
		/*
		**  UpdateMemberProfile
		**
		**  This function accepts a members unique id record and sets the
		**  isAccountVerified flag in the database so that they may login to the site.
		**	The function also returns users record information for sanity checks and later use in 
		**  the controller.
		*/
		public function VerifyMemberProfile($memberId){			
			$data = array(				
				'isAccountVerified' => '1'			
			);		
			
			$this->db->where('userId', $memberId);
			$this->db->update('members', $data);
			
			$query = $this->db->get_where('members', array('userId' => $memberId, 'isAccountVerified' => '1') ,1,0);
			
			return $query->row_array();	
		}
		
		/*
		**  ClearConfirmationInfo
		**
		**  This function accepts a members unique id record and removes
		**	it from the confirmUser table.
		*/
		
		public function ClearConfirmationInfo($Id){
			$this->db->delete('confirmUser', array('memberId' => $Id));
		}		
		
		/*
		**  GetConfirmationInfo
		**
		**  This function accepts a members uniquely generated pass key and
		**	returns the users record information from the confirmUsers table for
		** 	sanity checks and later use in the controller.
		*/
		
		public function GetConfirmationInfo($key){			
			$query = $this->db->get_where('confirmUser', array('key' => $key) ,1,0);
			return $query->row_array();
		}
		
		/*
		**  GetPasswordInfo
		**
		**  This function accepts a members email and returns their password.
		*/
		
		public function GetPasswordInfo($email){			
			$query = $this->db->get_where('members', array('email' => $email) ,1,0);
			
			if($query->num_rows() == 1)
			{
				$row = $query->row();
				$data = $row->password;
				
				return $data;
			}
			return false;
			
		}
		
		public function CheckEmail($email){
			$this->db->where('email', $email);
			
			$query = $this->db->get('members');
			
			if($query->num_rows() >= 1)
			{
				return true;
			}
			return false;
		}
	}
?>