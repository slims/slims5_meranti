<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<!--
Taken from http://www.oswd.org/design/preview/id/3293
by http://www.sdworkz.com/
Ported to Senayan by Hendro Wicaksono (hendrowicaksono@yahoo.com)
-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $page_title; ?></title>
<!--<link href="css/style.css" rel="stylesheet" type="text/css" /> -->
<link href="template/core.style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $sysconf['template']['css']; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/form.js"></script>
<script type="text/javascript" src="js/gui.js"></script>
<?php echo $metadata; ?>
</head>
<body>
<div id="wrapper">
  <div id="content">
    <div id="header">
      <div id="logo">&nbsp;</div>
      <div id="links">
        <ul>
          <li><a href="index.php"><?php echo __('Home'); ?></a></li>
          <li><a href="index.php?p=libinfo"><?php echo __('Library Information'); ?></a></li>
          <li><a href="index.php?p=help"><?php echo __('Help on Search'); ?></a></li>
          <li><a href="index.php?p=member"><?php echo __('Member Area'); ?></a></li>
          <li><a href="index.php?p=login"><?php echo __('Librarian LOGIN'); ?></a></li>
        </ul>
      </div>
    </div>
    <div id="mainimg">
      <h3><?php echo $sysconf['library_name']; ?></h3>
      <h4><?php echo $sysconf['library_subname']; ?></h4>
    </div>
    <div id="contentarea">
      <div id="leftbar">

        <p><?php echo $header_info; ?></p>
        <br />


<!-- simple search -->
    <form name="simpleSearch" id="simpleSearch" action="index.php" method="get">
    <strong>Quick Search :</strong> <input type="text" name="keywords" id="simpleKeywords" style="width: 65%;" />
    <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
    <script type="text/javascript">$('simpleKeywords').focus();</script>
    </form><br />
<!-- simple search end -->


        <div id="infoBox"><?php echo $info; ?></div>

<?php echo $main_content; ?>
<br /><br /><br />
      </div>
      <div id="rightbar">
        <h2><?php echo __('Select Language'); ?></h2>
        <p><form name="langSelect" action="index.php" method="get">
        <select name="select_lang" style="width: 90%;" onchange="document.langSelect.submit();">
        <?php echo $language_select; ?>
        </select>
        </form></p>
        <h2><?php echo __('Advanced Search'); ?></h2>
        <form name="advSearchForm" id="advSearchForm" action="index.php" method="get">

        <span class="orangetext"><?php echo __('Title'); ?></span> :
        <input type="text" name="title" class="ajaxInputField" /><br />
        <span class="orangetext"><?php echo __('Author(s)'); ?></span> :
        <?php echo $advsearch_author; ?><br />
        <span class="orangetext"><?php echo __('Subject(s)'); ?></span> :
        <?php echo $advsearch_topic; ?><br />
        <span class="orangetext"><?php echo __('ISBN/ISSN'); ?></span> :
        <input type="text" name="isbn" class="ajaxInputField" /><br />
        <span class="orangetext"><?php echo __('GMD'); ?></span> :
        <select name="gmd" class="ajaxInputField" />
        <?php echo $gmd_list; ?>
        </select>
        <span class="orangetext"><?php echo __('Collection Type'); ?></span> :
        <select name="colltype" class="ajaxInputField" />
        <?php echo $colltype_list; ?>
        </select>
        <span class="orangetext"><?php echo __('Location'); ?></span> :
        <select name="location" class="ajaxInputField" />
        <?php echo $location_list; ?>
        </select>
        <br />
        <input type="submit" name="search" value="<?php echo __('Search'); ?>" class="button marginTop" />
        <!-- <input type="button" value="More Options" onclick="" class="button marginTop" /> -->
        </form>

        <h2>License</h2>
        <p>This Software is Released Under <a href="http://www.gnu.org/copyleft/gpl.html" title="GNU GPL License" target="_blank">GNU GPL License</a>
        Version 3.</p>
        <br />

        <h2>Award</h2>
        <p align="center">
        The Winner in the Category of OSS
        <img src="template/invention/images/logo-inaicta.png"
            alt="Indonesia ICT Award 2009" border="0" />
        </p>
        <br />

        <h2>Validated</h2>
        <p align="center">
        <a href="http://validator.w3.org/check?uri=referer"><img
            src="template/valid-xhtml10.png"
            alt="Valid XHTML 1.0 Transitional" border="0" /></a>
        <br />
        <img src="template/valid-css.png" alt="Valid CSS" />
        </p>


        <!--
        <p><span class="orangetext">12/08/2006</span><br />
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Utid anisl nec leo congue fringilla. <br />
          <br />
          <span class="orangetext">10/08/2006</span><br />
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Utid anisl nec leo congue fringilla. <br />
          <br />
          <span class="orangetext">28/07/2006</span><br />
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Utid anisl nec leo congue fringilla. </p>
        -->

      </div>
    </div>
    <div id="bottom">
      <div id="email"><a href="http://www.oswd.org/design/preview/id/3293">OSWD Template</a></div>
      <div id="validtext">
        <p>

      Ported to <a href="http://senayan.diknas.go.id">Senayan</a> by <a href="http://hendrowicaksono.net">Hendro Wicaksono</a></p>
      </div>
    </div>
  </div>
</div>
</body>
</html>
