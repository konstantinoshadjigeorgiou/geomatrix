(function ($) {
  var body = $('body');
  var menuButton = $('.menu-button');
  var mobileMenu = $('.mobile-navigation');

  var btn = $('.login');

  btn.on('click', function (e) {
    console.log('open');
  });

  menuButton.on('click', function (e) {
    mobileMenu.toggleClass('open');
    body.toggleClass('mobile-menu-open');
  });

  mobileMenu.find('.menu-item-has-children > a').each(function () {
    $(this).on('click', function (e) {
      e.preventDefault();
      $(this).parent().toggleClass('open');
    })
  });

})(jQuery);