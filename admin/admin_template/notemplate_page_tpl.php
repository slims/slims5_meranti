<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head><title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo SENAYAN_WEB_ROOT_DIR.'template/core.style.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo SENAYAN_WEB_ROOT_DIR.'admin/'.$sysconf['admin_template']['css']; ?>" />
<?php if (isset($css)) { echo $css; } ?>
<style type="text/css">
body { background: #FFFFFF; }
</style>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>prototype.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>updater.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>form.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>gui.js"></script>
<?php if (isset($js)) { echo $js; } ?>
</head>
<body>
<div id="pageContent">
<?php echo $content; ?>
</div>
</body>
</html>
