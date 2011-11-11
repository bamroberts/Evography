<?php echo $open; ?>
	<label <?php if ($id = $this->attr('id')) echo ' for="'.$id.'"'; ?>>
		<?php echo $label; ?>
	</label>	
		<div class="input">
			<?php if ($this->editable() === TRUE): ?>
				<?php echo $this->html(); ?>
			<?php else: ?>
				<b><?php echo $this->val(); ?></b>
			<?php endif; ?>
    	<?php echo $message; ?>
		</div>
<?php echo $close; ?>