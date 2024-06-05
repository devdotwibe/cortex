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