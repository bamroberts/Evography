<style>
 
.rectangle-speech-border {
	position:relative; 
	padding:8px 8px; 
	margin:1em 0 3em;
	border:3px solid blue; 
	text-align:center; 
	color:#333;
	background:#fff; 
	/* css3 */
	-webkit-border-radius:8px;
	-moz-border-radius:8px;
	border-radius:8px;
	float:right;
}

/* creates larger curve */
.rectangle-speech-border:before {
	content:""; 
	position:absolute; 
	z-index:10; 
	bottom:-12px; 
	left:10px; 
	width:20px; 
	height:10px;
	border-style:solid; 
	border-width:0 3px 3px 0; 
	border-color:blue; 
	background:transparent;
	/* css3 */
	-webkit-border-bottom-right-radius:80px 50px;
	-moz-border-radius-bottomright:80px 50px;
	border-bottom-right-radius:80px 50px;
    /* reduce the damage in FF3.0 */
    display:block; 
}

/* creates smaller curve */
.rectangle-speech-border:after {
	content:""; 
	position:absolute; 
	z-index:10; 
	bottom:-12px; 
	left:10px; 
	width:10px; 
	height:20px; 
	border-style:solid; 
	border-width:0 3px 3px 0; 
	border-color:blue; 
	background:transparent;
	/* css3 */
	-webkit-border-bottom-right-radius:40px 50px; 
	-moz-border-radius-bottomright:40px 50px; 
	border-bottom-right-radius:40px 50px; 
    /* reduce the damage in FF3.0 */
    display:block; 
}

/* creates a small circle to produce a rounded point where the two curves meet */
.rectangle-speech-border > :first-child:before {
	content:""; 
	position:absolute; 
	bottom:-40px; 
	left:45px; 
	width:10px; 
	height:10px;
	background:#5a8f00;
	/* css3 */
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
	border-radius:10px;
}

/* creates a white rectangle to cover part of the oval border*/
.rectangle-speech-border > :first-child:after {
	content:""; 
	position:absolute; 
	bottom:-10px; 
	left:76px; 
	width:24px; 
	height:15px; 
	background:#fff;
}</style>

<section id="node_<?php echo $album->id; ?>" class="well">
  <header>  
    <?php if (true) : ?>
      <?php echo facebook::like(Route::URL($album->id)); ?>
    <?php endif; ?>
    
      <a href="#" class="rectangle-speech-border"><span>113</span></a>
    <?php echo $pagination->render(); ?>
  </header>
  <div class="media">
    <?php echo $media ?> 
  </div>
  <footer>
    <?php echo $pagination->render(); ?>
  </footer>
</section>

