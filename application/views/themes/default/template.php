<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php echo $site->name; ?><?php echo (isset($title))?"- $title":""; ?></title>
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <meta name="author" content="">
  <link href="<?php echo url::site(url::canonical()); ?>" rel="canonical">
  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1">  
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />

  
<?php
    echo Assets::factory('main')
        ->css('basic.css')
        //->css('core.css')
        //->css('theme/basic.css')
        //->css('style/basic.css')
        ->js("libs/modernizr-1.7.min.js", null);
        
    ?>
  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
   <script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAA-2tTbIRKJojggSRM--n-hxSvpd12rs751Bi4QsVjQ2FFNzfAXhQ0TlJ9sZ-4vT9cZebJUS67Zc18rw"></script>
    <script>
google.load("jquery", "1.6.4");
google.load("jqueryui", "1.8.16");
</script>
<script>window.jQuery || document.write('<script src="/assets/javascript/libs/jquery-1.5.1.min.js"><\/script>')</script>

    
  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script--> 
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->
  
  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  
  <!-- JavaScript at the bottom for fast page loading -->
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
         <style>
      .loading  {opacity: 0.25; height:100%; overflow: hidden;}
    </style>  
      


<style>
  .lightbox-target {position: relative; overflow:hidden;}
 
  .lightbox-target .lightbox-window a { position: absolute; top:50%;
        z-index:1001; }
   
  .lightbox-target a.next     { right:10px; }
  .lightbox-target a.previous { left:10px;  }
  .lightbox-target a.fullscreen { left:100%; margin-left:-50%;  }
        
  body.lightbox-target a.next     { right:27%; }
  body.lightbox-target a.previous { left:27%;  }
  body.lightbox-target a.fullscreen { display:none; }
  
  .lightbox-target .lightbox-window {
        position:absolute;
        top:0%;
        left:0%;
        width:100%;
        height:100%;
        background-color:rgba(0,0,0,0.6);
}
  
  body.lightbox-target .lightbox-window {
          position:fixed;
          top:-50%;
          left:-50%;
          width:200%;
          height:200%;
          
  }
  
.lightbox-window img {
        background-color:black;
        border:5px solid white;
        outline:5px solid transparent;
        
        -moz-box-sizing: border-box;
         padding:40px;

        position:absolute;
        top:0;
        left:0;
        right:0;
        bottom:0;
        margin:auto;
        max-width:100%;
        max-height:100%;
}

body.lightbox-target img {max-height:50%;}

section {position: relative;
}
.container, section {padding:0;}

header, .padding   {padding: 15px 25px;}

section.intro .fade-up {position:absolute; bottom:0; width:100%; box-sizing:border-box;}

header {background-color:rgba(0,0,0,0.7);}

.fade-up {
	background: -moz-linear-gradient(top,  rgba(35,35,35,0) 0%, rgba(35,35,35,0.63) 38%, rgba(35,35,35,1) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(35,35,35,0)), color-stop(38%,rgba(35,35,35,0.63)), color-stop(100%,rgba(35,35,35,1))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  rgba(35,35,35,0) 0%,rgba(35,35,35,0.63) 38%,rgba(35,35,35,1) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  rgba(35,35,35,0) 0%,rgba(35,35,35,0.63) 38%,rgba(35,35,35,1) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  rgba(35,35,35,0) 0%,rgba(35,35,35,0.63) 38%,rgba(35,35,35,1) 100%); /* IE10+ */
	background: linear-gradient(to bottom,  rgba(35,35,35,0) 0%,rgba(35,35,35,0.63) 38%,rgba(35,35,35,1) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00232323', endColorstr='#232323',GradientType=0 ); /* IE6-9 */
}
.fade-down {
	background: -moz-linear-gradient(top,  rgba(35,35,35,1) 0%, rgba(35,35,35,0.63) 62%, rgba(35,35,35,0) 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(35,35,35,1)), color-stop(62%,rgba(35,35,35,0.63)), color-stop(100%,rgba(35,35,35,0))); /* Chrome,Safari4+ */
	background: -webkit-linear-gradient(top,  rgba(35,35,35,1) 0%,rgba(35,35,35,0.63) 62%,rgba(35,35,35,0) 100%); /* Chrome10+,Safari5.1+ */
	background: -o-linear-gradient(top,  rgba(35,35,35,1) 0%,rgba(35,35,35,0.63) 62%,rgba(35,35,35,0) 100%); /* Opera 11.10+ */
	background: -ms-linear-gradient(top,  rgba(35,35,35,1) 0%,rgba(35,35,35,0.63) 62%,rgba(35,35,35,0) 100%); /* IE10+ */
	background: linear-gradient(to bottom,  rgba(35,35,35,1) 0%,rgba(35,35,35,0.63) 62%,rgba(35,35,35,0) 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#232323', endColorstr='#00232323',GradientType=0 ); /* IE6-9 */
}

hr {margin:0}

.container {
	width: 940px;
	width:auto;
} 


.hint {
	font-size: 2em;
	font-color:#dd9;
	position:fixed;
	bottom:10px;
	right:10px;
}


section {
	background:#fff url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7) no-repeat fixed center center;
	background-size:100%;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	-o-background-size: cover;
	background-size: cover;
	position:relative;
}

section:before {
	box-sizing: border-box;
	position:absolute;
	content: " ";
	display:block;
	width:100%;
	height:100%;
	background: rgba(0,0,0,.7) url(/assets/images/ui/overlay/04.png);
	opacity:0.3;
}

section.intro:before {
	display:none;
}

section * {position:relative;}

.loading:after {
	/* Spinner */
}

.Slider {-webkit-backface-visibility: hidden;}
</style>


</head>
<body id="<?php echo url::page_id(); ?>" class="<?php echo url::page_class(); ?>" style="<?php if(false && Access::permission($node) || $node->password->cover) : ?>background-image:url(<?php echo url::image($node->cover,1000,1000,'fit'); ?>);<?php endif; ?>">
  <a class="tabfocus hide" href="#main">jump to content (press enter)</a>
  <div class="container">
<!--
    <header>
      <h1><a href="<?php echo URL::Site('/'); ?>"><?php echo $site->name; ?></a></h1>
      <?php echo $breadcrumbs; ?>
	</header>
-->
  </div>
  <div class="container <?php echo $node->type;?>"> 
  <section class="intro" style="<?php if(Access::permission($node) || $node->password->cover) : ?>
background:url(<?php echo url::image($node->cover,1000,1000,'fit'); ?>) no-repeat center center; 
background-size:100%;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
<?php endif; ?>">
	<header>
      <h1><a href="<?php echo URL::Site('/'); ?>"><?php echo $site->name; ?></a></h1>
      <?php echo $breadcrumbs; ?>
	</header>
	<hr />
	<div class="padding fade-up">
	    <?php echo facebook::like(Route::URL($node->id)); ?>
	    <h2><?php echo $node->name; ?></h2>
	    <?php if(Route::exists($node->parent->id) && $node->parent->type=='gallery') : ?>
        	<?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'part')))->execute();?>
        <?php endif; ?>
	    
	    <?php //echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'part')))->execute();?>
	    <p><?php echo $node->desc; ?></p>
	</div>
  </section>  
  

	<!--
<div id="main" role="main">
	   <?php if(Route::exists($node->parent->id) && $node->parent->type=='gallery') : ?>
     <div class="well intro">
        <?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'part')))->execute();?>
     </div>
     <?php endif; ?>
	   <h2><?php echo $node->name; ?></h2>
	   <p><?php echo $node->desc; ?></p>
-->
	       <?php echo $content; ?>
	</div>
	
</div> <!--! end of #container -->
<footer>   
	 &copy;<?php echo Date('Y'); ?> <strong><?php echo $site->name; ?></strong> All rights reserved. 
</footer>
<div class="hint">
	Hint!
</div>
<script>
	  	
	  	$(document).ready(function() {
	  		
	  		hint();
	 		setInterval(hint(),3000);
	 		function hint(){
		 		$('.hint')
		 			.fadeIn(300)
		 			.delay(300)
		 			.fadeOut(300)
		 			.fadeIn(300)
		 			.delay(300)
		 			.fadeOut(300);
	 		}

 		});	
 		
 		
 		
 		//Open all site links using js
 		$("body").live("click", "a", function(e) {
 			console.log($(e.target).data('events'));
	 		e.target.href.indexOf(location.hostname) && e.target.target != "_blank" && (window.location = e.target.href);
   		});
 		
 		$(window).resize(function() {
	  		 $('.container.gallery section').each(function() {$(this).css('min-height',$(window).height())});
	  	});
	  	$(window).resize()

</script>
 <?php echo Assets::factory('script')
        //->css('core.css')
        //->css('theme/basic.css')
        //->css('style/basic.css')
       // ->js("libs/modernizr-1.7.min.js", null)
        ->js("libs/jquery-css-transform.js",null)
        ->js("libs/jquery-animate-css-rotate-scale.js")
        
        ->js("mylibs/general.js")    
        ->js("mylibs/close.js")    
        ->js("mylibs/fade.js")    
        ->js("mylibs/lightbox.js")    
        ->js("mylibs/pagination.js")  
        ->js("mylibs/slideshow.js")    
        ->js("mylibs/polaroid.js")

        ->js("pageflip/js/swfobject.js")  
        ->js("pageflip/js/flippingbook.js")   
        ->js("slideshowify/js/jquery.slideshowify.js")   
        ->js("queryLoader/js/queryLoader.js") 
          
        ->js("plugins.js") 
        ->js("script.js")->render();
    ?>
    
  <!-- Change UA-XXXXX-X to be your site's ID -->
  <?php if(false) : ?>
  <script>
    window._gaq = [['_setAccount','<?php echo $account->tracking_code; ?>'],['_trackPageview'],['_trackPageLoadTime']];
    Modernizr.load({
      	
      load: ('https:' == location.protocol ? '//ssl' : '//www') + '.google-analytics.com/ga.js'
    });
  </script>
  <?php endif; ?>
</body>
</html>