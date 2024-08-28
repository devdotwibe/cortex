
jQuery(function () {
    jQuery(".side-dropdown-menu").hide();
    jQuery(".side-dropdown-toggle").click(function () {
        if (jQuery(this).next().is(":hidden")) {
            jQuery(".side-dropdown-toggle")
                .removeClass("active")
                .next()
                .slideUp("slow");
            jQuery(this).toggleClass("active").next().slideDown("slow");
        }
    });
});
jQuery(".side-dropdown-toggle").click(function () {
    if (jQuery(this).hasClass("active")) {
        jQuery(this).removeClass("active");
        jQuery(".side-dropdown-menu").hide("active");
    }
});


$(document).ready(function() {
    $('.critical-reasoning-row1 h3').click(function() {
        $('.critical-reasoning-conten').removeClass('active');
        $('.critical-reasoning-row1 h3').removeClass('active');
        var targetId = $(this).data('target');
        $('#' + targetId).addClass('active');
        $(this).addClass('active');
    });
});