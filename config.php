<?php
  /////////////////// TODOs /////////////////////////////////////
  // dynamic image error. it cannot recognize cache HEADER
  ///////////////////////////////////////////////////////////////
  
  define('CACHE_LOADED', 1);
  
  // root of your web (where "cache" directory and .htaccess installed.)
  $my_cache_web_root = '/home/test/';
  
  // duration of availablity in "seconds"
  $my_cache_duration = 10;
  
  // cache level
  // use 'G' to cache based on URL + GET parameters.
  // use 'P' to cache based on URL + POST parameters.
  // use 'C' to cache based on URL + COOKIE parameters.
  // use 'S' to cache based on URL + SESSION parameters.
  // you can use combination of them too, eg. 'GSPC' or 'GPS' :)
  $my_cache_level = '';
?>