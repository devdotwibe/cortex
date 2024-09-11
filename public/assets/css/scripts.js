
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


$('.hamburger-toggle').on('click', function(e){
    $('.overlay').toggleClass('show');
    $(this).toggleClass('active');
    e.preventDefault();
});


  AOS.init({once: true,});


//   $("#tab1").click(moveToFirst);
//   $("#tab2").click(moveToSecond);
//   $("#tab3").click(moveToThird);
//   $("#tab4").click(moveToFour);
  
//   function moveToFirst() {
//       $("#myTabContent").attr('class', 'move-to-first');
//       $(".tab").attr('class', 'nav-link');
//       $("#tab1").attr('class', 'nav-link selected');
//   }
  
//   function moveToSecond() {
//       $("#myTabContent").attr('class', 'move-to-second');
//       $(".tab").attr('class', 'nav-link');
//       $("#tab2").attr('class', 'nav-link selected');
//   }
  
//   function moveToThird() {
//        $("#myTabContent").attr('class', 'move-to-third');
//       $(".tab").attr('class', 'nav-link');
//       $("#tab3").attr('class', 'nav-link selected');
//   }
  
//   function moveToFour() {
//        $("#myTabContent").attr('class', 'move-to-four');
//       $(".tab").attr('class', 'tab');
//       $("#tab4").attr('class', 'nav-link selected');
//   }


$(document).ready(function(){
   
    $('.tab-slider').slick({
      dots: false,
      infinite: false,
      speed: 800,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false, 
      draggable: false, 
    swipe: false, 
    touchMove: false 
    });
  
    // Handle tab clicks
    $('.nav-link').on('click', function(e) {
      e.preventDefault();
      
      // Remove 'active' class from all tabs and add it to the clicked tab
      $('.nav-link').removeClass('active');
      $(this).addClass('active');
  
      // Get target pane ID and slide to that pane
      var targetPane = $(this).data('target');
      var slideIndex = $('.tab-content .tab-pane').index($(targetPane));
      $('.tab-slider').slick('slickGoTo', slideIndex);
    });
  });