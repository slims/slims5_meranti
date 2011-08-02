<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
        login_template.inc.php
        
        Copyright 2011 Indra Sutriadi Pipii <indra@sutriadi.web.id>
        
-->
<?php
	$segment = explode("/", $sysconf['template']['css']);
	unset($segment[count($segment)-1]);
	$path = implode("/", $segment);
	$css = $path . "/css";
	$js = $path . "/js";
	$img = $path . "/img";
	if ($_GET['p'] == 'visitor')
	{
		include("$path/index_template.inc.php");
		exit();
	}
	preg_match_all("/(<([\w]+)[^>]*>)(.*?)(<\/\\2>)/", $main_content, $matches, PREG_SET_ORDER);
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
	<title><?php echo $page_title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo $path . "/google2.ico";?>" type="image/x-icon" />
	<link href="<?php echo $css . "/style.css"; ?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript">
		<?php if(count($matches) != 0 AND $matches[0][2] == 'script') print(htmlentities($matches[0][3]));?>
	</script>
	<?php echo $metadata; ?>
</head>
<body onload="document.forms[0].userName.focus();">
	<div id="menu-bar" class="menu-bar">
		<a class="menu" href="index.php"><?php echo __('Home'); ?></a>
		<a class="menu" href="index.php?p=libinfo"><?php echo __('Library Information'); ?></a>
		<a class="menu" href="index.php?p=help"><?php echo __('Help on Search'); ?></a>
		<a class="menu" href="index.php?p=member"><?php echo __('Member Area'); ?></a>
		<a class="menu" href="index.php?p=login"><?php echo __('Librarian LOGIN'); ?></a>
	</div>
	<div id="header-wrapper" class="header-wrapper">
		<div id="login-box">
			<form action="index.php?p=login" method="post">
				<p>
					<span id="info"><?php echo __('Sign in to your account at');?></span>
					<h3 id="name"><?php echo $sysconf['library_name'];?></h3>
					<h5 id="subname"><?php echo $sysconf['library_subname'];?></h5>
				</p>
				<p>
					<label for="userName"><?php echo __('Username');?></label>
					<input type="text" id="userName" name="userName" class="login" class="text" />
				</p>
				<p>
					<label for="passWord"><?php echo __('Password');?></label>
					<input type="password" id="passWord" name="passWord" class="login" class="text" />
				</p>
				<p>
					<label>&nbsp;</label>
					<input type="submit" name="logMeIn" value="Logon" id="loginButton" class="text button" />
				</p>
			</form>
		</div>
	</div>
	<div id="footer-wrapper" class="footer-wrapper">
		<div id="badges" class="badges">
			<p>
				The Winner in the Category of OSS
				<img src="template/default/media/logo-inaicta.png"
					alt="Indonesia ICT Award 2009" border="0" />
			</p>
		</div>
		<div id="copyright" class="copyright">
			<p>
				Powered by <a href="http://slims.web.id/" target="_blank">SLiMS</a> | Design by <a href="http://sutriadi.web.id/" target="_blank">Indra Sutriadi Pipii</a>
			</p>
		</div>
	</div></body>
</html>
