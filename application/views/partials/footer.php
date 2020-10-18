<script src="scripts/jquery.easing.1.3.js"></script>
<script src="scripts/jquery.animate-enhanced.min.js"></script>
<script src="scripts/jquery.superslides.js" type="text/javascript" charset="utf-8"></script>


<script src="scripts/datatables.net/js/jquery.dataTables.min.js"></script>
<script>
     var pageUrl = "<?php echo site_url('SmtpEmail/fetchfrmsmtp/') ?>";
     setInterval(
          fetchEmails, 300000);

     function fetchEmails() {
          $.ajax({
               type: 'get',
               url: pageUrl,
               dataType: 'json',
               success: function(resp) {
                    console.log("success");
               }
          });
     }
</script>