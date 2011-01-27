<?php
// be sure that this file not accessed directly
if (!defined('INDEX_AUTH')) {
    die("can not access this file directly");
} elseif (INDEX_AUTH != 1) { 
    die("can not access this file directly");
}

include LIB_DIR.'content_custom.inc.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
	default1.0 by Arie Nugraha & Senayan Developers Team
	http://senayan.diknas.go.id
	Do not remove this comment for appreciation reason.
        If you modify this template for your own need, just add
        "This template has been modified by your_name_here"
-->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head><title><?php echo $page_title; ?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="webicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="webicon.ico" type="image/x-icon" />
<link href="template/core.style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sysconf['template']['css']; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/gui.js"></script>
<!-- css for glider -->
<link rel="stylesheet" href="<?php echo SENAYAN_WEB_ROOT_DIR.$sysconf['template']['dir']; ?>/default_v2/stylesheets/glider.css" type="text/css" media="screen" charset="utf-8">
<!-- javascript for glider -->
<script src="<?php echo SENAYAN_WEB_ROOT_DIR.$sysconf['template']['dir']; ?>/default_v2/javascripts/prototype.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SENAYAN_WEB_ROOT_DIR.$sysconf['template']['dir']; ?>/default_v2/javascripts/effects.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo SENAYAN_WEB_ROOT_DIR.$sysconf['template']['dir']; ?>/default_v2/javascripts/glider.js" type="text/javascript" charset="utf-8"></script>

<?php echo $metadata; ?>
</head>
<body>

<table id="main" cellpadding="0" cellspacing="0">
<!-- main menu -->
<tr>
<td id="mainMenu" colspan="2">
<ul id="menuList">
        <li><a class="menu" href="index.php"><?php echo __('Home'); ?></a></li>
        <li><a class="menu" href="index.php?p=libinfo"><?php echo __('Library Information'); ?></a></li>
        <li><a class="menu" href="index.php?p=help"><?php echo __('Help on Search'); ?></a></li>
        <li><a class="menu" href="index.php?p=member"><?php echo __('Member Area'); ?></a></li>
        <li><a class="menu" href="index.php?p=login"><?php echo __('Librarian LOGIN'); ?></a></li>
</ul>
</td>
</tr>
<!-- main menu end -->

<!-- header -->
<tr>
        <td id="mainHeader" colspan="2"><div id="headerImage">&nbsp;</div>
            <div id="libraryName"><?php echo $sysconf['library_name']; ?>
                <div id="librarySubName"><?php echo $sysconf['library_subname']; ?></div>
            </div>
        </td>
</tr>
<!-- header end -->

<!--body-->
<tr>
<!-- sidepan -->
<td id="sidepan" valign="top">
    <!-- language selection -->
        <div class="heading"><?php echo __('Select Language'); ?></div>
        <form name="langSelect" action="index.php" method="get">
        <select name="select_lang" style="width: 99%;" onchange="document.langSelect.submit();">
        <?php echo $language_select; ?>
        </select>
        </form>
    <!-- language selection end -->

    <!-- simple search -->
        <div class="heading"><?php echo __('Simple Search'); ?></div>
        <form name="simpleSearch" action="index.php" method="get">
        <input type="text" name="keywords" style="width: 99%;" /><br />
        <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
        </form>
    <!-- simple search end -->

    <!-- advanced search -->
        <div class="heading"><?php echo __('Advanced Search'); ?></div>
        <form name="advSearchForm" id="advSearchForm" action="index.php" method="get">
        <?php echo __('Title'); ?> :
        <input type="text" name="title" class="ajaxInputField" /><br />
        <?php echo __('Author(s)'); ?> :
        <?php echo $advsearch_author; ?><br />
        <?php echo __('Subject(s)'); ?> :
        <?php echo $advsearch_topic; ?><br />
        <?php echo __('ISBN/ISSN'); ?> :
        <input type="text" name="isbn" class="ajaxInputField" /><br />
        <?php echo __('GMD'); ?> :
        <select name="gmd" class="ajaxInputField" />
        <?php echo $gmd_list; ?>
        </select>
        <?php echo __('Collection Type'); ?> :
        <select name="colltype" class="ajaxInputField" />
        <?php echo $colltype_list; ?>
        </select>
        <?php echo __('Location'); ?> :
        <select name="location" class="ajaxInputField" />
        <?php echo $location_list; ?>
        </select>
        <br />
        <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
        <!-- <input type="button" value="More Options" onclick="" class="button marginTop" /> -->
        </form>
    <!-- advanced search end -->

    <!-- license -->
        <div class="heading">License</div>
        <p>
        This Software is Released Under <a href="http://www.gnu.org/copyleft/gpl.html" title="GNU GPL License" target="_blank">GNU GPL License</a>
        Version 3.
        </p>
    <!-- license end -->

    <!-- award -->
        <div class="heading">Award</div>
        <p align="center">
        The Winner in the Category of OSS
        <img src="template/default/media/logo-inaicta.png"
            alt="Indonesia ICT Award 2009" border="0" />
        <br />
        </p>
    <!-- award -->

    <!-- w3c validate -->
        <div class="heading">Validated</div>
        <p align="center">
        <a href="http://validator.w3.org/check?uri=referer"><img
            src="template/valid-xhtml10.png"
            alt="Valid XHTML 1.0 Transitional" border="0" /></a>
        <br />
        <img src="template/valid-css.png" alt="Valid CSS" />
        </p>
    <!-- w3c validate end -->

</td>
<!-- main menu end -->
<!-- main content -->
<td id="mainContent" valign="top">
<?php echo $header_info; ?>
<div id="infoBox"><?php echo $info; ?></div>

<!-- glider effect starts here -->
        <?php 
        $content_view = new content_custom();
        if ($content_view->is_page('frontpage')) {
        ?>

                <div id="my-glider-horizontal">
            		<div class="controls">
        			<a href="#section1">Apa itu SLiMS</a> | 
		        	<a href="#section2">Lisensi</a> |
        			<a href="#section3">Open Source</a> |
        			<a href="#section4">Modul Tersedia</a> 
        		</div>
		
        		<div class="scroller">
		        	<div class="content">
				        <div class="section" id="section1">
                        <?php
                        $content_about_slims = new content_custom();
                        $content_about_slims->do_content_custom('about_slims');
                        echo $content_about_slims->get_between('<!--intro_awal-->', '<!--intro_akhir-->');
                        echo ' | ';
        				?>
                        <a href="<?php echo $content_about_slims->get_url(); ?>"> Detail</a>.
                        </div>
		        		<div class="section" id="section2">
                        <?php
                        $content_lisensi_slims = new content_custom();
                        $content_lisensi_slims->do_content_custom('lisensi_slims');
                        echo $content_lisensi_slims->get_between('<!--intro_awal-->', '<!--intro_akhir-->');
                        echo ' | ';
        				?>
                        <a href="<?php echo $content_lisensi_slims->get_url(); ?>">Detail</a>.
		        		</div>
        				<div class="section" id="section3">
                        <?php
                        $content_opensource = new content_custom();
                        $content_opensource->do_content_custom('opensource');
                        echo $content_opensource->get_between('<!--intro_awal-->', '<!--intro_akhir-->');
                        echo ' | ';
        				?>
                        <a href="<?php echo $content_opensource->get_url(); ?>">Detail</a>.
		        		</div>
        				<div class="section" id="section4">
                        <?php
                        $content_modul_tersedia = new content_custom();
                        $content_modul_tersedia->do_content_custom('modul_tersedia');
                        echo $content_modul_tersedia->get_between('<!--intro_awal-->', '<!--intro_akhir-->');
                        echo ' | ';
        				?>
                        <a href="<?php echo $content_modul_tersedia->get_url(); ?>">Detail</a>.
		        		</div>
        			</div>
		        </div>	
	        <script type="text/javascript" charset="utf-8">
		        var my_glider = new Glider('my-glider-horizontal', {controlsEvent: 'mouseover',duration:0.5, autoGlide: true});
        	</script>

        <?php 
        }
        ?>
<!-- glider effect starts here -->

<?php echo $main_content; ?>
<br />
</td>
<!-- main content end -->
</tr>
<!--body end-->

</table>

</body>
</html>
