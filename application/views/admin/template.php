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

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script--> 
  <link rel="stylesheet" href="/assets/css/basic.css">
  <link rel="stylesheet" href="/assets/vendor/jwysiwyg/jquery.wysiwyg.css"> 
  
  <script src="/assets/javascript/libs/modernizr-1.7.min.js"></script>
  <!-- JavaScript at the bottom for fast page loading -->
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
  <script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAA-2tTbIRKJojggSRM--n-hxSvpd12rs751Bi4QsVjQ2FFNzfAXhQ0TlJ9sZ-4vT9cZebJUS67Zc18rw"></script>      
  <script>
  google.load("jquery", "1.6.4");
  google.load("jqueryui", "1.8.16");
  </script>
  
  <style>
    .main {border:1px solid white; padding:20px;border-top-width:0;margin-top:-20px;}
  </style>
  
</head>
<body>
  <div class="container">
    <header class="fix">
      <h1 class="pull-left">EVOGRAPHY <a href="<?php echo Route::url('admin');?>">Admin Area</a></h1> 
      <h5 class="pull-right">
           <?php if ($user=Auth::instance()->get_user()) : ?>
            You are 
            <a href="<?php echo Route::url('admin');?>user/details">
              <?php echo $user->username; ?>
            </a>  
            / 
            <a href="<?php echo Route::url('admin');?>user/logout">
              Logout  
            </a>
           <?php else : ?>
            <a href="<?php echo Route::url('admin');?>user/login">
              Login  
            </a>
           <?php endif; ?> 
      </h5>
    </header> 
    
    <nav class="tabs">
        <?php echo $menu; ?>
    </nav>
     
    
    <div class="main">
        <h5><?php echo $breadcrumb; ?></h5>
        <?php echo $flash; ?>
        <?php echo $content;?>
    </div>
    
    <footer>
      <nav class="pull-right">
        <?php echo $menu; ?>
      </nav>
    </footer>
  </div>
</body>

<script type="text/javascript" src="/assets/vendor/jwysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript">
$(function() {
    $('textarea').wysiwyg({
      rmUnusedControls: true,
      controls: {
        bold: { visible: true },
        italic: { visible: true },
        underline: { visible: true },
        justifyLeft: { visible: true },
        justifyCenter: { visible: true },
        justifyRight: { visible: true },
       // undo: { visible: true },
      //  insertHorizontalRule: { visible: true },
        createLink: { visible: true },
      //  paragraph: { visible: true },
      //  h2: { visible: true },
      //  h3: { visible: true },
      //  h4: { visible: true },
        
        html: { visible: true },
      }
    });
});
</script>

</html>