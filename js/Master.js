
jQuery('.menu-toggle').on('click', function () {
    if (jQuery('#site-navigation').hasClass('menu-opened')) {
        jQuery('#site-navigation').removeClass('menu-opened');
        jQuery(this).attr('aria-expanded', 'false');

        jQuery('li.menu-item-has-children.open').removeClass('open');
        jQuery('#opened-sub-menu').attr('id', '');
        jQuery('#masthead').removeClass('menu-sub-open');
    } else {
        jQuery('#site-navigation').addClass('menu-opened');
        jQuery(this).attr('aria-expanded', 'true');
    }
});
jQuery('li.menu-item-has-children:not(.open)').on('mouseover focusin', function () {
    if (jQuery(window).width() > 1000) {
        jQuery(this).addClass('open');
        jQuery(this).children('a').attr('aria-expanded', 'true');
        jQuery(this).children('ul.sub-menu').attr('id', 'opened-sub-menu');
    } else {

    }
});

jQuery('li.menu-item-has-children:not(.open)').on('click', function () {
    if (jQuery(window).width() <= 1000) {
        jQuery('#masthead').addClass('menu-sub-open');
        jQuery(this).addClass('open');
    } else {
    }
});

jQuery('li.menu-item-has-children').on('mouseout focusout', function () {
    if (jQuery(window).width() > 1000) {
        jQuery(this).removeClass('open');
        jQuery(this).children('a').attr('aria-expanded', 'false');
        jQuery(this).children('#opened-sub-menu').attr('id', '');
        jQuery('#masthead').removeClass('menu-sub-open');
    } else {
    }
});

jQuery('.sub-menu-close').on('click', function () {
    jQuery('li.menu-item-has-children.open').removeClass('open');
    jQuery('#opened-sub-menu').attr('id', '');
    jQuery('#masthead').removeClass('menu-sub-open');
});