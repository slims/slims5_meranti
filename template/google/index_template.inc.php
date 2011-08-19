<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--
        index_template.inc.php
        Copyright 2011 Indra Sutriadi Pipii <indra@sutriadi.web.id>
-->
<?php
/**
 *
 * from http://www.phpro.org/examples/Get-Text-Between-Tags.html
 * 
 * @get text between tags
 * @param string $tag The tag name
 * @param string $html The XML or XHTML string
 * @param int $strict Whether to use strict mode
 * @return array
 *
 */
function getTextBetweenTags($tag, $html, $strict=0)
{
    $dom = new domDocument;

    if($strict==1)
        $dom->loadXML($html);
    else
        $dom->loadHTML($html);

    $dom->preserveWhiteSpace = false;
    $content = $dom->getElementsByTagname($tag);
    $out = array();
    foreach ($content as $item)
        $out[] = $item->nodeValue;
    return $out;
}

	$segment = explode("/", $sysconf['template']['css']);
	unset($segment[count($segment)-1]);
	$path = implode("/", $segment);
	$css = $path . "/css";
	$js = $path . "/js";
	$img = $path . "/img";
	$search = FALSE;
	$page = FALSE;
	$detail = FALSE;
	if (isset($_GET['dest']) AND !empty($_GET['dest']))
		header("Location:" . $_GET['dest']);
	
	if (isset($_GET['search']) AND !empty($_GET['search'])) {
		if (isset($_GET['keywords']) AND !empty($_GET['keywords'])) {
			$page_title = $_GET['keywords'] . " - Senayan Search";
			$q = $_GET['keywords'];
			$search = TRUE;
		}
		else {
			if (isset($_GET['title']) AND !empty($_GET['title'])) {
				$page_title = "Title: " . $_GET['title'] . " - Senayan Search";
				$q = $_GET['title'];
			}
			foreach ($_GET as $key => $val) {
				if ($key != 'search' AND !empty($val)) {
					$search = TRUE;
					$_GET[$key] = htmlspecialchars($val);
				}
			}
		}
	}
	else if (isset($_GET['p'])) {
		$page = TRUE;
		if ($_GET['p'] == 'show_detail')
			$detail = TRUE;
	}
	
	if (isset($_GET['view']) AND strtolower($_GET['view']) == 'advanced') {
		$advanced = TRUE;
		$page_title = __('Advanced Search') . " - Senayan Search";
	}
	else {
		$advanced = FALSE;
	}

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
<head>
	<title><?php echo $page_title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo $path . "/google2.ico";?>" type="image/x-icon" />
	<link href="<?php echo $css . "/style.css"; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $css . "/jquery-ui.custom.css"; ?>" rel="stylesheet" type="text/css" />
	<link href="<?php echo $css . "/custom.css"; ?>" rel="stylesheet" type="text/css" />
	<?php echo $metadata; ?>
	<script type="text/javascript" src="<?php echo $js . "/jquery.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $js . "/jquery-ui.custom.min.js";?>"></script>
	<script type="text/javascript" src="<?php echo $js . "/default.js";?>"></script>

<?php
	if ($detail === TRUE):
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$auser = $sysconf['ajaxsec_user'];
		$apwd = $sysconf['ajaxsec_passwd'];
		$aturl = SENAYAN_WEB_ROOT_DIR.'lib/contents/attachment_list.php';
		$iturl = SENAYAN_WEB_ROOT_DIR.'lib/contents/item_list.php';
		$data = "id=$id&ajaxsec_user=$auser&ajaxsec_passwd=$apwd";
?>

	<script type="text/javascript">
		function loadjsfile(filename)
		{
			var fileref=document.createElement('script');
			fileref.setAttribute("type","text/javascript");
			fileref.setAttribute("src", filename);
			if (typeof fileref!="undefined")
				document.getElementsByTagName("head")[0].appendChild(fileref)
		}
		
		function init()
		{
			$.ajax({
				url: '<?php echo $aturl;?>',
				type: 'POST',
				data: '<?php echo $data;?>',
				success: function(data) {
					$('#attachListLoad').html(data);
					$( "a[href='#']" ).attr('href', '#refviewer');
				},
			});

			$.ajax({
				url: '<?php echo $iturl;?>',
				type: 'POST',
				data: '<?php echo $data;?>',
				success: function(data) {
					$('#itemListLoad').html(data);
					$( "a[href='#']" ).attr('href', '#refviewer');
				}
			});
			loadjsfile("<?php echo $js . "/custom.js";?>");
		}
	</script>
<?php
	else:
?>

	<script type="text/javascript">
		function init() {
		}
	</script>
	<script type="text/javascript" src="<?php echo $js . "/custom.js";?>"></script>

<?php
	endif;
?>

</head>
<body onload="init();">

	<?php
		if ($detail === TRUE):
	?>

		<div id="fileviewer">
			<iframe id="framehtml" src=""></iframe>
		</div>

	<?php
		endif;
	?>

	<div id="menu-bar" class="menu-bar">
		<a class="menu" href="index.php"><?php echo __('Home'); ?></a>
		<a class="menu" href="index.php?p=libinfo"><?php echo __('Library Information'); ?></a>
		<a class="menu" href="index.php?p=help"><?php echo __('Help on Search'); ?></a>
		<a class="menu" href="index.php?p=member"><?php echo __('Member Area'); ?></a>
		<a class="menu" href="index.php?p=login"><?php echo __('Librarian LOGIN'); ?></a>
<?php if(isset($_SESSION['m_name'])): ?>

			<div id="user-bar" class="user-bar">
				<span class="username"><?php echo($_SESSION['m_name']);?></span>
				|<a class="menu" href="index.php?p=member&logout=1"><?php echo __('LOGOUT');?></a>
			</div>
<?php endif;?>

	</div>
<?php
	if ($search === FALSE AND $page === FALSE AND $advanced === FALSE):
?>

	<div id="header-wrapper" class="header-wrapper">
		<div id="header">
			<img src="<?php echo $img . "/logo.png";?>" id="logo-img" />
			<h1 id="name"><?php echo $sysconf['library_name'];?></h1>
			<h3 id="subname"><?php echo $sysconf['library_subname'];?></h3>
		</div>
	</div>
	<div id="content-wrapper" class="content-wrapper">
		<div id="search-box" class="search-box">
			<form action="index.php" method="get">
				<p>
					<input type="text" id="keywords" name="keywords" class="text keyword front" />
				</p>
				<p>
					<input type="submit" name="search" class="text button" value="<?php echo __('Search'); ?>" />
					<input type="button" class="text button" onclick="show_advanced();" value="<?php echo __('Advanced Search');?>" />
				</p>
			</form>
        </div>
	</div>

<?php
	elseif ($advanced === TRUE || $search === TRUE || $page === TRUE):
?>

	<div id="header-wrapper" class="header-wrapper">
		<div id="header-bar" class="header-bar">
			<div id="title">
				<h3 id="name"><?php echo $sysconf['library_name'];?></h3>
			</div>
			<div id="image">
				<img src="<?php echo $img . "/small-logo.png";?>" id="logo-small-img" />
			</div>
		</div>
<?php
		if ($search === TRUE):
?>

		<div id="search-bar" class="search-bar">
			<form action="index.php" method="get">
				<p>
					<input type="text" id="keywords" name="keywords" class="text keyword back"
						value="<?php echo isset($q) ? $q : '';?>" />
					<input type="submit" name="search" class="button button-back" value="<?php echo __('Search'); ?>" />
				</p>
			</form>
		</div>
<?php
		else:
			$info = $advanced === TRUE ? __('Advanced Search') : $info;
			if(strpos($info, 'div')){
				$info = getTextBetweenTags('div', $info);
				$info = $info[0];
			}
			$title_bar = $info;
?>

		<div id="title-bar" class="title-bar">
			<div><?php echo $title_bar;?></div>
		</div>
<?php
		endif;
?>

<?php
		if ($advanced === TRUE):
?>

		<div id="advanced-box">
			<form name="advSearchForm" id="advSearchForm" action="index.php" method="get">
				<p>
					<label for="txt_title"><?php echo __('Title'); ?></label>
					<input type="text" class="text keyword" id="txt_title" name="title"
						value="<?php echo isset($q) ? $q : '';?>" />
				</p>
				<p>
					<label for="author"><?php echo __('Author(s)'); ?></label>
					<input type="text" class="text keyword" id="author" name="author"
						value="<?php echo isset($_GET['author']) ? $_GET['author'] : '';?>" />
				</p>
				<p>
					<label for="subject"><?php echo __('Subject(s)'); ?></label>
					<input type="text" class="text keyword" id="subject" name="subject"
						value="<?php echo isset($_GET['subject']) ? $_GET['subject'] : '';?>" />
				</p>
				<p>
					<label for="isbn"><?php echo __('ISBN/ISSN'); ?></label>
					<input type="text" class="text keyword" id="isbn" name="isbn"
						value="<?php echo isset($_GET['isbn']) ? $_GET['isbn'] : '';?>" />
				</p>
				<p>
					<label for="gmd"><?php echo __('GMD'); ?></label>
					<select id="gmd" name="gmd" /><?php echo $gmd_list; ?></select>
				</p>
				<p>
					<label for="colltype"><?php echo __('Collection Type'); ?></label>
					<select id="colltype" name="colltype" /><?php echo $colltype_list; ?></select>
				</p>
				<p>
					<label for="location"><?php echo __('Location'); ?></label>
					<select id="location" name="location" /><?php echo $location_list; ?></select>
				</p>
				<p align="right">
					<input type="hidden" name="advanced" value="Search" />
					<input type="submit" class="button" name="search" value="<?php echo __('Advanced Search'); ?>" />
				</p>
			</form>
		</div>

<?php
		endif;
?>

	</div>

<?php	if ($advanced === FALSE): ?>

	<div id="content-wrapper" class="content-wrapper">
		<div id="side-bar" class="side-bar">
			<div id="language" class="language">
				<h3><?php echo __('Select Language'); ?></h3>
				<form name="langSelect" action="index.php" method="get">
					<select name="select_lang" style="width: 99%;" onchange="change_lang(this);">
						<?php echo $language_select; ?>
					</select>
				</form>
			</div>

<?php
			if ($search === TRUE || $detail === TRUE):
?>

			<div id="advanced" class="advanced">
				<!-- advanced search -->
				<h3><?php echo __('Advanced Search'); ?></h3>
				<form name="advSearchForm" id="advSearchForm" action="index.php" method="get">
					<p>
						<label for="txt_title" class="block"><?php echo __('Title'); ?></label>
						<input type="text" class="text keyword" id="txt_title" name="title"
							value="<?php echo isset($q) ? $q : '';?>" />
					</p>
					<p>
						<label for="author" class="block"><?php echo __('Author(s)'); ?></label>
						<input type="text" class="text keyword" id="author" name="author"
							value="<?php echo isset($_GET['author']) ? $_GET['author'] : '';?>" />
					</p>
					<p>
						<label for="subject" class="block"><?php echo __('Subject(s)'); ?></label>
						<input type="text" class="text keyword" id="subject" name="subject"
							value="<?php echo isset($_GET['subject']) ? $_GET['subject'] : '';?>" />
					</p>
					<p>
						<label for="isbn" class="block"><?php echo __('ISBN/ISSN'); ?></label>
						<input type="text" class="text keyword" id="isbn" name="isbn"
							value="<?php echo isset($_GET['isbn']) ? $_GET['isbn'] : '';?>" />
					</p>
					<p>
						<label for="gmd" class="block"><?php echo __('GMD'); ?></label>
						<select id="gmd" name="gmd" /><?php echo $gmd_list; ?></select>
					</p>
					<p>
						<label for="colltype" class="block"><?php echo __('Collection Type'); ?></label>
						<select id="colltype" name="colltype" /><?php echo $colltype_list; ?></select>
					</p>
					<p>
						<label for="location" class="block"><?php echo __('Location'); ?></label>
						<select id="location" name="location" /><?php echo $location_list; ?></select>
					</p>
					<p>
						<input type="hidden" name="advanced" value="Search" />
						<input type="submit" class="button" name="search" value="<?php echo __('Search'); ?>" />
					</p>
				</form>
			</div>
<?php
			endif;
?>

		</div>
		<div id="content" class="content">
			<?php if($page === FALSE AND isset($info) AND !empty($info)):?><div id="content-info"><?php echo $info;?></div><?php endif;?>
			<?php $content = trim($main_content); echo (empty($content) || $content == '<br />')  ? '<h3>Kosong</h3>' : $content;?>
		</div>
	</div>
<?php	endif;?>

<?php
	endif;
?>

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
	</div>

</body>
</html>
