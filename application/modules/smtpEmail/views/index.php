<style type="text/css">
     #contact-inner h2 {
          color: black;
     }

     .pagination {
          display: inline-block;
          text-align: center;
          border: 1px solid black;
          padding: 5px;
          cursor: pointer;
     }

     #contact-wrapper {
          float: left;
          width: 100%;
          min-height: 200px;
          height: auto !important;
          padding: 0px;
          margin: 0px;
     }


     table {
          border-collapse: collapse;
          width: 100%;
     }

     th,
     td {
          text-align: left;
          padding: 8px;
     }

     tr:nth-child(even) {
          background-color: #f2f2f2
     }

     th {
          background-color: #4CAF50;
          color: white;
     }
</style>
<div id="contact-wrapper">
     <div id="contact-inner">
          <h2>Email List</h2>
          <table class="table table-bordered table-striped" id="sample">
               <thead>
                    <th class="">Date</th>
                    <th class="">Subject</th>
                    <th class="">Fromaddress</th>
                    <!-- <th class="">body</th> -->
                    <th class="">Delete</th>
               </thead>

               <tbody>
                    <?php
                    if (!empty($inbox) && count($inbox) > 0) {
                         foreach ($inbox as $count => $mails) {
                    ?>
                              <tr>
                                   <td><?php echo $mails->date; ?></td>
                                   <td><?php echo $mails->headder; ?></td>
                                   <td><?php echo $mails->from; ?></td>
                                   <!-- <td><?php echo $mails->content; ?></td> -->
                                   <td style="width: 20px;">
                                        <a class="deleteRow" href="javascript:void(0);" data-url="<?php echo site_url('SmtpEmail/deleteEmail/' . $mails->emil_index); ?>">
                                             <i class="icon-trash"></i>delete</a>
                                   </td>
                              </tr>
                    <?php
                         }
                    }
                    ?>
               </tbody>
          </table>
          <div style="margin-top: 2%;">
               <?php if ($count > 0) {
                    $offset = 0;
                    do {
                         $i = 0;
                         $page = $i+1;
                         
                    
               ?>
                         <div class="pagination" offset="<?php echo $offset; ?> "><?php echo $page; ?></div>
               <?php
                    $offset = $i+10;
                    $i++;
                    }while($i <= $count/10);
               }
               ?>
          </div>
     </div>
</div>

<script>
     var pageUrl = "<?php echo site_url('SmtpEmail/index/') ?>";
     $(document).ready(function() {
         // var sample = $('#sample').DataTable();
     })

     $(document).off('click', '.deleteRow');
     $(document).on('click', '.deleteRow', function() {
          if (confirm('Are you sure want to delete this record?')) {
               var url = $(this).attr('data-url');
               var id = $(this).attr('id');
               var oTable = $('#sample').dataTable();
               var rowIndex = oTable.fnGetPosition($(this).closest('tr')[0]);
               $.ajax({
                    type: 'post',
                    url: url,
                    dataType: 'json',
                    success: function(resp) {
                         showMessage(resp.msg, resp.status);
                         oTable.fnDeleteRow(rowIndex);
                    }
               });
          }
     });

     $(document).off('click', '.pagination');
     $(document).on('click', '.pagination', function() {
          var offset = $(this).attr('offset');
          window.location = pageUrl + "?offset=" + offset;
          history.pushState({}, null, pageUrl);
          // $.ajax({
          //      type: 'get',
          //      url: pageUrl,
          //      dataType: 'json',
          //      data: {
          //           'offset': offset,
          //           'page': true
          //      },
          //      success: function(resp) {
          //           console.log(resp, "resp");
          //           var sample = $('#sample').DataTable({
          //                'processing': false,
          //                'serverSide': false,
          //                'serverMethod': 'get',
          //                "pageLength": 50,
          //                "searching": false,
          //                "bPaginate": false,
          //                'tooltip': true,
          //                'columns': [{
          //                     data: ''
          //                     },
          //                     {
          //                          data: ''
          //                     },
          //                     {
          //                          data: ''
          //                     },
          //                     {
          //                          data: ''
          //                     },
          //                     {
          //                          data: ''
          //                     },
          //                     {
          //                          data: ''
          //                     },
          //                ]
          //           });
          //      }
          // });
     });
</script>