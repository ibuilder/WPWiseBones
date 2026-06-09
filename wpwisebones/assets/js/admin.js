/**
 * WPWiseBones â€“ admin.js
 * Admin-side enhancements.
 */

(function ($) {
    'use strict';

    // Colour pickers in admin options page
    if ($.fn.wpColorPicker) {
        $('.wpb-color-picker').wpColorPicker();
    }

    // Confirm before bulk delete
    $('[data-confirm]').on('click', function (e) {
        if (!confirm($(this).data('confirm'))) {
            e.preventDefault();
        }
    });

    // Tabs on admin settings page
    $(document).on('click', '.wpb-admin-tab', function (e) {
        e.preventDefault();
        const target = $(this).attr('href');
        $('.wpb-admin-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.wpb-tab-content').hide();
        $(target).show();
    });

    // Trigger first tab on load
    const firstTab = $('.wpb-admin-tab:first');
    if (firstTab.length) firstTab.trigger('click');

})(jQuery);
