<h2><i style="color:#333; font-size:70%; display:block; line-height:50%;"><?php echo ucwords($collection->type); ?>: </i><?php echo $collection->name; ?></h2>
<style>
nav.sections {border-style: solid; border-color: #333; border-width:1px 0;}
nav.sections li {border-width: 0 1px 1px 1px; border-bottom-color: #333; border-bottom-style: solid;}
nav.sections li a {padding:20px 10px; display: block; background-color:black;}
nav.sections li.active a {padding:20px 10px; background-color:#31A2FF; color:white;}

nav.vertical li {float:none;}


</style>

<?php $sections=array('Summary'=>'index','Details'=>'edit','Cover'=>'cover','Style'=>'style','Access'=>'password','Watermarks'=>'watermark','Cart'=>'shopping',); 
if (Request::initial()->action()=='add'){
  $sections=array('Create new'=>'add');
}
?>

<section class="row album">
  <nav class="span3 sections vertical">
    <ul>
    <?php foreach ($sections as $name=>$action) : ?>
      <li class="<?php echo (Request::initial()->action()==$action)?'active':false ; ?>">
        <a href="<?php echo Request::initial()->url(array('action'=>$action)); ?>"><?php echo $name; ?></a>
      </li>
    <?php endforeach; ?>
    </ul>
  </nav>
  <article class="span11">
   <?php echo $content; ?>
  </article>
</section>

