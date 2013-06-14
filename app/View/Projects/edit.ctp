<div class="row">
  <?php 
  echo $this->Form->create('Project', array(
    'class' => 'span6 offset1',
    'type' => 'file',
  )); 
  echo $this->Form->hidden('id');
  ?>
    <h3><?php echo $pageTitle; ?></h3>
    <div class="clearfix">
    	<?php
  		echo $this->Form->input('title', array('class' => 'input-block-level', 'id' => 'title-field'));
  		?>
  		<div class="pull-right thumbnail">
    		<?php
        echo $this->Thumbnail->render('project/' . 1 . '.jpg', array(
          'width' => 160, 
          'height' => 160, 
          'resizeOption' => 'auto',
        )); 
        ?>
  		</div>
  		<?php
  		echo $this->Form->input('picture', array(
  		  'type' => 'file',
  		  'id' => 'picture-field'
  		));
  		?>
    </div>
    <?php
		echo $this->Form->input('about', array('class' => 'input-block-level project-about', 'id' => 'about-field'));
    ?>  		
    <div class="row">
  		<?php
  		echo $this->Form->input('start_date', array(
  		  'type' => 'text',
  		  'div' => array(
    		  'class' => 'span3',
    	  ),
    	  'id' => 'start_date-field'
  		));
  		echo $this->Form->input('end_date', array(
  		  'type' => 'text',
  		  'div' => array(
    		  'class' => 'span3',
    	  ),
    	  'id' => 'end_date-field'
  		));
  		?>
    </div>  		
		<?php
		echo $this->Form->input('tags', array(
		  'type' => 'text',
		  'class' => 'input-block-level',
		  'id' => 'tags-field'
		));
  	?>
  <?php 
  echo $this->Form->end(array(
    'label' => __('Submit'),
    'class' => 'btn',
    'id' => 'save-button',
  ));
  ?>
</div>
