<?php $this->load->view('templates/page_header'); ?>

<!-- ####################################################################################################### -->
<div class="wrapper col2">
	<div id="container" class="clear">
    <!-- ####################################################################################################### -->
		<h2>Contact <?php echo $memberDetails['username'];?></h2>
			<?php if(! is_null($msg)) echo $msg; ?>
			<?php echo validation_errors(); ?>
			<p>
			<?php
				echo form_open('member/sendPhotographerInquiry') ."<br />"; 
				echo "<p>".form_label('Name: ', 'name'). "</td><td>" . form_input('name', set_value('name')) . "</p>";
				echo "<p>".form_label('Email: ', 'email'). "</td><td>" . form_input('email', set_value('email')) . "</p>";
				$data = array(
					'name' => 'contactInquiry',
					'id' => 'contactInquiry',
					'value' => set_value('contactInquiry'),
					'rows' => '6',
					'cols' => '50',
					'style' => 'margin: 0; padding: 0;',
					);
				echo "<p>".form_label('Inquiry: ', 'contactInquiry'). "</td><td>" . form_textarea($data) . "</p>";
				
				//sending unique user typeId for account type
				$data = array(
					'name' => 'memberEmail',
					'id' => 'memberEmail',
					'value' => $memberDetails['email'],
					'type' => 'hidden',
				);
				echo form_input($data);
				
				//sending unique user typeId for account type
				$data = array(
					'name' => 'memberId',
					'id' => 'memberId',
					'value' => $memberDetails['userId'],
					'type' => 'hidden',
				);
				echo form_input($data);
				
				echo "<p>Type the Captcha below:</p>";
				
				echo $cap['image'];
				
				$data = array(
					'name' => 'captchaData',
					'id' => 'captchaData',
					'value' =>'',
				);
				echo form_input($data);
				
				$submitarray = array (
					'name' => 'submit',
					'id' => 'submit',
				);
				
				echo "<p>".form_submit($submitarray, 'Submit') . "</p>";
				echo form_close();
			?>
			</p>
			
			<p><a href="<?php echo base_url('member/member/'.$memberDetails['userId'].''); ?>">Back To Profile</a></p>
	</div>
</div>