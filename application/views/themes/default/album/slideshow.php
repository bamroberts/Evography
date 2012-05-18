  <div data-slider="1" class="media-grid">  
  <?php foreach ($images as $key=>$image) : ?>
    <article data-page="<?php echo $key; ?>" style="float:left;">
      <a href="<?php echo Request::current()->url(array('controller'=>'image','id'=>$image->id)); ?>">
       <img src="<?php echo url::image($image->ext,$image->filehash,1024,768,'fit'); ?>" alt="image <?php echo $image->name; ?> preview" class="media" style="height:100%;" />
      </a>
    </article>
  <?php endforeach; ?>
  </div>
  <p class="details"><?php echo $details; ?></p>
  
  <script>
    $('[data-slideshow]').each(function(){
      var $this    =  $(this).addClass('slideshow');
      var $wrapper =  $($this.wrapInner('<div class="wrapper"></div>').find('.wrapper').first());
      var $slider =   $($wrapper.wrapInner('<div class="slider"></div>').find('.slider').first());
      var $items   =  $this.find('article');
      var width    =  $this.outerWidth();
      var height   =  $($items[0]).outerHeight();
      var page=1
      
      
      console.log('item width ' + width);
      console.log('total width ' + width * $items.length);
      
      console.log('height ' + height);
      
      $wrapper.css('overflow','hidden').css('width',width)
      $slider.css("width",width * $items.length).css('height',height);
      $items.css("width",width).css('height',height);
      
      $this.append('<a href="#'+($items.length)+'" class="previous">previous</a>')
      $this.append('<a href="#'+(page+1)+'" class="next">next</a>')
      $this.append('<a href="javascript::void()" class="fullscreen">fullscreen</a>')
      
    
      
      
      $this.find('a.fullscreen').click(function(){
        $clone=$( $this.clone() );
        
        $clone
          .css('position','absolute')
          .css('top','0')
          .css('left','0')
          .css('width','100%')
          .css('height','100%')
          ;
        //var $items   =  $this.find('article').css();
        $clone.appendTo('body');
      })
      
     
      $this.find('a.next').click(function(){
        
        console.log('page: ' + page) 
        page++;
        if (page>$items.length) page=0;
        
        $(this).attr('href','#'+ (page+1))
        
        console.log('page: ' + page)
        
        left =  width * page;
        console.log('scroll to: ' + left)
  
        if (page>$items.length) page=0;
        console.log('page: ' + page) 
        
        $wrapper.animate({
                scrollLeft : left
            }, 500);
      
      })
       $this.find('a.previous').click(function(){
        page--;
        if (page<0) page=$items.length+1;
        
        $(this).attr('href','#'+ (page-1))
        
        console.log('page: ' + page)
           
        left =  width * page;
        console.log('scroll to: ' + left)
        
       
        $wrapper.animate({
                scrollLeft : left
            }, 500);
      
      })            
    })
  </script>
  <style>
  .slideshow {position: relative;}
  .slideshow .next:hover, .slideshow .previous:hover {background-color:rgba(255,255,255,0.6);}  
  .slideshow .next {position:absolute; top:50%; right:20px;}
  .slideshow .previous {position:absolute; top:50%; left:20px;}
  </style>