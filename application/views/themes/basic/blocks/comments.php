<div class="media-grid comment">
  <?php foreach ($comments as $comment): ?>
  <blockquote id="comment_<?php echo $comment->id ?>">
    <span class="avatar pull-left">  
          <?php if($comment->source=='facebook') : ?>
          <!--  <a href="<?php echo $comment->user->facebook->link; ?>" target="_blank"> -->
              <img src="<?php echo str_replace('_q','_s',$comment->user->facebook->picture); ?>" alt="Image of <?php echo $comment->user->username; ?>" />
            <!-- </a>  -->
          <?php else: ?>
              <?php $default=''; ?>
              <?php $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $comment->user->email ) ) ) . "?d=mm" . urlencode( $default ) ."&size=100";?>
              <img src="<?php echo $grav_url; ?>" alt="Image of <?php echo $comment->user->username; ?>" />
              <!-- or openImg or Dummy -->
          <?php endif; ?>
    </span>
    <p><?php echo $comment->message ?></p>
    <small class="clear">
        <?php if($comment->source=='facebook') : ?>
          <!--<a class='button' href="<?php echo $comment->user->facebook->link; ?>" target="_blank">F:</a> -->
          <?php echo $comment->user->facebook->name; ?>
        <?php else : ?>
          <?php echo $comment->user->name ?>
        <?php endif; ?>
       <span>
        <?php echo date::formatted_time($comment->add_date,'D jS F Y'); ?>
       </span> 
  </small>
  </blockquote>
  <?php endforeach ?>
</div>