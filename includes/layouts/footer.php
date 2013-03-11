   
    <footer class="footer">
      <div class="container-fluid">
        <p>&copy; DPoint Technologies Asia <?php echo date("Y", time()); ?></p>
      </div>
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/holder.js"></script>
    <script type="text/javascript" language="javascript">
      function confirmAction()
      {
        var confirmed = confirm("Are you sure? This will remove the record forever.");
        return confirmed;
      }

      $(function(){
        $('.tooltip_dialog').tooltip();
      });

      $('input[id=lefile]').change(function(){
        $('#photoCover').val($(this).val());
      });
    </script>
    
  </body>
</html>
