<style>
 .image_select li {list-style: none; position:relative; float:left; padding:2px; height:140px; width:130px; margin-left:0; margin-right: 30px;}
 .image_select li img {padding:5px;border:1px solid #000; background:#fff;}
 .image_select li input {position: absolute; top:5px; left:5px; width:auto; z-index: 20;}
 fieldset div {display: inline-block;}
 fieldset {float:none;}
 .image_select label {display: none;}
 .image_select li label {display: block;}
 
 #fb_album div.select {display:inline-block}
 .head {margin-left:20px;}
 .head img {border:1px solid #414141; padding:2px; background: white; margin-right: 10px;}
 button, {margin-left:20px;}
</style>
<section id="facebook">
  <h4>From Facebook</h4>
  <div class="row">
    
    <div class="span4">
       <img src="<?php echo $user->picture; ?>" class="media" />
       <p>
        <?php echo $user->name; ?>
       </p>
    </div> 
    
    <?php echo $albums; ?>
    
  </div>  

  <?php echo $images; ?>
   
</section>

<script>
$("[data-control]").each(function(){
  var $this=$(this);
  $this.prepend('<label><input type="checkbox" name="all" data-checkbox="" /> Check all / none');
  $this.find('[data-checkbox]').change(function () {
            if ($(this).attr('checked')) {
              $this.find('div.group input:checkbox').attr('checked',true);
            } 
            else {  
              $this.find('div.group input:checkbox').removeAttr('checked');
            }
                            
        });
})
</script>