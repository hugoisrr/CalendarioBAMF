    <!-- js placed at the end of the document so the pages load faster -->

    <script type="text/javascript">
        // Add the following into your HEAD section
        var timer = 0;
        function set_interval() {
          // the interval 'timer' is set as soon as the page loads
          timer = setInterval("auto_logout()", 900000);
          // the figure '10000' above indicates how many milliseconds the timer be set to.
          // Eg: to set it to 5 mins, calculate 5min = 5x60 = 300 sec = 300,000 millisec.
          // So set it to 300000
          // En este caso se establece el tiempo en 15 min = 15x60 = 900 sec, por lo tanto
          // 900000
        }

        function reset_interval() {
          //resets the timer. The timer is reset on each of the below events:
          // 1. mousemove   2. mouseclick   3. key press 4. scroliing
          //first step: clear the existing timer

          if (timer != 0) {
            clearInterval(timer);
            timer = 0;
            // second step: implement the timer again
            timer = setInterval("auto_logout()", 900000);
            // completed the reset of the timer
          }
        }

        function auto_logout() {
          // this function will redirect the user to the logout script
          window.location = "logout.php";
        }
    </script>    
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="assets/js/jqueryCustoms.js"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

