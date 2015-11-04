<?php $this->load->view('templates/page_header'); ?>
<?php $this->load->view('templates/page_menu'); ?>

<div id="splash"><img src="http://photographerprofile.com/images/img03.jpg" width="940" height="255" alt="" /></div>
  <div id="page">
    <div id="page-bgtop">
        <div id="content">
			<div class="post">
				<div class="entry">
					<fieldset>
					<legend><h2>Contact PhotographerProfile.com</h2></legend>
						<?php echo validation_errors(); ?>
						<p>
						<table id="contact">
						<?php
							echo form_open('contact') . "<br />"; 
							echo "<tr><td>".form_label('Name: ', 'name'). "</td><td>" . form_input('name', set_value('name')) . "</td></tr>";
							echo "<tr><td>".form_label('Email: ', 'email'). "</td><td>" . form_input('email', set_value('email')) . "</td></tr>";
							$data = array(
								'name' => 'content',
								'id' => 'content',
								'value' => set_value('content'),
								'rows' => '6',
								'cols' => '50',
								'style' => 'margin: 0; padding: 0;',
								);
							echo "<tr><td>".form_label('Inquiry: ', 'content'). "</td><td>" . form_textarea($data) . "</td></tr>";
							
							echo "<tr><td>".form_submit('submit', 'Submit') . "</td></tr>";
							echo form_close();
						?>
						</table>
						</p>
					</fieldset>
				</div>
			</div>
		</div>
		<?php $this->load->view('templates/side_bar'); ?>
      <div style="clear: both; height: 1px"></div>
	</div>
</div>
	
		