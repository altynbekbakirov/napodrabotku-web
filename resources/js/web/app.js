$(document).ready(function () {
    // Left side nav

    var $window_width_left = $(window).width();

    //if you change this breakpoint in the style.css file (or _layout.scss if you use SASS), don't forget to update this value as well
    var $left = 992,
        $menu_navigation_left = $('#left-nav'),
        $hamburger_icon = $('#hamburger-menu'),
        $shadow_layer_left = $('#shadow-layer-left');

    //open lateral menu on mobile
    $hamburger_icon.on('click', function (event) {
        event.preventDefault();
        $(this).toggleClass("is-active");
        $('#left-nav-close').show();
        $('#right-nav-close').hide();
        toggle_panel_visibility_left($menu_navigation_left, $shadow_layer_left, $('body'));
    });

    //close lateral cart or lateral menu
    $('#left-nav-close, #shadow-layer-left').on('click', function () {   
        $shadow_layer_left.removeClass('is-visible');
        $('#left-nav-close').hide();
        $hamburger_icon.removeClass("is-active");
        $menu_navigation_left.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
            $('body').removeClass('overflow-hidden');
        });
    });

    //move #left-navigation inside header on laptop
    //insert #left-navigation after header on mobile
    move_navigation_left($menu_navigation_left, $left);
    blocks_arrange_left($window_width_left);

    $(window).on('resize', function () {
        move_navigation_left($menu_navigation_left, $left);
        if ($(window).width() >= $left && $menu_navigation_left.hasClass('speed-in')) {
            $menu_navigation_left.removeClass('speed-in');
            $shadow_layer_left.removeClass('is-visible');
            $('body').removeClass('overflow-hidden');
        }
        $window_width_left = $(window).width();
        blocks_arrange_left($window_width_left);
    });

    function blocks_arrange_left($window_width_left) {
        if ($window_width_left > 992) {
            $('.block').each(function () {
                $(this).height($(this).width());
            });
            $('.block-half').each(function () {
                $(this).height($(this).width() / 2 - 5);
            });
            $('.block-quarter').each(function () {
                $(this).height($(this).width() - 5);
            });
        } else {
            $('.block').each(function () {
                $(this).height($(this).width());
            });
        }
    }

    function toggle_panel_visibility_left($lateral_panel_left, $background_layer_left, $body) {
        if ($lateral_panel_left.hasClass('speed-in')) {
            // firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
            $lateral_panel_left.removeClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                $body.removeClass('overflow-hidden');
            });
            $background_layer_left.removeClass('is-visible');

        } else {
            $lateral_panel_left.addClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                $body.addClass('overflow-hidden');
            });
            $background_layer_left.addClass('is-visible');
        }
    }

    function move_navigation_left($navigation_left, $MQ) {
        if ($(window).width() >= $MQ) {
            $navigation_left.detach();
            $navigation_left.appendTo('.navbar .container');
        } else {
            $navigation_left.detach();
            $navigation_left.insertAfter('.navbar');
        }
    }

    // Right side nav

    var $window_width_right = $(window).width();

    //if you change this breakpoint in the style.css file (or _layout.scss if you use SASS), don't forget to update this value as well
    var $right = 992,
        $menu_navigation_right = $('#right-nav'),
        $user_icon = $('#user-menu'),
        $shadow_layer_right = $('#shadow-layer-right');
    
    //open lateral menu on mobile
    $user_icon.on('click', function (event) {
        event.preventDefault();
        $(this).toggleClass("is-active");
        $('#right-nav-close').show();
        $('#left-nav-close').hide();
        toggle_panel_visibility_right($menu_navigation_right, $shadow_layer_right, $('body'));
    });
    
    //close lateral cart or lateral menu
    $('#right-nav-close, #shadow-layer-right').on('click', function () {                
        $shadow_layer_right.removeClass('is-visible');
        $user_icon.removeClass("is-active");
        $('#right-nav-close').hide();
        $menu_navigation_right.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
            $('body').removeClass('overflow-hidden');
        });
    });
    
    //move #right-navigation inside header on laptop
    //insert #right-navigation after header on mobile
    move_navigation_right($menu_navigation_right, $right);
    blocks_arrange_right($window_width_right);
    
    $(window).on('resize', function () {
        move_navigation_right($menu_navigation_right, $right);
        if ($(window).width() >= $right && $menu_navigation_right.hasClass('speed-in')) {
            $menu_navigation_right.removeClass('speed-in');
            $shadow_layer_right.removeClass('is-visible');
            $('body').removeClass('overflow-hidden');
        }
        $window_width_right = $(window).width();
        blocks_arrange_right($window_width_right);
    });
    
    function blocks_arrange_right($window_width_right) {
        if ($window_width_right > 992) {
            $('.block').each(function () {
                $(this).height($(this).width());
            });
            $('.block-half').each(function () {
                $(this).height($(this).width() / 2 - 5);
            });
            $('.block-quarter').each(function () {
                $(this).height($(this).width() - 5);
            });
        } else {
            $('.block').each(function () {
                $(this).height($(this).width());
            });
        }
    }
    
    function toggle_panel_visibility_right($lateral_panel_right, $background_layer_right, $body) {
        if ($lateral_panel_right.hasClass('speed-in')) {
            // firefox transitions break when parent overflow is changed, so we need to wait for the end of the trasition to give the body an overflow hidden
            $lateral_panel_right.removeClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                $body.removeClass('overflow-hidden');
            });
            $background_layer_right.removeClass('is-visible');
    
        } else {
            $lateral_panel_right.addClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                $body.addClass('overflow-hidden');
            });
            $background_layer_right.addClass('is-visible');
        }
    }
    
    function move_navigation_right($navigation_right, $MQ) {
        if ($(window).width() >= $MQ) {
            $navigation_right.detach();
            $navigation_right.appendTo('header .container');
        } else {
            $('.navbar').addClass('sticky-top');
            $navigation_right.detach();
            $navigation_right.insertAfter('header');
        }
    }

    $(".dropdown-menu").on("click", function (e) {
        e.stopImmediatePropagation();
    });
    
});

if ($('header')[0]) {
    $(window).scroll(function () {
        if ($("header").offset().top > 277) {
            $("header").addClass("nav-shadow");
        } else {
            $("header").removeClass("nav-shadow");
        }
    });
}