<style>
nav.sections {border-style: solid; border-color: #333; border-width:1px 0;}
nav.sections li {border-width: 0 1px 1px 1px; border-bottom-color: #333; border-bottom-style: solid;}
nav.sections li a {padding:20px 10px; display: block; background-color:black;}
nav.sections li.active a {padding:20px 10px; background-color:#31A2FF; color:white;}

nav.vertical li {float:none;}
</style>

<?php $sections=array('Overview'=>'index','Contact Details'=>'edit','Payment'=>'payment','Domains'=>'domains',);
if (Request::initial()->action()=='add'){
  $sections=array('Create new'=>'add');
}
 ?>
 
<section class="row album">
  <nav class="span3 sections vertical">
    <ul>
    <?php foreach ($sections as $name=>$action) : ?>
      <li class="<?php echo (Request::initial()->action()==$action)?'active':false ; ?>">
        <a href="<?php echo Route::url('admin',array('controller'=>Request::initial()->controller(),'action'=>$action)); ?>"><?php echo $name; ?></a>
      </li>
    <?php endforeach; ?>
    </ul>
  </nav>
  <article class="span11">
   <?php echo $content; ?>
  </article>
</section>
