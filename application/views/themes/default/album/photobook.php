<div class="book-frame">
  <div class="book" <?php echo $data; ?> >
    <?php foreach ($images as $key=>$image) : ?>
  	<table class="wrapper left">
        <tr>
           <td>
             <a href="<?php echo Route::url($image->album_id,array('controller'=>'image','id'=>$image->id)); ?>">
          	   <img src="/images/dynamic/<?php echo $image->filehash;?>/450x380xfit.<?php echo $image->ext; ?>" alt="image <?php echo $image->name; ?> preview" />  
          	 </a>  
           </td>
        </tr>
     </table>
    <?php endforeach; ?>
  </div>
  <b class="next">next</b>
</div>


<script src="/assets/vendor/turn/turn.js"></script>

<style>

.book-frame {border:4px solid #333;}

.book {
	height:400px;
}


.book .turn-page{
	width:400px;
	height:400px;
	background-color:#666;
  text-align: center;
}


 .book .side1 {
  background-image: -moz-linear-gradient(left,
    rgba(125, 125, 125, 0.7) 0%, rgba(125, 125, 125, 0) 5%
  );
  background-image: -webkit-linear-gradient(left,
    rgba(125, 125, 125, 0.7) 0%, rgba(125, 125, 125, 0) 5%
  );
  border-left:1px solid black;
}

 .book .side0 {
  background-image: -moz-linear-gradient(right,
    rgba(125, 125, 125, 0.7) 0%, rgba(125, 125, 125, 0) 5%
  );
  background-image: -webkit-linear-gradient(right,
    rgba(125, 125, 125, 0.7) 0%, rgba(125, 125, 125, 0) 5%
  );

}

.book img {max-width:100%; max-height:100%; border:2px solid black;}

.wrapper {
   height:100%;
   width: 100%;
   margin: 0;
   padding: 0;
   border: 0;
}
.wrapper td {
   vertical-align: middle;
   text-align: center;
}
</style>

<script>
  $('[data-photobook]').turn({
							display: 'double',
							acceleration: true,
							gradients: !$.isTouch,
							elevation:50,
							inclination:1,
							when: {
								turned: function(e, page) {
								  if ($(this).turn('view')[0]==0) {
								   $(this).animate({'margin-left':'-25%'});
								  } else if ($(this).turn('view')[1]==0 ){
								   $(this).animate({'margin-left':'25%'});
								  } else {
								   $(this).animate({'margin-left':'0%'});
								  }
									console.log('Current view: ', $(this).turn('view') );
								}
							}
							//set time out to add turn icons
							//play mode?
						});


	/*
$(window).bind('keydown', function(e){

		if (e.keyCode==37)
			$('[data-magazine]').turn('previous');
		else if (e.keyCode==39)
			$('[data-magazine]').turn('next');

	});
	
	
	for each $('[data-magazine]')
	var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();

    var elemTop = $(elem).offset().top;
    var elemBottom = elemTop + $(elem).height();

    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
*/

  
  
  $('.book-frame .next').click(function(e){
    $('[data-photobook]').turn('next');
  });
</script>


 