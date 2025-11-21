jQuery(document).ready(function($) {
    console.log('Building Designer Admin loaded');
    
    $('.bd-admin-notice').each(function() {
        var $notice = $(this);
        setTimeout(function() {
            $notice.fadeOut();
        }, 5000);
    });
});
