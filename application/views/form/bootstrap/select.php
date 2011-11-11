<?php echo $open; ?>
	<label<?php if ($id = $this->attr('id')) echo ' for="'.$id.'"'; ?>>
		<?php echo $label; ?>
  </label>
		<div class="input">
			<?php if ($this->editable() === TRUE): ?>
				<?php echo $this->open(); ?>
					<option value=""></option>
					<?php foreach ($this->_field->get('options') as $key => $value): ?>
					<?php if (is_array($value)): ?>
						<optgroup label="<?php echo $key?>">
						<?php foreach ($value as $_key => $_value): ?>
							<option<?php echo HTML::attributes($this->get_option_attr('select', $_key)); ?>><?php echo $this->option_label($_value); ?></option>
						<?php endforeach; ?>
						</optgroup>
					<?php else: ?>
						<option<?php echo HTML::attributes($this->get_option_attr('select', $key)); ?>><?php echo $this->option_label($value); ?></option>
					<?php endif; ?>
					<?php endforeach; ?>
				<?php echo $this->close(); ?>
			<?php else: ?>
				<strong><?php echo $this->val(); ?></strong>
			<?php endif; ?>
		</div>
	<?php echo $message; ?>
<?php echo $close; ?>