<!DOCTYPE html>
<html lang="en">
     <body class="<?php echo $body_class ?>">
          <?php echo ($this->router->fetch_class() != 'user') ? $template['partials']['header'] : ''; ?>
          <?php echo $template['partials']['flash_messages'] ?>
          <?php echo $template['body'] ?>
          <?php echo ($this->router->fetch_class() != 'user') ? $template['partials']['footer'] : ''; ?>
     </body>
</html>