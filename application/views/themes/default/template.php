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
  
  


 /* Lightbox PUBLIC CLASS DEFINITION
  * ============================= */
  var Lightbox = function ( content, options ) {
  
    //merge settings with defaults 
    this.settings = $.extend({}, $.fn.lightbox.defaults, options)
    
    //master object
    this.$element = $(content)
      .delegate('a img', 'click', $.proxy(this.click, this))
      ;
    
    this.settings.target = this.settings.target ? $(this.settings.target) : this.$element.closest('section');
    
        
    //all elements that have an image in an href
    this.$set = this.$element.find('a img');
    
    this.page=0;
    this.current=false;
    
    //this.$element.append('<div class="window">Hello</div>')
    
    this.$window=$('<div class="lightbox-window">'); 
    this.$window.delegate('.lightbox-window img', 'click', $.proxy(this.hide, this))
      .delegate('.next', 'click', $.proxy(this.next, this))
      .delegate('.previous', 'click', $.proxy(this.previous, this))
      .delegate('.fullscreen', 'click', $.proxy(this.fullscreen, this))
          
    
    this.bind(this.settings.target);    
    //this.$target.append(this.$window);
    
    if (this.settings.preload){
    
    }

    return this
  }
  
  Lightbox.prototype = {
     next: function (item) {
       //next = $(this.current).parent().next().find('img').first() || this.$element.find('img').first();
       //this.show($(next))
       index = this.page;
       if (++index>this.$set.length-1) index=0;
       
       this.show( $(this.$set[index]) )
     },
     previous: function (event) {
       //previous = this.current.previous('img') || this.$element.find('img').last();
       
       
       index = this.page;
       if (--index<0) index=this.$set.length-1;
       
       this.show( $(this.$set[index]) )
     },
     click:function (e) {
        e && e.preventDefault();
        this.show(e.currentTarget)
     },
     show: function (item) {
        var that = this
  
        this.$element.pass('polaroid','pause');
        
       // if ($polaroid=this.$element.data('polaroid')){
       //     $polaroid.pause();
      //  }
        
        //console.log(this.$set.length)
        
        this.current = item ;
        this.page = this.$set.index(this.current);
        var href = $(item).parent('a').attr('href').replace(/\/$/, '');
         
         this.$window.empty();
         this.$window.append('<img src="'+href+'.jpg" />');
        
         this.$window.append('<a class="next btn">next</a>');
         this.$window.append('<a class="previous btn">previous</a>');
         this.$window.append('<a class="close btn">close</a>');
           
         this.$window.append('<a class="fullscreen btn">fullscreen</a>');
         this.$window.append('<span class="count">'+this.page + '/' + this.$set.length + '</span>');

       
        img=this.$window.find('img').first()
        
        width=img.width();
        height=img.height();
        if (height>width) img.addClass('portrait');
       
        this.$target.addClass('lightbox-target');
       
        console.log(href);
        
        this.isShown = true
        
        escape.call(this)
        
        return this
      }

    , hide: function (e) {
        e && e.preventDefault()

        if ( !this.isShown ) {
          return this
        }

        var that = this
        this.isShown = false
        escape.call(this)
        
        this.$target.removeClass('lightbox-target');
        
        
        if (this.fullscreen) {
          this.fullscreen=false;
          this.bind(this.settings.target);
        }
        
        this.$window.empty();
                
        return this
      }
      
    , fullscreen: function(e) {
       // this.$target.removeClass('lightbox-target');
        
        this.fullscreen=true;
        this.bind('body');
      }
    
    , bind:   function(item) {
      if (this.$target) {
            this.$target.removeClass('lightbox-target')
      }     
      this.$target = $(item);
      
      this.$window.appendTo(this.$target)
      
      if (this.isShown) {
        this.$target.addClass('lightbox-target');
      }
    }
      
  }


 //This is a function that allows communication between javascript plugins attach to the same object.
 $.fn.pass = function (plugin,action,options){
  var data=[];
 
  this.each(function(){
    if ($plugin=$(this).data(plugin)){
      if (typeof $plugin[action]==='function') {
            return data.push ($plugin[action]() )
          }
      return data.push( $plugin[action] )
    }
    return data.push(this);
    });
   
  //if there is only one result, do not return it as an array  
  return (data.length == 1) ? data[0] : data ;  
 } 


 /* Lightbox PLUGIN DEFINITION
  * ======================= */

  $.fn.lightbox = function ( options ) {
      return this.each(function () {
        $(this).data('lightbox', new Lightbox(this, options))
      })
    return this
  }

  $.fn.lightbox.defaults = {
    backdrop: true
  , keyboard: true
  , fullscreen: true
  , show: false
  , destroy:false
  , target: false
  
  }
  
  

  function escape() {
    var that = this
    if ( this.isShown && this.settings.keyboard ) {
      $(document).bind('keypress.lightbox', function ( e ) {
         if (e.which==32) {  
            e && e.preventDefault() //space
            that.next();
          }
      });
      
        $(document).bind('keyup.lightbox', function ( e ) {
         switch (e.which) {
            case 37: that.previous(); break; //left - next
            case 39: that.next(); break; //right
            case 27: that.hide(); break; //esacpe
        }      
      });
    } else if ( !this.isShown ) {
      $(document).unbind('keyup.lightbox');
      $(document).unbind('keypress.lightbox')
    }
  }
   


$(function () {
    $("[data-lightbox]").lightbox();
        //var $speed = $(this).data('speed', 300);
   
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






</style>


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
        <?php echo Request::factory(Request::current()->url(array('controller'=>'menu','action'=>'index','format'=>'part')))->execute();?>
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