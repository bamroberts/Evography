<!DOCTYPE html> 
<html> 
<head> 
	<title><?php echo $site->name; ?><?php echo (isset($title))?"- $title":""; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1"> 
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
	<style>
	   section { 
	         width:100%;
	         height:100%;
	         position:relative;
	         background-color: black;
	   }
	   
	   
	</style>
</head> 
<body> 

<?php echo $content; ?>	
  
</body>
</html>