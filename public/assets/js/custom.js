
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

        // Check if the clicked h3 is already active
        if ($this.hasClass('active')) {
            // If the clicked h3 is active, remove 'active' class from it and the target content
            $this.removeClass('active');
            $targetContent.removeClass('active');
        } else {
            // Remove 'active' class from all content elements and all h3 elements
            $('.critical-reasoning-conten').removeClass('active');
            $('.critical-reasoning-row1 h3').removeClass('active');
            
            // Add 'active' class to the target content and clicked h3
            $targetContent.addClass('active');
            $this.addClass('active');
        }
    });
});