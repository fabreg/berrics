<?php
App::uses('LocalAppController', 'Controller');
/**
 * TrendingPosts Controller
 *
 * @property TrendingPost $TrendingPost
 */
class TrendingPostsController extends LocalAppController {

	public function beforeFilter() {
		
		parent::beforeFilter();

		$this->initPermissions();

	}

/**
 * index method
 *
 * @return void
 */
	public function index() {

		$this->Paginator->settings = array(
			"TrendingPost"=>array(
				"contain"=>array(
					"Dailyop"
				)
			)
		);

		$this->TrendingPost->recursive = 0;
		$this->set('trendingPosts', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->TrendingPost->id = $id;
		if (!$this->TrendingPost->exists()) {
			throw new NotFoundException(__('Invalid trending post'));
		}
		$this->set('trendingPost', $this->TrendingPost->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TrendingPost->create();
			if ($this->TrendingPost->save($this->request->data)) {
				$this->Session->setFlash(__('The trending post has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The trending post could not be saved. Please, try again.'));
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
		$this->TrendingPost->id = $id;
		if (!$this->TrendingPost->exists()) {
			throw new NotFoundException(__('Invalid trending post'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {

			$this->request->data['TrendingPost']['start_date'] = $this->request->data['TrendingPost']['start_date_date']." ".$this->request->data['TrendingPost']['start_time'].":00";

			$this->request->data['TrendingPost']['end_date'] = $this->request->data['TrendingPost']['end_date_date']." ".$this->request->data['TrendingPost']['end_time'].":00";

			if ($this->TrendingPost->save($this->request->data)) {
				$this->Session->setFlash(__('The trending post has been saved'));

				if(isset($this->request->params['named']['cb'])) return $this->redirect(base64_decode($this->request->params['named']['cb']));

				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The trending post could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->TrendingPost->find("first",array(

				"conditions"=>array(
					"TrendingPost.id"=>$id
				),
				"contain"=>array(
					"Dailyop"=>array(
						"DailyopSection"
					)
				)

			));

			$stime = strtotime($this->request->data['TrendingPost']['start_date']);
			$etime = strtotime($this->request->data['TrendingPost']['end_date']);

			$this->request->data['TrendingPost']['start_date_date'] = date("Y-m-d",$stime);
			$this->request->data['TrendingPost']['start_time'] = date("h:i",$stime);
			$this->request->data['TrendingPost']['end_date_date'] = date("Y-m-d",$etime);
			$this->request->data['TrendingPost']['end_time'] = date("h:i",$etime);

		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->TrendingPost->id = $id;
		if (!$this->TrendingPost->exists()) {
			throw new NotFoundException(__('Invalid trending post'));
		}
		if ($this->TrendingPost->delete()) {
			$this->Session->setFlash(__('Trending post deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Trending post was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function add_post($dailyop_id) {

		$id = $this->TrendingPost->addPost($dailyop_id);

		$this->redirect(array("action"=>"edit",$id));

		return;

	}








}
