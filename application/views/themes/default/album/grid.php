  <div class="media-grid grid" <?php echo $data; ?>>
    <?php foreach ($images as $key=>$image) : ?>
      <a href="<?php echo Route::url($image->album_id, array('controller'=>'image','id'=>$image->id)); ?>">
         <img src="<?php echo url::image($image,100,100,'crop'); ?>" alt="image <?php echo $image->name; ?> preview" />
      </a>
     <?php endforeach ;?> 
  </div>
  <p class="details"><?php echo $details; ?></p>
  
  
  
<style>

 .slider-target {position:relative;}
 
 .slider-target .slider {display:block; overflow:hidden;}
 
 .slider,
 .slider-overlay {
   
   top:0;
   left:0;
   width:100%;
   height:100%;
 }

.slider {
   z-index:1000;display:none; 
   position:absolute; 
   background-color:black;
   -webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-o-user-select: none;
user-select: none;

}
.slider-overlay {z-index:999; background-color:red; opacity:0.6; position:fixed;}
 

.slider .slider-control {position:absolute; text-align:center; width:100%; height:100%; top:0;}





.pull-left{float:left; margin-right:10px;}
.pull-right{float:right; margin-left:10px;}

.slider-timer b {display:block; width:0; height:20px; background-color:rgba(255,255,255,.5);  text-align:right; border-right:1px solid white;}
.slider-timer span {display:none; color:white;  }

.slider-timer {height:2px; overflow:hidden; background-color:rgba(0,0,0,.5); 
-webkit-box-shadow:1px 1px 3px rgba(0,0,0,0.5); 
box-shadow:1px 1px 3px rgba(0,0,0,0.5); 
  margin-left:-1px;
}

.slider-control.active .slider-timer span {display:inline; position:absolute; right:4px;}
.slider-control-bottom {position:absolute; bottom:0; width:100%;}

.slider-timer-end b {width:100%;}

.slider-control-center {position:absolute; top:50%; margin-bottom:2%; width:100%;}

.slider-ui { display:none; }
.slider-control.active .slider-ui, .slider-ui.active {display:block;}


body.slider-target .slider{ position:fixed; border-width:0;}
body.slider-target .slider-overlay{display:none;}

.slider-title {float:left;;background-color:rgba(0,0,0,.5); padding:4px; color:white;}

.slider-image {position:absolute; top:0; left:0;}


.slider-control-bottom { padding:6px 0;}
.slider-control-bottom .slider-ui:firstChild {margin-right:6px}

.slider-control.active .animate {opacity:1;}

.slider-control.active .slider-control-bottom .animate {position:relative; top:0;}
.slider-control .slider-control-bottom .animate {position:relative; top:50px;}

.slider-thumbnails {position:absolute; height:100%; top:0%; padding:0 20px; margin:0px; auto; overflow:auto; background-color:rgba(0,0,0,0.5); color:white; }
.slider-thumbnail  { width:80px; height:80px; float:left; }
.slider-thumbnail img {width:100%; border:1px solid #ccc; padding:5px; background-color:white;}
.slider-thumbnail img {
    -moz-transition: all 0.2s linear 0s;
    -webkit-transition: all 0.2s linear 0s;
    
    -moz-transform:scale(0.75);
	   -webkit-transform:scale(0.75);
	   
}

.slider-thumbnail:hover img { 
     -moz-transform:scale(1);
	   -webkit-transform:scale(1);
	   z-index:5000;
	   position:relative;
	   box-shadow:0 1px 1px rgba(0, 0, 0, 0.5);
	   
	   -webkit-box-shadow:0 1px 6px rgba(0, 0, 100, 0.7);
}



.slider-ui, .slider-ui-disable {
    -moz-border-bottom-colors: none;
    -moz-border-image: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    -moz-transition: all 0.1s linear 0s;
    background-color: #E6E6E6;
    background-image: -moz-linear-gradient(center top , #FFFFFF, #FFFFFF 25%, #E6E6E6);
    background-repeat: no-repeat;
    border-color: #CCCCCC #CCCCCC #BBBBBB;
    border-radius: 20px;
    border-style: solid;
    border-width: 1px;
    box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset, 0 1px 2px rgba(0, 0, 0, 0.05);
    color: #333333;
    cursor: pointer;
    display: inline-block;
    font-size: 13px;
    line-height: normal;
    padding: 4px 8px 3px;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    text-decoration:none;
  }

.slider-ui:hover {
    background-position: 0 -15px;
    color: #333333;
    text-decoration: none;  
}

.slider-ui-disable {
    opacity:0.3;
    cursor:default;  
}

.slider-ui.on, .slider-ui:active, .slider-ui-disable.on {
   background-color: #0064CD;
    background-image: -moz-linear-gradient(center top , #049CDB, #0064CD);
    background-repeat: repeat-x;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    color: #000000;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
}

.slider-ui.previous {padding:20px 10px 16px; border-radius:0 40px 40px 0; position:relative; top:-20px; left:-8px}
.slider-ui.next {padding:20px 10px 16px; border-radius:40px 0 0 40px; position:relative; top:-20px;left:8px}

.slider-ui.previous:hover {left:0}
.slider-ui.next:hover {left:0}




/*ANIMATION  */
.slider-title {
    -moz-transition: all 0.6s linear 0s;
    -webkit-transition: all 0.6s linear 0s;
    height:0;
    padding:0;
    width:0;
    
    width:100%;

    overflow:hidden;
    color:transparent;
}

.slider-title.active {
    height:auto;
    width:100%;
    padding:6px 10px;
    color:white;
}

.slider-ui {
    -moz-transition: opacity 1s linear 0s;
    -webkit-transition: opacity 1s linear 0s;
    opacity:0
}

.slider-control.active .slider-ui, .slider-ui.active {
   -moz-transition: all 0.3s linear 0s;
   -webkit-transition: all 0.3s linear 0s;
   opacity:1
}


.slider-control .slider-timer {
   -moz-transition: all 0.6s linear 0s;
   -webkit-transition: all 0.6s linear 0s;
    height:2px;
    opacity:0;
    display:none;
}

.slider.playing .slider-control .slider-timer{
    opacity:1;
    display:block;
}

.slider-control.active .slider-timer {
 -moz-transition: all 0.3s linear 0s;
   -webkit-transition: all 0.3s linear 0s;
  height:20px;

}

.slider-ui.play {float:right; margin-right:12px}

.aslider-loading span {
    
    background:url('/assets/images/spinner.gif') white no-repeat 10px center;
    display:block;
    -moz-box-shadow:1px 1px 3px rgba(0,0,0,0.5);
    border:1px solid #333;
    border-radius:5px;
  }

  
.slider-loading {
    background:url('/assets/images/spinner.gif') rgba(255,255,255,0.5) no-repeat center center;
}



</style>