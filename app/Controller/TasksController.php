<?php

App::uses('AppController', 'Controller');

class TasksController extends AppController {

	public $uses = ['Task'];
	public $components = ['RequestHandler', 'Paginator'];
	public $layout = null;
	public $autoRender = false;

	public function beforeFilter()
	{
		if ($this->request->method() == 'OPTIONS') {
			$this->response->header('Access-Control-Allow-Headers', 'Content-Type');
			$this->response->send();
			exit;
		}
	}

	public function afterFilter()
	{
		$this->RequestHandler->respondAs('application/json');
	}

	public function index()
	{
		$this->Paginator->settings = [
			'limit' => 3,
			'page' => $this->request->query('page') ?: 1
		];

		$this->response->statusCode(200);

		return $this->response->body(json_encode([
			'data' => $this->Paginator->paginate(),
			'pagination' => $this->makePagination()
		]));
	}

	public function view($id)
	{
		$task = $this->Task->findById($id);

		if(!count($task)) {
			return $this->response->statusCode(404);
		}

		$this->response->statusCode(200);
		return $this->response->body(json_encode($task));
	}

	public function add()
	{
		$this->Task->set($this->request->data);

		if(!$this->Task->validates()) {
			$this->response->statusCode(400);
			return $this->response->body(json_encode($this->Task->invalidFields()));
		}

		$task = $this->Task->save($this->request->data);

		$this->response->statusCode(201);
		return $this->response->body(json_encode($task));
	}

	public function edit($id)
	{
		$this->Task->read(null, $id);
		$this->Task->set($this->request->data);

		if(!$this->Task->validates()) {
			$this->response->statusCode(400);
			return $this->response->body(json_encode($this->Task->invalidFields()));
		}

		$data = $this->request->data;
		if(!isset($data['completed_at']) || $data['completed_at'] == null) {
			$data['completed_at'] = '0000-00-00 00:00:00';
		}

		$task = $this->Task->save($data);

		$this->response->statusCode(200);
		return $this->response->body(json_encode($task));
	}

	public function delete($id)
	{
		$this->Task->delete($id);

		return $this->response->statusCode(204);
	}
	/**
	 * @return array
	 */
	private function makePagination()
	{
		$perPage = 3;
		$total = $this->Task->find('count');
		$currentPage = (int)$this->request->query('page') ?: 1;

		return [
			'total' => $total,
			'per_page' => $perPage,
			'current_page' => $currentPage,
			'last_page' => ceil($total / $perPage),
			'from' => ($currentPage - 1) * $perPage + 1,
			'to' => $currentPage * $perPage
		];
	}

}
