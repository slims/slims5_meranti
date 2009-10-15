<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
	terrafirma1.0 by nodethirtythree design
	http://www.nodethirtythree.com
	Modified for SLiMS template by Hendro Wicaksono (hendrowicaksono@yahoo.com)
-->
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title><?php echo $page_title; ?></title>
<link href="template/core.style.css" rel="stylesheet" type="text/css" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<!--<link rel="stylesheet" type="text/css" href="style.css" />-->
<link href="<?php echo $sysconf['template']['css']; ?>" rel="stylesheet" type="text/css" />
</head>
<body>

<div id="outer">

	<div id="upbg"></div>

	<div id="inner">

		<div id="header">
			<!-- <h1><span>terra</span>firma<sup>1.0</sup></h1> -->
			<h1><?php echo $sysconf['library_name']; ?></h1>
			<!-- <h2>by nodethirtythree & Hendro Wicaksono</h2> -->
			<h2><?php echo $sysconf['library_subname']; ?></h2>
		</div>
	
		<div id="splash"></div>
	
		<div id="menu">
			<ul>
          <li class="first"><a href="index.php"><?php echo __('Home'); ?></a></li>
          <li><a href="index.php?p=libinfo"><?php echo __('Library Information'); ?></a></li>
          <li><a href="index.php?p=help"><?php echo __('Help on Search'); ?></a></li>
          <li><a href="index.php?p=member"><?php echo __('Member Area'); ?></a></li>
          <li><a href="index.php?p=login"><?php echo __('Librarian LOGIN'); ?></a></li>

			<!--	<li class="first"><a href="#">Home</a></li>
				<li><a href="#">Archives</a></li>
				<li><a href="#">Links</a></li>
				<li><a href="#">Resources</a></li>
				<li><a href="#">Contact</a></li>
                        -->
			</ul>

		<div id="date">August 1, 2006</div>
		</div>
	

		<div id="primarycontent">
		
			<!-- primary content start -->


<!--		
			<div class="post">
				<div class="header">
					<h3>TerraFirma<sup>1.0</sup> by NodeThirtyThree</h3>
					<div class="date">August 1, 2006</div>
				</div>
				<div class="content">
					<img src="template/terrafirma/images/pic1.jpg" class="picA floatleft" alt="" />
					<p><strong>TerraFirma</strong><sup>1.0</sup> is a free, lightweight, tableless, W3C-compliant website design by <a href="http://www.nodethirtythree.com/">NodeThirtyThree Design</a>. You're free to dissect, manipulate and use it to your heart's content. We only ask that you link back to our site in some way. If you find this design useful, feel free to let us know :)</p>
					<p>This template has been ported for SLiMS (Senayan Library Management System) by <a href="mailto:hendrowicaksono@yahoo.com">Hendro Wicaksono</a>. Feel free to use and modify it, as long as you dont remove copyright statement.</p>
				</div>			

				<div class="footer">
					<ul>
						<li class="printerfriendly"><a href="#">Printer Friendly</a></li>
						<li class="comments"><a href="#">Comments (18)</a></li>
						<li class="readmore"><a href="#">Read more</a></li>
					</ul>
				</div>

			</div>
-->

<?php echo $header_info; ?>

<!-- simple search -->
    <form name="simpleSearch" id="simpleSearch" action="index.php" method="get">
    <strong>Quick Search :</strong> <input type="text" name="keywords" id="simpleKeywords" style="width: 65%;" />
    <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
    <script type="text/javascript">$('simpleKeywords').focus();</script>
    </form><br />
<!-- simple search end -->

<div id="infoBox"><?php echo $info; ?></div><br />

<!--
			<div class="post">
				<div class="header">
					<h3>Vivamus tortor sed aenean</h3>
					<div class="date">July 31, 2006</div>
				</div>
				<div class="content">
					<p>Volutpat at varius sed sollicitudin et, arcu. Vivamus viverra. Nullam turpis. Vestibulum sed etiam. Lorem ipsum sit amet dolore. Nulla facilisi. Sed tortor. Aenean felis. Quisque eros. Cras lobortis commodo metus. Vestibulum vel purus. In eget odio in sapien adipiscing blandit. Quisque augue tortor, facilisis sit amet, aliquam, suscipit vitae, cursus sed, arcu lorem ipsum dolor sit amet.</p>					<p>Fermentum at, varius pretium, elit. Mauris egestas scelerisque nunc. Mauris non ligula quis wisi laoreet malesuada. In commodo. Maecenas lobortis cursus dolor.</p>
				</div>			
				<div class="footer">
					<ul>
						<li class="printerfriendly"><a href="#">Printer Friendly</a></li>
						<li class="comments"><a href="#">Comments (18)</a></li>
						<li class="readmore"><a href="#">Read more</a></li>
					</ul>
				</div>
			</div>

			<div class="post">
				<div class="header">
					<h3>Vivamus tortor sed aenean</h3>
					<div class="date">July 31, 2006</div>
				</div>
				<div class="content">
					<p>Volutpat at varius sed sollicitudin et, arcu. Vivamus viverra. Nullam turpis. Vestibulum sed etiam. Lorem ipsum sit amet dolore. Nulla facilisi. Sed tortor. Aenean felis. Quisque eros. Cras lobortis commodo metus. Vestibulum vel purus. In eget odio in sapien adipiscing blandit. Quisque augue tortor, facilisis sit amet, aliquam, suscipit vitae, cursus sed, arcu lorem ipsum dolor sit amet.</p>					<p>Fermentum at, varius pretium, elit. Mauris egestas scelerisque nunc. Mauris non ligula quis wisi laoreet malesuada. In commodo. Maecenas lobortis cursus dolor.</p>
				</div>			
				<div class="footer">
					<ul>
						<li class="printerfriendly"><a href="#">Printer Friendly</a></li>
						<li class="comments"><a href="#">Comments (18)</a></li>
						<li class="readmore"><a href="#">Read more</a></li>
					</ul>
				</div>
			</div>
-->

<?php echo $main_content; ?>


			<!-- primary content end -->
	
		</div>
		
		<div id="secondarycontent">

			<!-- secondary content start -->
		
			<h3>About SDC</h3>
			<div class="content">
				<img src="template/terrafirma/images/pic2.jpg" class="picB" alt="" />
				<p><strong>Nullam turpis</strong> vestibulum et sed dolore. Nulla facilisi. Sed tortor. lobortis commodo. <a href="#">More ...</a></p>
			</div>
			
			<h3>Topics</h3>
			<div class="content">
				<ul class="linklist">
					<li class="first"><a href="#">Accumsan congue (32)</a></li>
					<li><a href="#">Dignissim nec augue (14)</a></li>
					<li><a href="#">Nunc ante elit nulla (83)</a></li>					<li><a href="#">Aliquam suscipit (74)</a></li>					<li><a href="#">Cursus sed arcu sed (14)</a></li>					<li><a href="#">Eu ante cras at risus (24)</a></li>					<li><a href="#">Donec mollis dolore (39)</a></li>					<li><a href="#">Aliquam suscipit (74)</a></li>				</ul>
			</div>

			<!-- secondary content end -->

		</div>
	
		<div id="footer">
		
			&copy; My Website. All rights reserved. Design by <a href="http://www.nodethirtythree.com/">NodeThirtyThree</a>. Modified for SLiMS by <a href="mailto:hendrowicaksono@yahoo.com">Hendro Wicaksono</a>.
		
		</div>

	</div>

</div>

</body>
</html>
