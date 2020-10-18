<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="no-js">

<head>
     <title><?php echo $template['title'] ?></title>
     <?php echo $template['metadata'] ?>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
     <meta name="author" content="" />
     <meta name="robots" content="index, follow" />
     <base href="<?php echo base_url('assets/'); ?>/" />
     <link href="images/favicon.png" rel="shortcut icon" id="favicon" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script>
          var site_url = "<?php echo site_url(); ?>";
          var none_image = "<?php echo $this->config->item('none_image'); ?>";
     </script>
     <!-- -->
     <link rel="stylesheet" type="text/css" href="styles/style.css" />
     <link rel="stylesheet" href="styles/superslides.css" />
     <link href="styles/bootstrap.css" rel='stylesheet' type='text/css' />
     <link href="styles/megamenu.css" rel="stylesheet" type="text/css" />

     <!--[if lt IE 9]>
                      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
              <![endif]-->
     <script src="scripts/jquery-1.11.2.min.js"></script>
     <script src="scripts/megamenu.js"></script>
     <!-- -->

</head>
<body class="fixed-top">
     <?php echo $template['partials']['header']; ?>
     <?php echo $template['partials']['flash_messages'] ?>
     <?php echo $template['body'] ?>
     <?php echo $template['partials']['footer']; ?>
</body>

</html>