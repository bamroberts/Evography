<style>
 
.rectangle-speech-border {
	position:relative; 
	padding:8px 8px; 
	margin:1em 0 3em;
	border:3px solid #0069D6; 
	text-align:center; 
	color:#333;
	background:#C7EEFE; 
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
	bottom:-14px; 
	left:10px; 
	width:20px; 
	height:10px;
	border-style:solid; 
	border-width:0 3px 3px 0; 
	border-color:#0069D6; 
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
	bottom:-13px; 
	left:10px; 
	width:10px; 
	height:10px; 
	border-style:solid; 
	border-width:0 3px 3px 0; 
	border-color:#0069D6; 
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
	bottom:-14px; 
	left:7px; 
	width:8px; 
	height:10px;
	background:black;
	/* css3 */
	-webkit-border-radius:10px;
	-moz-border-radius:10px;
	border-radius:10px;
	z-index:20;
}

/* creates a white rectangle to cover part of the oval border*/
.rectangle-speech-border > :first-child:after {
	content:""; 
	position:absolute; 
	bottom:-9px; 
	left:20px; 
	width:9px; 
	height:10px; 
	background:#C7EEFE;
}</style>

<section id="node_<?php echo $album->id; ?>" class="album">
  <header>  
    <?php if (true) : ?>
      <?php echo facebook::like(Route::URL($album->id)); ?>
    <?php endif; ?>
    <?php if($comments) : ?>
      <a href="#comments" class="rectangle-speech-border"><span><?php echo $comment_count; ?></span></a>  
    <?php endif; ?>    
      
    <?php echo $pagination->render(); ?>
  </header>
  <div class="media">
    <?php echo $media ?> 
  </div>
  <footer>
    <?php echo $pagination->details(); ?>
  </footer>
</section>

<?php if($comments) : ?>
  <section id="node_<?php echo $album->id; ?>_comments" class="comments">
      <h4>Comments</h4>
      <?php echo $comments; ?>
  </section>
<?php endif; ?>

<?php if(false && $upload) : ?>
  <section id="upload_<?php echo $album->id; ?>_comments" class="upload">
      <h4>Upload</h4>
      <?php echo $upload; ?>
  </section>
<?php endif; ?>

