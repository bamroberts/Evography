<ul id="subnav">
  <?php foreach ($pages as $page ) :?>
  <li<?php if($page['selected']) echo ' class="selected"'; ?>>
    <a href="<?php echo $page['link']; ?>" >
      <?php echo $page['name']; ?>
    </a>
  </li>
  <?php endforeach ;?>
</ul>
         