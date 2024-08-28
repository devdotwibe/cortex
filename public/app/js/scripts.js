
$(document).ready(function() {
    $('.accordion-item-header').click(function() {
        var $accordionItem = $(this).closest('.accordion-item');
        $('.accordion-item').removeClass('active');
        $accordionItem.addClass('active');
        $('.feature-img').removeClass('active');
        var targetId = $(this).data('target');
        $('#' + targetId).addClass('active');
    });
});

$('.review-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots:false,
    arrow:true
  });


  $(document).ready(function() {
    $('.accordion h5').click(function() {
        $(this).next('.accordion-content1').slideToggle(300);
        $(this).toggleClass('active');
        $('.accordion h5').not(this).removeClass('active');
        $('.accordion-content1').not($(this).next()).slideUp(300);
    });
});


document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.process-box');
    const stickyContainer = document.querySelector('.sticky-cards');
    const cardHeight = cards[0].offsetHeight;
    const gap = 20; // Gap between stacked cards

    function handleScroll() {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;

        cards.forEach((card, index) => {
            const offset = (index * (cardHeight + gap)) - scrollTop;
            if (offset < window.innerHeight && offset > -cardHeight) {
                card.style.transform = `translateY(${Math.max(0, offset)}px)`;
                card.style.zIndex = cards.length - index; // Stack cards on top of each other
            } else {
                card.style.transform = 'translateY(0px)';
                card.style.zIndex = 1;
            }
        });
    }

    window.addEventListener('scroll', handleScroll);
    handleScroll(); // Call once to initialize
});