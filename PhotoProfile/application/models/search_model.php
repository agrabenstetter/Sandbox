<?php
    class Search_Model extends CI_Model{
        public function __construct(){
            $this->load->database();
        }
        public function get_searchResults($milesFrom, $zipcode, $minPriceRange, $maxPriceRange, $chargeType, $photographerTypes){			
		$zipcodes = array();
			if (!is_null($zipcode)){
				$query = $this->db->get_where('zipcodes', array('zipcode' => $zipcode),1,0);
				if($query->num_rows() > 0){
					$latlong = $query->row();
					$queryString="SELECT zipcode, city, ( 3959 * acos( cos( radians( ".$latlong->latitude." ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ".$latlong->longitude." ) ) + sin( radians( ".$latlong->latitude." ) ) * sin( radians( latitude ) ) ) ) AS distance FROM zipcodes HAVING distance <= ".$milesFrom." ORDER BY distance";
					$newQuery = $this->db->query($queryString);					
					foreach($newQuery->result_array() as $zipResult)
					{
						$zipcodes[] = $zipResult['zipcode'];
					}
				}
				$this->db->distinct();
				$this->db->select('members.userId, members.username, members.shortBio');
				$this->db->where_in('zipPostalCode', $zipcodes);
				
					if($minPriceRange != '' && $maxPriceRange != ''){
						$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
						$this->db->where('member_photographerTypes.minPrice >=', $minPriceRange);
						$this->db->where('member_photographerTypes.maxPrice <=', $maxPriceRange);
						$this->db->order_by("minPrice", "desc");
						if(!empty($photographerTypes)){
							$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
							$this->db->where_in('photographer_type.photographerType', $photographerTypes);
						}
					}
					else if ($minPriceRange == '' && $maxPriceRange != ''){
						$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
						$this->db->where('member_photographerTypes.maxPrice <=', $maxPriceRange);
						$this->db->order_by("maxPrice", "desc");
						if(!empty($photographerTypes)){
							$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
							$this->db->where_in('photographer_type.photographerType', $photographerTypes);
						}
					}
					else if ($minPriceRange != '' && $maxPriceRange == ''){
						$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
						$this->db->where('member_photographerTypes.minPrice >=', $minPriceRange);
						$this->db->order_by("minPrice", "desc");
						if(!empty($photographerTypes)){
							$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
							$this->db->where_in('photographer_type.photographerType', $photographerTypes);
						}
					}
					
					if($chargeType != ''){
						if($minPriceRange == '' && $maxPriceRange == ''){
							$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
							if(!empty($photographerTypes)){
								$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
								$this->db->where_in('photographer_type.photographerType', $photographerTypes);
							}
						}
						$this->db->where('member_photographerTypes.photoChargeType', $chargeType);
					}
					else{
						if($minPriceRange == '' && $maxPriceRange == ''){
							if(!empty($photographerTypes)){
								$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
								$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
								$this->db->where_in('photographer_type.photographerType', $photographerTypes);
							}
						}
					}
					
					$query = $this->db->get('members');
					return $query->result_array();			
				}			
				else{
					$this->db->distinct();
					$this->db->select('members.userId, members.username, members.shortBio');
					
					if($minPriceRange != '' && $maxPriceRange != ''){
						$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
						$this->db->where('member_photographerTypes.minPrice >=', $minPriceRange);
						$this->db->where('member_photographerTypes.maxPrice <=', $maxPriceRange);
						$this->db->order_by("minPrice", "desc");
						if(!empty($photographerTypes)){
							$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
							$this->db->where_in('photographer_type.photographerType', $photographerTypes);
						}
					}
					else if ($minPriceRange == '' && $maxPriceRange != ''){
						$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
						$this->db->where('member_photographerTypes.maxPrice <=', $maxPriceRange);
						$this->db->order_by("maxPrice", "desc");
						if(!empty($photographerTypes)){
							$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
							$this->db->where_in('photographer_type.photographerType', $photographerTypes);
						}
					}
					else if ($minPriceRange != '' && $maxPriceRange == ''){
						$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
						$this->db->where('member_photographerTypes.minPrice >=', $minPriceRange);
						$this->db->order_by("minPrice", "desc");
						if(!empty($photographerTypes)){
							$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
							$this->db->where_in('photographer_type.photographerType', $photographerTypes);
						}
					}

					if($chargeType != ''){
						if($minPriceRange == '' && $maxPriceRange == ''){
							$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
							if(!empty($photographerTypes)){
								$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
								$this->db->where_in('photographer_type.photographerType', $photographerTypes);
							}
						}
						$this->db->where('member_photographerTypes.photoChargeType', $chargeType);
					}
					else{
						if($minPriceRange == '' && $maxPriceRange == ''){
							if(!empty($photographerTypes)){
								$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
								$this->db->join('photographer_type', 'member_photographerTypes.photographerTypeId = photographer_type.id');
								$this->db->where_in('photographer_type.photographerType', $photographerTypes);
							}
						}
					}
					
				$query = $this->db->get('members');	
				return $query->result_array();			
				}
        }				
		
		public function checkPostalCode($zipcode){			
		$query = $this->db->get_where('zipcodes', array('zipcode' => $zipcode),1,0);			
		return $query->num_rows();		
		}
		
		public function getMembersByCategory($catId){
			$this->db->select('*');
			$this->db->from('members');
			$this->db->join('member_photographerTypes', 'member_photographerTypes.memberId = members.userId');
			$this->db->where('member_photographerTypes.photographerTypeId = ' . $catId);
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function get_zipcodesWithinDistance($zipcode, $distance){
			$query = $this->db->get_where('zipcodes', array('zipcode' => $zipcode),1,0);
			if($query->num_rows() > 0){
				$latlong = $query->row();
				$queryString="SELECT zipcode, city, ( 3959 * acos( cos( radians( ".$latlong->latitude." ) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians( ".$latlong->longitude." ) ) + sin( radians( ".$latlong->latitude." ) ) * sin( radians( latitude ) ) ) ) AS distance FROM zipcodes HAVING distance <= ".$milesFrom." ORDER BY distance";
				//$newQuery = $this->db->query("SELECT zipcode, ( 3959 * acos( cos( radians( {$latlong->lat} ) ) * cos( radians( lat ) ) * cos( radians( long ) - radians( {$coords['long']} ) ) + sin( radians( {$coords['lat']} ) ) * sin( radians( lat ) ) ) ) AS distance FROM zipcodes HAVING distance <= {$distance} ORDER BY distance");
				return $newQuery->resultArray();
			}
			return 0;
		}
		
		public function getNewestMembers($filldepth){
			$this->db->select('members.userID, members.username');
			$this->db->from('members');
			$this->db->join('member_member_type', 'member_member_type.memberId = members.userId');
			$this->db->where('members.isAccountVerified = 1');
			$this->db->where('member_member_type.memberTypeId = 2');
			$this->db->order_by("dateCreated", "desc");
			$this->db->limit(3);
			$query = $this->db->get();
			return $query->result_array();
		}
		
		public function getFeaturedPhotographer($featuredPhotographer){
			$this->db->select('userId, username, shortBio');
			$this->db->from('members');
			$this->db->where('userId', $featuredPhotographer);
			
			$query = $this->db->get();
			
			return $query->result_array();
		}
    }
?>
