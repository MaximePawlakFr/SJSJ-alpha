<?php

class AssignPeople {

	public $ppl;
	public $tasks;

	public function __construct(){
		$this->loadFiles();
		$this->randomize();
		$this->output();
	}

	public function loadFiles(){
		$sjsj = file_get_contents('README.md');
		$this->tasks = explode("\n", $tasks);
		
		$ppl = file_get_contents("https://smp.ovh/ppl.json");
		$ppl = json_decode($ppl);
		foreach($ppl as $human){
			$this->ppl[] = new Human($human);
		}
	}

	public function randomize(){
		shuffle($this->sjsj);
		shuffle($this->ppl);
	}

	public function output(){
		var_dump($this->sjsj);
		var_dump(json_encode($this->ppl));
	}

}

class Human {

	public $name;

	public function __construct($humanObject){
		$this->name = ucfirst($humanObject->first_name) . ' ' . substr(ucfirst($humanObject->last_name),0,1) .'.';
	}

}


new AssignPeople();