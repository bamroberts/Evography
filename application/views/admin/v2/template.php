<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $site; ?><?php echo (isset($title))?"- $title":""; ?></title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="">
  <link href="<?php echo url::site(url::canonical()); ?>" rel="canonical">
  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
</head>
  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script--> 
    
    <link rel="stylesheet" href="/assets/admin/v2/stylesheets/app.css">
    <script src="/assets/admin/v2/scripts/library.js"></script>
    <script src="/assets/admin/v2/scripts/app.js"></script>
    <script src="/assets/admin/v2/sscripts/initialize.js"></script>  
</head>
<body>

 <!-- Top level Nav -->
  <div id="header">
    <div class="con">
        <?php if ($user=Auth::instance()->get_user()) : ?>
        	<?php echo $menu; ?>
        <?php endif; ?>
     </div>
  </div>	
  <!-- END Top level Nav -->
  
  <!-- Stream Actions -->
  <div id="stream">
    <div class="con">
        <div class="tile" id="hello">
        	<?php if ($user=Auth::instance()->get_user()) : ?>
              <h2><span>Hi,</span> <?php echo $user->details->name; ?></h2>
              <p>You last visited <strong>two hours</strong> ago</p>
            <?php endif; ?>
            <ul class="nav">
                <li>
                    <a href="#home">*</a>
                </li>
                <li>
                    <a href="#icons">8</a>
                </li>
                <li>
                    <a href="#settings">!</a>
                </li>
                <li>
                    <a href="#more">v</a>
                </li>
            </ul>
        </div>
        <a class="tile" href="#link-to-something">
            <span class="vector">C</span>
            <span class="title"><strong>Create</strong> Gallery</span>
            <span class="desc"><strong>Start a new </strong> Gallery or Collection</span>
        </a>
        <a class="tile" href="#link-to-something">
            <span class="vector">3</span>
            <span class="title"><strong>Manage</strong> Galleries</span>
            <span class="desc"><strong>Simply</strong> everything</span>
        </a>
        <a class="tile" href="#link-to-something">
            <span class="vector count" data-count="4">)</span>
            <span class="title"><strong>Sales</strong></span>
            <span class="desc"><strong>Up from</strong> 68%</span>
        </a>
        <a class="tile" href="#link-to-something">
            <span class="vector">I</span>
            <span class="title"><strong>Upload</strong> Photos</span>
            <span class="desc"><strong>Up from</strong> 68%</span>
        </a>
        <a class="tile" href="#link-to-something">
            <span class="vector">O</span>
            <span class="title"><strong>Preview</strong> live site</span>
            <span class="desc"><strong></strong></span>
        </a>
    </div>
  </div>

  <div id="dashboard">
    <div class="scroll con">
    	<h5><?php echo $breadcrumb; ?></h5>
        <div class="section current padding" title="Our First Section" id="first_section">
        	<?php echo $flash; ?>
        	<?php echo $content;?>
        </div>
    </div>
  </div>
         
  <footer id="footer"> 
	  <div class="con">
		  <nav class="pull-right">
		    <?php echo $menu; ?>
		  </nav>
	  </div>
  </footer>
 
</body>
</html>