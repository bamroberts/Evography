

<style>
.features ul {list-style: none; margin:0 0 1px;}
.features li {
  
  padding:10px 20px;
  border-top:1px solid white;
  border-bottom:1px solid black;
  width:920px;
  height:250px;
  background-color: #1e1e1e;
  
}
.js .carousel .window {border:1px solid white;}
.js .carousel li {border-right:5px solid white;}

.carousel	a.back,.carousel	a.forward {    background-color: white;
    border-radius: 50px 0 0 50px;
    left: -20px;
    padding: 10px 7px ;
    position: absolute;
    top: 42%;
    cursor:pointer;
    }
		.carousel	a.forward {right:-21px; left:auto;border-radius: 0 50px 50px 0;}

.carousel	a.arrow:hover {opacity: 1;}
.carousel .control {text-align: center; position: relative; top:-12px;}


.features h2 {width:400px;text-shadow:0 0 2px black, 0 0 37px #008BFD}
.features li {background:url('/assets/images/ui/collection.png') #161616 no-repeat 90% 100%; position: relative;}
.features a.btn {position: absolute; bottom:20px; left:20px;}

.features li.preview {background-image:url('/assets/images/wedding_book.png');}
.features li.setup {background-image:url('/assets/images/alec_maxwell_photography_logo.png');}
.features li.pro {background-image:url('/assets/images/cake.png');}

.box {background-color:white; border-radius: 5px; padding:5px; -moz-box-sizing: border-box;}
 h2 {color:#31A2FF;}

.grids {margin-left:-10px;}

.wisp {border-radius: 0 50px 0 50px; font-weight: bold; font-size: 2em; padding:10px; background-color: #444; }

n.span8 {width:48% !important; margin:0 10px 0 1%; padding:5px 1%;}
n.span5 {width:30% !important; margin:0 10px 0 1%; padding:5px 1%;}
n.end   {overflow:hidden;}

p {color:#383838;}

.row {margin-bottom:30px;}

.polaroid {overflow: visible;}

</style>
<h1>Showcase your photos with style.<span>Manage all your photo galleries as an enthusiast or professional</span></h1>
<div class="features carousel">
  <ul>
    <li class="preview">
      <h2>Easy to manage image galleries in over 50 styles and variation</h2>
      <a class="btn large primary" href="">Check out the styles</a>  
    </li>
    
    <li class="setup">
      <h2>Simple to set up, you can have yours online in under 5 minutes</h2>
      <a class="btn large primary" href="">Watch the video</a>  
    </li>
    
    <li class="pro">
      <h2>Pro version for those that want to bundle this as part of their photography offering</h2>
      <a class="btn large primary" href="">Check out the feature list</a>  
    </li>
    
    <li class="mobile">
      <h2>Designed to work anywhere; mobile, tablet, desktop, you name it</h2>
    </li>
    <li class="mobile">
      <h2>Creative galleries</h2>
      <?php //echo Request::factory('http://alec-maxwell.evography.com/bryony-and-luke-stala/main-album.part')->execute(); ?>
      <a class="btn large primary" href="">Check out all our different styles!</a> 
    </li>
  </ul>
</div>

<div class="row">
  <div class="span16 box"><h2>Sample Galleries</h2>
  <?php //echo Request::factory('http://alec-maxwell.evography.com/bryony-and-luke-stala/main-album.part')->execute(); ?>
  </div>
</div>

<div class="row">
  <div class="span16 box"><h2>Documenting life</h2>
    <p>
      Evography is about capturing and cataloguing life.  We want to offer our users the types of galleries they 
      would <strong>hang on their wall</strong> or place on a <strong>coffee table</strong>. We understand that it is the images, memories and 
      essence that you want, not all the online clutter that comes with online galleries.</p>  
    <p>
      Our galleries are being used to not least show off <strong>weddings</strong>, celebrate <strong>births</strong> and remember <strong>lost ones</strong> and for a whole list of other purposes.  In essence we like to help people show off life.
    </p>  
    <p>Our gallery system gives you a place to ... We have a number of different display modules and image organisational tools that all come in a number of different styles, helping you show off and frame your images in way that is personal and truly does them justice.</p>  
    <p>We offer galleries, guestbooks, flipbooks, slideshows, photoblogs, and open albums your friends and family can contribute to.  All of these sections off the ability to leave comments or purchase a copy for your actual wall.
    </p>
    <p>So what are you waiting for <a href="<?php echo route::url('site',array('action'=>'signup')); ?>">get started now!</a></p>  
  </div>
</div>

<div class="row">
  <div class="span8 box"><h2>For you</h2><p>Events and tings</p></div>
  <div class="span8 box"><h2>For your business</h2><p>Get it on</p></div>
</div>

<div class="row">
  <div class="span8 box">
    <h2>Easy-peasy</h2>
    <p>You really can be up and running with your first gallery in under five minutes</p>
  </div>
  <div class="span8 box"><h2>Style</h2><p>Get it on</p></div>
</div>

<div class="row">
  <div class="span8 box"><h2>Mobile</h2>
    <p>All our modules and styles fully tested on iPad, iPhone.</p>
    <p>Offering touch, framed....</p>
  </div>
  <div class="span8 box"><h2>Flexability</h2>
    <p>Get it on</p>
    <p>Get it on</p>
    <p>Custom styles</p>
  </div>
</div>

<div class="row">
  <div class="span8 box"><h2>Privacy</h2>
    <p>Password protected sites and galleries</p>
    <p>Watermarking of images</p>
  </div>
  <div class="span8 box"><h2>k</h2>
    
  </div>
</div>

  
<div class="row">
  <div class="span8 box"><h2>Standards</h2>
    <p>All our designs are coded using the latest HTML5 and CSS3 standards.  
    This gives the most modern feature including animations and shadows and 
    degrade nicely for people on older legacy web browsers.
    This way everyone get the best possible experience.
    </p>
    <p>Cloud hosting, speedy delivery.</p>
  </div>
  
  <div class="span8 box end"><h2>Openness</h2>
    <p>Have it on your own domain</p>
    <p>Use our Api</p>
    <p>Import and export between facebook, flickr, etc</p>
    <p>Export and download your photos anytime, and feel safe that we always have a back up</p>
  </div>
</div>

<div class="row">
  <div class="span4 box"><h2>Facebook</h2>
  </div>
  
  <div class="span4 box"><h2>Twitter</h2></div>
  <div class="span4 box"><h2>Paypal</h2></div>
  <div class="span4 box"><h2>Other</h2></div>
</div>

<a class="wisp">+</a>
