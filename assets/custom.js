
window.addEventListener("load", function(event) {
  const scroller = new LocomotiveScroll({
      el: document.querySelector('[data-scroll-container]'),
      smooth: false,
      getDirection: true,
      touchMultiplier: 3,
      smartphone: {
        // smooth: true,
      //   touchMultiplier: 41,
      //   multiplier: 5,
        getDirection: true,
      },
      tablet: {
        // smooth: true,
        inertia: 0.8,
        getDirection: true,
      },
  })

  scroller.on('call', (obj) => {
    console.log(obj);
    var isViewved = false;
    jQuery(function($) {
      if(!isViewved){

        $('.counter-value').each(function() {
          var $this = $(this),
            countTo = $this.attr('data-count');
          $({
            countNum: $this.text()
          }).animate({
              countNum: countTo
            },
      
            {
      
              duration: 2000,
              easing: 'swing',
              step: function() {
                $this.text(Math.floor(this.countNum));
              },
              complete: function() {
                $this.text(this.countNum);
                $this.append("+");
                //alert('finished');
              }
              
            });
          });
          isViewved = true;
        }
    })
  });
  document.addEventListener('DOMContentLoaded', function() {
  
    function ScrollUpdateDelay() {
        setTimeout(function(){ scroller.update(); }, 500);
   
    }
  
    ScrollUpdateDelay();
  });
});

// var link = document.createElement('a');
// link.href = "#";
// document.body.appendChild(link);
// link.click();  


jQuery(function($) {
  $( document ).ready(function() {

    $('[data-toggle=tooltip]').tooltip();

    $('.popup-youtube').magnificPopup({
      type: 'iframe'
    });

    AOS.init();

    AOS.init({
      offset: 120, // offset (in px) from the original trigger point
      delay: 0, // values from 0 to 3000, with step 50ms
      duration: 1400, // values from 0 to 3000, with step 50ms
      easing: 'ease', // default easing for AOS animations
      mirror: true,
      anchorPlacement: 'bottom-center'
    })
  

    $(document).on('submit', '[data-js-form=filter]', function(e){
        e.preventDefault();
        // console.log(this);

        var data = $(this).serialize();
        console.log(data);
        $(".filterBtn").text('Processing...'); 
        document.getElementById("filterBtn").disabled = true;

        $.ajax({
          url: '/wp-admin/admin-ajax.php',
            data: data,
            type: 'post',
            // beforeSend:function(){
            //   $(".filterBtn").text('Processing...'); // changing the button label
            // },
            success: function(result){
            //   $('html, body').animate({
            //     scrollTop: $("#p-wrap").offset().top + 500
            // }, 2000);
                $("#products-wrapper").html(result);
                // console.log(result);
                // $(".sidebar").removeClass('active');
                // $("#loadMoreDeals").hide();

                $(".filterBtn").text('Apply filter');
                document.getElementById("filterBtn").disabled = false;
                
            },
            error: function(result){
                console.log('n');
            },
        });

    });

    $(".products-megamenu").hover(function(){
      $(".m-menu-wrapper").addClass("active");
      }, function(){
      $(".m-menu-wrapper").removeClass("active");
    });

  });

    
})
   
// ==== Fancybox ======

var elementExists = document.getElementById("thumbCarousel");

if(elementExists){
  
  // Initialise Carousel
  const mainCarousel = new Carousel(document.querySelector("#mainCarousel"), {
    Dots: false,
  });
  
  // Thumbnails
  const thumbCarousel = new Carousel(document.querySelector("#thumbCarousel"), {
    Sync: {
      target: mainCarousel,
      friction: 0,
    },
    Dots: false,
    Navigation: false,
    center: true,
    slidesPerPage: 2,
    infinite: false,
  });
  
  // Customize Fancybox
  Fancybox.bind('[data-fancybox="gallery"]', {
    Carousel: {
      on: {
        change: (that) => {
          mainCarousel.slideTo(mainCarousel.findPageForSlide(that.page), {
            friction: 0,
          });
        },
      },
    },
  });

}

// ----- Download catalouge on form submit -----
// window.bootstrap = require('bootstrap');
document.addEventListener( 'wpcf7submit', function( event ) {
  // if ( '241' == event.detail.contactFormId ) {
  if ( '243' == event.detail.contactFormId ) {
    // var cModal = document.getElementById('catalougeDownload');
    // var modal = bootstrap.Modal.getInstance(cModal)
    // modal.hide();

    // var myModal = new bootstrap.Modal(document.getElementById("catalougeDownload"), {});
    // document.onreadystatechange = function () {
    //   myModal.show();
    // };
    // window.open("/wp-content/uploads/2022/02/leakproof-pumps-catalouge.pdf", "_blank");
    location = "/wp-content/uploads/2022/02/leakproof-pumps-catalouge.pdf";
  }
}, false );