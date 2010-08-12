<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head><title><?php echo $page_title; ?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="webicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="webicon.ico" type="image/x-icon" />
<link href="<?php echo THEMES_WEB_ROOT_DIR; ?>default/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo THEMES_WEB_ROOT_DIR; ?>default/960.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>form.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>gui.js"></script>
<?php echo $metadata; ?>
</head>
<body>
<div class="container_12">
    <!--header-->
    <div class="grid_12" id="header">
    <h1 id="app-title"><a href="index.php"><?php echo $sysconf['server']['name']; ?></a><div><?php echo $sysconf['server']['subname']; ?></div></h1>
    </div>
    <div class="clear">&nbsp;</div>
    <!--header end-->

    <!--application main menu-->
    <div class="grid_12 tabs" id="main-menu">
        <ul id="primary-links">
            <li><a class="menu" href="index.php"><span><?php echo __('Home'); ?></a></span></li>
            <li><a class="menu" href="index.php?p=libinfo"><span><?php echo __('Union Catalog Information'); ?></span></a></li>
            <li><a class="menu" href="index.php?p=help"><span><?php echo __('Help'); ?></span></a></li>
            <li><a class="menu" href="http://senayan.diknas.go.id"><span>SLiMS</span></a></li>
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
            <?php echo __('Location'); ?> :
            <select name="node" />
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
    </div>
    <!--application navigation menu/side menu-->

    <!--application main content -->
    <div class="grid_9" id="main-content">
    <?php echo $header_info; ?>
    <div id="info-box"><?php echo $info; ?></div>
    <!-- simple search -->
    <div class="spacer">&nbsp;</div>
    <fieldset id="simple-search">
        <div class="block-header"><?php echo __('Quick Search'); ?></div>
        <form name="simpleSearch" action="index.php" method="get">
        <input type="text" name="keywords" style="width: 80%;" /> <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button" />
        </form>
    </fieldset>
    <div class="spacer">&nbsp;</div>
    <!-- simple search end -->
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
