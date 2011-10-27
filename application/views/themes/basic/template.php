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
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->

  <!-- CSS: implied media=all -->
  <!-- CSS concatenated and minified via ant build script--> 
  <link rel="stylesheet" href="/assets/css/basic.css?>">
  <!-- end CSS-->

  <!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->
  <script>
    var $settings = {}; 
    <?php if ($script_options) : ?>
        $settings.node_<?php echo $node->id; ?>= <?php echo json_encode($script_options); ?>;
    <?php endif; ?>
  </script>
  <!-- All JavaScript at the bottom, except for Modernizr / Respond.
       Modernizr enables HTML5 elements & feature detects; Respond is a polyfill for min/max-width CSS3 Media Queries
       For optimal performance, use a custom Modernizr build: www.modernizr.com/download/ -->
  <script src="/assets/javascript/libs/modernizr-1.7.min.js"></script>
  <!-- JavaScript at the bottom for fast page loading -->
  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
      <script type="text/javascript" src="https://www.google.com/jsapi?key=ABQIAAAA-2tTbIRKJojggSRM--n-hxSvpd12rs751Bi4QsVjQ2FFNzfAXhQ0TlJ9sZ-4vT9cZebJUS67Zc18rw"></script>
    
    <style>
      .loading  {opacity: 0.25; height:100%; overflow: hidden;}
    </style>  
      
<script>
google.load("jquery", "1.6.4");
google.load("jqueryui", "1.8.16");
</script>
  
  <script>window.jQuery || document.write('<script src="/assets/javascript/libs/jquery-1.5.1.min.js"><\/script>')</script>

<script>
var Fade = function ( content, options ) {
    //this.settings = $.extend({}, $.fn.fade.defaults, options)
    this.$element = $(content)
    var speed=$(content).data('fade-speed') || 300;
    $(this.$element).find('img').hide().fadeIn(speed);
    
    $(this.$element).find('img').load(function () {
          $(this).fadeIn(speed);
      });
       
    return this
  }
  
var Paginate = function ( content, options ) {
    //this.settings = $.extend({}, $.fn.fade.defaults, options)
    //this is a section
    var $element = $(content)
    var $target=$($element.find('.media'));
    var $url=(window.location.pathname);
    
    //set current page as url
    $element.find('.pagination a.current').attr('href',$url);
    $element.delegate('.pagination a', 'click', function(e){
      e.preventDefault();
      var $currentlink=$(this).attr('href');
      if ($currentlink==$url) {return;}
      $url=$currentlink;
      $target.animate({opacity:'0'}, 300)
      //window.location.replace($currentlink);
      $.ajax({
        url: $(this).attr('href') + ".part",
        context: document.body,
        success: function(data){
          $target.html(data);
          $target.animate({opacity:'1'}, 300);
          $element.find('.pagination a').removeClass('current')
          $element.find('.pagination a[href="'+ $currentlink +'"]').addClass('current');
          //alert('Load was performed.');  
        }
      });
    });
    //alert($target.parent().parent().find('.media-grid').html);
    //this.$current_url=window.loaction;
         
      //alert('Loading page' + $(this).attr('href')  );
    
    
    
    return this
  }  
  
$.fn.fadeImages = function( options ) {
  // alert("fade");
    $(this).data('fade', new Fade( this, options ))
    return this;
  } 

$.fn.pagination = function( options ) {
    //alert($(this).html);
    //$(this).data('fade', new Paginate( this, options ))
    $(this).data('paginate', new Paginate( this, options ))
    return this;
  }
   


$(function () {
    $("[data-lightbox]").delegate("img", "click", function(e){
         e.preventDefault  ();
        //var $speed = $(this).data('speed', 300);
        alert ("showing lightbox");
    });
    $("[data-fade]").fadeImages();
    $("[data-paginate]").pagination();
  
     //$("[data-fade]").fadeOut(0)
    // $("body").delegate("[data-fade]", "ready", function(){
    //    var $speed = $(this).data('show', 300);
    //    $(this).fadeIn($speed);
    //});
    
   // $("img").fadeOut(0).live('load', function() {
   //   alert ('load')
     //$(this).hide();
     // console.log(this.nodeName);
     //  $(this).fadeIn(5000) ;

    
  });



</script>

</head>
<body id="<?php echo url::page_id(); ?>" class="<?php echo url::page_class(); ?>" style="<?php if(Access::permission($node) || $node->password->cover) : ?>
background:url(<?php echo url::image($node->cover->ext,$node->cover->filehash,1000,1000,'fit'); ?>) no-repeat fixed center center; background-size:100%
<?php endif; ?>">
  <a class="tabfocus hide" href="#main">jump to content (press enter)</a>
  <div class="container">
    <header>
      <h1><a href="<?php echo URL::Site('/'); ?>"><?php echo $site->name; ?></a></h1>
      <?php echo $breadcrumbs; ?>
	  </header>
  </div>
  <div class="container"> 
	<div id="main" role="main">
	   <?php if(Route::exists($node->parent->id) && $node->parent->type=='gallery') : ?>
     <div class="well intro">
        <?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'.part')))->execute();?>
     </div>
     <?php endif; ?>
	   <h2><?php echo $node->name; ?></h2>
	   <p><?php echo $node->desc; ?></p>
	       <?php echo $content; ?>
	</div>
	
	<ul class="pallet hide">
    <li class="baseColor">baseColor</li>
    <li class="complement">complement</li>
    
    <li class="split1">split1</li>
    <li class="split2">split2</li>
    
    <li class="triad1">triad1</li>
    <li class="triad2">triad2</li>
    
    <li class="tetra1">tetra1</li>
    <li class="tetra2">tetra2</li>
    
    <li class="analog1">analog1</li>
    <li class="analog2">analog2</li>
  </ul>
	<?php //echo debug::vars(Profiler::application()); ?>
  </div> <!--! end of #container -->
  <footer>   
	  &copy;<?php echo Date('Y'); ?> <strong><?php echo $site->name; ?></strong> All rights reserved. 
  </footer>
  
    <!-- scripts concatenated and minified via ant build script-->
  <script defer src="/assets/javascript/plugins.js"></script>
  
  <script defer src="/assets/pageflip/js/swfobject.js"></script>
  <script defer src="/assets/pageflip/js/flippingbook.js"></script>
  
  <script defer src="/assets/javascript/libs/jquery-css-transform.js"></script>
  <script defer src="/assets/javascript/libs/jquery-animate-css-rotate-scale.js"></script>
  <script defer src="/assets/vendor/queryLoader/js/queryLoader.js"></script>

  
  <script defer src="/assets/javascript/script.js"></script>
  <!-- end scripts-->

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