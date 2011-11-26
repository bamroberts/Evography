<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="en-us" />
    <title>Alec Maxwell Photography - <?php echo $title; ?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="<?php echo strip_tags($meta_description); ?>" />
    <meta name="copyright" content="" />

<link type="text/css" href="http://alecmaxwell.co.uk/assets/css/reset.css" rel="stylesheet" media="screen" />
<link type="text/css" href="http://alecmaxwell.co.uk/assets/css/text.css" rel="stylesheet" media="screen" />
<link type="text/css" href="http://alecmaxwell.co.uk/assets/css/960.css" rel="stylesheet" media="screen" />
<link type="text/css" href="http://alecmaxwell.co.uk/assets/css/mediaboxAdvBlack.css" rel="stylesheet" media="screen" />
<link type="text/css" href="http://alecmaxwell.co.uk/assets/css/web_alecmaxwell.css" rel="stylesheet" media="screen" />
<?php foreach($scripts as $file) { echo HTML::script($file, NULL, TRUE), "\n"; }?>
<script type="text/javascript" src="http://alecmaxwell.co.uk/assets/javascript/jd.gallery.js"></script>
<script type="text/javascript" src="http://alecmaxwell.co.uk/assets/javascript/jd.gallery.set.js"></script>
<script type="text/javascript" src="http://alecmaxwell.co.uk/assets/javascript/jd.gallery.transitions.js"></script>
<script type="text/javascript" src="http://alecmaxwell.co.uk/assets/javascript/alecmaxwell.js"></script>
<script type="text/javascript" src="/assets/themes/alecmaxwell.co.uk/mediaboxAdv-1.2.4.js"></script>
    
<style>
  .gallery ul {
  width:700px;
  margin-left:40px;
  margin-top:15px;
  margin-bottom:0;
}
p.pagination {
text-align: center;
margin-bottom: 5px;
font-size: 10px;
}
p.pagination a {
padding:0 5px;
margin:-2px;
background-position: center center;
background-color: #ccc !important;

}
p.pagination a:hover , p.pagination a.hover {
background-position: center top; border-color: #999;
}
p.pagination .text {font-size: 8pt; padding:0 3px; line-height: 10pt;}
p.pagination span.text {display: none;}

/* forms */


label {
    display:block;
    margin: 0 1.5em;
    position:relative;
    font-weight:bold;
}
label span {
  color:red;
  position:absolute;
  top:-3px;
  left:-5px;  
}

fieldset div.input{
display: block;
}


fieldset div.text input, 
fieldset div.textarea textarea,
fieldset div.select select {
-moz-border-radius-bottomleft:5px;
-moz-border-radius-bottomright:5px;
-moz-border-radius-topleft:5px;
-moz-border-radius-topright:5px;
-moz-box-shadow:0 1px 3px rgba(0, 0, 0, 0.15) inset;


padding:5px;
border:2px solid #aaa;
display:inline-block;
width:480px;
font-family:"HelveticaNeue-Light","Helvetica Neue",Helvetica,Arial,sans-serif;
font-size:14px;
}

fieldset div.select select {height:35px;margin-left:20px;}

fieldset div input:focus, 
fieldset div textarea:focus, 
fieldset div select:focus {
  -moz-box-shadow:0 1px 3px rgba(0, 0, 0, 0.3) inset, 0 0 5px #3375B6;
	border-color:#3375B6;
  background-color: white;
  color:black;
}

fieldset div.radio li {list-style: none;}

fieldset div.radio li label,
fieldset div.checkbox label.helper{font-weight: normal;}

fieldset div.radio input, 
fieldset div.checkbox input {
  width:inherit;
  float:left;
}



form button {
margin-left:20px;
font-size: 15px;
line-height: 21px;
color:#414141;
}

#head {height:auto;}


</style>
<script>


var preLoad = new Class({

  Implements: [Options,Events],

  new_images:[],
 
  /* additional options */
  options: {
    elements: 'img',
    async: false,
    delay: 1,
  },

  /* initialize */
  initialize: function(options) {
     this.setOptions(options);
     console.log(this.options.elements);
     
     var new_images=this.new_images;
     
     this.images= $$(this.options.elements);
     this.images.each(function(img){
        if (link=img.getParent().href) {
          new_images.push(link);
        }
      });
     if (this.options.async) {
      this.load_async.delay(this.options.delay,this);
     } else {
      this.load_sync.delay(this.options.delay,this);
     }
  },
  
  load_sync: function(){
    var sync=this;
  
    if (link=this.new_images.shift()){
      newImg= new Asset.image(link,{
         onload: function(){
            console.log("pre-loaded " + link);
            sync.load_sync();
          }
        });
    }
  },
  
  load_async: function(){
    console.log('preloading ' + this.new_images.length + ' images');
    var loader = new Asset.images(this.new_images,{
      onProgress:function(counter, index, source){
        console.log('loaded image ' + index + ' : ' + source);
      }
    }); 
  },
});

window.addEvent('domready', function(){new preLoad({elements:'.gallery .image img',delay:3000})});
</script>

    <!--[if IE]>
       <link type="text/css" href="http://alecmaxwell.co.uk/assets/css/ie.css" rel="stylesheet" />    
       <style>
          #comments .top {
            background-position:0 -28px;
	          height:16px;
          }
          #comments .top .head {border:none; color:#000;font-weight:bold;top:0;}
          #comments .head {border:none; text-align:right;}
          #comments .body {background:transparent url(http://alecmaxwell.co.uk/images/chrome/ie/intro_bg.png) no-repeat 0 0 !important;}
       </style>   
    <![endif]-->
  </head>
  <body id="<?php echo str_replace('/','_',trim(Request::current()->url(),'/')); ?>" class="<?php echo str_replace('/',' ',trim(Request::current()->url(),'/')); ?>">	
    <div id="body">
    <?php if(is_object($cover)) : ?>
      <div id="photoframe" class="static"><img src="/images/dynamic/<?php echo $cover->filehash;?>/1020x416xcrop<?php echo $cover->crop; ?>.<?php echo $cover->ext; ?>" alt="Cover image" /></div>
    <?php endif; ?>
		 <div id="frame">
		  <div class="container_16" id="head">

			  <div id="nav" class="grid_16">
			    <h1 id="logo">
			      <a href="/" class="replace"> 
			        Alec Maxwell Photography
			      </a> 
			    </h1>
			    <div>
			      <ul>
				      				      					      <li  >
					        <a href="http://alecmaxwell.co.uk/" class="replace index">

					          Home					        </a>
					      </li>
				      					      <li >
					        <a href="http://alecmaxwell.co.uk/wedding/" class="replace wedding">
					          Weddings					        </a>
					      </li>
				      					      <li  >
					        <a href="http://alecmaxwell.co.uk/commercial/" class="replace commercial">

					          Commercial					        </a>
					      </li>
					     
					      <li  class="selected" >
					        <a href="http://gallery.alecmaxwell.co.uk/" class="replace gallery">

					          Gallery					        </a>
					      </li>

				      					      <li  >
					        <a href="http://alecmaxwell.co.uk/contact/" class="replace contact">
					          Contact					        </a>
					      </li>
				      			      </ul>
			    </div>

			  </div>
		    <!-- end .grid_16 -->
		    <div class="clear"> </div>
		    <div id="intro" class="grid_15" style="<?php echo (is_object($cover))?'':'height:auto;'; ?>">
		    <?php if(Request::current()->controller()=='collection') : ?>
		        <p class="fright" style="margin-right:0;background-color:black;padding-left:5px;">
  		        <b style="display:block;">Like this collection</b>
              <iframe src="http://www.facebook.com/plugins/like.php?app_id=179663692087801&amp;href=<?php echo URL::site($page_link,'http'); ?>&amp;send=false&amp;layout=standard&amp;width=200&amp;show_faces=false&amp;action=like&amp;colorscheme=dark&amp;font=verdana&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:35px;" allowTransparency="true"></iframe>
            </p>     
         <?php endif; ?>   
            <h2><?php echo $collection_title; ?></h2>
		        <p><?php echo $collection_desc; ?></p>
		        <?php if($parent=$node->parent) : ?>
     <!--
<a class="btn button" href="<?php //echo Route::url($parent->id); ?>">
     &lt; Back to: <?php //echo $parent->name; ?>
     
</a>
-->
    <?php endif; ?>
        </div>

  <!-- end .grid_16 -->
  <div class="clear">
    
  </div>  
</div> <!-- end .head -->
<div id="content" class="container_16" >
    <div id="wrapper"  class="grid_16">
      <?php echo $content;?>

   		    <div class="grid_16" id="footer">		      
		      <div class="contact">
		      <p>
		         Email <a href="&#109;&#097;&#105;&#108;&#116;&#111;&#058;&#105;n&#102;&#x6f;&#64;al&#101;&#x63;&#109;a&#x78;&#119;&#x65;l&#x6c;&#x2e;&#99;&#111;&#109;">&#105;n&#102;&#x6f;&#64;al&#101;&#x63;&#109;a&#x78;&#119;&#x65;l&#x6c;&#x2e;&#99;&#111;&#109;</a>		       </p>
		       <p>
		         Phone <span>023 8047 3474</span> or <span>077 8060 1613</span>

		       </p>
		       <ul id="smallnav" class="clearfix">
		         		      <li  >
		        <a href="http://alecmaxwell.co.uk/" class="index">
		          Home		        </a>
		      </li>
		      		      <li>
		        <a href="http://alecmaxwell.co.uk/wedding/" class="wedding">

		          Weddings		        </a>
		      </li>
		      		      <li  >
		        <a href="http://alecmaxwell.co.uk/commercial/" class="commercial">
		          Commercial		        </a>
		      </li>
		      <li  class="selected" >
		        <a href="http://gallery.alecmaxwell.co.uk/" class="gallery">
		          Gallery		        </a>
		      </li>
		      		      <li  >
		        <a href="http://alecmaxwell.co.uk/contact/" class="contact">

		          Contact		        </a>
		      </li>
		      		        </ul>
		      </div>
		  </div>
    </div>
      <!-- end .grid_16 -->
    <div class="clear"> </div>

    <p class="copy" >&copy;copyright 2011 <span>Alec Maxwell Photography</span> All rights reserved. Design &amp; build by <a href="http://www.rocomanda.com" target="_blank">ROCOmanda</a></p>
  </div>
  </div>
</body>
</html>
 
