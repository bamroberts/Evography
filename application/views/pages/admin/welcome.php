<h2>Congratulation!  Your new account has been created </h2>
<p>You can use this page to help you get started, or if you know what you're doing you can go strait to  the 
  <a href="<?php Helpers::URL(array('action'=>'')); ?>">
    control panel
  </a>
</p>
<ul>
    <li>
      <h3>Step 1</h3>
      Update a few key user details
      <?php if ($step==1) echo $content; ?>
      <?php if ($step>1) echo '[COMPLETE]' ?>
    </li>
    <li>
      <h3>Step 2</h3>
      Create your first album
      <?php if ($step==2) echo $content; ?>
      <?php if ($step>2) echo '[COMPLETE]' ?>
    </li>
    <li>
      <h3>Step 3</h3>
      Upload some images
      <?php if ($step==3) echo $content; ?>
      <?php if ($step>3) echo '[COMPLETE]' ?>
    </li>
    <li>
      <h3>Step 4</h3>
      Go check it out
      <?php if ($step==4) echo $content; ?>
    </li>
</ul>