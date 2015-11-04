<?php $this->load->view('templates/page_header'); ?>
  
<div class="wrapper col2">
  <div id="container" class="clear">
	<div id="content">
	  <h1><b>Results</b></h1>
	  <?php if(! is_null($msg)) echo $msg; ?>
	  <?php //echo $zip; ?>
	  <?php $count = 0; ?>
		<?php foreach($results as $result_item): ?>	
		<div>
			<h2><a href="<?php echo base_url("member/member/". $result_item['userId']); ?>"><?php echo $result_item['username']; ?></a></h2>
			<!--<p class="byline">Rating: 5 stars</p>-->
				<div>
				<b>Profile Image:</b><br />
				<?php echo '<img src="'. base_url('userImages/'.$result_item['userId'].'/profileImage/'.$profilePhoto[$count]['fileName']) . '" width="100" height="100" alt="--" />'; ?><br />
				<p><?php echo $result_item['shortBio']; ?></p><br />
				</div>
		</div><br/>
		<?php $count++; ?>
		<?php endforeach ?>
    <!-- ####################################################################################################### -->
	</div>
	<div id="column">
      <div class="subnav">
        <h2>Refine Search</h2>
		<?php echo form_open('search/viewResults', array('id' => 'search-filter')); ?>
				<?php 
					$data = array(
						'name' => 'milesFrom',
						'id' => 'milesFrom',
						'value' => '50',
						'maxlength' => '4',
						'size' => '4',
						'class' => 'search square',
						'type' => 'hidden'
					);
					echo form_input($data);
				?>
			<p>
			<label>Zip/Postal Code: </label>
				<?php 
					if($zip == ''){
						$data = array(
							'name' => 'location',
							'id' => 'location',
							'value' => '',
							'maxlength' => '10',
							'size' => '10',
							'class' => 'userLocation'
						);
					}
					else{
						$data = array(
							'name' => 'location',
							'id' => 'location',
							'value' => $zip,
							'maxlength' => '10',
							'size' => '10',
							'class' => 'userLocation'
						);
					}
					echo form_input($data);
				?>
			</p>
			<p><b>Categories (optional)</b></p>
			<p>
				<?php			
					foreach($phoTypes as $type)
					{
						$data = array(
							'name' => 'photoCat[]',
							'id' => $type['id'],
							'value' => $type['photographerType'],
							'checked' => false
						);
						echo form_checkbox($data).'<b>'.$type['photographerType'].'</b> <br />';						
					}
				?>
			</p>
			<p><b>Price Range (optional)</b></p>
			<p>
			<label>Min Price: </label>
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
				?>
			</p>
			<p>
			<label>Max Price: </label>
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
				?>
			</p>
			<p>
			<label>Cost Per: </label>
				<?php 
					$data = array(
						'' => '',
						'hour' => 'Hour',
						'session' => 'Session',
					);
					echo form_dropdown('photoChargeType', $data);
				?>
			</p>
			<br />
		<?php echo form_submit('mysubmit', 'Update', "id='submit'"); echo form_close();?>
      </div>
    </div>
    <!-- ####################################################################################################### -->
  </div>
</div>	