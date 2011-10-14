<form method="post">
  <table>
    <tr>
      <th>Domain</th>
      <th>Start page</th>
      <th>Theme</th>
      <th>Live</th>
      <th></th>
    </tr>
    <?php foreach ($domains as $domain) : ?>
      <?php if($domain->id==$edit) : ?>
        <tr>
          <td><?php echo Form::render($columns,$data,$errors,'name'); ?></td>
          <td><?php echo Form::render($columns,$data,$errors,'node_id'); ?></td>
          <td><?php echo Form::render($columns,$data,$errors,'theme_id'); ?></td>
          <td><?php echo Form::render($columns,$data,$errors,'published'); ?></td>
          <td>
            <button type="submit" class="button">Save changes</button>
            <a href="<?php echo Request::initial()->url(array('id'=>'','action'=>'')); ?>" class="button">Cancel</a>
          </td>
        </tr> 
      <?php else: ?>
        <tr>
          <td><?php echo $domain->name; ?></td>
          <td><?php echo $domain->node->name; ?></td>
          <td><?php echo $domain->theme->name; ?></td>      
          <td><?php echo $domain->published?'Active':'Offline'; ?></td>
          <td>
            <?php if(!$domain->system) : ?>
              <a href="<?php echo Request::initial()->url(array('id'=>$domain->id,'action'=>'edit')); ?>" class="button">Edit</a>
              <a href="<?php echo Request::initial()->url(array('id'=>$domain->id,'action'=>'delete')); ?>" class="button">Remove</a>
            <?php endif; ?>
            </td>
        </tr> 
      <?php endif; ?>  
    <?php endforeach; ?>
    <?php if(!$edit) : ?>
       <tr>
          <td><?php echo Form::render($columns,$data,$errors,'name'); ?></td>
          <td><?php echo Form::render($columns,$data,$errors,'node_id'); ?></td>
          <td><?php echo Form::render($columns,$data,$errors,'theme_id'); ?></td>
          <td><?php echo Form::render($columns,$data,$errors,'published'); ?></td>
          <td><button type="submit" class="button">Add new</button></td>
       </tr> 
    <?php endif; ?>
  </table>
</form>