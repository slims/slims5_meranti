<?php
// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) {
    die("can not access this file directly");
}

// this template is based on Addari theme for Drupal
// Porting to SLIMS by Arie Nugraha (dicarve@yahoo.com, dicarve@gmail.com)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="webicon.ico" type="image/x-icon" />
<link type="text/css" rel="stylesheet" href="template/matoa/master.css"/> 
<link type="text/css" rel="stylesheet" media="all" href="template/core.style.css" />
<link type="text/css" rel="stylesheet" media="all" href="<?php echo $sysconf['template']['css']; ?>" />
<!--[if lt IE 7]>
<![endif]-->
<style type="text/css" media="all">@import "template/matoa/fix-ie6.css";</style>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/gui.js"></script>
<script type="text/javascript" src="template/matoa/script.js?n"></script>
</head>
<body class="front logged-in page-node one-sidebar sidebar-left sideTrue  search_box " id="mainbody" >

<div id="container">

<div id="head">

<div id="hleft">
<div id="titles">
  <div id="logocontainer"><a href="index.php" title="Home"><img src="template/matoa/images/logo.png" alt="Home" /></a></div> 
  <div id="textcontainer">
  <h1 class='site-name'><a href="index.php" title="Home"><?php echo $sysconf['library_name']; ?><div id="subname"><?php echo $sysconf['library_subname']; ?></div></a></h1>
  </div>
</div>
</div>

<div id="hright">
<div id="secondary-links"></div>
<div id="header_block">
</div>
</div>

</div><!-- end head-->

<div id="mast">

<div id="primary_menu_bar">
<ul class="menu">
<li class="active-trail first last active"><a href="index.php" title="Homepage" class="active"><span><?php echo __('Home'); ?></span></a></li>
<li><a href="index.php?p=libinfo"><span><?php echo __('Library Information'); ?></span></a></li>
<li><a href="index.php?p=help"><span><?php echo __('Help on Search'); ?></span></a></li>
<li><a href="index.php?p=member"><span><?php echo __('Member Area'); ?></span></a></li>
<li><a href="index.php?p=login"><span><?php echo __('Librarian LOGIN'); ?></span></a></li>
</ul>
</div><!-- end primary menu bar -->

<div id="wrap" >

<div id="postarea">
<div id="postareainner">
<?php echo $header_info; ?>
<div id="info-box"><?php echo $info; ?></div>
<?php echo $main_content; ?>
</div><!-- end postareainner -->
</div><!-- end postarea -->

<div id="sidearea">

<div id="search-block-main">
<form action="index.php" accept-charset="UTF-8" method="get" id="search-theme-form">
	<div><div class="container-inline">
	<div class="form-item" id="edit-search-theme-form-1-wrapper">
	 <label for="edit-search-theme-form-1">Search</label>
	 <input type="text" maxlength="128" name="keywords" id="edit-search-theme-form-1" size="15" value=""  title="Enter the terms you wish to search for." class="form-text" />
	</div>
	<input type="submit" name="search" id="edit-submit" value="Search"  class="form-submit" />
	</div>
	</div>
</form>
</div><!-- end search block main -->

<div id="sidebars" class="clear-block">

<div class="block block-user" id="block-user-1">
    <h2 class="title"><?php echo __('Select Language'); ?></h2>
    <div class="content">
	<form name="langSelect" action="index.php" method="get">
	<select name="select_lang" style="width: 99%;" onchange="document.langSelect.submit();">
	<?php echo $language_select; ?>
	</select>
	</form> 	
	</div>
</div>

<div class="block block-user" id="block-user-1">
    <h2 class="title"><?php echo __('Advanced Search'); ?></h2>
    <div class="content">
    <form name="advSearchForm" id="advSearchForm" action="index.php" method="get">
    <?php echo __('Title'); ?> :
    <input type="text" name="title" />
    <?php echo __('Author(s)'); ?> :
    <?php echo $advsearch_author; ?>
    <?php echo __('Subject(s)'); ?> :
    <?php echo $advsearch_topic; ?>
    <?php echo __('ISBN/ISSN'); ?> :
    <input type="text" name="isbn" />
    <?php echo __('GMD'); ?> :
    <select name="gmd">
    <?php echo $gmd_list; ?>
    </select>
    <?php echo __('Collection Type'); ?> :
    <select name="colltype">
    <?php echo $colltype_list; ?>
    </select>
    <?php echo __('Location'); ?> :
    <select name="location">
    <?php echo $location_list; ?>
    </select>
    <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button margin-top" />
    </form>
	</div>
</div>

<div class="block block-user" id="block-user-1">
<h2 class="title">License</h2>
<div class="content">
<p>
This Software is Released Under <a href="http://www.gnu.org/copyleft/gpl.html" title="GNU GPL License" target="_blank">GNU GPL License</a>
Version 3.
</p>
</div>
</div>

<div class="block block-user" id="block-user-1">
<h2 class="title">Award</h2>
<div class="content">
The Winner in the Category of OSS<br />
  <img src="template/matoa/images/logo-inaicta.png"
            alt="Indonesia ICT Award 2009" border="0" /></div>
</div>



</div><!--sidebars-->

</div><!-- end sidearea -->
<br style="clear:both;" />
</div>

</div>

<div id="footer"> <div id="foot-block">  <div class="block block-system" id="block-system-0">
    <h2 class="title"></h2>
    <div class="content"><?php echo $sysconf['page_footer']; ?></div>
 </div>
 </div><br/> Powered by <a href="http://slims.web.id">SLiMS</a>, ported from Addari, a Drupal themes from <a href="http://www.worthapost.com/" title="Worthapost Drupal themes">Worthapost Drupal themes</a>, by Dicarve@gmail.com </div>

</div> <!--container-->
  </body>
</html>