<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head><title><?php echo $page_title; ?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="webicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="webicon.ico" type="image/x-icon" />
<link href="template/core.style.css" rel="stylesheet" type="text/css" />
<link href="template/igos/960.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sysconf['template']['css']; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/gui.js"></script>
<?php echo $metadata; ?>
</head>
<body>
<div class="container_12">
    <!--header-->
    <div class="grid_12" id="header">
    <h1 id="app-title"><a href="index.php"><?php echo $sysconf['library_name']; ?></a><div><?php echo $sysconf['library_subname']; ?></div></h1>
    </div>
    <div class="clear">&nbsp;</div>
    <!--header end-->

    <!--application main menu-->
    <div class="grid_12 tabs" id="main-menu">
        <ul id="primary-links">
            <li><a class="menu" href="index.php"><span><?php echo __('Home'); ?></a></span></li>
            <li><a class="menu" href="index.php?p=libinfo"><span><?php echo __('Library Information'); ?></span></a></li>
			<li><a class="menu" href="index.php?p=member"><span><?php echo __('Member Area'); ?></span></a></li>
            <li><a class="menu" href="index.php?p=peta"><span>Show map</span></a></li>
            <li><a class="menu" href="index.php?p=help"><span><?php echo __('Help on Search'); ?></span></a></li>
            <li><a class="menu" href="http://www.igos.web.id"><span>IGOS</span></a></li>
            <li><a class="menu" href="http://senayan.diknas.go.id"><span>SENAYAN</span></a></li>
            <li><a class="menu" href="index.php?p=login"><span><?php echo __('Librarian LOGIN'); ?></span></a></li>
        </ul>
    </div>
    <div class="clear">&nbsp;</div>
    <div class="spacer">&nbsp;</div>
    <!--application main menu end-->


    <!--application navigation menu/side menu-->
    <div class="grid_2" id="side-menu">
        <!-- language selection -->
            <div class="block-header"><?php echo __('Select Language'); ?></div>
            <form name="langSelect" action="index.php" method="get">
            <select name="select_lang" onchange="document.langSelect.submit();">
            <?php echo $language_select; ?>
            </select>
            </form>
        <!-- language selection end -->

        <!-- simple search -->
            <div class="block-header"><?php echo __('Simple Search'); ?></div>
            <form name="simpleSearch" action="index.php" method="get">
            <input type="text" name="keywords" />
            <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
            </form>
        <!-- simple search end -->

        <!-- advanced search -->
            <div class="block-header"><?php echo __('Advanced Search'); ?></div>
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
            <select name="gmd" />
            <?php echo $gmd_list; ?>
            </select>
            <?php echo __('Collection Type'); ?> :
            <select name="colltype" />
            <?php echo $colltype_list; ?>
            </select>
            <?php echo __('Location'); ?> :
            <select name="location" />
            <?php echo $location_list; ?>
            </select>

            <input type="submit" name="search" value="<?php echo __('Search'); ?>" />
            <!-- <input type="button" value="More Options" onclick="" class="button marginTop" /> -->
            </form>
        <!-- advanced search end -->

        <!-- license -->
            <div class="block-header">License</div>
            <p>
            This Software is Released Under <a href="http://www.gnu.org/copyleft/gpl.html" title="GNU GPL License" target="_blank">GNU GPL License</a>
            Version 3.
            </p>
        <!-- license end -->

        <!-- Awards -->
            <div class="block-header">Awards</div>
            <p>
            The Winner in the Category of OSS</br>
			<img src='template/igos/media/logo-inaicta.png' />
            </p>
        <!-- Awards end -->
    </div>
    <!--application navigation menu/side menu-->

    <!--application main content -->
    <div class="grid_9" id="main-content">
    <?php echo $header_info; ?>
    <div id="info-box"><?php echo $info; ?></div>
    <?php echo $main_content; ?>
    </div>
    <!--application main content end -->

    <!--footer-->
    <div class="grid_12" id="footer">
    <?php echo $sysconf['page_footer']; ?>
    </div>
    <!--footer end-->

    <div class="clear">&nbsp;</div>
    <div class="spacer">&nbsp;</div>
</div>
</body>
</html>
