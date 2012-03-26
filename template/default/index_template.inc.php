<?php
/*------------------------------------------------------------

	Template		: Slims Meranti Template
	Create Date	: March 24, 2012
	Author		: Eddy Subratha (eddy.subratha@gmail.com)

-------------------------------------------------------------*/
// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) {
    die("can not access this file directly");
}
//set default index page
$p = 'home';

if (isset($_GET['p']))
{
	if ($_GET['p'] == 'libinfo') {
		$p = 'libinfo';
	} elseif ($_GET['p'] == 'help') {
		$p = 'help';
	} elseif ($_GET['p'] == 'member') {
		$p = 'member';
	} elseif ($_GET['p'] == 'login') {
		$p = 'login';
	}
}
// menu list
// if you want to add some menu, add array item below
$menus['home'] 	= array('url' => 'index.php', 			'text' => __('Home'));
$menus['libinfo'] = array('url' => 'index.php?p=libinfo', 	'text' => __('Library Information'));
$menus['help'] 	= array('url' => 'index.php?p=help', 	'text' => __('Help on Search'));
$menus['member'] 	= array('url' => 'index.php?p=member', 	'text' => __('Member Area'));
$menus['login'] 	= array('url' => 'index.php?p=login', 	'text' => __('Librarian LOGIN'));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title><?php echo $page_title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<!-- load style -->
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
	<script type="text/javascript" src="<?php echo $sysconf['template']['dir'].'/'.$sysconf['template']['theme']; ?>/js/supersized.3.1.3.min.js"></script>
	<script type="text/javascript" src="<?php echo $sysconf['template']['dir'].'/'.$sysconf['template']['theme']; ?>/js/adapt.min.js"></script>

</head>

<body>
	<div id="masking"></div>
	<div id="content">
		<div class="topic">
			<div class="container_12">
				<div class="language grid_5">
				    <form name="langSelect" action="index.php" method="get">
						<?php echo __('Select Language'); ?>&nbsp;&nbsp;
					    <select name="select_lang"  onchange="document.langSelect.submit();">
					    <?php echo $language_select; ?>
					    </select>
				    </form>
				</div>
				<div class="treding grid_7">
					<ul class="social">
						<li><a href="http://www.facebook.com/groups/senayan.slims/" target="blank">Facebook</a></li>
						<li><a href="http://twitter.com/#!/slims_official" target="_blank">Twitter</a></li>
						<li><a href="https://github.com/slims/" target="_blank">Github</a></li>
						<li><a href="http://www.youtube.com/user/senayanslims" target="_blank">Youtube Channel</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div class="logo">
			<div class="container_12">
				<div class="grid_4 title">
					<div class="sitename"><a href="index.php" title="Home"><?php echo $sysconf['library_name']; ?></div>
					<div class="subname"><?php echo $sysconf['library_subname']; ?></div>
				</div>
				<ul class="nav">
					<?php foreach ($menus as $path => $menu) { ?>
						<li><a href="<?php echo $menu['url']; ?>" title="<?php echo $menu['text']; ?>" <?php if ($p == $path) {echo ' class="active"';} ?>><?php echo $menu['text']; ?></a></li>
					<?php } ?>
				</ul>
			</div>
		</div>

		<div class="content">
			<div class="container_12">
				<div class="grid_12 welcome">
					<?php if(isset($_GET['title']) || isset($_GET['keyword'])) { ?>
					<div class="sidebar">
						<div class="tagline">
							<?php echo __('Information'); ?>
						</div>
						<p class="info">
							<?php echo $info; ?>
						</p>
						<div class="tagline">
							Related Collections
						</div>
						<ul>
							<li><a href="#">Lorem Ipsum</a></li>
							<li><a href="#">simply dummy text</a></li>
							<li><a href="#">the printing</a></li>
							<li><a href="#">typesetting industry</a></li>
							<li><a href="#">the industry</a></li>
							<li><a href="#">standard dummy text</a></li>
						</ul>

					</div>

					<div class="section">
						<div class="tagline">
							<?php echo __('Collections'); ?>
							<a href="javascript: history.back();" class="back to_right"> <?php echo __('Back'); ?> </a>
						</div>
						<div class="collections-list">
							<?php echo $main_content; ?>
							<div class="clear">&nbsp;</div>
						</div>
					</div>
					<?php } elseif($_GET['p'] == 'member') { ?>
					<div class="sidebar">
						<div class="tagline">
							<?php echo __('Information'); ?>
						</div>
						<div class="info">
							<?php echo $info; ?>
						</div>

						<div class="tagline">
							<?php echo __('User Login'); ?>
						</div>
						<div class="info">
							<?php echo $header_info; ?>
						</div>
					</div>
					<div class="section">
						<div class="collections-list">
							<?php echo $main_content; ?>
							<div class="clear">&nbsp;</div>
						</div>
					</div>
					<?php } elseif(isset($_GET['p'])) { ?>
						<?php echo $main_content; ?>
					<?php } else { ?>
					<div class="tagline">
						<?php echo $info; ?>
					</div>
					<div class="search">
					    <form name="advSearchForm" id="advSearchForm" action="index.php" method="get">
							<div class="simply">
							    <input type="text" name="title" id="title" class="keyword defaultText" value="" />
						    </div>
						    <div class="advance" style="display:none;">
						    <table width="100%">
							    <tr>
								    <td class="value">
								    <?php echo __('Author(s)'); ?>
								    </td>
								    <td class="value">
								    <?php echo $advsearch_author; ?>
								    </td>
								    <td class="value">
								    <?php echo __('Subject(s)'); ?>
								    </td>
								    <td class="value">
								    <?php echo $advsearch_topic; ?>
								    </td>
							    </tr>
							    <tr>
								    <td class="value">
								    <?php echo __('ISBN/ISSN'); ?>
								    </td>
								    <td class="value">
									    <input type="text" name="isbn" />
								    </td>
								    <td class="value">
									    <?php echo __('GMD'); ?>
								    </td>
								    <td class="value">
									    <select name="gmd">
									    <?php echo $gmd_list; ?>
									    </select>
								    </td>
								</tr>
								<tr>
								    <td class="value">
									    <?php echo __('Collection Type'); ?>
								    </td>
								    <td class="value">
									    <select name="colltype">
									    <?php echo $colltype_list; ?>
									    </select>
								    </td>
								    <td class="value">
									    <?php echo __('Location'); ?>
								    </td>
								    <td class="value">
									    <select name="location">
									    <?php echo $location_list; ?>
									    </select>
								    </td>
								</tr>
							    <tr>
								    <td colspan="4" class="value" style="text-align:center;">
									    <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="loginButton" style="te" />
									</td>
								</tr>
							</table>
							</div>
							<div id="show_advance">
							    	<a href="#"><?php echo __('Advanced Search'); ?></a>
						    </div>
					    </form>
					</div>
					<script type="text/javascript">
						$(document).ready(function()
						{
							//Disable all html autocomplete
							$('#advSearchForm input').attr('autocomplete','off');

							$('#show_advance').click(function(){
								$('.advance').slideToggle();
							});

							$('#title').focus();
						});

					</script>
					<?php } ?>
				</div>
			</div>
		</div>

		<div class="footer">
			<div class="container_12">
				<div class="grid_6 lisence">
					This software and this template are released Under GNU GPL License Version 3
				</div>
				<div class="grid_5 oss">
					Award-Winning of Open Source Software Category in ICT Award 2009
				</div>
			</div>
		</div>

	</div>

	<script type="text/javascript">
	jQuery(function($){
		$.supersized({
      transition			: 6,
      keyboard_nav          : 0,
			start_slide			:	1,		//Start slide (0 is random) //Requires multiple background images
			vertical_center       	:   1,		//Vertically center background
			horizontal_center     	:   1,		//Horizontally center background
			min_width		    	:   1000,	//Min width allowed (in pixels)
			min_height		    	:   700,	//Min height allowed (in pixels)
			fit_portrait         	:   1,		//Portrait images will not exceed browser height
			fit_landscape			:   0,		//Landscape images will not exceed browser width
			image_protect			:	1,		//Disables image dragging and right click with Javascript
			slides					:   [ 		//Background image
			{ image : '<?php echo $sysconf['template']['css']; ?>/../images/1.jpg' },
			{ image : '<?php echo $sysconf['template']['css']; ?>/../images/2.jpg' }										]
		});
	});

	</script>

</body>
</html>