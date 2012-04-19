<?php
/**
 * Slims Installer files
 *
 * Copyright � 2006 - 2012 Advanced Power of PHP
 * Some modifications & patches by Eddy Subratha (eddy.subratha@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

    require "settings.php";    
    
	$completed = false;
	$error_mg  = array();	
	
	if ($_POST['submit'] == "step2") {
		$database_host		= isset($_POST['database_host'])?$_POST['database_host']:"";
		$database_name		= isset($_POST['database_name'])?$_POST['database_name']:"";
		$database_username	= isset($_POST['database_username'])?$_POST['database_username']:"";
		$database_password	= isset($_POST['database_password'])?$_POST['database_password']:"";
		$database_sample	= isset($_POST['install_sample'])?$_POST['install_sample']:"";
		
		if (empty($database_host)){
			$error_mg[] = "<li>Database host can not be empty </li>";	
		}
		
		if (empty($database_name)){
			$error_mg[] = "<li>Database name can not be empty</li>";	
		}
		
		if (empty($database_username)){
			$error_mg[] = "<li>Database username can not be empty</li>";	
		}
		
		if (empty($database_password)){
			$error_mg[] = "<li>Database password can not be empty</li>";	
		}
		
		if(empty($error_mg)){
		
			$config_file = file_get_contents($config_file_default);
			$config_file = str_replace("_DB_HOST_", $database_host, $config_file);
			$config_file = str_replace("_DB_NAME_", $database_name, $config_file);
			$config_file = str_replace("_DB_USER_", $database_username, $config_file);
			$config_file = str_replace("_DB_PASSWORD_", $database_password, $config_file);
			
			$f = @fopen($config_file_path, "w+");
			if (@fwrite($f, $config_file) > 0){
			$link = @mysql_connect($database_host, $database_username, $database_password);
				if($link){					
					if (@mysql_select_db($database_name)) {                        
					    if(false == ($db_error = apphp_db_install($database_name, $sql_dump))){
						$error_mg[] = "<li>Could not read file ".$sql_dump."! Please check if the file exists</li>";                            
						@unlink($config_file_path);
					    }else{
						if($_POST['install_sample'] == 'yes')
						{
						    if(false == ($db_error = apphp_db_install($database_name, $sql_sample))){
							$error_mg[] = "<li>Could not read file ".$sql_sample."! Please check if the file exists</li>";                            
						    }else{
							$completed = true;                            
						    }						    
						} else {
						    $completed = true;                            						    
						}
					    }
					} else {
						$error_mg[] = "<li>Database connecting error! Check your database exists.</li>";
			                        @unlink($config_file_path);
					}
				} else {
					$error_mg[] = "<li>Database connecting error! Check your connection parameters</li>";
		                        @unlink($config_file_path);
				}
			} else {				
				$error_mg[] = "<li>Can not open configuration file ".$config_file_directory.$config_file_name."</li>";				
			}
			@fclose($f);			
		}
	}
        
?>	

<!DOCTYPE HTML>
<html>
<head>
	<title>Start | Slims's Easy Installer Guide</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="wrapper">
	    <?php if(!$completed) { ?>
	    <div class="title">
		<h2>Step 2 - Installation Not Completed</h2>	    
	    </div>
	    <p class="error">Please correct your information according to this message</p>
	    <div class="content">	    
	    <?php
	    foreach($error_mg as $msg){
		    echo "<ul class=\"list\">".$msg."</ul>";
	    }
	    ?>
	    <div class="toright">
		<input type="button" class="button" value="Back" name="submit" onclick="javascript: history.go(-1);">
		<input type="button" class="button" value="Retry" name="submit" onclick="javascript: location.reload();">
	    </div>
	    <br/>
	    </div>		    
	    <?php } else { ?>
	    <div class="title">
		<h2>Step 2 - Installation Completed</h2>	    
	    </div>
	    <p class="success">Hooray, the installation was successful</p>
	    <div class="content">
		<p>The <?=$config_file_name;?> file was sucessfully created.</p>
		<p>For security reasons, please remove install/ folder from your server.</p>
		<br/>
		<div class="toright">
		    <? if($application_start_file != ""){ ?><a href="<?=$application_start_file;?>" class="button">OK, start the SLiMS</a><? } ?>
		</div>
		<br/>
	    <? } ?>
	    <?php include_once("footer.php"); ?>
	</div>

    </div>    
                  
</body>
</html>







<? 


  function apphp_db_install($database, $sql_file) {
    $db_error = false;

    if (!@apphp_db_select_db($database)) {
      if (@apphp_db_query('create database ' . $database)) {
        apphp_db_select_db($database);
      } else {
        $db_error = mysql_error();
        return false;		
      }
    }

    if (!$db_error) {
      if (file_exists($sql_file)) {
        $fd = fopen($sql_file, 'rb');
        $restore_query = fread($fd, filesize($sql_file));
         fclose($fd);
      } else {
          $db_error = 'SQL file does not exist: ' . $sql_file;
          return false;
      }
		
      $sql_array = array();
      $sql_length = strlen($restore_query);
      $pos = strpos($restore_query, ';');
      for ($i=$pos; $i<$sql_length; $i++) {
        if ($restore_query[0] == '#') {
          $restore_query = ltrim(substr($restore_query, strpos($restore_query, "\n")));
          $sql_length = strlen($restore_query);
          $i = strpos($restore_query, ';')-1;
          continue;
        }
        if ($restore_query[($i+1)] == "\n") {
          for ($j=($i+2); $j<$sql_length; $j++) {
            if (trim($restore_query[$j]) != '') {
              $next = substr($restore_query, $j, 6);
              if ($next[0] == '#') {
                // find out where the break position is so we can remove this line (#comment line)
                for ($k=$j; $k<$sql_length; $k++) {
                  if ($restore_query[$k] == "\n") break;
                }
                $query = substr($restore_query, 0, $i+1);
                $restore_query = substr($restore_query, $k);
                // join the query before the comment appeared, with the rest of the dump
                $restore_query = $query . $restore_query;
                $sql_length = strlen($restore_query);
                $i = strpos($restore_query, ';')-1;
                continue 2;
              }
              break;
            }
          }
          if ($next == '') { // get the last insert query
            $next = 'insert';
          }
          if ( (eregi('create', $next)) || (eregi('insert', $next)) || (eregi('drop t', $next)) ) {
            $next = '';
            $sql_array[] = substr($restore_query, 0, $i);
            $restore_query = ltrim(substr($restore_query, $i+1));
            $sql_length = strlen($restore_query);
            $i = strpos($restore_query, ';')-1;
          }
        }
      }

      for ($i=0; $i<sizeof($sql_array); $i++) {
	    apphp_db_query($sql_array[$i]);
      }
      return true;
    } else {
      return false;
    }
  }

  function apphp_db_select_db($database) {
    return mysql_select_db($database);
  }

  function apphp_db_query($query) {
    global $link;
    $res=mysql_query($query, $link);
    return $res;
  }

?>