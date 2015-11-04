<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Image_Model extends CI_Model{
        
		public function __construct(){
            $this->load->database();
        }
	
		public function GetMemberImages($memberId){
		
			$this->db->select('member_photos.fileName, member_photos.memberId, member_photos.albumId, member_photos.fileDescription');
			$this->db->from('member_photos');
			$this->db->join('member_albums', 'member_albums.id = member_photos.albumId');
			$this->db->where('member_photos.memberId', $memberId);
			$this->db->where('member_albums.albumTypeId !=', 0);
			$this->db->limit(50);
			$query = $this->db->get();
			//return $query->result_array();
		
			//$query = $this->db->get_where('member_photos', array('memberId' => $memberId),50,0);
            $rows = array();
            
            foreach($query->result_array() as $row)
            {
				if($row['fileName'] != 'profileImage.jpg')
				{
					$rows[] = $row;
				}
            }
            return $rows;
		}
		
		public function GetImage($fileId){
			$query = $this->db->get_where('member_photos', array('fileId' => $fileId),50,0);
			return $query->row();
		}
		
		public function AddImage($uploadData){
			$this->db->insert('member_photos', $uploadData);
			return $this->db->insert_id();
		}
		
		public function AddProfileImage($imageData){
			$this->db->insert('member_photos', $imageData);
			return $this->db->insert_id();
		}
		
		public function RemoveImage($fileId){
			//TODO: add funtion
		}
		
		public function GetMemberAlbums($memberId){
			$query = $this->db->get_where('member_albums', array('memberId' => $memberId),50,0);
			$rows = array();
			foreach($query->result_array() as $row)
			{
				if($row['albumName'] != 'profileImage')
				{
					$rows[] = $row;
				}
			}
			return $rows;
		}
		
		public function GetMemberProfileImageAlbumId($memberId){
			$this->db->where('memberId', $memberId);
			$this->db->where('albumName', 'profileImage');
			
			$query = $this->db->get('member_albums');
			
			if($query->num_rows() == 1)
			{
				$row = $query->row();
				$data = array(
					'id' => $row->id
				);
				return $data;
			}
		}
		
		public function GetMemberProfileImageAlbumIds($results){
			$query = $this->db->get_where('member_albums', array('memberId' => $results['userId'], 'albumName' => 'profileImage'),50,0);
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				if($row['albumName'] == 'profileImage')
				{
					$rows = $row;
				}
				else
				{
					$rows = NULL;
				}
			}
			return $rows;
		}
        
		public function GetMemberProfileImage($memberId, $albumId){
			$this->db->where('memberId',$memberId);
			$this->db->where('albumId', $albumId);
			
			$query = $this->db->get('member_photos');
			
			if($query->num_rows() == 1)
			{
				$row = $query->row();
				$data = array(
					'fileName' => $row->fileName
				);
				return $data;
			}
			{
				$data = array(
					'fileName' => NULL
				);
				return $data;
			}
		}
		
		public function GetMemberProfileImages($data){
			$query = $this->db->select('fileName');
			$query = $this->db->get_where('member_photos', array( 'albumId' => $data),50,0);
			
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				if($row)
				{
					$rows = $row;
				}
				else
				{
					$rows = NULL;
				}
			}
			return $rows;
		}
		
        /*
		**  AddMemberPhotoAlbum
		**
		**  This function adds a new photo album to a members profile.
		*/
		
		public function AddMemberPhotoAlbum($memberId, $albumName){
			$this->db->insert('member_albums', array('memberId' => $memberId, 'albumName' => $albumName));
			return $this->db->insert_id();
		}
		
		/*
		**  UpdateMemberPhotoAlbum
		**
		**  This function updates a photo album already created in a members profile.
		*/
		
		public function UpdateMemberPhotoAlbum($memberId, $albumName){
			$this->db->where('memberId', $memberId);
			$this->db->where('albumName', $albumName); 
			$this->db->update('member_albums', $memberData);
			return $this->db->insert_id();
		}
		
		/*
		**  DeleteMemberPhotoAlbum
		**
		**  This function returns an array of photo albums for a provided memberId.
		*/
		
		public function DeleteMemberPhotoAlbum($memberId, $albumName){
			$this->db->delete('member_albums', $memberData);
		}	
		
		public function GetMemberProfileImageAlbumIdOnly($memberId){
			$this->db->select('id');
			$this->db->where('memberId', $memberId);
			$this->db->where('albumName', 'profileImage');
			
			$query = $this->db->get('member_albums');
			
			return $query->row('id');
		}
			
		public function GetFeaturedImages($memberId){
			$this->db->select('member_photos.fileName, member_photos.memberId, member_albums.albumName');
			$this->db->from('member_photos');
			$this->db->join('member_albums', 'member_albums.id = member_photos.albumId');
			$this->db->where('member_photos.memberId', $memberId);
			$this->db->where('member_albums.albumTypeId !=', 0);
			$this->db->limit(5);
			$query = $this->db->get();
			return $query->result_array();
		}
	}
?>