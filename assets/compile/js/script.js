/* Author: 


*/
     QueryLoader.overlay=false;
     QueryLoader.selectorPreload = '.container';
     //QueryLoader.init();

$('[data-drag]').polaroid();
//Re write this as a class; repeat, speed, start, stop, unload, shuffle etc. 
$('[data-dra]').each(function(){
    $el=$(this)
    
    $el.delegate('a', 'mouseover', function(){  
      if ($(this).data('drag') || $(this).is(':animated')) return;
      $(this).draggable({ containment: $(this).parent('.media-grid'), scroll: false, stack: $(this).parent('.media-grid').find('a') });
      $(this).data('drag',true);
    })
    
    if ($el.is('[data-drag-rain]')) {
      var images=$el.find('a').hide();
      
      var time=1500
      var i = 0
      function display(){
        var image=images[i++];
        $(image).css({'z-index': i})
         // .fadeOut(600)
          .animate({scale: '10',roation:'0deg', opacity:'0'}, {duration: 0})
          .show()
          .animate({scale: '1',roation:'-40deg', opacity:'1'}, {duration: 1000, easing:'swing'});
       // $(image).find('img').fadeIn(15000);
         
        var Rand = time - Math.floor(Math.random()*750);
        if (i<images.length){wait = setTimeout(display, Rand);}
       //else {i=0; time=time*5; wait = setTimeout(display, Rand*5)} 
        //$(image).addClass( "fall", 0 ).show();
        //$(image).removeClass( "fall", 1000 ).find('img').fadeIn(5000);;
      };
      
      display();
    }
    
});
/*

$('[data-photobook]').each(function(){
    $el=$(this);
    pages=$el.data('photobook');
    
    //alert(pages);
    
   // $el.data('next',{img: 40,20,30,'50' });
    ;
    
    //alert ($el.data('next'));
    
   // return;
    flippingBook.pages=pages//.split(',');
     //alert(book.pages);
// define custom book settings here
flippingBook.settings.bookWidth  = $el.width() || '800';
flippingBook.settings.bookHeight = $el.height() || '500';
flippingBook.settings.preserveProportions = true;
flippingBook.settings.pageBackgroundColor = rgb2hex($el.parent('section').css('color')||'rgb(0,0,0)');
flippingBook.settings.backgroundColor     = rgb2hex($el.parent('section').css('background-color')||'rgb(255,255,255)');
flippingBook.settings.zoomUIColor = 0x919d6c;
flippingBook.settings.useCustomCursors = false;
flippingBook.settings.dropShadowEnabled = false,
flippingBook.settings.zoomImageWidth = 992;
flippingBook.settings.zoomImageHeight = 1403;
//flippingBook.settings.flipSound = "sounds/02.mp3";
flippingBook.settings.flipCornerStyle = "first page only";
flippingBook.settings.zoomHintEnabled = true;


// default settings can be found in the flippingbook.js file
flippingBook.create();

});
*/

     


/*


function rgb2hex(rgb){
 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
 return "0x" +
  ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
  ("0" + parseInt(rgb[3],10).toString(16)).slice(-2);
}
*/


  
 // $(function () {
      $("[data-lightbox]").lightbox();
      $("[data-fade]").fadeImages();
      $("[data-paginate]").pagination();
      
//  });
  
//alert($("[data-fade]").length);

/*

$.fn.slideshow = function( options ) {
    //alert($(this).html);
    //$(this).data('fade', new Paginate( this, options ))
    options=$(this).data('slideshow');
    $(this).data('slideshow', new Slideshow( this, options ))
    return this;
  }



$("[data-slideshow]").slideshow()


*/
$('[data-slider]').each(function(i, instance){
    // myOptions = {};
      instance=$(instance)
      myOptions.data=instance.data('slider-data')+'?current[limit]=0';
      var slideshow=instance.slider(myOptions)
      instance.find('img').click(function(e){
        e.preventDefault();
        slideshow.data('slider').find('link', $(this).parents('a').first().attr('href'))
      })
  });









