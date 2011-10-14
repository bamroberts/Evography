<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en" xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Language" content="en-us" />
    <title><?php echo $title;?></title>
    <meta name="author" content="">
    <meta name="keywords" content="<?php echo $meta_keywords;?>" />
    <meta name="description" content="<?php echo $meta_description;?>" />
    <meta name="copyright" content="<?php echo $meta_copywrite;?>" />
    
    <?php foreach($styles as $file => $type) { echo HTML::style($file, array('media' => $type)), "\n"; }?>
    <?php #foreach($scripts as $file) { echo HTML::script($file, NULL, TRUE), "\n"; }?>
    
    <link media="screen" rel="stylesheet" href="/assets/css/style.css" type="text/css">
    <link media="screen" rel="stylesheet" href="/assets/css/admin.css" type="text/css">
    
    <style>
      body {background-color: #222;}
      p {font-size:1em;}
      h1 {font-size:4em; color:white;text-shadow: 2px 1px 2px #000000; line-height: 1em;}
      h1 span {font-size:0.5em;color: #C8C8C8; display: block;line-height: 1.4em;}
      h2 {font-size:2.5em; line-height: 1.2em;}
    
      header, footer, #main {      
        border-top: 1px solid #666;
        border-bottom: 1px solid #000;
        box-shadow: 0 10px 18px rgba(0, 0, 0, 0.3) inset,0 -10px 18px rgba(0, 0, 0, 0.3) inset;
      }
      
     footer {height:100px; margin-top:-20px;background-color:#222;}
      #main {z-index:100;}
      
      #main .wrapper, header, #main
      { background-image:url(/assets/images/noise_5.png);
        background-position: center center;
        background-repeat: repeat;}
      
      .wrapper {
        clear: left;
        margin: 0 auto;
        position: relative;
        text-align: left;
        width: 960px;
        padding:0;
  
      }  
      #loginContainer {top:-15px; }
    .top {    background-color: rgba(0, 139, 253, 0.2);
    border-bottom: 1px solid #CCCCCC;
    height: 20px;
    position: absolute;
    top: 0;
    width: 100%;}
    .top a {padding-right:20px;}
    
    .top .wrapper {text-align: right;padding-right:40px;}
    	#logo {
			color:#008BFD; font-size: 3.5em; line-height: 17pt; padding-top: 24px; margin:20px 0; display:inline-block;
			text-shadow: -3px -2px 5px #000, 3px 2px 5px #333;
			}
			
			#logo span {
			 font-size: 0.5em; color:white; margin-left: -22px; line-height: 14pt;
			}
			
			#logo span span {
			 display: block; font-size: 0.6em; line-height: 18pt; margin-left: 4px;
			}
			
		  #main {background-color:#999;}
		   #main .wrapper {background-color:#333; margin-top:-20px; border-radius: 5px; border:1px solid #666; padding:30px;}
		  #main h1 {
		  
    
    
		  }
		  
		   *:focus {outline: red 5px solid;}
		  
		  .package {margin:0px 13px; box-shadow: 2px 2px 7px rgba(0, 0, 0, 0.3); }
		  .package:first-child {margin-left:0px;}
		  .package:last-child {margin-right:0px;}
		  
		  .package {width:300px; float:left; margin-right:12px; color:white; border:1px solid white;  -moz-border-radius: 5px;text-shadow: 2px 1px 2px rgba(0,0,0,0.5);background-color: #1e1e1e;}
		  .package h3 {font-size: 3em; padding:0 10px; background-color:#008BFD;border-bottom: 1px solid #111; margin:0;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;}
		  .package .description {font-size: 1em;border-bottom: 1px solid #000;border-top: 1px solid #666; padding:10px; }
		  .package ul {border-top: 1px solid #666;}
		  .package li {font-size: 1.75em;}
		  .package li span {display: block; font-size: 0.6em;}
		  
		  .package .price {text-align: center;border-bottom: 1px solid #000;border-top: 1px solid #666;}
		  .package .value {font-size: 10em; line-height: 1em; color:#008BFD;text-shadow: 2px 1px 2px rgba(0,0,0,0.75);}
		  .package .currency { 
		      font-size: 4em;
          left: 5px;
          position: relative;
          top: -56px;
      }
      .package .time {font-size: 1.5em; position: relative; left:-10px;}
      .package .total span {color:#008BFD;display: inline-block; padding-left:1px;}
      .package .total {display: block;position: relative; top:-15px;}
      .package .link {background-color: #ccc; text-align: center;}
     .trial {clear:both; font-size: 2em; padding:0.5em 1em; margin-bottom:1em; background-color: #008BFD; -moz-border-radius: 5px;color:white; border:1px solid white;}
     .trial span {display:block; font-size: 0.5em; line-height: 0.8em;}
     .trial a {float:right;
    left: 20px;
    position: relative;
    top: -10px;
    
    }
    
    .package ul {margin:0; padding-left:30px;}
    
   button:hover, a.button:hover {box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); background-color: #7AC3FF;}
			
	 button,	a.button {
		  
		  box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
      text-shadow: rgba(255,255,255,0.5) 1px 1px 0;
		}	
		
		button.big, a.button.big {font-size: 2em;}
			
		form {background-color:white; border-radius:10px;}	
		
		header .nav {float:right;margin-top:45px;}
		header .nav li {float:left; list-style: none;}
		header .nav li a {
  		border: 1px solid transparent;
      border-radius: 5px 5px 5px 5px;
      
      font-size: 1.5em;
      margin: 0 10px;
      padding: 6px 8px 5px;
      text-shadow:0 0 2px rgba(0, 0, 0, 0.5), 0 0 7px #008BFD;
    }	
		header .nav li a:hover,header .nav li a.active {box-shadow: 0px 0px 10px #008BFD, 0 0 5px black inset;  color:white; text-decoration:none;}
		
		header .nav li a.active {background:url("/assets/images/ui/button_alpha.png") repeat-x scroll center center #008BFD;box-shadow: 0px 0px 10px #008BFD, 0 0 2px white inset;}
		
		
		
		#main form {
		    border-color: #222 #ddd #ddd #222;
        border-style: solid;
        border-width: 2px;
        margin: 1em 0;
        background-color: #EEEEEE;
        border-radius: 10px 10px 10px 10px;
        box-shadow: 1px 1px 3px black inset;}

		
		
		.access {padding:10px; background-color:#008BFD; border-radius: 15px;}
		.access span{padding:5px; background-color:#eee; border-radius: 15px;}
		
		.more-link:after {
  /* Too many people use &raquo; in their markup to signify progression/movement, that ainÍt cool. LetÍs insert that using content:""; */
  content: " \00BB"; }

.more-link::after {
  content: " \00BB"; }
		
    </style>
    
    <script src="/assets/javascript/libs/modernizr-1.7.min.js"></script>
    
    
  </head>
  
  <body id="<?php echo $page; ?>">	
    <header>
      <div class="wrapper">
        <div id="logo" style="">
          EVOGRAPHY
          <span>
            .com 
            <span>
              event focused galleries
            </span>
          </span>
        </div>
        <ul class="nav">
          <li>
            <a accesskey="h" class="active" href="/">HOME</a>
          </li>
          <li>
            <a accesskey="2" href="/site/tour">TOUR</a>
          </li>
          <li>
            <a accesskey="3" href="/site/pricing">PRICES</a>
          </li>
          <li>
            <a accesskey="4" href="/site/signup">SIGN UP</a>
          </li>
        </ul>
        
        
        
      </div>
    </header>
    
    <div id="main" role="main">
     <div class="wrapper">
     <?php echo $content;?>
     </div>
    </div>
    
    <footer id="footer">
     <div class="wrapper">
     </div>
    </footer>
    
    <div class="top">
      <div class="wrapper">
        <a href="#">About us</a><a href="#">Blog</a><a href="#">Help</a><a href="#">Contact</a>
         <!-- Login Starts Here -->
            <div id="loginContainer">
                <a href="/admin/" id="loginButton"><span>Login</span><em></em></a>
                <div style="clear:both"></div>
                <div id="loginBox">                
                    <form id="loginForm" method="post" action="/admin/">
                        <fieldset id="body">
                            <fieldset>
                                <label for="email">Email Address</label>
                                <input type="text" name="email" id="email" />
                            </fieldset>
                            <fieldset>
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" />
                            </fieldset>
                            <input type="submit" id="login" value="Sign in" />
                            <label for="checkbox"><input type="checkbox" id="checkbox" />Remember me</label>
                        </fieldset>
                        <span><a href="/admin/user/lost-password/">Forgot your password?</a></span>
                    </form>
                </div>
            </div>
            <!-- Login Ends Here -->
    
    </div></div>
    
    
  <!-- JavaScript at the bottom for fast page loading -->

  <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  <script>window.jQuery || document.write("<script src='/assets/javascript/libs/jquery-1.5.1.min.js'>\x3C/script>")</script>


  <!-- scripts concatenated and minified via ant build script-->
  <script src="/assets/javascript/plugins.js"></script>
  <script src="/assets/javascript/script.js"></script>
  <script src="/assets/javascript/libs/login.js"></script>
  <!-- end scripts-->

  <script type="text/javascript">

$.fn.infiniteCarousel = function () {
    return this.each(function () {
      //create wrapper
      //crete window
      //ul is content
      //li is items
    
    
        var $carousel = $(this).css('position', 'relative'),
            $slider = $carousel.find('> ul'),
            window=$slider.wrap('<div class="window" />'),
            $wrapper = $carousel.find('> div.window',this).css('overflow', 'hidden'),
           
        
            $items = $slider.find('> li').css('float','left'),
            $single = $items.filter(':first'),
            
            singleWidth = $single.outerWidth(), 
            totalWidth=$slider.css('width',singleWidth * $items.length),
            
            height= $slider.css('height',$single.outerHeight()),
           
            //visible = Math.ceil($wrapper.innerWidth() / singleWidth), // note: doesn't include padding or border
            currentPage = 1,
            pages = $items.length;            


        function gotoPage(page) {
            var dir = page < currentPage ? -1 : 1,
                n = Math.abs(currentPage - page),
                left=((page==1))?0:'+=' + singleWidth * dir * n;
            
                console.log('page ' + page);
                console.log('n ' + n);
                console.log('left ' + left);
            
            $wrapper.animate({
                scrollLeft : left
            }, 500, function () {
                if (page == 0) {
                    //$wrapper.scrollLeft(singleWidth  * (pages-1));
                    //page = pages;
                    return gotoPage(pages)
                    console.log('end-');
                } else if (page > pages) {
                console.log('start-');
                    return gotoPage(1)
                    //$wrapper.scrollLeft(singleWidth );
                    // reset back to start position
                    //page = 1;
                } 
                $('input.page_'+page, this.parentNode).attr('checked', 'checked');
                currentPage = page;
            }); 
            clearTimeout(wait);               
            wait = setTimeout(incrementPage, 5000);
            return false;
        }
        
        
        $carousel.append('<div class="control"></div>')
        $control=$carousel.find('.control');
        
        $carousel.append('<a class="arrow back">&lt;</a>'); 
        $items.each(function (index) {$control.append('<input class="control page_'+(index+1)+'" type="radio" value="'+(index+1) + '" name="page" />')});
        $carousel.append('<a class="arrow forward">&gt;</a>'); 
        
        $('input.page_1', this.parentNode).attr('checked', 'checked');
        // 5. Bind to the forward and back buttons
        $('a.back', this).click(function () {
            return gotoPage(currentPage - 1);                
        });
        
        $('a.forward', this).click(function () {
            return gotoPage(currentPage + 1);
        });
        
        $('input.control', this).click(function () {
            gotoPage(Math.abs(this.value));
        });
        
        // create a public interface to move to a specific page
        $(this).bind('goto', function (event, page) {
            gotoPage(page);
        });
        var state=1;
        
        function incrementPage(){
          if (state==0) return gotoPage(currentPage);  
          return gotoPage(currentPage+1);
        };
        
        var wait = setTimeout(incrementPage, 5000);
        $wrapper.mouseenter(function(){state=0;});
        $wrapper.mouseleave(function(){state=1;});        
    });  
};

//$(document).ready(function () {
  $('.carousel').infiniteCarousel();
//});
$(document).ready(function() {
 $(document).keydown(function(e) {
   if (e.keyCode != 18 && !e.altKey)
        return;

   $("[accesskey]").each(function() {
   if ($("div#access_" + $(this).attr("accesskey")).length > 0)
        return;
        
   var content=$(this).attr("title") || $(this).text();
   $("<div id='access_" + $(this).attr("accesskey") + "' class='access'><span>" + $(this).attr("accesskey") + "</span> " + content +"</div>")
                .insertAfter($(this));

    $(this).addClass("accessactive");
   });
  });

  $(document).keyup(function(e) {
     if (e.keyCode != 18 && !e.altKey)
         return;

     $("[accesskey]").each(function() {
         $("div#access_" + $(this).attr("accesskey")).remove();
         $(this).removeClass("accessactive");
     });
  });
});

$(document).ready(function() {
  var tabindex = 1;
    $('a,textarea,input,select,button').each(function() {
        if (this.type != "hidden") {
            var $input = $(this);
            $input.attr("tabindex", tabindex);
            tabindex++;
        }
    });
 
 //current= $("[tabindex=1]").focus();

 $('html').live('keydown', function(e) { 
    var keyCode = e.keyCode || e.which; 

    if (keyCode == 9) { 
      dir = e.shiftKey ? -1 : 1,
      console.log('tab pressed');
      e.preventDefault(); 
      var tindex=Math.abs($(":focus").attr("tabindex"))+(1*dir) || 1;
        
      console.log(tindex);
      $("[tabindex='" + tindex + "']").focus();
      console.log("Tabed to " +$("[tabindex='" + tindex + "']'").attr("name") ||$("[tabindex='" + tindex + "']'").text()  )
    } 
  });
  
 //add forward-back
 

});
</script>


  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->

  </body>
</html>