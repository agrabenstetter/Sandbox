<?php //Load Header ?>
<?php $this->load->view('templates/page_header'); ?>

<!-- ####################################################################################################### -->
<div class="wrapper col1">
  <div id="featured_slide">
    <!-- ####################################################################################################### -->
    <div id="slider">
	What type of photo services are you searching for?  Click on any of the "Search Photographers" links below to search by specific category or go to the main search page.
      <ul id="categories">
        <li class="category">
          <h2>Wedding Photos</h2>
          <a href="<?php echo base_url("search/browseCategory/1"); ?>"><img src="http://photographerprofile.com/images/home/Wedding_150x110.jpg" alt="" /></a>
          <p>Wedding Photography includes aspects of photographing a wedding and traditionally, the reception following the wedding ceremony.  Find a photographer today to help capture this special event!</p>
          <p class="readmore"><a href="<?php echo base_url("search/browseCategory/1"); ?>">Search Photographers &raquo;</a></p>
        </li>
        <li class="category">
          <h2>Engagement Photos</h2>
          <a href="<?php echo base_url("search/browseCategory/5"); ?>"><img src="http://photographerprofile.com/images/home/Engagement_150x110.jpg" alt="" /></a>
          <p>Engagement Photography captures images of the newly engaged couple proceeding the wedding nuptuals.</p>
          <p class="readmore"><a href="<?php echo base_url("search/browseCategory/5"); ?>">Search Photographers &raquo;</a></p>
        </li>
        <li class="category">
          <h2>Family Photos</h2>
          <a href="<?php echo base_url("search/browseCategory/4"); ?>"><img src="http://photographerprofile.com/images/home/Family_150x110.jpg" alt="" /></a>
          <p>Family photography can include a small intimate family experience, or large extended family photo shoots.</p>
          <p class="readmore"><a href="<?php echo base_url("search/browseCategory/4"); ?>">Search Photographers &raquo;</a></p>
        </li>
        <li class="category">
          <h2>Newborn Photos</h2>
          <a href="<?php echo base_url("search/browseCategory/3"); ?>"><img src="http://photographerprofile.com/images/home/Newborn_150x110.jpg" alt="" /></a>
          <p>Photography of infants and newborns that capture their very early stages of life.  Typically taken a few days to weeks into the newborn's life.</p>
          <p class="readmore"><a href="<?php echo base_url("search/browseCategory/3"); ?>">Search Photographers &raquo;</a></p>
        </li>
        <li class="category">
          <h2>Maternity/Birth Photos</h2>
          <a href="<?php echo base_url("search/browseCategory/2"); ?>"><img src="http://photographerprofile.com/images/home/Birth_150x110.jpg" alt="" /></a>
          <p>Maternity photos capture the blossoming mommy-to-be, while birthing photos capture the miracle of child birth at the time of labor and delivery.</p>
          <p class="readmore"><a href="<?php echo base_url("search/browseCategory/2"); ?>">Search Photographers &raquo;</a></p>
        </li>
        <li class="category">
          <h2>School Photos</h2>
          <a href="<?php echo base_url("search/browseCategory/6"); ?>"><img src="http://photographerprofile.com/images/home/School_150x110.jpg" alt="" /></a>
          <p>Capture their years as they grow, anywhere from Preschool through the College years. Senior photography is the most common among the school photography sessions.</p>
          <p class="readmore"><a href="<?php echo base_url("search/browseCategory/6"); ?>">Search Photographers &raquo;</a></p>
        </li>
        <li class="category">
          <h2>Prom/Event Photos</h2>
          <a href="<?php echo base_url("search/browseCategory/7"); ?>"><img src="http://photographerprofile.com/images/home/Prom_150x110.jpg" alt="" /></a>
          <p>Captures the High School experience that is the magic of prom. In addition, other school dances or events may be included in this category as well.
          <p class="readmore"><a href="<?php echo base_url("search/browseCategory/7"); ?>">Search Photographers &raquo;</a></p>
        </li>
        <li class="category">
          <h2>Artistic Photos</h2>
          <a href="<?php echo base_url("search/browseCategory/8"); ?>"><img src="http://photographerprofile.com/images/home/Artistic_150x110.jpg" alt="" /></a>
          <p>Artistic Photography may include photography that is typically non-portrait photography. Still lifes, landscapes and pastoral photography as well as other non-human subject matter.</p>
          <p class="readmore"><a href="<?php echo base_url("search/browseCategory/8"); ?>">Search Photographers &raquo;</a></p>
        </li>
      </ul>
      <a class="prev disabled"></a> <a class="next disabled"></a>
      <div style="clear:both"></div>
    </div>
    <!-- ####################################################################################################### -->
  </div>
</div>
<!-- ####################################################################################################### -->
<div class="wrapper col2">
  <div id="container" class="clear">
    <!-- ####################################################################################################### -->
    <div id="tabcontainer">
      <ul id="tabnav">
        <li><a href="#tabs-1">Latest Photographers</a></li>
        <li><a href="#tabs-2">Featured Photographer</a></li>
        <li><a href="#tabs-3">Featured Websites</a></li>
        <li><a href="#tabs-4">Featured Articles</a></li>
		<!--<li><a href="#tabs-1">Site Features</a></li>-->
      </ul>
      <div id="tabs-1" class="tabcontainer">
        <h2 class="title">Newest Photographers To Join The Network!</h2>
        <ul class="line clear">
		<?php $count = 0; ?>
		<?php foreach($newMembers as $result): ?>
          <li>
			<div class="imgholder"><a href="<?php echo base_url("member/member/".$result['userID']);?>"><img src="<?php echo base_url("userImages/".$result['userID']."/profileImage/".$imageFile[$count]['fileName']);?>" alt="" /></a></div>
            <p class="name"><?php echo $result['username'];?></p>
            <p class="readmore"><a href="<?php echo base_url("member/member/".$result['userID']);?>">View This Photographer &raquo;</a></p>
          </li>
		<?php $count++; ?>
		<?php endforeach ?>
        </ul>
      </div>
      <!-- ########### -->
      <div id="tabs-2" class="tabcontainer">
        <div id="hpage_portfolio" class="clear">
          <div class="fl_left">
            <div id="portfolioslider">
              <ul>
				<?php foreach($featuredPhotos as $photos) : ?>
                <li><img src="<?php echo base_url("/userImages/".$photos['memberId']."/".$photos['albumName']."/".$photos['fileName']); ?>" width="480" height="280" alt="" /></li>
				<?php endforeach ?>
              </ul>
            </div>
          </div>
          <div class="fl_right">
			<?php foreach($featuredPhotographer as $featured) :?>
            <h2><?php echo $featured['username'];?></h2>
            <p><?php echo $featured['shortBio']?></p>
            <p class="readmore"><a href="<?php echo base_url("member/member/".$featured['userId']);?>">View This Photographer &raquo;</a></p>
			<?php endforeach ?>
          </div>
        </div>
      </div>
      <!-- ########### -->
      <div id="tabs-3" class="tabcontainer">
        <h2>Full Width Content</h2>
        <p>Lornunc tincidunt nec nequat risus convallisis elit vestiquat justo et volutpat. Urnanec monterdum turistibus semportis non vivamus justo pellus ac integestiquat eros. Turet cursuspend ero nulla dapienteger quisque nullamcorper lorem in ut pellus. Auctortorvel habitudin laorem commodo tincidunt eget habitur vitae aenec sentesque maecenasce. Nibhvivamus pretra cursuspendrerit pede ligula leo quismod condimentesque aenean ligula ipsum.</p>
        <p>Atmaecenas nec non nam nullamcorper magna id id nisl ac in. Sedfauctortis fuscetus estibus gravida id dui curabitur commodo facilisi loborttitorttitor vitae. Tortortissagittitortis diam vel hac nibh justo sed semper eget vitassa mattis. Aliquerhoncus tempus vest ulla justo pellus in aliquet in sed aucibulum. Odioelit tincidunt laorem venean tris vitae magna ut vel urnar vestibulus.</p>
      </div>
      <!-- ########### -->
      <div id="tabs-4" class="tabcontainer">
        <div id="content">
          <h1>This uses the 2 column layout found in the style demo</h1>
          <img class="imgr" src="http://photographerprofile.com/images/demo/imgr.gif" alt="" width="125" height="125" />
          <p>Aliquatjusto quisque nam consequat doloreet vest orna partur scetur portortis nam. Metadipiscing eget facilis elit sagittis felisi eger id justo maurisus convallicitur.</p>
          <p>Dapiensociis <a href="#">temper donec auctortortis cumsan</a> et curabitur condis lorem loborttis leo. Ipsumcommodo libero nunc at in velis tincidunt pellentum tincidunt vel lorem.</p>
          <img class="imgl" src="http://photographerprofile.com/images/demo/imgl.gif" alt="" width="125" height="125" />
          <p>Temperinte interdum sempus odio urna eget curabitur semper convallis nunc laoreet. Nullain convallis ris <a href="#"><strong>elis vest liberos nis diculis</strong></a> feugiat in rutrum. Suspendreristibulumfaucibulum lobortor quis tortortor ris sapien sce enim et volutpat sus.</p>
          <p>Urnaretiumorci orci <strong>fauctor leo justo nulla cras ridiculum</strong> eu id vitae. Etnon et dolor auctor eu loreet fring temper pend pede integestibus.</p>
          <p>Portortornec condimenterdum eget consectetuer condis consequam pretium pellus sed mauris enim. Puruselit mauris nulla hendimentesque elit semper nam a sapien urna sempus.</p>
        </div>
        <div id="column">
          <div id="featured">
            <ul>
              <li>
                <h2>Indonectetus facilis leonib</h2>
                <p class="imgholder"><img src="http://photographerprofile.com/images/demo/240x90.gif" alt="" /></p>
                <p>Nullamlacus dui ipsum conseque loborttis non euisque morbi penas dapibulum orna. Urnaultrices quis curabitur phasellentesque congue magnis vestibulum quismodo nulla et feugiat. Adipisciniapellentum leo ut consequam ris felit elit id nibh sociis malesuada.</p>
                <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>
              </li>
            </ul>
          </div>
        </div>
        <div class="clear"></div>
      </div>
      <!-- ########### -->
    </div>
    <!-- ####################################################################################################### -->
  </div>
</div>
<!-- Load Footer -->

		
			
				
			
			
			


			
			
		



	
	
	
	
	

