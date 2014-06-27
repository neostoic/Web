jQuery(document).ready(function(){
  var events = jQuery('ul.events li.event');
  var properties = jQuery('ul.properties li', events);

  function workflow() {

    this.gates = jQuery('.workflow-gates ul.gates');

    this.add_gate = function(event){
      var name = jQuery(event).text();
      this.gates.append("<li class=\"gate gate-" + name + "\"><div class=\"name\"><span>if</span></div><div class=\"argument\"><em>" + name + "</em> is <select name=\"op\" class=\"operation\"></select> <input name=\"value\" class=\"value\"/></div></li>")
      var gate = jQuery('.gate-' + name);

      jQuery('select[name=op]', gate)
        .append('<option value="=">=</option>')
        .append('<option value="<="><=</option>')
        .append('<option value=">=">=</option>')
        .append('<option value="!=">!=</option>')
        ;
      this.post_gate_add();
    };

    this.remove_gate = function(event){
      var name = jQuery(event).text();
      jQuery('li.gate-' + name).remove();
      this.post_gate_add();
    }

    this.post_gate_add = function(){
      if(jQuery('li.gate', this.gates).length > 1){
        jQuery('.workflow-gates .gate-group-operation, .workflow-gates .gate-group-description').show();
        jQuery('.workflow-gates ul.gates').removeClass('hide-box')
      }else{
        jQuery('.workflow-gates .gate-group-operation, .workflow-gates .gate-group-description').hide();
        jQuery('.workflow-gates ul.gates').addClass('hide-box')
      }
    };

    this.setup = function(){
      var workflow = this;
      setTimeout(function(){
        events.each(function(i, event){
          var height = jQuery('.name span', event).width() + 10;
          var heightpx = height + 'px';
          jQuery(this).css('min-height', heightpx);
        });
      }, 150);

      properties.hover(function(){
        jQuery(this).addClass('hover');
      }, function(){
        jQuery(this).removeClass('hover');
      });

      properties.click(function(){
        if(jQuery(this).hasClass('selected')){
          jQuery(this).removeClass('selected');
          workflow.remove_gate(this);
        }else{
          jQuery(this).addClass('selected');
          workflow.add_gate(this)
        }
      });

      this.post_gate_add();
    };
  };

  var wf = new workflow();
  wf.setup();

});