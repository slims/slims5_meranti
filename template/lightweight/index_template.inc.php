<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr"><head><title><?php echo $page_title; ?></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="webicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="webicon.ico" type="image/x-icon" />
<link href="<?php echo $sysconf['template']['css']; ?>" rel="stylesheet" type="text/css" />
<?php echo $metadata; ?>
</head>
<body>

<table id="main" cellpadding="0" cellspacing="0" width="100%">
<!-- main menu -->
<tr>
<td id="barTop"><strong id="librarySubName"><?php echo $sysconf['library_subname']; ?></strong></td>
</tr>
<!-- main menu end -->

<!-- header -->
<tr>
<td id="mainHeader"><h3 id="libraryName"><?php echo $sysconf['library_name']; ?></h3>
<a class="menu" href="index.php"><?php echo __('Home'); ?></a>&nbsp;&nbsp;
<a class="menu" href="index.php?p=libinfo"><?php echo __('Library Information'); ?></a>&nbsp;&nbsp;
<a class="menu" href="index.php?p=help"><?php echo __('Help on Search'); ?></a>&nbsp;&nbsp;
<a class="menu" href="m/index.php?fullsite=1">Full Site</a>
</td>
</tr>
<!-- header end -->

<!--body-->
<tr>
<!-- main content -->
<td id="mainContent" valign="top">
<?php echo $header_info; ?>
<div id="infoBox">
<table width="100%">
    <tr>
        <td width="60%">
            <form name="simpleSearch" action="index.php" method="get">
            <input type="text" name="keywords" style="width: 70%;" />
            <input type="submit" name="search" value="<?php echo __('Search'); ?>" />
            </form>
        </td>
        <td width="40%" align="right">
            <form name="langSelect" action="index.php" method="get">
            <select name="select_lang"><?php echo $language_select; ?></select>
            <input type="submit" name="changeLang" value="Change Language" />
            </form>
        </td>
    </tr>
</table>
<?php echo $info; ?>
</div>
<?php echo $main_content; ?>
<br />
</td>
<!-- main content end -->
</tr>
<!--body end-->

</table>

</body>
</html>
