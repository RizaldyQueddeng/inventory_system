   

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script>
      $(function() {
        $('a[data-toggle="tab"]').on('shown', function (e) {
          //save the latest tab; use cookies if you like 'em better:
          localStorage.setItem('lastTab', $(e.target).attr('id'));
        });
       
        //go to the latest tab, if it exists:
        var lastTab = localStorage.getItem('lastTab');
        if (lastTab) {
            $('#'+lastTab).tab('show');
        }
      });

      $(function() {
        $('a[data-toggle="tab"]').on('shown', function(e){
          //save the latest tab using a cookie:
          $.cookie('last_tab', $(e.target).attr('href'));
        });
       
        //activate latest tab, if it exists:
        var lastTab = $.cookie('last_tab');
        if (lastTab) {
            $('ul.nav-tabs').children().removeClass('active');
            $('a[href='+ lastTab +']').parents('li:first').addClass('active');
            $('div.tab-content').children().removeClass('active');
            $(lastTab).addClass('active');
        }
      });
    </script>
  </body>
</html>
