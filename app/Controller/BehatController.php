<?php

App::uses('ProjectsController', 'Controller');

/**
 * Behat Controller
 * API to support Behat testing
 */
class BehatController extends AppController {
  public $uses = array('Project', 'User');
  public $layout = 'ajax';
  
  public function config() {
    $this->set(array(
      'pageSize' => ProjectsController::PAGE_SIZE,
      'noCol' => ProjectsController::NO_COL,
    ));
    $this->render('json');
  }

  /**
   * @TODO: Need to find a better way to configure these values
   */
  public function createProjects($count = 0) {
    $count = intval($count);
    if (!$count) {
      $this->set(array(
        'status' => 'ERROR',
        'message' => "You need to pass the number of projects to be created.",
      ));
      $this->render('json');
      return;
    }
    
    $user_id = array();
    foreach (array('tester', 'admin') as $username) {
      $user = $this->User->find('first', array(
        'conditions' => array(
          'User.username' => $username
        )
      ));
      if (!$user) {
        $this->set(array(
          'status' => 'ERROR',
          'message' => "You need to create user '{$username}'.",
        ));
        $this->render('json');
        return;
      }
      
      $user_id[$username] = $user['User']['id'];
    }
    
    // Delete all projects of users 'tester' and 'admin'
    $this->Project->deleteAll(array(
      'Project.user_id' => $user_id
    ));
    
    $tmp = tempnam('/tmp', 'testimage.');
    $picture = array(
      'tmp_name' => $tmp,
      'type' => 'image/jpeg',
      'error' => 'behat_test',
    );
    
    // All generated projects except last belong to 'tester'. Last one belongs to 'admin'
    for ($i = 1; $i <= $count; $i++) {
      copy(IMAGES . 'testimage.jpg', $tmp);
    
      $this->Project->create();
      $start_month = $i*2 - 5;
      $end_month = $i*2 - 3;
      if (!$this->Project->save($p = array(
        'user_id' => $i == $count ? $user_id['admin'] : $user_id['tester'],
        'title' => "Sample project #{$i}",
        'about' => "Lorem #{$i} ipsum dolor sit amet, consetetur 
sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et 
dolore magna aliquyam erat, sed diam voluptua. 
        
At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd 
gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem 
ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod 
tempor invidunt ut labore et dolore magna aliquyam erat, sed diam 
voluptua. 

At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd 
gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.",
        'start_date' => strftime('%Y-%m-%d', 
          strtotime("{$start_month} months ago")),
        'end_date' => strftime('%Y-%m-%d', 
          strtotime("{$end_month} months ago")),
        'created' => strftime('%Y-%m-%d %H:%M:%S'),
        'picture' => $picture,
      ))) {
        throw new Exception("SAVE failed");
      }
      error_log(json_encode($p), 3, '/tmp/behat.log');
    }
    $this->set(array(
      'status' => 'OK',
      'message' => "Created {$count} projects",
    ));
    $this->render('json');
  }
  
  public function checkLogin() {
    $user_id = $this->Auth->user('id');
    $this->set('logged_in', $user_id ? TRUE : FALSE);
    error_log("CHECK: LOGGED-IN AS {$user_id}\n", 3, '/tmp/behat.log');
    $this->render('json');
  }
  
  public function checkAdmin() {
    $user_id = $this->Auth->user('id');
    $role = $this->User->field('role', array('User.id' => $user_id));
    $this->set('is_admin', $role == 'admin' ? TRUE : FALSE);
    $this->render('json');
  }
  
  public function myFirstProject() {
    $user_id = $this->Auth->user('id');
    $project = $this->Project->find('first', array(
      'conditions' => array(
        'Project.user_id' => $user_id
      ),
      'fields' => array('id')
    ));
    $this->set(array(
      'user_id' => $user_id,
      'project_id' => $project['Project']['id']
    ));
    error_log("MY FIRST: user={$user_id}, project={$project['Project']['id']}\n", 3, '/tmp/behat.log');
    $this->render('json');
  }
  
  public function someoneElsesProject() {
    $user_id = $this->Auth->user('id');
    $project = $this->Project->find('first', array(
      'conditions' => array(
        'Project.user_id !=' => $user_id
      ),
      'fields' => array('id')
    ));
    
    $this->set(array(
      'user_id' => $user_id,
      'project_id' => empty($project) ? NULL : $project['Project']['id']
    ));
    $this->render('json');
  }
  
  public function beforeFilter() {
    $this->Auth->allow();
  }
}