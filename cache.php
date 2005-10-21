<?php
  $old_error_reporting = error_reporting(0);
  include_once('config.php');

  // set levels
  $file='';
  if(!(strpos($my_cache_level, 'G') === false)){
    $file .= implode('', $_GET);
  }
  if(!(strpos($my_cache_level, 'P') === false)){
    $file .= implode('', $_POST);
  }
  if(!(strpos($my_cache_level, 'C') === false)){
    $file .= implode('', $_COOKIE);
  }
  if(!(strpos($my_cache_level, 'S') === false)){
    session_start();
    $file .= implode('', $_SESSION);
  }
  $file .= $_GET['my_cache_file_path'];

  $file = md5($file);
  
  // if file exist
  // AND if it can get statistics of the file
  // AND if it is NOT tooooo old
  $stat = @stat('./cache/'.$file);
  if( $stat && mktime() <= ( $stat[9] + $my_cache_duration )){
      
      $fp = fopen('./cache/'.$file, 'r');
      echo fread($fp, 102400);
      
  }else{
    
    // set the path to support includes.
    $path = substr($_GET['my_cache_file_path'], 0, strripos($_GET['my_cache_file_path'], '/'));
    set_include_path($my_cache_web_root . $path . ';' . get_include_path());
    
    // restore error reporting to its default
    error_reporting($old_error_reporting);
    
    // buffering output to write in a file for future use.
    ob_start();
    include($my_cache_web_root.$_GET['my_cache_file_path']);
    $contents = ob_get_flush();
    header('Connection: Close');
    flush();
    
    // check if it is NOT text, ignore it.
    // this section is usefull for dynamic images or ...
    $header = apache_response_headers();
    if(isset($header['Content-type'])) $header['Content-Type']=$header['Content-type'];
    $header = $header['Content-Type'];
    
    // you can SET NO_NO_CACHE to disable caching system for a file.
    if(!defined('NO_NO_CACHE') || strpos($header, 'text')==0 ){  
      $fp = fopen('./cache/'.$file, 'w');
      fwrite($fp, $contents);
    }
  }
  
  function my_cache_del($mainfile){
  	$file=''
  	if(!(strpos($my_cache_level, 'G') === false)){
    	$file .= implode('', $_GET);
	  }
  	if(!(strpos($my_cache_level, 'P') === false)){
    	$file .= implode('', $_POST);
  	}
  	if(!(strpos($my_cache_level, 'C') === false)){
    	$file .= implode('', $_COOKIE);
  	}
  	if(!(strpos($my_cache_level, 'S') === false)){
    	session_start();
    	$file .= implode('', $_SESSION);
  	}
  	$file .= $mainfile;

  	$file = md5($file);
    unlink('./cache/'.$file);
  }
?>