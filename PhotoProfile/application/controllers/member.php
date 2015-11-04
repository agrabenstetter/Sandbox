<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {
    public function __construct(){
        parent::__construct();
        //load validation library
        $this->load->library('form_validation');
        $this->load->model('member_model');
        $this->load->model('image_model');
		$this->load->model('captcha_model');
		$this->load->library('encrypt');
		$this->load->library('session');
		$this->load->helper('captcha');
    }
    
    public function index($id = 1, /*$activeTab = 0,*/ $msg = ''){
			$data['title'] = 'Members' . $id;
			$data['addlHeadData'] = '';
			$data['validated'] = $this->check_isValidated();
			
		    $data['phoTypes'] = $this->member_model->GetPhotographerTypes();
			$data['memberSpecialties'] = $this->member_model->GetMemberSpecialties($id);
			$data['userInfo'] = $this->member_model->GetMemberDetails($id);
			$data['profileInfo'] = $this->member_model->GetMemberProfile($id);
			$data['ratingInfo'] = $this->member_model->GetMemberRatings($id);
			$data['memberAlbums'] = $this->image_model->GetMemberAlbums($id);
			$data['memberPhotos'] = $this->image_model->GetMemberImages($id);
			$memberProfileImageAlbum = $this->image_model->GetMemberProfileImageAlbumId($id);
			$data['profilePhoto'] = $this->image_model->GetMemberProfileImage($id, $memberProfileImageAlbum['id']);
			
			$this->load->view('templates/header', $data);
			$this->load->view('members', $data);
			$this->load->view('templates/footer', $data);
    }
	
	//This function will be used to confirm user accounts.
	public function confirm(){
	
		//init data array
		$confirm_info = array();
		
		//grab the passkey from the uri segment
		$key = $this->uri->segment(3);
		
		//check key has data		
		if($key){

			// Get Confirmation info from DB
			$confirm_info = $this->member_model->GetConfirmationInfo($key);
			
			//check confirm info array has data
			if($confirm_info['id'] != NULL){
				
				//set account confirmed status and verify setting
				$update_users = $this->member_model->VerifyMemberProfile($confirm_info['memberId']);
				
				//delete the confirmUser row
				$delete = $this->member_model->ClearConfirmationInfo($confirm_info['memberId']);
				
				if(($update_users['isAccountVerified']) == 1){
					
					$result = $this->member_model->ConfirmUserLogin($update_users['username']);
					
					if(!$result){
						echo "bad mojo happened";
					}
					else{
						$this->myProfile();
					}
				}
				else{
					echo "Failure in Updating User";
				}
			
			}
			else{
				//ASG - just adding a placeholder...fancy it up later.
				echo "Passkey invalid...please ensure that your clicking or pasting the appropriate confirmation link and that your account has not already been verified.";
			}
		}
	}
	 
    public function member($id){
        if($id > 0){
            
        }
    }
    
    public function memberLogin($msg = NULL, $activeTab = 0){
		$data['title'] = 'Member Login';
        $data['addlHeadData'] = '
		<script type="text/javascript">	
		function forgotPWD()
			{
			var x;

			var email=prompt("Please enter your email","email@example.com");

			if (email!=null)
			  {
			  $.ajax({type: "POST", 
			  url: "http://photographerprofile.com/member/forgotPWD", 
			  data: {"email" : email}});
			  x="Password information has been mailed to: " + email;
			  document.getElementById("forgotPWD").innerHTML=x;
			  }
			}
			</script>
		';
        
		// if ($this->session->flashdata('msg'); != NULL){
			// $data['msg'] = $this->session->flashdata('msg');;
		// }
		// else{
			// $data['msg'] = $msg;
		// }
			
		$data['msg'] = $msg;
        $data['validated'] = $this->check_isValidated();
        $data['phoTypes'] = $this->member_model->GetPhotographerTypes();
        $data['activeTab'] = $activeTab;
        
		//generating captcha info for comment/review submission tab
		$vals = array(
			//'word'	 => 'Random word',
			'img_path'	 => './userImages/captcha/',
			'img_url'	 => 'http://photographerprofile.com/userImages/captcha/',
			//'font_path'	 => './path/to/fonts/texb.ttf',
			'img_width'	 => '150',
			'img_height' => 30,
			'expiration' => 7200
		);
		
		$cap = create_captcha($vals);
		$data['cap'] = $cap;
			
		$captchadata = array(
			'captcha_time'	=> $cap['time'],
			'ip_address'	=> $this->input->ip_address(),
			'word'	 => $cap['word']
		);
			
		$this->captcha_model->InsertCaptcha($captchadata);
		
        $memberInfo = array(
            'username' => $this->input->post('username'),
            'firstName' => $this->input->post('firstname'),
            'lastName' => $this->input->post('lastname'),
            'password' => $this->input->post('password'),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'zipPostalCode' => $this->input->post('zip'),
            'email' => $this->input->post('email'),
            'shortBio' => $this->input->post('shortBio')
        );
        
        $data['memberInfo'] = $memberInfo; 
          
        $this->load->view('templates/header', $data);
        $this->load->view('login', $data);
        $this->load->view('templates/footer', $data);
    }
    
    public function loginProcess(){
        $this->load->model('member_model');
        $result = $this->member_model->ValidateUserLogin();
		
        if(!$result){
			$msg = "<div class = 'ui-state-error'><p><strong>Alert:</strong>Invalid User Credentials!</p></div>";
            $this->memberLogin($msg);
        } 
        elseif(!$this->session->userdata['verified']) {
			$msg = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Account not verified, please check email for verification steps</p></div>";
            $this->memberLogin($msg);
		}
		else{
            $this->index($this->session->userdata['userId']);
			$this->myProfile();
        }
    }
    
    public function memberLogout(){
        $this->session->sess_destroy();
		
		// $msg = 'You have been logged out';
		// $this->session->set_flashdata('msg', $msg);
        
		redirect('member/memberLogin');
    }
    
    public function myProfile($msg = '', $activeTab = 0){
        if($this->check_isValidated()){
            $data['profileId'] = $this->session->userdata('userId');
            
            $data['addlHeadData'] = '';
            
            $data['msg'] = $msg;
			$data['activeTab'] = $activeTab;
            $data['validated'] = $this->check_isValidated();
            
            $data['phoTypes'] = $this->member_model->GetPhotographerTypes();
            $data['userInfo'] = $this->member_model->GetMemberDetails($this->session->userdata('userId'));
            $data['memberType'] = $this->member_model->GetMemberType($this->session->userdata('userId'));
            $data['profileInfo'] = $this->member_model->GetMemberProfile($this->session->userdata('userId'));
            $data['ratingInfo'] = $this->member_model->GetMemberRatings($this->session->userdata('userId'));
            $data['memberSpecialties'] = $this->member_model->GetMemberSpecialties($this->session->userdata('userId'));
            
            $data['memberAlbums'] = $this->image_model->GetMemberAlbums($this->session->userdata('userId'));
            $data['memberImages'] = $this->image_model->GetMemberImages($this->session->userdata('userId'));
            
            $this->load->view('templates/header', $data);
            
            $this->load->view('member_profile_edit', $data);
            $this->load->view('templates/footer', $data);
        }
        else{
			$msg = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>You must be logged in to view that page.</p></div>";
            $this->memberLogin($msg);
        }
    }
    
    public function profileUpdate(){
		
        $memberInfo = array(
            'username' => $this->session->userdata['username'],
            'firstName' => $this->input->post('firstname'),
            'lastName' => $this->input->post('lastname'),
            'password' => $this->encrypt->encode(($this->input->post('password'))),
            'city' => $this->input->post('city'),
            'state' => $this->input->post('state'),
            'zipPostalCode' => $this->input->post('zip'),
            'email' => $this->input->post('email'),
            'profileImage' => $this->input->post('profileImageUrl'),
			'shortBio' => $this->input->post('shortBio')
        );
        
        //setting validation rules before running the validation routine
        $this->form_validation->set_rules('zip', 'Postal Code', 'required|numeric|exact_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if ($this->input->post('password')){
			$this->form_validation->set_rules('verifyPassword', 'Verify Password', 'required|matches[password]');
        }
		
        if($this->form_validation->run() == TRUE){
            $resultId = $this->member_model->UpdateMember($this->session->userdata['userId'], $memberInfo);
        }
        else{
            $errors = validation_errors();
            echo $errors;
        }
        
		// new update section
		if ($this->input->post('linkedInURL') != '' || $this->input->post('pintrestURL') != '' || $this->input->post('facebookURL') != '' || $this->input->post('tumblrURL') != '' || $this->input->post('flikrURL') != '' || $this->input->post('websiteURL') != ''){
			$URLArray = array();
			$URLArray[]	= $this->input->post('linkedInURL');
			$URLArray[]	= $this->input->post('pintrestURL');
			$URLArray[]	= $this->input->post('facebookURL');
			$URLArray[]	= $this->input->post('tumblrURL');
			$URLArray[]	= $this->input->post('flikrURL');
			$URLArray[]	= $this->input->post('websiteURL');
			
			$bInvalidURL = false;
			
			for($i = 0; $i < count($URLArray); $i++){
				if($URLArray[$i] != '')
				{
					if (!$this->validateURLRegex($URLArray[$i]))
					{
						$bInvalidURL = true;
					}
				}
			}
			
			if (!$bInvalidURL){
				$profileInfo = array(
					'memberId' => $this->session->userdata['userId'],
					'profileHeader' => '1234',
					'linkedInURL' => $this->input->post('linkedInURL'),
					'pintrestURL' => $this->input->post('pintrestURL'),
					'facebookURL' => $this->input->post('facebookURL'),
					'tumblrURL' => $this->input->post('tumblrURL'),
					'flikrURL' => $this->input->post('flikrURL'),
					'websiteURL' => $this->input->post('websiteURL'),
					'education' => $this->input->post('education')
				);

				$profileId = $this->member_model->UpdateMemberProfile($this->session->userdata['userId'], $profileInfo);
				
				$this->member_model->ClearPhotographerType($this->session->userdata['userId']);
				
				$photographerTypes = $this->input->post('photographerType');
				$minPrices = array_filter($this->input->post('minPrice'));
				$maxPrices = array_filter($this->input->post('maxPrice'));
				$photoTypeDescs = array_filter($this->input->post('photoTypeDesc'));
				
				if($photographerTypes != NULL){
					for ($i = 0; $i < count($photographerTypes); $i++){
						if($minPrices[$i] == '' OR $minPrices[$i] == NULL){
							$minPrices[$i] == 0;
						}
						if($maxPrices[$i] == '' OR $maxPrices[$i] == NULL){
							$maxPrices[$i] == 0;
						}
						$entryTypes = array(
							'memberId' => $this->session->userdata['userId'],
							'photographerTypeId' => $photographerTypes[$i],
							'minPrice' => $minPrices[$i],
							'maxPrice' => $maxPrices[$i],
							'photoTypeDesc' => $photoTypeDescs[$i]
						);
						
						$entryId = $this->member_model->AddPhotographerType($entryTypes);
					}
				}
				else{
					for ($i = 0; $i < count($photographerTypes); $i++){
						$entryTypes = array(
							'memberId' => $this->session->userdata['userId'],
							'photographerTypeId' => 0,
							'minPrice' => 0,
							'maxPrice' => 0,
							'photoTypeDesc' => ''
						);
						
						$entryId = $this->member_model->AddPhotographerType($entryTypes);
					}
				}
				$msg = "<div class = 'ui-state-highlight'><p><span class='ui-icon ui-icon-info'></span><strong>Good News!</strong>Your profile has been Updated.</p></div>";
				$this->myProfile($msg);
				
			}
			else{
				$msg = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Not a valid URL</p></div>";
				$this->memberLogin($msg);
			}
		}
		else{
			$profileInfo = array(
					'memberId' => $this->session->userdata['userId'],
					'profileHeader' => '1234',
					'linkedInURL' => $this->input->post('linkedInURL'),
					'pintrestURL' => $this->input->post('pintrestURL'),
					'facebookURL' => $this->input->post('facebookURL'),
					'tumblrURL' => $this->input->post('tumblrURL'),
					'flikrURL' => $this->input->post('flikrURL'),
					'websiteURL' => $this->input->post('websiteURL'),
					'education' => $this->input->post('education')
			);

			$profileId = $this->member_model->UpdateMemberProfile($this->session->userdata['userId'], $profileInfo);
			
			$this->member_model->ClearPhotographerType($this->session->userdata['userId']);
			
			$photographerTypes = $this->input->post('photographerType');
			$minPrices = array_filter($this->input->post('minPrice'));
			$maxPrices = array_filter($this->input->post('maxPrice'));
			$photoTypeDescs = array_filter($this->input->post('photoTypeDesc'));
			
			for ($i = 0; $i < count($photographerTypes); $i++){
				$entryTypes = array(
					'memberId' => $resultId,
					'photographerTypeId' => $photographerTypes[$i],
					'minPrice' => $minPrices[$i],
					'maxPrice' => $maxPrices[$i],
					'photoTypeDesc' => $photoTypeDescs[$i]
				);
				
				$entryId = $this->member_model->AddPhotographerType($entryTypes);
			} 
			
			$msg = "<div class = 'ui-state-highlight'><p><span class='ui-icon ui-icon-info'></span><strong>Good News!</strong>Your profile has been Updated.</p></div>";
			$this->myProfile($msg);
		}
    }
    
    public function memberAdd(){
		//setting validation rules before running the validation routine
        $this->form_validation->set_rules('username', 'User Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('verifyPassword', 'Verify Password', 'required|matches[password]');        
        $this->form_validation->set_rules('zip', 'Postal Code', 'required|numeric|exact_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		if($this->member_model->CheckEmail($this->input->post('email'))){
			$msg = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Email Address already in-use, please use the forgot password feature if necessary.</p></div>";
			$this->memberLogin($msg);
		}
		else{
			$memberInfo = array(
				'username' => $this->input->post('username'),
				'email' => $this->input->post('email'),
				'password' => $this->encrypt->encode(($this->input->post('password'))),
				'firstName' => $this->input->post('firstname'),
				'lastName' => $this->input->post('lastname'),
				'city' => $this->input->post('city'),
				'state' => $this->input->post('state'),
				'zipPostalCode' => $this->input->post('zip'),
				'shortBio' => 'Enter a short description of your photography here...',
				'dateCreated' => date('Y-m-d H:i:s')
			);
			
			$profileInfo = array(
				'memberId' => ''
			);
			if($this->form_validation->run() == TRUE){
				/*******
				Add Member to database
				*******/
				$resultId = $this->member_model->AddMember($memberInfo);
				$profileInfo['memberId'] = $resultId;
				$profileId = $this->member_model->AddMemberProfile($profileInfo);
				$memberTypeId = $this->input->post('memberTypeId');
				$typeResultId = $this->member_model->AddMemberType($resultId, $memberTypeId);
				$albumId = $this->image_model->AddMemberPhotoAlbum($resultId, 'profileImage');
				$imageData = array(
					'memberId' => $resultId,
					'albumId' => $albumId,
					'fileName' => 'no_photo.png',
					'fileType' => 'image/png',
					'fileSize' => '877',
					'fileExtension' => '.png',
					'fileDescription' => 'Profile Image'
				);
				$profileImage = $this->image_model->AddProfileImage($imageData);
				
				//move default image to user profile folder
				$folderName = './userImages/'.$resultId.'/profileImage';
				mkdir($folderName, 0777, true);
				$noPhoto = './images/no_photo.png';
				$newPhoto = $folderName.'/no_photo.png';
				//rename($noPhoto, $newPhoto);
				copy($noPhoto, $newPhoto);
				
				/*******
				Email Confirmation
				*******/
				//create a random confirmation key  
				$key = $this->input->post('username') . $this->input->post('email') . date('mY');  
				$key = md5($key);  

				$confirmEntry = array(
						'id' => NULL,
						'memberId' => $resultId,
						'email' => $this->input->post('email'),
						'key' => $key
				);
				
				$confirmId = $this->member_model->AddConfirmationInfo($confirmEntry);

				//Generating Confirmation Email
				
				$sendto = $this->input->post('email'); // this is the email address collected form the form 
				//$ccto = "Bcc:info@photographerprofile.com\n"; //you can cc it to yourself 
				$subject = "Email Confirmation"; // Subject
				$confirmLink = base_url('member/confirm/'.$key.'');
				$message = '
				<html>
					<body>
					  <p>Welcome '.$this->input->post('username').' to PhotographerProfile.com!</p>
					  <p>There is just one last step in the registration process before you can use the site.</p>
					  <p>Please verify your account by clicking the link below</p>
					  <a href="'.$confirmLink.'">Confirm!</a>
					  <p>If the above link is not working, please copy and paste this address:'.$confirmLink.' </br>
					  into your browsers address bar.</p>
					  <p>You received this e-mail because you just created an account on PhotographerProfile.com. If you think you should not have received this e-mail, please contact <a href="mailto:info@photographerprofile.com">info@photographerprofile.com</a></p>
					</body>
				</html>
				';
				
				//html email setup
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				
				//additional header info
				$header .= "From: auto-confirm@photographerprofile.com\r\n"; 
				$header .= "Reply-to: info@photographerprofile.com\r\n"; 
				$header .= "Bcc:info@photographerprofile.com\n"; //you can cc it to yourself 
				// This is the function to send the email 
				mail($sendto, $subject, $message, $header); 
				
				$this->memberLogin('Your profile has been created. Please check your email and verify your account before logging in.');	
			}
			else{
				$errors = '';
				if(validation_errors() != ''){
					$errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Missing Required Fields! (Noted by an *)</p></div>"; // validation_errors();   
				}   
				if($errors != ''){
					if ($this->input->post('memberTypeId') == 2){
						$this->memberLogin($errors, 1);
					}
					else{
						$this->memberLogin($errors, 2);
					}
				}
				else{
					$this->memberLogin($errors, 0);		
				}
			}
		}
	}
   
    public function uploadPhoto(){
		$config['upload_path'] = './userImages/'.$this->session->userdata['userId'].'/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']    = '1000';
        $config['max_width']  = '1024';
        $config['max_height']  = '768';
		
        $this->load->library('upload', $config);
		
		$folderName = './userImages/'.$this->session->userdata['userId'].'/';
		
		if(!is_dir($folderName)){
			if(mkdir($folderName, 0777)){
				if ( ! $this->upload->do_upload('photoUpload')){
					$error = array('error' => $this->upload->display_errors());
					$this->myProfile($error['error']);
				}
				else{
					$uploadData = $this->upload->data();
					$data = array('upload_data' => $uploadData);
					
					
					$imageData = array (
						'memberId' => $this->session->userdata['userId'],
						'albumId' => $this->input->post('ddAlbums'),
						'fileName' => $uploadData['file_name'],
						'fileType' => $uploadData['file_type'],
						'fileSize' => $uploadData['file_size'],
						'fileExtension' => $uploadData['file_ext'],
						'fileDescription' => ''
					
					);
					$this->image_model->addImage($imageData);
					
					$success = "<div class = 'ui-state-highlight'><p><span class='ui-icon ui-icon-info'></span><strong>Good News!</strong>Image uploaded successfully!</p></div>";
					$this->myProfile($success); 
				}
			}
			else{
				$errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Folder Could Not be Created</p></div>";
				$this->myProfile($errors); 
			}
		}

		if ( ! $this->upload->do_upload('photoUpload')){
			$error = array('error' => $this->upload->display_errors());
			
			$this->myProfile($error['error']);
		}
		else{
			$uploadData = $this->upload->data();
			$data = array('upload_data' => $uploadData);
			
			
			$imageData = array (
				'memberId' => $this->session->userdata['userId'],
				'albumId' => $this->input->post('ddAlbums'),
				'fileName' => $uploadData['file_name'],
				'fileType' => $uploadData['file_type'],
				'fileSize' => $uploadData['file_size'],
				'fileExtension' => $uploadData['file_ext'],
				'fileDescription' => ''
			
			);
			$this->image_model->addImage($imageData);
			
			$success = "<div class = 'ui-state-highlight'><p><span class='ui-icon ui-icon-info'></span><strong>Good News!</strong>Image uploaded successfully!</p></div>";
			$this->myProfile($success); 
			
		}
    }
	
	public function addAlbum(){
		$this->form_validation->set_rules('albumName', 'Album Name', 'required');
		
		if($this->form_validation->run() == TRUE){
			$userAlbum = array(
				'memberId' => $this->session->userdata['userId'],
				'albumName' => $this->input->post('albumName')
			);
			
			//Add album to the db
			$albumId = $this->image_model->AddMemberPhotoAlbum($userAlbum['memberId'], $userAlbum['albumName']);
			if($albumId){
				$success = "<div class = 'ui-state-highlight'><p><span class='ui-icon ui-icon-info'></span><strong>Good News!</strong>Album Added!</p></div>";
				$this->myProfile($success, 3);
			}
			else{
				$errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Error occurred and album was not added</p></div>";
				$this->myProfile($errors, 3);
			}
		}
		else{
			$errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Missing Required Fields! (Noted by an *)</p></div>";
            $this->myProfile($errors, 3);		
		}		
	}
    
	public function forgotPassword($msg = NULL){
		$data['title'] = 'Forgot Password';
		$data['validated'] = $this->check_isValidated();
		$data['addlHeadData'] = '';
		$data['msg'] = '';
		
		$this->load->view('templates/header', $data);
        $this->load->view('forgot_password', $data);
        $this->load->view('templates/footer', $data);
	}
	
	public function forgotPWD(){
		echo "hi";
		//$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$test = $this->input->post('email');
		
		///if($this->form_validation->run() == TRUE){
			$password = $this->encrypt->decode($this->member_model->GetPasswordInfo($test));
			if($password){
				//Generating Password Email

				$sendto = $this->input->post('email'); // this is the email address collected form the form 
				$subject = "Password Information"; // Subject
			
				$message = '
				<html>
					<body>
					  <p>Dear Member,</p>
					  <p>The password to your account on PhotographerProfile.com is:'.$password.'</p>
					  <p>Please log into your account and change the password as a precautionary move.</p>
					  
					  <p>You received this e-mail because you just submitted a "Forgot Password" request on PhotographerProfile.com. If you think you should not have received this e-mail, please contact <a href="mailto:info@photographerprofile.com">info@photographerprofile.com</a></p>
					</body>
				</html>
				';

				//html email setup
				$header  = 'MIME-Version: 1.0' . "\r\n";
				$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

				//additional header info
				$header .= "From: auto-password@photographerprofile.com\r\n"; 
				$header .= "Reply-to: info@photographerprofile.com\r\n"; 
				 
				mail($sendto, $subject, $message, $header); 
				
				$success = "<div class = 'ui-state-highlight'><p><span class='ui-icon ui-icon-info'></span><strong>Good News!</strong>Account password has been sent to supplied email address</p></div>";				
				
				//Display Success Message on Login page
                $this->memberLogin($success, 0);
			}
			// else{
				//Display Error Messages
				// $errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Password for supplied account was not found, please contact the site owner</p></div>";
				// $this->forgotPassword($errors);
			// }
		//}
		// else{
			//Display Error Messages
			// $errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Email is required to send password</p></div>";
			// $this->forgotPassword($errors);
		// }
	}
	
	//this will validate urls with regular expressions
	function validateURLRegex($input){
	  if (preg_match('/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/', $input)){
		return true; // it matched, return true or false if you want opposite
	  }
	  else{
		return false;
	  }
	}
	
	public function addPhotoReview(){
		$this->form_validation->set_rules('reviewerComment', 'Reviewer Comment', 'required');
		
		if($this->form_validation->run() == TRUE){
			if($this->session->userdata['userId'] != $this->input->post('memberId')){
				$today = date("Y-m-d H:i:s"); 
				$ratingInfo = array(
					'reviewerName' => $this->session->userdata['userId'],
					'reviewerComment' => $this->input->post('reviewerComment'),
					'memberId' => $this->input->post('memberId'),
					'rating' => '5', //$this->input->post('rating')
					'dateCreated' => $today
				);
				
				$result = $this->member_model->AddMemberRatings($ratingInfo);
				
				if($result != ''){
					$success = "<div class = 'ui-state-highlight'><p><span class='ui-icon ui-icon-info'></span><strong>Good News!</strong>The review was successfully added to the photographers profile</p></div>";
					$this->index($this->input->post('memberId'), $success);
				}
				else{
					$errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>There was an issue when saving the review.  Please try again</p></div>";
					$this->index($this->input->post('memberId'), $errors);
				}
			}
			else{
				$errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>You cannot add a review about yourself.  Ask clients for reviews.</p></div>";
				$this->index($this->input->post('memberId'), $errors);
			}
		}
		else{
			$errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Missing Required Fields! (Noted by an *)</p></div>";
			$this->index($this->input->post('memberId'), $errors);
		}
	}
	
	public function contactPhotographer($id = 1, $msg = NULL){
		$data['title'] = 'Contact Photographer';
		$data['validated'] = $this->check_isValidated();
		$data['addlHeadData'] = '';
		$data['msg'] = $msg;
		$data['memberDetails'] = $this->member_model->GetMemberDetails($id);
		
		$vals = array(
			//'word'	 => 'Random word',
			'img_path'	 => './userImages/captcha/',
			'img_url'	 => 'http://photographerprofile.com/userImages/captcha/',
			//'font_path'	 => './path/to/fonts/texb.ttf',
			'img_width'	 => '150',
			'img_height' => 30,
			'expiration' => 7200
		);
		
		$cap = create_captcha($vals);
		$data['cap'] = $cap;
		
		$captchadata = array(
			'captcha_time'	=> $cap['time'],
			'ip_address'	=> $this->input->ip_address(),
			'word'	 => $cap['word']
		);
		
		$this->captcha_model->InsertCaptcha($captchadata);
		
		$this->load->view('templates/header', $data);
        $this->load->view('contact_photographer', $data);
        $this->load->view('templates/footer', $data);
	}
	
	public function sendPhotographerInquiry(){
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		
		if($this->form_validation->run() == TRUE)
		/* Check if form (and captcha) passed validation*/
		//if ($this->form_validation->run() == TRUE &&
        //strcmp(strtoupper($userCaptcha),strtoupper($word)) == 0)
		{
			//Generating Password Email

			$sendto = $this->input->post('memberEmail'); // this is the email address collected form the form 
			$subject = "Photography Inquiry from PhotographerProfile"; // Subject
		
			$message = '
			<html>
				<body>
				  <p>Dear Member,</p>
				  <p>'.$this->input->post('name').' has contacted you with the following message through PhotographerProfile.com: </p>
				  <p>'.$this->input->post('contactInquiry').'</p>
				  
				  <p>You can contact this user via the following email address to respond to their inquiry: '.$this->input->post('email').'</a></p>
				</body>
			</html>
			';

			//html email setup
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

			//additional header info
			$header .= "From: photographer-contact@photographerprofile.com\r\n"; 
			$header .= "Reply-to: info@photographerprofile.com\r\n"; 
			 
			mail($sendto, $subject, $message, $header);

			//TEST - Captcha
			/* Clear the session variable */
			//$this->session->unset_userdata('captchaWord');
			
			$this->index($this->input->post('memberId'));
		}
		else{
			$errors = "<div class = 'ui-state-error'><p><span class='ui-icon ui-icon-alert'></span><strong>Alert:</strong>Missing Required Fields! (Noted by an *)</p></div>";
			$this->contactPhotographer($this->input->post('memberId'), $errors);
		}
	}
	
	public function unhtmlspecialchars($string){
		static $translation;
		if (!isset($translation))
			$translation = array_flip(get_html_translation_table(HTML_SPECIALCHARS, ENT_QUOTES)) + array('&#039;' => '\'', '&nbsp;' => ' ');
		return strtr($string, $translation);
	}
	
    public function check_isValidated(){
        if(!$this->session->userdata('validated')){
            return false;
        }
        else{
            return true;
        }
    }
}

?>