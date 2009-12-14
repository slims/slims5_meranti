<?php
$swf = $_GET['swf'];
?>

<html>
<frameset rows="0%,100%">

  <frame src="empty.html">
  <frame src="js/zviewer/index.php?swf=<?php echo $swf; ?>">

</frameset>

</html>

<?php exit(); ?>
