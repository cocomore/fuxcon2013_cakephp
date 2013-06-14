<div class="row">
  <div class="span5">
    <p class="thumbnail picture-content">
      <?php 
      echo $this->Thumbnail->render('project/' . $project['Project']['id'] . '.jpg', array(
        'width' => 380, 'height' => 380, 'resizeOption' => 'auto')); 
      ?>
    </p>
    <?php if ($dates): ?>
      <p class="dates-content"><strong>Times:</strong> <?php echo $dates; ?></p>
    <?php endif; ?>
    <?php if ($project['Tag']): ?>
      <p class="tags-content"><strong>Topics:</strong> 
        <?php foreach ($project['Tag'] as $tag): ?>
          <span class="label"><?php echo $tag['name']; ?></span>
        <?php endforeach; ?>
      </p>
    <?php endif; ?>
    <p class="actions">
      <?php if ($mayEdit): ?>
        <?php echo $this->Html->link('edit this project', array('action' => 'edit', $project['Project']['id']), array('class' => 'btn', 'id' => 'edit-project')); ?>
      <?php endif; ?>
    </p>
  </div>
  <div class="span4">
      <h1 class="title-content"><?php echo $project['Project']['title']; ?></h1>
      <div class="about-content"><?php echo Markdown($project['Project']['about']); ?></div>
  </div>
</div>
