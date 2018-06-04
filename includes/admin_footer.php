
<script>
var now = new Date();
var hrs = now.getHours();
var msg = "";

if (hrs >  0) msg = "Mornin' Sunshine!"; // REALLY early
if (hrs >  6) msg = "Good morning";      // After 6am
if (hrs > 12) msg = "Good afternoon";    // After 12pm
if (hrs > 17) msg = "Good evening";      // After 5pm
if (hrs > 22) msg = "Time for Bed!";
document.getElementById("msg").innerHTML = msg;

$(function () {
  $('.navbar-toggle').click(function () {
      $('.navbar-nav').toggleClass('slide-in');
      $('.side-body').toggleClass('body-slide-in');

      /// uncomment code for absolute positioning tweek see top comment in css
      //$('.absolute-wrapper').toggleClass('slide-in');

  });
});
</script>
</body>
</html>
<?php $connect->close(); ?>
