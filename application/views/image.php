<h1><?php echo $image->name; ?>(<?php echo $image->id; ?>)</h1>
 <img style="float:left;" src="/images/dynamic/<?php echo $image->filehash;?>/500x500xfit.jpg" alt="image <?php echo $image->name; ?> preview" />
 <?php if ($image->albums->find()->cart) : ?>
	<a class="minibutton" href="/<?php echo Request::current()->uri(array('controller'=>'buy','action'=>'image','id'=>$image->id));?>/">
		<span class="buy">Buy me</span>
	</a>
 <?php endif; ?>
 <?php echo $image->name; ?> (<?php echo $image->id; ?>)
 This image has been viewed <?php echo $image->views;?> 
 times since <?php echo Date::formatted_time($image->taken,'D jS F Y');?> 
 <a href="/user/favorite/add/<?php echo $image->id?>">
 	add to favourite
 </a> 
 (<?php echo $image->favorite->count_all(); ?> times)

 <h4>comments</h4>
 <ul>
  <?php
  $comments=$image->comments->where('approved','=','1')->find_all();
  foreach($comments as $comment) : ?>
    <li> 
  	   <?php echo $comment->comment; ?>
    </li>
  <?php endforeach; ?>
</ul>

<?php echo Form::open( Request::current()->uri( array('action'=>'add_comment') ) ); ?>
  <?php echo helpers::render_form($image->comments->list_columns(),false,false,'comment');?>
  <input type="submit" name="action" value="Add comment"
<?php echo Form::close(); ?>

<ul style='clear:both;'>

<?php if ($previous) : $image=$previous; ?>
  <li style='float:left;'> 
  	<a href="/<?php echo Request::current()->uri(array('id'=>$image->id,'action'=>false));?>">
      <img src="/images/dynamic/<?php echo $image->filehash;?>/50x50xcrop.jpg" alt="image <?php echo $image->name; ?> preview" />
      Previous image<?php echo $image->name; ?> (<?php echo $image->id; ?>) 
  	</a>
  </li>
<?php endif; ?> 

<?php if ($next) : $image=$next;?>
  <li style='float:right;'> 
  	<a href="/<?php echo Request::current()->uri(array('id'=>$image->id,'action'=>false));?>" title="<?php echo $image->name; ?>">
  	Next image<?php echo $image->name; ?> (<?php echo $image->id; ?>)
      <img src="/images/dynamic/<?php echo $image->filehash;?>/50x50xcrop.jpg" alt="image <?php echo $image->name; ?> preview" />
  	  
  	</a>
  </li>
<?php endif; ?>  
 
</ul>

<p>
  Back to the album 
  <a class='minibutton' href="<?php echo Route::url($album->id);?>">
    <span>
      <?php echo $album->name ?>
    </span>
  </a>
</p>
