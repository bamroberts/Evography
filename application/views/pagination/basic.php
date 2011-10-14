<p class="pagination">
	<?php if ($first_page !== FALSE): ?>
		<a class='first text minibutton' href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="first"><span><?php echo __('First') ?></span></a>
	<?php else: ?>
		<span class='first text'><?php echo __('First') ?></span>
	<?php endif ?>

	<?php if ($previous_page !== FALSE): ?>
		<a class='previous text minibutton' href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="prev"><span><?php echo __('Previous') ?></span></a>
	<?php else: ?>
		<span class='previous text'><?php echo __('Previous') ?></span>
	<?php endif ?>

	<?php for ($i = 1; $i <= $total_pages; $i++): ?>

		<?php if ($i == $current_page): ?>
			<a class="current minibutton hover" href="#"><span><?php echo $i ?></span></a>
		<?php else: ?>
			<a class="minibutton" href="<?php echo HTML::chars($page->url($i)) ?>"><span><?php echo $i ?></span></a>
		<?php endif ?>

	<?php endfor ?>

	<?php if ($next_page !== FALSE): ?><a 
		<a class="next text minibutton" href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next"><span><?php echo __('Next') ?></span></a>
	<?php else: ?>
		<span class="next text"><?php echo __('Next') ?></span>
	<?php endif ?>

	<?php if ($last_page !== FALSE): ?>
		<a class="last text minibutton" href="<?php echo HTML::chars($page->url($last_page)) ?>" rel="last"><span><?php echo __('Last') ?></span></a>
	<?php else: ?>
		<span class="last text"><?php echo __('Last') ?></span>
	<?php endif ?>

</p><!-- .pagination -->