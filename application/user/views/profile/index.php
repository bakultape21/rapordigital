<!DOCTYPE html>

<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $this->config->item('title'); ?> </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/ticker-style.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/flaticon.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/slicknav.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/animate.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/magnific-popup.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/themify-icons.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/slick.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/nice-select.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/web-profile/assets/css/style.css">
     <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />
</head>


<body>
    <?php echo $_header; ?>
    <?php echo $_fullcontent; ?>
    <?php echo $_footer; ?>
<div class="search-model-box">
    <div class="d-flex align-items-center h-100 justify-content-center">
        <div class="search-close-btn">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Searching key.....">
        </form>
    </div>
</div>
<!-- Search model end -->

</body>



</html>

<!-- JS here -->

    <script src="<?= base_url() ?>/assets/web-profile/assets/js/vendor/modernizr-3.5.0.min.js"></script>
    <!-- Jquery, Popper, Bootstrap -->
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/popper.min.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/bootstrap.min.js"></script>
    <!-- Jquery Mobile Menu -->
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/jquery.slicknav.min.js"></script>

    <!-- Jquery Slick , Owl-Carousel Plugins -->
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/owl.carousel.min.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/slick.min.js"></script>
    <!-- Date Picker -->
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/gijgo.min.js"></script>
    <!-- One Page, Animated-HeadLin -->
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/wow.min.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/animated.headline.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/jquery.magnific-popup.js"></script>

    <!-- Scrollup, nice-select, sticky -->
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/jquery.scrollUp.min.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/jquery.nice-select.min.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/jquery.sticky.js"></script>
    
    <!-- contact js -->
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/contact.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/jquery.form.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/jquery.validate.min.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/mail-script.js"></script>
    <script src="<?= base_url() ?>/assets/web-profile/assets/js/jquery.ajaxchimp.min.js"></script>
    
    <!-- Jquery Plugins, main Jquery -->    
    <!-- <script src="<?= base_url() ?>/assets/web-profile/assets/js/plugins.js"></script> -->
    <!-- <script src="<?= base_url() ?>/assets/web-profile/assets/js/main.js"></script> -->
    <script type="text/javascript">
    $(document).ready(function (){
      $('#datatablecustome').DataTable();
  // Declare Carousel jquery object
  var owl = $('.owl-carousel');

  // Carousel initialization
  owl.owlCarousel({
      loop:false,
      margin:0,
      navSpeed:500,
      nav:true,
      autoplay: true,
      rewind: true,
      items:1
  });


  // add animate.css class(es) to the elements to be animated
  function setAnimation ( _elem, _InOut ) {
    // Store all animationend event name in a string.
    // cf animate.css documentation
    var animationEndEvent = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';

    _elem.each ( function () {
      var $elem = $(this);
      var $animationType = 'animated ' + $elem.data( 'animation-' + _InOut );

      $elem.addClass($animationType).one(animationEndEvent, function () {
        $elem.removeClass($animationType); // remove animate.css Class at the end of the animations
      });
    });
  }

// Fired before current slide change
  owl.on('change.owl.carousel', function(event) {
      var $currentItem = $('.owl-item', owl).eq(event.item.index);
      var $elemsToanim = $currentItem.find("[data-animation-out]");
      setAnimation ($elemsToanim, 'out');
  });

// Fired after current slide has been changed
  var round = 0;
  owl.on('changed.owl.carousel', function(event) {

      var $currentItem = $('.owl-item', owl).eq(event.item.index);
      var $elemsToanim = $currentItem.find("[data-animation-in]");
    
      setAnimation ($elemsToanim, 'in');
  })
  
  owl.on('translated.owl.carousel', function(event) {
    console.log (event.item.index, event.page.count);
    
      if (event.item.index == (event.page.count - 1))  {
        if (round < 1) {
          round++
          console.log (round);
        } else {
          owl.trigger('stop.owl.autoplay');
          var owlData = owl.data('owl.carousel');
          owlData.settings.autoplay = false; //don't know if both are necessary
          owlData.options.autoplay = false;
          owl.trigger('refresh.owl.carousel');
        }
      }
  });

});
</script>

<script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-1b93190375e9ccc259df3a57c1abc0e64599724ae30d7ea4c6877eb615f89387.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.7/semantic.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js"></script>
  <script id="rendered-js">
  $(document).ready(function () {
  $('#calendar').fullCalendar({
  header: {
  left: 'prev,next today',
  center: 'title',
  right: 'month,basicWeek,basicDay' },
  defaultDate: '2016-12-12',
  navLinks: true, // can click day/week names to navigate views
  editable: true,
  eventLimit: true, // allow "more" link when too many events
  events: [
  {
  title: 'All Day Event',
  start: '2016-12-01' },
  {
  title: 'Long Event',
  start: '2016-12-07',
  end: '2016-12-10' },
  {
  id: 999,
  title: 'Repeating Event',
  start: '2016-12-09T16:00:00' },
  {
  id: 999,
  title: 'Repeating Event',
  start: '2016-12-16T16:00:00' },
  {
  title: 'Conference',
  start: '2016-12-11',
  end: '2016-12-13' },
  {
  title: 'Meeting',
  start: '2016-12-12T10:30:00',
  end: '2016-12-12T12:30:00' },
  {
  title: 'Lunch',
  start: '2016-12-12T12:00:00' },
  {
  title: 'Meeting',
  start: '2016-12-12T14:30:00' },
  {
  title: 'Happy Hour',
  start: '2016-12-12T17:30:00' },
  {
  title: 'Dinner',
  start: '2016-12-12T20:00:00' },
  {
  title: 'Birthday Party',
  start: '2016-12-13T07:00:00' },
  {
  title: 'Click for Google',
  url: 'https://google.com/',
  start: '2016-12-28' }] });
  });
  //# sourceURL=pen.js
  </script>
