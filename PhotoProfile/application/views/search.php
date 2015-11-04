<?php $this->load->view('templates/page_header'); ?>

<div class="wrapper col2">
  <div id="container" class="clear">
	<div id ="respond">
	<?php if(! is_null($msg)) echo $msg; ?>
	<?php echo form_open('search/viewResults', array('id' => 'categoryfilter')); ?> 
	<h2>Find a photographer that suits your needs</h2>
		<?php 
			$data = array(
				'name' => 'milesFrom',
				'id' => 'milesFrom',
				'value' => '50',
				'maxlength' => '4',
				'size' => '4',
				'class' => 'milesFromUser',
				'type' => 'hidden'
			);
			
			echo form_input($data);
		?>
	<p>
	<label>Zip/Postal Code: </label>
		<?php 
			$data = array(
				'name' => 'location',
				'id' => 'location',
				'value' => '',
				'maxlength' => '10',
				'size' => '10',
				'class' => 'userLocation'
			);
			
			echo form_input($data);
		?>
	</p>
	<br />
	<p><b>Categories (optional)</b></p><br />
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
	<br />
	<p><b>Price Range (optional)</b></p>
	<p>
	<label>Min Price: </label>
		<?php 
			$data = array(
				'' => '',
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
				'' => '',
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
	 <?php 
		
	 echo form_submit('mysubmit', 'Search', "id='submit'"); echo form_close();?> 
	 
	</div>
  </div>
</div>