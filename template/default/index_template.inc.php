<?php
// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) {
    die("can not access this file directly");
}

// this template is based on Novus theme for Drupal
// created by Rocket Theme.
// visit: http://www.rockettheme.com/Templates/Free_Templates/Novus_-_Free_Joomla_Template/
// Porting to SLIMS by Arie Nugraha (dicarve@yahoo.com, dicarve@gmail.com)
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $page_title; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="webicon.ico" type="image/x-icon" />
<link href="template/core.style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sysconf['template']['css']; ?>" rel="stylesheet" type="text/css" />
<!--[if IE]>
  <link type="text/css" rel="stylesheet" media="all" href="template/default/ie.css"/>
<![endif]-->
<!--[if IE 6]>
  <link type="text/css" rel="stylesheet" media="all" href="template/default/ie6.css"/>
<![endif]-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/gui.js"></script>
</head>

<body class="not-front logged-in page-node node-type-page one-sidebar sidebar-left">
<div id="primary">
    <ul class="links" id="navlist">
	<li class="active-trail first last active"><a href="index.php" title="Homepage" class="active"><span><?php echo __('Home'); ?></span></a></li>
    <li><a href="index.php?p=libinfo"><span><?php echo __('Library Information'); ?></span></a></li>
    <li><a href="index.php?p=help"><span><?php echo __('Help on Search'); ?></span></a></li>
    <li><a href="index.php?p=member"><span><?php echo __('Member Area'); ?></span></a></li>
    <li><a href="index.php?p=login"><span><?php echo __('Librarian LOGIN'); ?></span></a></li>
	</ul>
</div>

<div id="header-region"></div>
<div id="header">
<div id="h2">
<a href="index.php" title="Home"><img src="template/default/images/logo.png" alt="Home" /></a>
<div class="search-box">
<form action="index.php" accept-charset="UTF-8" method="get" id="search-theme-form">
<div>
	<div id="search" class="container-inline">
	<div class="form-item" id="edit-search-theme-form-1-wrapper">
	<input type="text" maxlength="128" name="keywords" size="30" value="" title="Enter the terms you wish to search for." class="form-text" />
	<input type="submit" name="search" value="Search"  class="form-submit" />
    </div>
	</div>
</div>
</form>
</div>
<h1 class="site-name"><a href="index.php" title="Home"><?php echo $sysconf['library_name']; ?><div id="subname"><?php echo $sysconf['library_subname']; ?></div></a></h1>    
<span class="clear"></span>
</div>
</div> <!-- end header -->

<div id="wrapper">
<div id="sidebar-left" class="clearfix">

<div class="block block-user">
  <h2>Welcome</h2>
  <div class="content"><?php echo $header_info; ?></div>
</div><!-- end block -->

<div class="block block-user">
  <h2><?php echo __('Select Language'); ?></h2>

  <div class="content">
    <form name="langSelect" action="index.php" method="get">
    <select name="select_lang" style="width: 99%;" onchange="document.langSelect.submit();">
    <?php echo $language_select; ?>
    </select>
    </form> 
  </div>
</div><!-- end block -->

<div class="block block-user">
  <h2><?php echo __('Advanced Search'); ?></h2>

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
</div><!-- end block -->

<div class="block block-user">
  <h2>License</h2>

  <div class="content">This software and this template are released Under <a href="http://www.gnu.org/copyleft/gpl.html" title="GNU GPL License" target="_blank">GNU GPL License</a> Version 3.</div>
</div><!-- end block -->

</div><!-- end sidebar-left -->

<div id="main" class="clearfix">
<div id="main-inner">
<div id="main-inner2">
<div class="inner">
<h1 class="title"><?php echo $info; ?></h1>
<div class="node">
<br clear="all"/>
<div class="content">
<?php echo $main_content; ?>
</div><!-- end content -->
</div><!-- end node -->
</div><!-- end inner -->
</div><!-- end main-inner2 -->
</div><!-- end main-inner -->
</div><!-- end main -->
<br clear="all"/>
<span class="clear"></span>
</div><!-- end wrapper -->
<br clear="all"/>

<div id="footer">
This template is based on <a href="http://www.rockettheme.com/Templates/Free_Templates/Novus_-_Free_Joomla_Template/">Novus</a> Theme by <a href="http://www.rockettheme.com">Rocket Theme</a>. Porting to SLiMS by <a href="http://dicarve.blogspot.com">Dicarve@Gmail.com</a>
<br />Wallpaper by <a href="http://gnome-look.org/content/show.php/Sky+Race+%283+variations%29?content=144229">LiquidSky64</a> 
</div><!-- end footer -->

</body>
</html>