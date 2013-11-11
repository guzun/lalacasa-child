if (jQuery('.sticky').length > 0) {
  var distance = jQuery('.sticky').length ? jQuery('.sticky').offset().top: 0,
      $window = jQuery(window);

    $window.scroll(function() { 
      if ( $window.scrollTop() > distance ) {
         jQuery(".sticky").addClass("fixed");
      }

     else if ( $window.scrollTop() <= distance ) {
        jQuery(".sticky").removeClass("fixed");
     }
  });
}