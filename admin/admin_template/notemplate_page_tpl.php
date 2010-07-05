<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" />
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head><title><?php echo $page_title; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="Pragma" content="no-cache" /><meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, post-check=0, pre-check=0" /><meta http-equiv="Expires" content="Sat, 26 Jul 1997 05:00:00 GMT" />
<link rel="stylesheet" type="text/css" href="<?php echo SENAYAN_WEB_ROOT_DIR.'template/core.style.css'; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo SENAYAN_WEB_ROOT_DIR.'admin/'.$sysconf['admin_template']['css']; ?>" />
<?php if (isset($css)) { echo $css; } ?>
<style type="text/css">
body { background: #FFFFFF; }
</style>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>jquery.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>updater.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>form.js"></script>
<script type="text/javascript" src="<?php echo JS_WEB_ROOT_DIR; ?>gui.js"></script>
<?php if (isset($js)) { echo $js; } ?>
</head>
<body>
<div id="pageContent">
<?php echo $content; ?>
</div>
<?php if (isset($_GET['block'])) { ?>
<!-- block if we inside iframe -->
<script type="text/javascript">
// if we are inside iframe
var parentWin = self.parent;
if (parentWin && parentWin.jQuery('.editFormLink').length > 0) {
  var enabler = parentWin.jQuery('.editFormLink');
  jQuery(document.body).append('<div id="blocker" style="position: fixed; width: 100%; height: 100%; top: 0; left: 0; background: #ccc; opacity: 0.3">&nbsp;</div>');
  enabler.click(function(evt) { evt.preventDefault(); self.parent.jQuery('form').enableForm();
	self.jQuery('#blocker').remove();
	self.parent.jQuery('.makeHidden').removeClass('makeHidden'); });
}
</script>
<!-- block if we inside iframe -->
<?php } ?>
</body>
</html>
