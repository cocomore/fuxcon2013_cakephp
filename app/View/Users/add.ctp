<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username', array('id' => 'username-field'));
		echo $this->Form->input('password', array('id' => 'password-field'));
	?>
	</fieldset>
<?php 
echo $this->Form->end(array(
  'label' => __('Register'),
  'class' => 'btn',
  'id' => 'register-button',
));
?>
</div>
