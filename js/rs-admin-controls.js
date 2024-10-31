/**
 * JS file for Responsvie Subheader Admin Controls
 */
jQuery(document).ready(function(){
  var oOpts = {
    defaultColor: '#1e73be',
    change: function(event,ui){},
    clear: function() {},
    hide: true,
    palettes: true
  };
  jQuery('#rs_subheader_bg_color').wpColorPicker( oOpts );
  jQuery('#rs_subheader_fp_bg_color').wpColorPicker( oOpts );
});

jQuery(document).ready(function(){
  jQuery('.wp-picker-holder').mouseup(function(){
      var sBgColor = $('.wp-color-result').css("background-color");
      jQuery('.subheader-container').css('background-color',sBgColor);
  });
});
