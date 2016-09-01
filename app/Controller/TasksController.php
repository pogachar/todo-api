<?php

App::uses('AppController', 'Controller');

class TasksController extends AppController {

	public $uses = ['Task'];
	public $components = ['RequestHandler'];
	public $layout = null;
	public $autoRender = false;

	public function index()
	{
		$tasks = $this->Task->find('all');

		$statusCode = count($tasks) ? 200 : 204;

		$this->RequestHandler->respondAs('application/json');
		$this->response->statusCode($statusCode);
		return json_encode($tasks);
	}

	public function view($id)
	{
		$task = $this->Task->findById($id);

		$this->RequestHandler->respondAs('application/json');

		if(!count($task)) {
			return $this->response->statusCode(404);
		}

		$this->response->statusCode(200);
		return json_encode($task['Task']);
	}

	public function add()
	{
		$this->Task->set($this->request->data);

		if(!$this->Task->validates()) {
			$this->response->statusCode(400);
			return json_encode($this->Task->invalidFields());
		}

		$task = $this->Task->save($this->request->data);

		$this->RequestHandler->respondAs('application/json');
		$this->response->statusCode(201);
		return json_encode($task['Task']);
	}

	public function edit($id)
	{
		$this->Task->read(null, $id);
		$this->Task->set($this->request->data);

		if(!$this->Task->validates()) {
			$this->response->statusCode(400);
			return json_encode($this->Task->invalidFields());
		}

		$task = $this->Task->save($this->request->data);

		$this->RequestHandler->respondAs('application/json');
		$this->response->statusCode(200);
		return json_encode($task['Task']);
	}

	public function delete($id)
	{
		$this->Task->delete($id);

		$this->RequestHandler->respondAs('application/json');
		return $this->response->statusCode(204);
	}

}
