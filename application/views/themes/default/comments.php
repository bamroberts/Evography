<?php if (Request::initial()->controller()!='collection') echo $pagination->render(); ?>
  <?php foreach ($comments as $comment): ?>
    <div id="comment_<?php echo $comment->id ?>" class="comment clearfix">
     <div class='top'>
     <span class='head'>
       <?php if($comment->source=='facebook') : ?>
          <!--<a class='button' href="<?php echo $comment->user->facebook->link; ?>" target="_blank">F:</a> -->
          <?php echo $comment->user->facebook->name; ?>
        <?php else : ?>
          <?php echo $comment->user->name ?>
        <?php endif; ?>
      </span>
      </div>
      <div class="body">       
      <span class='avatar'>  
          <?php if($comment->source=='facebook') : ?>
            <a href="<?php echo $comment->user->facebook->link; ?>" target="_blank">
              <img src="<?php echo str_replace('_q','_s',$comment->user->facebook->picture); ?>" alt="Image of <?php echo $comment->user->username; ?>" />
            </a>
          <?php else: ?>
              <?php $default=''; ?>
              <?php $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $comment->user->email ) ) ) . "?d=mm" . urlencode( $default ) ."&size=100";?>
              <img class="fleft" src="<?php echo $grav_url; ?>" alt="Image of <?php echo $comment->user->username; ?>" />
              <!-- or openImg or Dummy -->
          <?php endif; ?>
        </span>

         <blockquote>
              <span><?php echo $comment->message ?></span>            
          </blockquote>     
      </div> 
       <div class="head clearfix"> 
        <p class="signoff ">
        
<span><?php echo date::formatted_time($comment->add_date,'D jS F Y'); ?></span></p> 
      </div>
    </div>
  <?php endforeach ?>
  <?php if (Request::initial()->controller()!='collection') echo $pagination->render(); ?>
  <?php $_REQUEST['comment_count']=$pagination->details();?>  