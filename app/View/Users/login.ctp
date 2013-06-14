<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
  <fieldset>
      <legend><?php echo __('Please enter your username and password'); ?></legend>
      <?php 
      echo $this->Form->input('username', array('id' => 'username-field'));
      echo $this->Form->input('password', array('id' => 'password-field'));
      ?>
  </fieldset>
<?php 
echo $this->Form->end(array(
  'label' => __('Login'),
  'class' => 'btn',
  'id' => 'login-button',
));
?>

  <p>&hellip; or <?php echo $this->Html->link('register', array('action' => 'add'), array('class' => 'register')); ?> a new account.</p>
</div>
