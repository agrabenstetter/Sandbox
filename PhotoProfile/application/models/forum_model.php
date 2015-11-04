<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    class Forum_Model extends CI_Model{
        
		public function __construct(){
            $this->load->database();
			$this->load->library('encrypt');
        }
	
		public function AddCategory($categoryData){
			$this->db->insert('forum_categories', $categoryData);
			return $this->db->insert_id();
		}
		
		public function UpdateCategory($categoryData){
			$this->db->where('cat_id', $categoryData['cat_id']); 
			$this->db->update('forum_categories', $categoryData);
			return true;
		}
		
		public function AddTopic($topicData, $categoryId){
			$memberData = array(
				'memberId' => $memberId,
				'memberTypeId' => $memberTypeId
			);
			
			$this->db->insert('member_member_type', $memberData); 
			return $this->db->insert_id();
		}
		
		public function UpdateTopic($topicData){
			$this->db->where('memberId', $memberId);
			$this->db->update('member_profiles', $profileData);
			return true;
		}
		
		public function GetCategoryInfo(){
			$query = $this->db->get('forum_categories');
			
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}
			return $rows;
		}
		
		public function GetTopicPerCategoryInfo($catId){
			$query = $this->db->where('topic_cat', $catId);
			$query = $this->db->get('forum_topics');
			
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}
			return $rows;
		}
		
		public function GetTopicInfo(){					
			$query = $this->db->get('forum_topics');
			
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}
			return $rows;			
		}
		
		public function GetTopicListInfo($id){
			$query = $this->db->where('topic_cat', $id); 
			$query = $this->db->get('forum_topics');
			
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}	
			return $rows;			
		}
		
		public function GetPostInfo(){					
			$query = $this->db->get('forum_posts');
			
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}
			return $rows;			
		}
		
		public function GetRecentPostInfo(){
			$date = date('Y-m-d H:i:s');
			$query = $this->db->where('post_date <=', $date); 
			$query = $this->db->get('forum_posts',3,0);
			
			$rows = array();
			
			foreach($query->result_array() as $row)
			{
				$rows[] = $row;
			}
			return $rows;			
		}
		
		public function GetLastPostInfo($cat_id){
			$query = $this->db->join('forum_topics', 'forum_topics.topic_id = forum_posts.post_topic');
			$query = $this->db->join('forum_categories','forum_topics.topic_cat = forum_categories.cat_id');
			$query = $this->db->where('topic_cat', $cat_id);
			$query = $this->db->order_by('cat_id', 'desc');
			$query = $this->db->order_by('post_date', 'desc');
			$query = $this->db->get('forum_posts',1,0);
			
			return $query->row_array();		
		}
		
		public function GetLastTopicPostInfo($topic_id){
			$query = $this->db->where('post_topic', $topic_id);
			$query = $this->db->order_by('post_date', 'desc');
			$query = $this->db->get('forum_posts',1,0);
			
			return $query->row_array();		
		}
		
		public function GetCatID($topicID){
			$query = $this->db->join('forum_topics', 'forum_topics.topic_id = forum_posts.post_topic');
			$query = $this->db->where('topic_id', $topicID);
			$query = $this->db->get('forum_posts',1,0);
			
			return $query->row_array();			
		}
		
		public function GetNumPostsPerTopicID($topicID){
			$this->db->where('post_topic', $topicID);
			$this->db->get('forum_posts');
			
			return $this->db->count_all_results();
		}
	}
?>