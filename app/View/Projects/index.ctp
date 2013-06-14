<?php 
$page = $this->params['paging']['Project']['page']; 
if ($page == 1):
?>
	<div class="jumbotron">
		<h1>CakePHP 2</h1>
		<p class="lead">4 Frameworks - FUxCon 2013</strong></p>
	</div>

<?php
endif;
?> 

<div class="row-fluid projects">

  <?php foreach ($columns as $column): ?>
  	<div class="span<?php echo $width; ?>">
    <?php foreach ($column as $project): ?>
      <div class="project">
        <h4>
          <?php echo $this->Html->link($project['Project']['title'], array('action' => 'view', $project['Project']['id'])); ?>
        </h4>
        <?php echo $this->Html->link(
          $this->Thumbnail->render('project/' . $project['Project']['id'] . '.jpg', array(
            'width' => 200, 'height' => 200, 'resizeOption' => 'auto',
          )), array('action' => 'view', $project['Project']['id']), array('escape' => FALSE, 'class' => 'thumbnail')); ?>
        <p class="about"><?php echo $this->Text->truncate($project['Project']['about'], /*length*/100 + rand(1, 100), array('exact' => FALSE)); ?></p>
      </div>
    <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>

<?php echo $this->element('paginate'); ?>
