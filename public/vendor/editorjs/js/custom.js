$(document).ready(function() {
    // Wrapper top space
    $(window).on('load resize orientationchange', function() {
        var header_hright = $('site-header').outerHeight();
        $('site-header').next('.wrapper').css('margin-top', header_hright + 'px');
    });

    /********* Multi-level accordion nav  ********/

    $('.down-arrow').click(function() {
        var label = $(this);
        var parent = label.parent('.acnav-label');
        var list = parent.siblings('.acnav-list');
        if (parent.hasClass('is-open')) {
            list.slideUp('fast');
            parent.removeClass('is-open');
        } else {
            list.slideDown('fast');
            parent.addClass('is-open');
        }
    });
    $(".categories-sidebar-popup-menu-row" ).each(function (){
        $(this).click(function(){
          clearStyle();
          $(this).addClass("active");
        });
      });

      function clearStyle(){
        buttonWithActive = $('.categories-sidebar-popup-menu-row.active');
        buttonWithActive.removeClass('active');
      }

    $(".menu-item").click(function () {
        $(".menu-item.active").removeClass('active')
        $(this).addClass('active')
    });

    $(".sider-button").click(function(){
        $(".left-bar").toggleClass("leftbar-collapsed");
    });

    $(".menu-btn").click(function(){
        $(".left-bar").toggleClass("leftbar-visible");
    });

});
