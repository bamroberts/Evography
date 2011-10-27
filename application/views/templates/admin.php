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
    
    <script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAA-2tTbIRKJojggSRM--n-hxSvpd12rs751Bi4QsVjQ2FFNzfAXhQ0TlJ9sZ-4vT9cZebJUS67Zc18rw"></script>
<script>
google.load("jquery", "1.6.4");
google.load("jqueryui", "1.8.16");
</script>
  </head>
<body id="<?php echo str_replace('/','_',trim(Request::current()->url(),'/')); ?>" class="<?php echo str_replace('/',' ',trim(Request::current()->url(),'/')); ?>">
     <div class="grids" id="head">  
         <h1 id="logo" class="grid-12">
            Evography
            <a href="<?php echo URL::site('/admin/')?>">Admin Area</a>
         </h1>
         <h5 class="grid-4">
           <?php if ($user=Auth::instance()->get_user()) : ?>
            You are 
            <a href="<?php echo Helpers::URL(array('controller'=>'user','action'=>'details'));?>">
              <?php echo $user->username; ?>
            </a>  
            / 
            <a href="<?php echo Helpers::URL(array('controller'=>'user','action'=>'logout'));?>">
              Logout  
            </a>
           <?php else : ?>
            <a href="<?php echo Helpers::URL(array('controller'=>'user','action'=>'login'));?>">
              Login  
            </a>
           <?php endif; ?> 
         </h5>
         
     </div>
     <ul class="nav">
          <li>Manage Galleries</li>
          <li>Options</li>
          <li>Sales</li>
          <li>Your Account</li>
         </ul>
     <div class="grids" id="content">
       <div class="grid-15 pad-1">
         <h5><?php echo $breadcrumb; ?></h5>
         <?php echo $flash; ?>
         <?php echo $content;?>
       </div>
       <div class="clear"></div>
     </div>
     <?php //echo debug::vars( Session::instance()->as_array() ); ?>
     <?php //echo debug::vars( $_COOKIE ); ?>
     
</body>
</html>
 
