<style>
     .cart_notificationbg{
          font-family: 'PT Sans', sans-serif;
          width:280px;
          height:auto;
          background-color:#036ab6;
          padding:15px 20px;
          position:fixed;
          top:25px;
          line-height:18px;
          right:25px;
          color:#FFF;
          font-size:13px;
          z-index: 999999999;
          -webkit-border-radius: 3px;
          -moz-border-radius: 3px;
          border-radius: 3px;
     }
     .notifi_close{
          color:#FFF;
          text-decoration:none;
          float:right;
     }
     .notifi_close:hover{
          color:#000;
     }
     #msg p{
          /*float:left;*/
          color: #fff !important;
     }
     @media screen and (max-width: 360px) {
          .cart_notificationbg{
               width:86%; padding:15px 2%; right:5%;}
          #msg{
               width:90%;}
     }
</style>

<!-- Javascript -->
<div class="cart_notificationbg msgBox" style="display: none;">
     <a href="javascript:void(0);" onclick="$(this).parent().hide();" class="notifi_close">X</a>
     <span id="msg">Item Successfully added to cart</span>
</div>
<!-- Javascript -->

<!-- php -->
<?php if ($alert = $this->session->flashdata('app_alert')): ?>
       <div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $alert ?></div>
  <?php endif ?>

<?php if ($error = $this->session->flashdata('app_error')): ?> 
       <div class="cart_notificationbg">
            <span id="msg"><?php echo $error; ?></span>
            <a href="javascript:void(0);" onclick="$(this).parent().hide();" class="notifi_close">X</a>
       </div>
  <?php endif ?>

<?php if ($success = $this->session->flashdata('app_success')): ?> 
       <div class="cart_notificationbg">
            <span id="msg"><?php echo $success; ?></span>
            <a href="javascript:void(0);" onclick="$(this).parent().hide();" class="notifi_close">X</a>
       </div>
  <?php endif ?>

<?php if ($info = $this->session->flashdata('app_info')): ?>
       <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $info ?></div>
  <?php endif ?>
<!-- php -->