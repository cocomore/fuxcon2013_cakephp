<?php
/**
 * Application level Controller
 */
App::uses('Controller', 'Controller');

class AppController extends Controller {
  public $theme = 'Bootstrap';
  public $components = array(
    'DebugKit.Toolbar', 
    'Session',  
    'Auth' => array(
      'loginRedirect' => array('controller' => 'projects', 'action' => 'index'),
      'logoutRedirect' => array('controller' => 'projects', 'action' => 'index'),
      'authorize' => array('Controller'),
      'element' => 'message-auth',
    )
  );

  public function beforeFilter() {
    $this->Auth->allow('index', 'view');
  }

  public function isAuthorized($user) {
    // Admin can access every action
    if (isset($user['role']) && $user['role'] === 'admin') {
      return TRUE;
    }

    // Default deny
    return FALSE;
  }
}
