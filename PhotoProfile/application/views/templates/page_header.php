<div class="wrapper col1">
<div id="header" class="clear">
    <div class="fl_left">
      <h1><a href="<?php echo base_url(); ?>">PhotographerProfile</a></h1>
      <p>Welcome to PhotographerProfile.com!</p>
    </div>
    <div class="fl_right"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>/images/HomeImg.jpg" alt="" /></a></div>
  </div>
</div>
<!-- Menu Header -->
<div class="wrapper col1">
  <div id="topbar" class="clear">
    <ul id="topnav">
      <li class="active"><a href="<?php echo base_url(); ?>">Home</a></li>
      <li><a href="<?php echo base_url('search'); ?>">Search</a></li>
      <li><a href="<?php echo base_url(); ?>">Forum Links - Coming Soon</a></li>
      <li><a href="#">Members</a>
        <ul>
		  <?php if($validated == true){ ?>
			<li><a href="<?php echo base_url('member/myProfile'); ?>">My Profile</a></li>
			<li><a href="<?php echo base_url('member/memberLogout'); ?>">Logout</a></li>
		  <?php } else { ?>
			<li><a href="<?php echo base_url('member/memberLogin'); ?>">Login/Create Account</a></li>
		  <?php } ?>		
        </ul>
      </li>
      <!--<li><a href="http://photographerprofile.com/application/views/templates/portfolio.html">News</a></li>-->
	  <li><a href ="<?php echo base_url('news'); ?>">News</a></li>
      <!--<li class="last"><a href="http://photographerprofile.com/application/views/templates/gallery.html">Gallery</a></li>-->
	  <li><a href ="<?php echo base_url('gallery'); ?>">Gallery</a></li>
    </ul>
    <form action="#" method="post" id="search">
      <fieldset>
        <legend>Site Search</legend>
        <input type="text" value="Search Our Website&hellip;" onfocus="this.value=(this.value=='Search Our Website&hellip;')? '' : this.value ;" />
        <input type="image" id="go" src="http://photographerprofile.com/images/search.gif" alt="Search" />
      </fieldset>
    </form>
  </div>
</div>
  <!-- end div#header -->