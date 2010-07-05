<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
	blue1.0 by Eddie Subratha
	http://senayan.diknas.go.id
	Do not remove this comment for appreciation reason.
        If you modify this template for your own need, just add
        "This template has been modified by your_name_here"
-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="senayan : an open source for library automation" />
<meta name="keywords" content="senayan, library, automation, open source, book, collection" />
<meta name="author" content="eddy subratha" />
<meta name="copyright" content="senayan" />
<link rel="icon" href="webicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="webicon.ico" type="image/x-icon" />
<title><?php echo $page_title; ?></title>
<link href="template/core.style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sysconf['template']['css']; ?>" rel="stylesheet" type="text/css" />
<!--[if gte IE 7]>
<link rel="stylesheet" media="screen" type="text/css" href="ie7.css" />
<![endif]-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/gui.js"></script>
<?php echo $metadata; ?>
</head>
<body>
    <div id="wrappper">
    <div id="container">
        <div id="header">
            <img src="template/blue/images/logo.png" border="0" alt="" />
            <div class="title green"><?php echo $sysconf['library_name']; ?><div class="title2"><?php echo $sysconf['library_subname']; ?></div></div>
            <ul id="nav">
                 <li><a class="menu" href="index.php"><?php echo __('Home'); ?></a></li>
                 <li><a class="menu" href="index.php?p=libinfo"><?php echo __('Library Information'); ?></a></li>
                 <li><a class="menu" href="index.php?p=help"><?php echo __('Help on Search'); ?></a></li>
                 <li><a class="menu" href="index.php?p=member"><?php echo __('Member Area'); ?></a></li>
                 <li><a class="menu" href="index.php?p=login"><?php echo __('Librarian LOGIN'); ?></a></li>
            </ul>
        </div>
        <div id="picture"><span>Library Picture</span></div>
        <div id="left">
        <?php echo $header_info; ?>
        <h1 class="title_bar"><?php echo $info; ?></h1>
        <?php echo $main_content; ?>
        </div>

        <div id="right">
        <!-- language selection -->
        <h1 class="title_bar"><?php echo __('Select Language'); ?></h1>
        <form name="langSelect" action="index.php" method="get">
        <select name="select_lang" style="width: 99%;" onchange="document.langSelect.submit();">
        <?php echo $language_select; ?>
        </select>
        </form>
        <br />
        <br />
        <!-- language selection end -->
        <h1 class="title_bar"><?php echo __('Simple Search'); ?></h1>
        <form name="simpleSearch" action="index.php" method="get">
        <input type="text" name="keywords" class="search" /><br /><br />
        <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="submit" />
        </form>
        <br />
        <br />
        <h1 class="title_bar"><?php echo __('Advanced Search'); ?></h1>
        <form name="advSearch" action="index.php" method="get">
        <?php echo __('Title'); ?> :<br />
        <input type="text" name="title" class="search" /><br /><br />
        <?php echo __('Author(s)'); ?> :<br />
        <?php echo $advsearch_author; ?><br /><br />
        <?php echo __('Subject(s)'); ?> :<br />
        <?php echo $advsearch_topic; ?><br /><br />
        <?php echo __('ISBN/ISSN'); ?> :<br />
        <input type="text" name="isbn" class="search" /><br />
        <?php echo __('GMD'); ?> :<br />
        <select name="gmd" style="width: 99%;" class="marginTop" />
        <?php echo $gmd_list; ?>
        </select><br /><br />
        <?php echo __('Collection Type'); ?> :<br />
        <select name="colltype" style="width: 99%;" class="marginTop" />
        <?php echo $colltype_list; ?>
        </select><br /><br />
        <?php echo __('Location'); ?> :<br />
        <select name="location" style="width: 99%;" class="marginTop" />
        <?php echo $location_list; ?>
        </select><br />
        <br />
        <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="submit" />
        <!-- <input type="button" value="More Options" onclick="" class="button marginTop" /> -->
        </form>
        <br />

        <h1 class="title_bar">Award</h1>
        <p align="center">
        The Winner in the Category of OSS
        <img src="template/blue/images/logo-inaicta.png"
            alt="Indonesia ICT Award 2009" border="0" />
        <br />
        </p>
        </div>

        <div class="fixedclear"></div>

        <div id="footer">
        <p>
        This Software is Released Under <a href="http://www.gnu.org/copyleft/gpl.html" title="GNU GPL License" target="_blank" class="link">GNU GPL License</a> Version 3<br />Valid <a href="http://validator.w3.org/check?uri=referer" class="link" target="_blank">XHTML</a> | <a href="#" class="link">CSS</a> | Design By <a href="http://eddy.ptpci.co.id" target="_blank" class="link">Eddy Subratha</a>, Ported By <a href="http://dicarve.blogspot.com" target="_blank" class="link">Arie Nugraha</a>
        </p>
        </div>
    </div>
    </div>
</body>
</html>
