<?php $this->load->view('templates/page_header'); ?>

<div class="wrapper col2">
  <div id="container" class="clear">
    <!-- ####################################################################################################### -->
	<h2 class="title"><?php echo $userInfo['username'].' - '.$userInfo['firstName'] . ' ' . $userInfo['lastName']; ?></h2>
    <div id="tabcontainer">
		<ul id="tabnav">
			<li><a href="#tabs-1">Basic Info</a></li>
			<li><a href="#tabs-2">Photography Categories</a></li>
			<li><a href="#tabs-3">Links</a></li>
			<!--<li><a href="#tabs-4">Reviews</a></li>-->
			<?php if($memberType->typeId != 1) {?> <li><a href="#tabs-4">Photos</a></li>  <?php } ?>
			<!--<li><a href="#tabs-6">Map</a></li>-->
		</ul>
        <div id="tabs-1" class="tabcontainer">
			<div id="hpage_portfolio" class="clear">		  
			<?php if(! is_null($msg)) echo $msg; ?>
			<p>
				<b>Basic Information</b><br />
				<p><b><?php echo $memberType->typeName; ?></b></p>
				<?php echo form_open('member/profileUpdate'); ?>
				<p><label>Email:</label>
					<?php 
						$data = array(
							'name' => 'email',
							'id' => 'email',
							'value' => $userInfo['email'],
							'maxlength' => '50',
							'size' => '40'
						);
						if(form_error('email') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>First Name:</label>
					<?php 
						$data = array(
							'name' => 'firstname',
							'id' => 'firstname',
							'value' => $userInfo['firstName'],
							'maxlength' => '50',
							'size' => '40'
						);
						if(form_error('firstname') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>Last Name:</label>
					<?php 
						$data = array(
							'name' => 'lastname',
							'id' => 'lastname',
							'value' => $userInfo['lastName'],
							'maxlength' => '50',
							'size' => '40'
						);
						if(form_error('lastname') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>City:</label>
					<?php 
						$data = array(
							'name' => 'city',
							'id' => 'city',
							'value' => $userInfo['city'],
							'maxlength' => '30',
							'size' => '40'
						);
						if(form_error('city') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>State:</label>
					<?php 
						$data = array(
							'blank' => '',
							'AL' => 'Alabama',												
							'AK' => 'Alaska',												
							'AZ' => 'Arizona',												
							'AR' => 'Arkansas',												
							'CA' => 'California',												
							'CO' => 'Colorado',												
							'CT' => 'Connecticut',												
							'DE' => 'Delaware',												
							'DC' => 'District of Columbia',												
							'FL' => 'Florida',												
							'GA' => 'Georgia',												
							'HI' => 'Hawaii',												
							'ID' => 'Idaho',												
							'IL' => 'Illinois',												
							'IN' => 'Indiana',												
							'IA' => 'Iowa',												
							'KS' => 'Kansas',												
							'KY' => 'Kentucky',												
							'LA' => 'Louisiana',												
							'ME' => 'Maine',												
							'MD' => 'Maryland',												
							'MA' => 'Massachusetts',												
							'MI' => 'Michigan',												
							'MN' => 'Minnesota',												
							'MS' => 'Mississippi',												
							'MO' => 'Missouri',												
							'MT' => 'Montana',												
							'NE' => 'Nebraska',												
							'NV' => 'Nevada',												
							'NH' => 'New Hampshire',												
							'NJ' => 'New Jersey',												
							'NM' => 'New Mexico',												
							'NY' => 'New York',												
							'NC' => 'North Carolina',												
							'ND' => 'North Dakota',												
							'OH' => 'Ohio',												
							'OK' => 'Oklahoma',												
							'OR' => 'Oregon',												
							'PA' => 'Pennsylvania',												
							'RI' => 'Rhode Island',												
							'SC' => 'South Carolina',												
							'SD' => 'South Dakota',												
							'TN' => 'Tennessee',												
							'TX' => 'Texas',												
							'UT' => 'Utah',												
							'VT' => 'Vermont',												
							'VA' => 'Virginia',												
							'WA' => 'Washington',												
							'WV' => 'West Virginia',												
							'WI' => 'Wisconsin',												
							'WY' => 'Wyoming'										
						);																				
						if(form_error('state') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_dropdown('state', $data, $userInfo['state']) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>Zip:</label>
					<?php 
						$data = array(
							'name' => 'zip',
							'id' => 'zip',
							'value' => $userInfo['zipPostalCode'],
							'maxlength' => '10',
							'size' => '10'
						);
						if(form_error('zip') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>Profile Image:</label>
					<?php 
						$data = array(
							'name' => 'userfile',
							'id' => 'userfile',
							'value' => '',
							'maxlength' => '150',
							'size' => '40'
						);
						echo  form_upload($data) . '<br />';
					?>
				</p>
				<p><b>Photographer Information</b></p>
				<p><label>Experience/Education:</label>
					<?php 
						$data = array(
							'name' => 'education',
							'id' => 'education',
							'value' => $profileInfo['education'],
							'rows' => '10',
							'cols' => '180'
						);
						if(form_error('education') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_textarea($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>Short Biography:</label>
					<?php 
						$data = array(
							'name' => 'shortBio',
							'id' => 'shortBio',
							'value' => $userInfo['shortBio'],
							'rows' => '10',
							'cols' => '180'
						);
						if(form_error('shortBio') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_textarea($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p></br>
				<p><label>Allow photographers/users to contact you?</label>
					<?php 
						$data = array(
							'0' => 'No',
							'1' => 'Yes'
						);
						echo form_dropdown('isOKToEmail',$data, $userInfo['isOKToEmail'])
					?>
				</p>
				<p><i>NOTE: Photographers and users of the site will not see your password.  This option allows them to send a message through photographerprofile.com to your registered email.</i></p></br>
				<p><b>Update Password</b></p>
				<p><label>Current Password:</label>
					<?php 
						$data = array(
							'name' => 'currentPassword',
							'id' => 'currentPassword',
							'value' => $this->encrypt->decode($userInfo['password']),
							'maxlength' => '30',
							'size' => '40',
							'type' => 'password'
						);
						if(form_error('currentPassword') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>New Password:</label>
					<?php 
						$data = array(
							'name' => 'newPassword',
							'id' => 'newPassword',
							'value' => '',
							'maxlength' => '30',
							'size' => '40',
							'type' => 'password'
						);
						if(form_error('newPassword') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p><label>Verify New Password:</label>
					<?php 
						$data = array(
							'name' => 'verifyNewPassword',
							'id' => 'verifyNewPassword',
							'value' => '',
							'maxlength' => '30',
							'size' => '40',
							'type' => 'password'
						);
						if(form_error('verifyNewPassword') != '') $validationMessage = '*';
						else $validationMessage = '';
						echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
					?>
				</p>
				<p>
						<?php 
							echo form_submit('updateProfile', 'Update'); 
							echo form_close();
						?>
					</p>							
			</p>
			</div>
		</div>
		<div id="tabs-2">
			<div id="hpage_portfolio" class="clear">
				<?php if(! is_null($msg)) echo $msg; ?>
				<p>	
					<p><h1><b>Photography Categories</b></h1></p>
						<?php foreach($phoTypes as $type):
							$checked = false;
							$minPrice = NULL;
							$maxPrice = NULL;
							$photoTypeDesc = NULL;
							
							foreach($memberSpecialties as $mType)
							{
								if($type['id'] == $mType['photographerTypeId'])
								{
									$checked = true;
									
									$minPrice = $mType['minPrice'];
									$maxPrice = $mType['maxPrice'];
									$photoTypeDesc = $mType['photoTypeDesc'];
								}
								else
								{
									$minPrice = NULL;
									$maxPrice = NULL;
									$photoTypeDesc = NULL;
								}
							}
							
							$data = array(
								'name' => $type['photographerType'],
								'id' => $type['photographerType'],
								'value' => $type['photographerType'],
								'checked' => $checked
							);
							
							echo form_checkbox($data);
						?>
						<label for="<?php echo $type['photographerType']; ?>"><?php echo $type['photographerType']; ?></label><br />
						<label>Min Price:</label>
						<?php 
							$data = array(
								'blank' => '',
								'0' => 'free',
								'100' => '$100 or less',
								'200' => '$200 or less',
								'500' => '$500 or less',
								'1000' => '$1000 or less'
							);
							echo form_dropdown('minPrice', $data);
						?><br />
						<label>Max Price:</label>
						<?php
							$data = array(
								'blank' => '',
								'100' => '$100 or less',
								'200' => '$200 or less',
								'500' => '$500 or less',
								'1000' => '$1000 or less',
								'2000' => '$2000 or less',
								'5000' => '$5000 or less',
								'5001' => 'Above $5000'
							);
							echo form_dropdown('maxPrice', $data);
						?><br />
						<label>Description Of Photography Service(time, packages, etc.):</label>
						<?php
							$data = array(
								'name' => 'photoTypeDesc[]',
								'id' => $type['id'].'photoTypeDesc',
								'value' => $photoTypeDesc,
								'rows' => '5',
								'cols' => '150'
							);
							echo form_textarea($data);
						?><br /><br />
						<?php endforeach ?>	
				</p>
			</div>
		</div>
		<div id="tabs-3">
			<div id="hpage_portfolio" class="clear">
				<?php if(! is_null($msg)) echo $msg; ?>
				<p>
					<p><b>Other Links Info</b></p>
					<p><label>LinkedIn URL:</label>
						<?php 
							$data = array(
								'name' => 'linkedInURL',
								'id' => 'linkedInURL',
								'value' => $profileInfo['linkedInURL'],
								'maxlength' => '150',
								'size' => '40'
							);
							if(form_error('linkedInURL') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p><label>Pinterest URL:</label>
						<?php 
							$data = array(
								'name' => 'pintrestURL',
								'id' => 'pintrestURL',
								'value' => $profileInfo['pintrestURL'],
								'maxlength' => '150',
								'size' => '40'
							);
							if(form_error('pintrestURL') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p><label>Facebook URL:</label>
						<?php 
							$data = array(
								'name' => 'facebookURL',
								'id' => 'facebookURL',
								'value' => $profileInfo['facebookURL'],
								'maxlength' => '150',
								'size' => '40'
							);
							if(form_error('facebookURL') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p><label>tumblr URL:</label>
						<?php 
							$data = array(
								'name' => 'tumblrURL',
								'id' => 'tumblrURL',
								'value' => $profileInfo['tumblrURL'],
								'maxlength' => '150',
								'size' => '40'
							);
							if(form_error('tumblrURL') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p><label>flikr URL:</label>
						<?php 
							$data = array(
								'name' => 'flikrURL',
								'id' => 'flikrURL',
								'value' => $profileInfo['flikrURL'],
								'maxlength' => '150',
								'size' => '40'
							);
							
							if(form_error('flikrURL') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p><label>Website URL:</label>
						<?php 
							$data = array(
								'name' => 'websiteURL',
								'id' => 'websiteURL',
								'value' => $profileInfo['websiteURL'],
								'maxlength' => '150',
								'size' => '40'
							);
							if(form_error('websiteURL') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
				</p>
			</div>
		</div>
		<!--<div id="tabs-4">
			<div id="hpage_portfolio" class="clear">
				<?php //if(! is_null($msg)) echo $msg; ?>
				<p><b>Reviews</b></p>
			</div>
		</div>-->
		<div id="tabs-4">
			<div id="hpage_portfolio" class="clear">
			<?php if(! is_null($msg)) echo $msg; ?>
			<?php 
			$totalImageSize = 0;
			foreach($memberImages as $image)   {
				$totalImageSize = $totalImageSize + $image['fileSize'];
			}
			
			 ?>
			<p><b>You are using <?php echo number_format($totalImageSize / 1024, 2, '.', ',') ; ?>MB of your <?php echo number_format($memberType->uploadQuota / 1024 / 1024); ?> MB quota</b><br />
			This is a test <?php echo $this->config->item('max_size');?>.
			</p>			
				<p>
					<p><b>Add Album</b></p>
					<?php echo form_open('member/addAlbum'); ?>
					<p><label>Album Name:</label>
							<?php 
								$data = array(
									'name' => 'albumName',
									'id' => 'albumName',
									'value' => '',
									'maxlength' => '50',
									'size' => '40'
								);
								if(form_error('albumName') != '') $validationMessage = '*';
								else $validationMessage = '';
								echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
							?>
					</p>
					<p>
						<?php 
							echo form_submit('addAlbum', 'Add Album'); 
							echo form_close();
						?>
					</p>
					<p><b>Upload Photo</b></p>
					<?php echo form_open_multipart('member/uploadPhoto'); 
						$albumList = array();
						foreach($memberAlbums as $album)
						{
							$albumList[$album['id']] = $album['albumName'];
							
						}
						$data = array(
									'name' => 'photoUpload',
									'id' => 'photoUpload',
									'value' => '',
									'maxlength' => '150',
									'size' => '40'
								);
						echo  'Album: ' . form_dropdown('ddAlbums', $albumList, '---') . '<br/>';
						echo  'Choose File: ' . form_upload($data) . '<br />';
						echo form_submit('uploadPhoto', 'Upload'); 
						echo form_close();
					?>
				</p>
			</div>
		</div>
		<!--<div id="tabs-6">
			<p>
				<?php //if(! is_null($msg)) echo $msg; ?>
				<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?oe=utf-8&amp;client=firefox-a&amp;q=1519+w+moss+ave+peoria+il&amp;ie=UTF8&amp;hq=&amp;hnear=1519+W+Moss+Ave,+Peoria,+Illinois+61606&amp;gl=us&amp;t=h&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?oe=utf-8&amp;client=firefox-a&amp;q=1519+w+moss+ave+peoria+il&amp;ie=UTF8&amp;hq=&amp;hnear=1519+W+Moss+Ave,+Peoria,+Illinois+61606&amp;gl=us&amp;t=h&amp;z=14&amp;iwloc=A&amp;source=embed" style="color:#0000FF;text-align:left">View Larger Map</a></small>
			</p>
		</div>-->
	</div>
  </div>
</div>
		
			
				
			
			
			


			
			
		

