<?php $this->load->view('templates/page_header'); ?>
<?php $this->load->view('templates/page_menu'); ?>

<div id="splash"><img src="http://photographerprofile.com/images/img03.jpg" width="940" height="255" alt="" /></div>  

<div id="page">    
	<div id="page-bgtop">        
		<div id="content">			
			<div class="post">				
				<div class="entry">					
					<fieldset>
					<?php if(! is_null($msg)) echo $msg; ?>
					<legend><h2>Forgot Password</h2></legend>
						<?php echo form_open('member/forgotPWD');?>
						<li><label for="email">Email:</label>
							<?php 
								$data = array(
									'name' => 'email',
									'id' => 'email',
									'value' => '',
									'maxlength' => '50',
									'size' => '40'
								);
								if(form_error('email') != '') $validationMessage = '*';
								else $validationMessage = '';
								echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
							?>
						</li>
						<li><label for="submit"></label>
							<?php echo form_submit('forgotPWD', 'Send Password'); echo form_close();?>
						</li>
					</fieldset>
				</div>			
			</div>		
		</div>		
		<?php $this->load->view('templates/side_bar'); ?>      
		<div style="clear: both; height: 1px"></div>	
	</div>
</div>