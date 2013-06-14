<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css');
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
	echo $this->Html->script('http://code.jquery.com/jquery-1.10.1.min.js');
	echo $this->Html->script('http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js'); 
	?>
</body>
</html>
