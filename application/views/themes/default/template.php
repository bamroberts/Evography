<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="en-us" />
    <title><?php echo $title;?></title>
    <meta name="keywords" content="<?php echo $meta_keywords;?>" />
    <meta name="description" content="<?php echo $meta_description;?>" />
    <meta name="copyright" content="<?php echo $meta_copywrite;?>" />
    <?php foreach($styles as $file => $type) { echo HTML::style($file, array('media' => $type)), "\n"; }?>
    <?php foreach($scripts as $file) { echo HTML::script($file, NULL, TRUE), "\n"; }?>
    <!--[if IE]>
       <?php echo HTML::style('assets/css/ie.css', NULL)?>
    <![endif]-->
    <style>
    	#content {
			background-color:black;
			color:white;
			margin:0 auto;
			width:900px;
			}
    </style>
  </head>
  <body id="<?php echo str_replace(' ','_',$page); ?>" class="<?php echo $page; ?>">	
    <div id="content">
    <h1 style="margin: 0pt 0pt 0pt 18px; font-size: 36pt; line-height: 17pt; padding-top: 24px;">
      EVOGRAPHY
      <span style="font-size: 22pt; color: rgb(65, 65, 65); margin-left: -22px; line-height: 14pt;">
        .com 
        <span style="display: block; font-size: 20pt; line-height: 25pt;">
          event focused galleries
        </span>
      </span>
    </h1>
     <?php echo $content;?>
    </div>
  </body>
</html>