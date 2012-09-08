 //This is a function that allows communication between javascript plugins attach to the same object.
 $.fn.pass = function (plugin,action,options){
  var data=[];
 
  this.each(function(){
    if ($plugin=$(this).data(plugin)){
      if (typeof $plugin[action]==='function') {
            return data.push ($plugin[action]() )
          }
      return data.push( $plugin[action] )
    }
    return data.push(this);
    });
   
  //if there is only one result, do not return it as an array  
  return (data.length == 1) ? data[0] : data ;  
 } 