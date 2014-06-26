jQuery(document).ready(function(){
  var events = jQuery('ul.events li.event');
  var properties = jQuery('ul.properties li', events);

  properties.hover(function(){
    jQuery(this).addClass('hover');
  }, function(){
    jQuery(this).removeClass('hover');
  });

  properties.click(function(){
    if(jQuery(this).hasClass('selected')){
      jQuery(this).removeClass('selected');
    }else{
      jQuery(this).addClass('selected');
    }
  });
});