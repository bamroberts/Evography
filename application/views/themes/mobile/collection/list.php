<ul data-role="listview">
   <?php foreach ($children as $key=>$child): ?>
   <?php if (!$child->published) continue; ?>
	   <li>
	     <a href="<?php echo Route::url($child->id); ?>">
	       <img src="<?php echo URL::image($child->cover,80,80,'crop'); ?>" alt="Cover for <?php echo $child->type; ?>">
	       <h2><?php echo $child->name; ?></h2>
	       <p><strong><?php echo ucwords($child->type); ?></strong> <?php echo $child->desc; ?></p>
	       <span class="ui-li-aside"></span>
	       <span class="ui-li-count">
	         <?php switch($child->type) {
	            case 'gallery': 
	            case 'collection':
	             echo $child->children->count();
	             break; 
	            case 'guestbook':
	             echo $child->comment->count_all();
	             break;
	            default:
	             echo $child->images->count_all();
	            break;
	           }; 
	         ?>
	       </span>
	     </a>
	   </li>
	  <?php endforeach; ?>
</ul>
