
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
        var $this = $(this);
        var targetId = $this.data('target');
        var $targetContent = $('#' + targetId);
        if ($this.hasClass('active')) {
            $this.removeClass('active');
            $targetContent.removeClass('active');
        } else {
            $('.critical-reasoning-conten').removeClass('active');
            $('.critical-reasoning-row1 h3').removeClass('active');
            $targetContent.addClass('active');
            $this.addClass('active');
        }
    });
});