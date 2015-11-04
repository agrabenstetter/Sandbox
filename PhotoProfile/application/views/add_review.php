<?php $this->load->view('templates/page_header'); ?>
<?php $this->load->view('templates/page_menu'); ?>

<div id="splash"><img src="http://photographerprofile.com/images/img03.jpg" width="940" height="255" alt="" /></div>  

<div id="page">    
	<div id="page-bgtop">        
		<div id="content">			
			<div class="post">				
				<div class="entry">					
					<fieldset>
					<?php if(! is_null($msg)) echo $msg;?>
					<legend><h2>Add A Photographer Review</h2></legend>
						<?php echo form_open('member/addPhotoReview');?>
						<li><label for="comments">Comments:</label>
							<?php 
								$data = array(
									'name' => 'reviewerComment',
									'id' => 'reviewerComment',
									'value' => '',
									'rows' => '10',
									'cols' => '50'
								);
								if(form_error('email') != '') $validationMessage = '*';
								else $validationMessage = '';
								echo form_textarea($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
							?>
						</li>
						<div class='movie_choice'>
							Rate This User!
							<div id="r1" class="rate_widget">
								<div class="star_1 ratings_stars"></div>
								<div class="star_2 ratings_stars"></div>
								<div class="star_3 ratings_stars"></div>
								<div class="star_4 ratings_stars"></div>
								<div class="star_5 ratings_stars"></div>
								<div class="total_votes">vote data</div>
							</div>
						</div>
						<!--<li><label for="rating">Rating:</label>
							<?php 
								$data = array(
									'name' => 'rating',
									'id' => 'rating',
									'value' => '',
									'maxlength' => '1',
									'size' => '1'
								);
								if(form_error('email') != '') $validationMessage = '*';
								else $validationMessage = '';
								echo form_input($data) . '<span style="color:red;">' .$validationMessage. '</span> ';
							?>
						</li>-->
						<?php 
							//sending memberId
							$data = array(
								'name' => 'memberId',
								'id' => 'memberId',
								'value' => $memberId,
								'type' => 'hidden',
							);
							
							echo form_input($data);
						?>
						<br />
						<li><label for="submit"></label>
							<?php echo form_submit('addPhotoReview', 'Add Review'); echo form_close();?>
						</li>
					</fieldset>
				</div>			
			</div>		
		</div>		
		<?php $this->load->view('templates/side_bar'); ?>      
		<div style="clear: both; height: 1px"></div>	
	</div>
</div>