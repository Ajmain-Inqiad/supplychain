<style>
#frame {
position: fixed;
bottom: 0;
right: 0;
display: none;
}
</style>
<iframe
    id="frame"
    width="350"
    height="430"
    src="https://console.dialogflow.com/api-client/demo/embedded/312d3d9b-c4df-4a21-ab08-417723369160">
</iframe>
<script type="text/javascript">
    $(document).ready(function(){
        $(".buttoncollapse").click(function() {
            var value = $(this).attr("data-id");
            if(value==1){
                $(".buttoncollapse").html('Hide Chat');
                $(".buttoncollapse").attr('data-id', '2');
                $('#frmae').css("display", "block");
            }else{
                $('#frmae').css("display", "none");
                $(".buttoncollapse").html('Open Chat');
                $(".buttoncollapse").attr('data-id', '1');
            }
            $('#frame').toggle();
         });
    });
</script>
<script>
var now = new Date();
var hrs = now.getHours();
var msg = "";

if (hrs >  0) msg = "Mornin' Sunshine!"; // REALLY early
if (hrs >  6) msg = "Good morning";      // After 6am
if (hrs > 12) msg = "Good afternoon";    // After 12pm
if (hrs > 17) msg = "Good evening";      // After 5pm
if (hrs > 22) msg = "Time for Bed!";
//document.getElementById("msg").innerHTML = msg;

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
