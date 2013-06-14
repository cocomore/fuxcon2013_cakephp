<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('/bootstrap/css/bootstrap.min');
		echo $this->Html->css('styles');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="<?php echo strtolower($this->name . '-' . $this->action); ?>">
	<div class="container-narrow">
		<div class="masthead">
  		<ul class="nav nav-pills pull-right">
  		  <?php 
  		  $user = AuthComponent::user();
  		  if ($user):
    		  ?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?php echo $user['username']; ?><b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
              <li><?php echo $this->Html->link('Create project', array('controller' => 'projects', 'action' => 'add')); ?></li>
              <li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?></li>
            </ul><!-- .dropdown-menu -->
          </li>
        <?php else: ?>
          <li><?php echo $this->Html->link('login', array('controller' => 'users', 'action' => 'login')); ?></li>
        <?php endif; ?>
      </ul><!-- .nav -->
			<h3 class="muted"><?php echo $this->Html->link('Projects', '/'); ?></h3>
		</div>
		<?php echo $this->Session->flash(); ?>
 		<?php echo $this->fetch('content'); ?>
		<hr>
		<div class="footer">
			in CakePHP for <?php echo $this->Html->link('FUxCon 2013', 'http://www.lugfrankfurt.de/FUxCon?action=AttachFile&do=get&target=cfp.pdf'); ?> by Olav Schettler
		</div>
	</div><!-- .container-narrow -->
	<?php 
	echo $this->Html->script('jquery-1.9.1.min');
	echo $this->Html->script('/bootstrap/js/bootstrap.min.js'); 
	?>
</body>
</html>
