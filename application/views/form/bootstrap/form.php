<?php echo $this->open(); ?>
	<?php if ($legend = $this->get('legend')): ?>
		<legend><?php echo $legend; ?></legend>
	<?php endif; ?>
	<?php if ($error = $this->error() AND $error !== TRUE): ?>
		<span class="error-message"><?php echo $this->error(); ?></span>
	<?php endif; ?>
	<?php foreach ($this->fields() as $_field): ?>
		<?php echo $_field->render(); ?>
	<?php endforeach; ?>
<?php echo $this->close(); ?>