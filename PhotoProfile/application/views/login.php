<?php $this->load->view('templates/page_header'); ?>
<!-- ####################################################################################################### -->
<div class="wrapper col2">
	<div id="container" class="clear">
    <!-- ####################################################################################################### -->
		<div id="tabcontainer">
			<ul id="tabnav">
				<li><a href="#tabs-1">Login</a></li>
				<li><a href="#tabs-2">Create New Account</a></li>
			</ul>
			<div id="tabs-1" class="tabcontainer">
			<?php if(! is_null($msg)) echo $msg; ?>
				<div id="respond">
					<?php echo form_open('member/loginProcess');?>
					<p align="center">
					<label for="username">Username:</label>	 
						<?php 
							$data = array(
								'name' => 'username',
								'id' => 'username',
								'value' => '',
								'maxlength' => '50',
								'size' => '40'
							);
							
							echo form_input($data);
						?> 
					</p>
					<p align="center">
					<label for="password">Password:</label>
						<?php 
							$data = array(
								'name' => 'password',
								'id' => 'password',
								'value' => '',
								'maxlength' => '50',
								'size' => '40',
								'type' => 'password'
							);
							
							echo form_password($data);
						?>
					</p>
					<p align="center">
						<?php 
					
						echo form_submit('login', 'Login!', "id='submit'"); echo form_close();?>
						<button id="submit" onclick="forgotPWD()">Forgot Password</button>
						<p id="forgotPWD"></p>
					</p>
				</div>
			</div>
			<div id="tabs-2" class="tabcontainer">						
				<?php if(! is_null($msg)) echo $msg; ?>	
				<div id="respond">
				<?php echo form_open_multipart('member/memberAdd'); ?>
					<p>
						<label for="username">Username:</label>
						<?php $validationMessage = '';  ?>
						<?php 
							$data = array(
								'name' => 'username',
								'id' => 'username',
								'value' => $memberInfo['username'],
								'maxlength' => '50',
								'size' => '40'
							);
							if(form_error('username') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p>
						<label for="email">Email:</label>
						<?php 
							$data = array(
								'name' => 'email',
								'id' => 'email',
								'value' => $memberInfo['email'],
								'maxlength' => '50',
								'size' => '40'
							);
							if(form_error('email') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p>
						<label for="password">Password:</label>
						<?php 
							$data = array(
								'name' => 'password',
								'id' => 'password',
								'value' => $memberInfo['password'],
								'maxlength' => '30',
								'size' => '40',
								'type' => 'password'
							);
							
							if(form_error('password') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p>
						<label for="password">Verify Password:</label>
						<?php 										
							$data = array(											
								'name' => 'verifyPassword',											
								'id' => 'verifyPassword',											
								'value' => '',											
								'maxlength' => '30',											
								'size' => '40',
								'type' => 'password'											
							);
							if(form_error('verifyPassword') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';																		
						?>								
					</p>
					<p>
						<label for="firstname">First Name:</label>
						<?php 
							$data = array(
								'name' => 'firstname',
								'id' => 'firstname',
								'value' => $memberInfo['firstName'],
								'maxlength' => '50',
								'size' => '40'
							);
							
							if(form_error('firstname') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';	
						?>
					</p>
					<p>
						<label for="lastname">Last Name:</label>
						<?php 
							$data = array(
								'name' => 'lastname',
								'id' => 'lastname',
								'value' => $memberInfo['lastName'],
								'maxlength' => '50',
								'size' => '40'
							);
							if(form_error('lastname') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';	
						?>
					</p>
					<p>
						<label for="city">City:</label>
						<?php 
							$data = array(
								'name' => 'city',
								'id' => 'city',
								'value' => $memberInfo['city'],
								'maxlength' => '30',
								'size' => '40'
							);
							if(form_error('city') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p>
						<label for="state">State:</label>
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
							echo form_dropdown('state', $data, $memberInfo['state']) . '<span style="color:red;">' .$validationMessage. '</span> ';										
						?>
					</p>
					<p>
						<label for="zip">Zip:</label>
						<?php 
							$data = array(
								'name' => 'zip',
								'id' => 'zip',
								'value' => $memberInfo['zipPostalCode'],
								'maxlength' => '10',
								'size' => '10'
							);
							if(form_error('zip') != '') $validationMessage = '*';
							else $validationMessage = '';
							echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
						?>
					</p>
					<p>
						<label>Are you a photographer?</label>
						<?php
							$data = array(
								'1' => 'No',
								'2' => 'Yes'
							);
							echo form_dropdown('memberTypeId',$data)
						?>
					</p>
					<p>
						<label for="">I Agree To The <a target="_blank" href="<?php echo base_url('policy/terms'); ?>">Terms Of Use</a>:</label>
						<?php 
							$data = array(
								'name' => 'AgreeToTerms',
								'id' => 'AgreeToTerms',
								'value' => 'Agree',
								'checked' => false,
								'style' => 'margin: 10px'
							);
							
							echo form_checkbox($data);
						?>
					</p>
					<?php //echo $cap['image']; ?>
					<!--<p>Enter the words in the image above:</p>-->
					<!--<p>
					<?php					
					//$data = array(
					//	'name' => 'captchaData',
					//	'id' => 'captchaData',
					//	'value' =>'',
					//);
					//echo form_input($data);
					?>
					</p></br>-->
					<p>
					<?php 
				
					echo form_submit('mysubmit', 'Register', "id='submit'"); echo form_close();?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>

		
			
				
			
			
			


			
			
		



	
	
	
	
	

