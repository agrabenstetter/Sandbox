<?php $this->load->view('templates/page_header'); ?>

<div class="wrapper col2">
  <div id="container" class="clear">
    <!-- ####################################################################################################### -->
	  <h2><?php echo $userInfo['username']?></h2>
	  <div id="tabcontainer">
		<ul id="tabnav">
			<li><a href="#tabs-1">Profile</a></li>
			<li><a href="#tabs-2">Photography Services Offered</a></li>
			<li><a href="#tabs-3">Reviews</a></li>
			<li><a href="#tabs-4">Portfolio</a></li>
		</ul>
		<div id="tabs-1" class="tabcontainer">
			<div id="hpage_portfolio" class="clear">
				<div class="content">
					<p>
					<?php 
						if($this->uri->segment(3)>0)
						{
							if($profilePhoto['fileName'] == NULL)
							{
								echo '<img class="imgl" src="'. base_url('images/no_photo.png') . '" width="150" height="150" alt="--" />';
							}
							else
							{
								echo '<img class="imgl" src="'. base_url('userImages/'.$this->uri->segment(3).'/profileImage/'.$profilePhoto['fileName']) . '" width="150" height="150" alt="--" />';
							}
						}
						else
						{
							if($profilePhoto['fileName'] == NULL)
							{
								echo '<img class="imgl" src="'. base_url('images/no_photo.png') . '" width="150" height="150" alt="--" />';
							}
							else
							{
								echo '<img class="imgl" src="'. base_url('userImages/'.$userInfo['userId'].'/profileImage/'.$profilePhoto['fileName']) . '" width="150" height="150" alt="--" />';
							}
						}				
					?>
					</p>
					<p><b>Joined: </b><?php echo $userInfo['dateCreated']; ?></p></br>
					<p><b>Verified Photographer: </b><?php echo ($userInfo['isAccountVerified'] == 1 ? 'Yes' : 'No'); ?></p></br>
					<p><b>Location: </b><?php echo $userInfo['city']; ?> <?php echo $userInfo['state']; ?>, <?php echo $userInfo['zipPostalCode']; ?></p></br>
					<p><b>Experience/Education: </b> <?php echo $profileInfo['education']; ?></p></br>
					<p><b>Bio: </b> <?php echo $userInfo['shortBio']; ?></p></br>
					<p><b>Social Links:</b><br /></br>
						<?php
							if ($profileInfo['facebookURL'] != NULL)
							{
								echo '<a target = "_blank" href="http://'.$profileInfo['facebookURL'].'"/><img src="'. base_url('images/facebookActive.png').'" width="30" height="30" alt="Facebook" /></a>';
							}
							else
							{
								echo '<img src="'. base_url('images/facebookInactive.png').'" width="30" height="30" alt="Facebook" />';
							}
							if ($profileInfo['linkedInURL'] != NULL)
							{
								echo '<a target = "_blank" href="http://'.$profileInfo['linkedInURL'].'"/><img src="'. base_url('images/linkedInActive.png').'" width="30" height="30" alt="LinkedIn" /></a>';
							}
							else
							{
								echo '<img src="'. base_url('images/linkedInInactive.png').'" width="30" height="30" alt="LinkedIn" />';
							}
							if ($profileInfo['pintrestURL'] != NULL)
							{
								echo '<a target = "_blank" href="http://'.$profileInfo['pintrestURL'].'"/><img src="'. base_url('images/pintrestActive.png').'" width="30" height="30" alt="Pintrest" /></a>';
							}
							else
							{
								echo '<img src="'. base_url('images/pintrestInactive.png').'" width="30" height="30" alt="Pintrest" />';
							}
							if ($profileInfo['tumblrURL'] != NULL)
							{
								echo '<a target = "_blank" href="http://'.$profileInfo['tumblrURL'].'"/><img src="'. base_url('images/tumblrActive.png').'" width="30" height="30" alt="tumblr" /></a>';
							}
							else
							{
								echo '<img src="'. base_url('images/tumblrInactive.png').'" width="30" height="30" alt="tumblr" />';
							}
							if ($profileInfo['flikrURL'] != NULL)
							{
								echo '<a target = "_blank" href="http://'.$profileInfo['flikrURL'].'"/><img src="'. base_url('images/flikrActive.png').'" width="30" height="30" alt="Flikr" /></a>';
							}
							else
							{
								echo '<img src="'. base_url('images/flikrInactive.png').'" width="30" height="30" alt="Flikr" />';
							}						
							if ($profileInfo['websiteURL'] != NULL)
							{
								echo '<a target = "_blank" href="http://'.$profileInfo['websiteURL'].'"/><img src="'. base_url('images/websiteActive.png').'" width="30" height="30" alt="Website" /></a>';
							}	
							else
							{
								echo '<img src="'. base_url('images/websiteInactive.png').'" width="30" height="30" alt="Website" />';
							}
						?>
					</p></br></br>
					<?php if(($userInfo['isOKToEmail'] == 1) && ($this->uri->segment(3)>0)){?>
					<p><b><a href="<?php echo base_url("member/contactPhotographer/". $this->uri->segment(3)); ?>">Contact This Photographer!</a></b></p>
					<?php } 
					else if(($userInfo['isOKToEmail'] == 1) && !($this->uri->segment(3)>0)){?>
					<p><b><a href="<?php echo base_url("member/contactPhotographer/". $userInfo['userId']); ?>">Contact This Photographer!</a></b></p>
					<?php } ?>
				</div>
			</div>
		</div>
		<div id="tabs-2" class="tabcontainer">
			<div id="content">
				<b>Photography Specialization:</b><br />
				<table summary="Summary Here" cellpadding="0" cellspacing="0">
				<thead>
				  <tr>
					<th>Photography Offering</th>
					<th>Minimum Price</th>
					<th>Maximum Price</th>
					<th>Cost Per Session/Hour</th>
					<th>Offering Description</th>
				  </tr>
				</thead>
				<tbody>
				<?php $tableCount = 0; ?>
				<?php foreach($phoTypes as $type): ?>
				<?php foreach($memberSpecialties as $mType){ 
					if($type['id'] == $mType['photographerTypeId']){				
				?>
				<?php if($tableCount <= 0){ ?>
			    <tr class="light">
				<?php 
					$tableCount++;
				}
				else{ ?>
				<tr class="dark">
				<?php 
					$tableCount = 0;
				} ?>
					<td><?php echo $type['photographerType']; ?></td>
					<td><?php echo '$'.$mType['minPrice']; ?></td>
					<td><?php echo '$'.$mType['maxPrice']; ?></td>
					<td><?php echo $mType['photoChargeType']; ?></td>
					<td><?php echo $mType['photoTypeDesc']; ?></td>
				</tr>
				<?php }
				}
				endforeach ?>
				</tbody>
				</table></br>
				<?php if(($userInfo['isOKToEmail'] == 1) && ($this->uri->segment(3)>0)){?>
				<p><b><a href="<?php echo base_url("member/contactPhotographer/". $this->uri->segment(3)); ?>">Contact This Photographer!</a></b></p>
				<?php } 
				else if(($userInfo['isOKToEmail'] == 1) && !($this->uri->segment(3)>0)){?>
				<p><b><a href="<?php echo base_url("member/contactPhotographer/". $userInfo['userId']); ?>">Contact This Photographer!</a></b></p>
				<?php } ?>
			</div>
		</div>
		<div id="tabs-3" class="tabcontainer">
			<div id = "comments">
			<h2>Comments/Reviews For <?php echo $userInfo['username']; ?></h2>
			<ul class="commentlist">
				<?php $count = 0; ?>
				<?php foreach($ratingInfo as $rating): ?>
				<?php
					$reviewDetail = $this->member_model->GetMemberDetails($rating['reviewerName']);
					$date = date_create($rating['dateCreated']);					
				?>
				<?php if($count <= 0){ ?>
			    <li class="comment_odd">
				<?php 
					$count++;
				}
				else{ ?>
				<li class="comment_even">
				<?php 
					$count = 0;
				} ?>
					<div class="author"><img class="avatar" src="<?php echo base_url('images/avatar.gif') ?>" width="32" height="32" alt="" /><span class="name"><a href="<?php echo base_url('member/member/'.$reviewDetail['userId']); ?>"><?php echo $reviewDetail['username']; ?></a></span> <span class="wrote">wrote:</span></div>
					<div class="submitdate"><?php echo date_format($date, 'g:ia \o\n l jS F Y'); ?></div>
					<p><?php echo $rating['reviewerComment']; ?></p>
				</li>
				<!--</h3> - Rating: <?php //echo $rating['rating']; ?> stars <br /> <br />-->
				<?php endforeach ?>
			</ul>
			</div>
			<h2>Write A Comment</h2>
			<p><i>You must be logged in with an account in order to submit a comment/review of a photographer.  You can create an account <a href="<?php echo base_url('/member/memberLogin'); ?>" >here</a></i></p>
			  <div id="respond">
				<?php echo form_open('member/addPhotoReview');?>
				  <p>
					<label for="comment" style="display:none;"><small>Comment (required)</small></label>
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
				  </p>
			  		<?php 
						$data = array(
							'name' => 'memberId',
							'id' => 'memberId',
							'value' => $userInfo['userId'],
							'class' => 'memberId',
							'type' => 'hidden'
						);
						
						echo form_input($data);
					?></br>

				  <p>
					<?php echo form_submit('addPhotoReview', 'Submit Comment', "id='submit'"); echo form_close();?>
				  </p>
			  </div>
		</div>
		<div id="tabs-4" class="tabcontainer">
			<div class="wrapper col2">
			  <div id="container" class="clear">
				<!-- ####################################################################################################### -->
				<div id="portfolio">
				  <?php foreach($memberAlbums as $Category) : ?>
				  <?php //var_dump($memberPhotos); ?>
				  <div class="portfoliocontainer clear">
					<div class="fl_left">
					  <h2><?php echo $Category['albumName']; ?></h2>
					  <p><?php echo $Category['albumDesc']; ?></p>
					</div>
					<div class="fl_right">
					  <ul>
						<?php $lastCount = 1;?>
						<?php for($i = 0; $i<count($memberPhotos);$i++){
								if($memberPhotos[$i]['albumId'] == $Category['id']){
									if($lastCount = 3){
						?>
						<li><img src="<?php echo base_url("userImages/".$userInfo['userId']."/".$Category['albumName']."/".$memberPhotos[$i]['fileName']);?>" width="210" height="150" alt="" />
						  <p class="name"><?php echo $memberPhotos[$i]['fileDescription']; ?></p>
						</li>
						<?php $lastCount = 0;} else {?>
						<li><img src="<?php echo base_url("userImages/".$userInfo['userId']."/".$Category['albumName']."/".$memberPhotos[$i]['fileName']);?>" width="210" height="150" alt="" />
						  <p class="name"><?php echo $memberPhotos[$i]['fileDescription']; ?></p>
						</li>
						<?php	} 
							$lastCount++;
							} 
						}
						?>
					  </ul>
					</div>
				  </div>
				  <?php endforeach ?>
				  <!-- ########### -->
				</div>
				<!-- ####################################################################################################### -->
				<div class="pagination">
				  <ul>
					<li class="prev"><a href="#">&laquo; Previous</a></li>
					<li><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li class="splitter">&hellip;</li>
					<li><a href="#">6</a></li>
					<li class="current">7</li>
					<li><a href="#">8</a></li>
					<li><a href="#">9</a></li>
					<li class="splitter">&hellip;</li>
					<li><a href="#">14</a></li>
					<li><a href="#">15</a></li>
					<li class="next"><a href="#">Next &raquo;</a></li>
				  </ul>
				</div>
				<!-- ####################################################################################################### -->
			  </div>
			</div>
		</div>	
	  </div>
  </div>
</div>
				
			
			
			


			
			
		

