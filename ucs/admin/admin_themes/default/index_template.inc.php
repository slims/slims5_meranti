<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head><title><?php echo $page_title; ?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="../webicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="../webicon.ico" type="image/x-icon" />
<link href="<?php echo ADMIN_WEB_ROOT_DIR.'admin_themes/default/style.css'; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>prototype.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>updater.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>gui.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>form.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>calendar.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>tiny_mce/tiny_mce.js"></script>
</head>
<body>
<!-- main menu -->
<div id="mainMenu"><?php echo $main_menu; ?></div>
<!-- main menu end -->

<!-- header-->
<div id="header"><div id="headerImage">&nbsp;</div><div id="libraryName"><?php echo $sysconf['server']['name']; ?><div id="librarySubName"><?php echo $sysconf['server']['subname']; ?></div></div></div>
<!-- header end-->

<table id="main" cellpadding="0" cellspacing="0">
<tr>
    <td id="sidepan" valign="top">
    <?php echo $sub_menu; ?>
    </td>

    <td valign="top"><a name="top"></a>
    <div class="loader"><?php echo $info; ?></div>
    <div id="mainContent">
    <?php echo $main_content; ?>
    </div>
    </td>
</tr>
</table>

<!-- license info -->
<div id="footer"><?php echo $sysconf['page_footer']; ?></div>
<!-- license info end -->

<!-- fake submit iframe for search form, DONT REMOVE THIS! -->
<iframe name="blindSubmit" style="visibility: hidden; width: 0; height: 0;"></iframe>
<!-- fake submit iframe -->
</body>
</html>
