<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="EN" lang="EN" dir="ltr">
<head profile="http://gmpg.org/xfn/11">
<title>PhotographerProfile</title>
<meta name="keywords" content="photography, profiles, networking, pricing, travel" />
<meta name="description" content="We bring the photographers to you" />

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="imagetoolbar" content="no" />

<link rel="stylesheet" href="http://photographerprofile.com/css/photo/layout.css" type="text/css" />
<link rel="stylesheet" href="http://photographerprofile.com/css/photo/prettyPhoto.css" type="text/css" />
	
<script type="text/javascript" src="http://photographerprofile.com/js/jquery-1.4.1.min.js"></script>
<script type="text/javascript" src="http://photographerprofile.com/js/jquery-ui-1.8.12.custom.min.js"></script>
<script type="text/javascript" src="http://photographerprofile.com/js/jquery-prettyPhoto.js"></script>

<script type="text/javascript">
$(document).ready(function () {
	$("#tabcontainer").tabs({
		event: "click"
	});
	$("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'dark_rounded'
	});
	$('#portfolioslider').coinslider({
		width: 480,
		height: 280,
		navigation: false,
		links: false,
		hoverPause: true
	});
});         
</script>

<?php echo $addlHeadData; ?>

</head>
<body>
<!--<div id="wrapper col1">-->
