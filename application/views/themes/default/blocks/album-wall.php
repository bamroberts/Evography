<?php
  $image_x ='100';
  $image_y ='100';
 ?>

<style>
#viewport{
    width:900px;
    height:450px;
    position:relative;
    overflow:hidden;
    margin:0 auto;
    background:#111111  ;
}
 
#wall{
    z-index:1;
}
#wall div.tile div {padding:5px;}
#wall div .active {border:3px solid red;}
#wall div img {border-radius:25px; border: 1px solid #ccc}
.large {z-index:10; position:absolute; background-color:rgba(0,0,0,0.75); text-align: center; width:900px; height:450px;}
</style>

<!-- Viewport and Wall -->
<div id="viewport">
    <div id="wall"></div>
</div>
TODO add click through or light box, preload large, preload little, add auto-movemment when not in use
<!-- END Viewport and Wall -->

<?php echo HTML::script("assets/javascript/libs/wall.js", NULL, TRUE); ?>
<script>
var images = [
<?php foreach($images as $image): ?>
  <?php echo "\"/images/dynamic/{$image->filehash}/{$image_x}x{$image_y}xcrop.{$image->ext}\",";?>
<?php endforeach; ?>
];
</script>
<script>
// Define The Wall
var maxLength    = images.length -1 ; // Max Number images
var counterFluid = 0;
var wallFluid = new Wall("wall", {
                "draggable":true,
                "inertia":true,
                "width":<?php echo $image_x + 20; ?>,
                "height":<?php echo $image_y + 20 ; ?>,
                "rangex":[-100,100],
                "rangey":[-100,100],
                callOnUpdate: function(items){
                        items.each(function(e, i){
                            var a = new Element("div");
                                a.set("html", "click me" );
                                var i = new Element("img[src="+images[counterFluid]+"]");
                                i.inject(a).fade("hide").fade("in");
                                a.inject(e.node);
                                // Behaviour on click
                                i.addEvent("click", function(e){
                                    // Get Movement
                                    if( !wallFluid.getMovement() ){
                                        var l = new Element("div");
                                        var li = new Element("img[src="+this.src.replace("100x100xcrop",'900x450xfit')+"]");
                                        li.inject(l);
                                        //var l = new Element("img[src="+images[counterFluid].replace(/{$image_x}x{$image_y}xcrop/,'900x450xfit')+"]");
                                        l.addClass('large');
                                        l.addEvent("click", function(e){
                                          l.destroy()
                                        });
                                        l.inject(wallFluid.viewport);
                                    }
                                })
                                a.addEvent("mouseenter", function(e){                                        
                                        this.addClass('active');
                                })
                                a.addEvent("mouseleave", function(e){                                        
                                        this.removeClass('active');
                                })
                                counterFluid++;
                                // Reset counter
                                if( counterFluid > maxLength ) counterFluid = 0;
                        }.bind( this ))
                    }.bind( this )
            });
// Init Fluid Wall
wallFluid.initWall();
//pre load unloaded images

//wallFluid.moveTo( c, r );

function getRandom(min, max)
{
var randomNum = Math.random() * (max-min);
return(Math.round(randomNum) + min);
} 

//wallFluid.moveTo( getRandom(0,images.length),  );

</script>

