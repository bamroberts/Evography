<?php $count=0;?>

<div class="links"> 
  <?php foreach ($pages as $page ) :?>
    <?php if($count++) echo '|' ?>
    <?php if($page['selected']) : ?>
     <b><?php echo $page['name']; ?></b>
    <?php else : ?>
    <a href="<?php echo $page['link']; ?>" >
      <?php echo $page['name']; ?>
    </a>
    <?php endif; ?>
  <?php endforeach ;?>
</div>