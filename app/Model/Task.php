<?php

App::uses('Model', 'Model');

class Task extends Model {

	public $useTable = 'tasks';

	public $primaryKey = 'id';

	public $data = ['title', 'description', 'author', 'created_at', 'completed_at'];

	public $_schema = [
		'title' => [
			'type' => 'string'
		],
		'description' => [
			'type' => 'string'
		],
		'author' => [
			'type' => 'string'
		],
		'created_at' => [
			'type' => 'datetime'
		],
		'completed_at' => [
			'type' => 'datetime'
		]
	];

	public $validate = [
		'title' => [
			'rule' => 'notBlank',
			'required' => true,
			'allowEmpty' => false,
			// 'message' => 'The title field is required'
		],
		'description' => [
			'rule' => 'notBlank',
			'required' => true,
			'allowEmpty' => false,
		],
		'author' => [
			'rule' => 'notBlank',
			'required' => true,
			'allowEmpty' => false,
		]
	];

}
