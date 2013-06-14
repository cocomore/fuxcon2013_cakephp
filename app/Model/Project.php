<?php
App::uses('AppModel', 'Model');
/**
 * Project Model
 *
 * @property User $User
 */
class Project extends AppModel {
  public $actsAs = array('Tags.Taggable', 'Containable');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'about' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * From http://book.cakephp.org/2.0/en/tutorials-and-examples/blog-auth-example/auth.html
	 */
	public function isOwnedBy($post, $user) {
    return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
  }
  
  /**
   * Before saving the project, check an uploaded picture
   */
  public function beforeSave($options = array()) {
    if (!isset($this->data[$this->alias]['picture'])) {
      return TRUE;
    }
    $file = $this->data[$this->alias]['picture'];
    //D error_log("UPLOAD " . json_encode($file) . "\n", 3, "/tmp/fuxcon.log");
    if ($file['error'] === UPLOAD_ERR_NO_FILE 
      || $file['error'] === 'behat_test') {
      //D error_log("UPLOAD SUCCESS 1\n", 3, "/tmp/fuxcon.log");
      return TRUE;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
      //D error_log("UPLOAD FAIL 1\n", 3, "/tmp/fuxcon.log");
      return FALSE;
    }
    if (strpos($file['type'], 'image/jpeg') !== 0) {
      //D error_log("UPLOAD FAIL 2\n", 3, "/tmp/fuxcon.log");
      return FALSE;
    }
    //D error_log("UPLOAD SUCCESS 2\n", 3, "/tmp/fuxcon.log");
    return TRUE;
  }

  /**
   * After saving the project, save an uploaded picture
   */
  public function afterSave($created) {
    if (!isset($this->data[$this->alias]['picture'])) {
      return;
    }
    $file = $this->data[$this->alias]['picture'];
    if ($file['error'] === 'behat_test') {
      if (!rename($file['tmp_name'], IMAGES . 'project' . DS . $this->id . '.jpg')) {
        //D error_log("AFTER FAIL 1\n", 3, "/tmp/fuxcon.log");
        throw new Exception("Failed to move file: " 
          . posix_strerror(posix_get_last_error()));
      }
    }
    else
    if ($file['error'] === UPLOAD_ERR_OK) {
      if (!move_uploaded_file($file['tmp_name'], IMAGES . 'project' . DS . $this->id . '.jpg')) {
        //D error_log("AFTER FAIL 2\n", 3, "/tmp/fuxcon.log");
        throw new Exception("Failed to move file: " 
          . posix_strerror(posix_get_last_error()));
      }
    }
  }
}
