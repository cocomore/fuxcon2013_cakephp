<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

  public function beforeFilter() {
    parent::beforeFilter();
    $this->Auth->allow('add'); // Letting users register themselves
  }
  
  public function login() {
    if ($user_id = $this->Auth->user('id')) {
      error_log("LOGIN: LOGGED-IN AS {$user_id}\n", 3, '/tmp/behat.log');
      $this->Session->setFlash(__('You are already logged-in'), 'message-error');
      $this->redirect('/');
    }
    if ($this->request->is('post')) {
      error_log("LOGIN-data: " . json_encode($this->request->data) . "\n", 3, '/tmp/behat.log');
      if ($this->Auth->login()) {
        $this->Session->setFlash(__('Welcome back'), 'message-success');
        $this->redirect($this->Auth->redirect());
      } else {
        $this->Session->setFlash(__('Invalid username or password, try again'), 'message-error');
      }
    }
  }
  
  public function logout() {
    $this->Session->setFlash(__('You are logged out'), 'message-success');
    $this->redirect($this->Auth->logout());
  }

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__("The user \"{$this->request->data['User']['username']}\" has been saved"), 'message-success');
				$this->redirect('/');
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'message-error');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'), 'message-success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'), 'message-error');
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'), 'message-success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'), 'message-error');
		$this->redirect(array('action' => 'index'));
	}
}
