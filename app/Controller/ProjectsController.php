<?php

App::uses('AppController', 'Controller');

/**
 * Projects Controller
 *
 * @property Project $Project
 */
class ProjectsController extends AppController {

  const NO_COL = 3;
  const PAGE_SIZE = 5;

  public $paginate = array(
    'Project' => array(
      'limit' => self::PAGE_SIZE,
    ) 
  );
  
  public $helpers = array('Thumbnail', 'Markdown.Markdown');

  /**
   * Show a list of columns with projects
   */
  public function index() {
		$this->Project->recursive = 0;
    $this->set('title_for_layout', 'Projects');

    $projects = $this->paginate('Project');
    $columns = array();
    foreach ($projects as $i => $project) {
      $col = $i % self::NO_COL;
      $columns[$col][] = $project;
    }
    $this->set(array(
      'columns' => $columns,
      'width' => 12 / self::NO_COL,
    ));
  }
  
  /**
   * Show a single project
   */
  public function view($id) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__('Invalid project'));
		}
		$project = $this->Project->find('first', array(
		  'conditions' => array(
		    'Project.' . $this->Project->primaryKey => $id
		  )
		));

    $startDate = $project['Project']['start_date']
      ? strftime('%m/%Y', strtotime($project['Project']['start_date']))
      : NULL;

    $dates = NULL;

    if ($startDate) {
      $dates = $startDate;
    }

    $endDate = $project['Project']['end_date']
      ? strftime('%m/%Y', strtotime($project['Project']['end_date']))
      : NULL;
    if ($endDate) {
      if (!empty($dates)) {
        $dates .= ' ';
      }
      $dates .= 'until ' . $endDate;
    }
    else
    if (!empty($dates)) {
      $dates = 'since ' . $dates;
    }

		$this->set(array(
		  'project' => $project,
		  'dates' => $dates,
		  'mayEdit' => $this->isAuthorized(AuthComponent::user(), 'edit'),
		));
    
    $this->set('title_for_layout', 'Project ' . $project['Project']['title']);
  }


/**
 * add method
 *
 * @return void
 */
	public function add() {
	  //D error_log("ADD\n", 3, "/tmp/fuxcon.log");
		if ($this->request->is('post')) {
			$this->Project->create();
      $this->request->data['Project']['user_id'] = $this->Auth->user('id');

			if ($this->Project->save($this->request->data)) {
			  //D error_log("SAVED " . $this->Project->getInsertId() . "\n", 3, "/tmp/fuxcon.log");
				$this->Session->setFlash(__('The project has been saved'), 'message-success');
				$this->redirect(array('action' => 'view', $this->Project->getInsertID()));
			} else {
			  //D error_log(json_encode($this->Project->validationErrors) . "\n", 3, "/tmp/fuxcon.log");
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'), 'message-error');
			}
		}
		$users = $this->Project->User->find('list');
		$tags = $this->Project->Tag->find('list');
		$this->set(compact('users', 'tags'));
		
		$this->set('pageTitle', __('Add new project'));
		$this->render('edit');
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Project->exists($id)) {
			throw new NotFoundException(__('Invalid project'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
      unset($this->request->data['user_id']);
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('The project has been saved'), 'message-success');
				$this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The project could not be saved. Please, try again.'), 'message-error');
			}
		} else {
			$options = array('conditions' => array('Project.' . $this->Project->primaryKey => $id));
			$this->request->data = $this->Project->find('first', $options);
		}
		$users = $this->Project->User->find('list');
		$tags = $this->Project->Tag->find('list');
		$this->set(compact('users', 'tags'));

		$this->set('pageTitle', __('Edit project'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			throw new NotFoundException(__('Invalid project'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Project->delete()) {
			$this->Session->setFlash(__('Project deleted'), 'message-success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Project was not deleted'), 'message-error');
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * From http://book.cakephp.org/2.0/en/tutorials-and-examples/blog-auth-example/auth.html
	 */
	public function isAuthorized($user, $action = NULL) {
    // All registered users can add projects
    if ($this->action === 'add') {
      return true;
    }

    if (!$action) {
      $action = $this->action;
    }

    // The owner of a project can edit and delete it
    if (in_array($action, array('edit', 'delete'))) {
      $projectId = $this->request->params['pass'][0];
      if ($this->Project->isOwnedBy($projectId, $user['id'])) {
        return TRUE;
      }
    }

    return parent::isAuthorized($user);
  }
}
