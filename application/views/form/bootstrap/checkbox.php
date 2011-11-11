<?php echo $open; ?>
	<label<?php if ($id = $this->attr('id')) echo ' for="'.$id.'"'; ?>><?php echo $label; ?></label>
		<div class="input">
	   <ul class="inputs-list">
			<li class="checkbox">
				<label <?php if ($id = $this->attr('id')) echo ' for="'.$id.'"'; ?>><?php echo $label; ?>>
				  <?php echo $this->html(); ?>
				  <?php if($msg=$this->get('placeholder')) : ?>
				    <span><?php echo $msg; ?></span>
				  <?php endif; ?>		  
				</label>
			</li>
	   </ul>
	 </div>
	 <?php echo $message; ?>
<?php echo $close; ?>