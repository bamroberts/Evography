<?php foreach ($messages as $message): ?>
<div class="alert-message <?php echo $message['type'] ?>">
        <a href="#" class="close">x</a>
        <p><?php echo $message['text'] ?></p>
</div>
<?php endforeach; ?>