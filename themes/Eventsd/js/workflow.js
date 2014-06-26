jQuery(document).ready(function(){
  var events = jQuery('ul.events li.event');
  var properties = jQuery('ul.properties li', events);

  setTimeout(function(){
    events.each(function(i, event){
      var height = jQuery('.name span', event).width() + 10;
      var heightpx = height + 'px';
      console.log("Height: " + heightpx);
      jQuery(this).css('min-height', heightpx);
    });
  }, 300);

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