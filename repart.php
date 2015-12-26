<?php

class AssignPeople {

	public $ppl;
	public $tasks;

	public function __construct(){
		$this->loadFiles();
		$this->randomize();
		$this->assign();
		$this->output();
	}

	public function loadFiles(){
		$tasks = file_get_contents('README.md');
		$this->tasks = explode("\n", $tasks);
		
		$ppl = file_get_contents("https://smp.ovh/ppl.json");
		$ppl = json_decode($ppl);
		foreach($ppl as $human){
			$this->ppl[] = new Human($human);
		}
	}

	public function randomize(){
		shuffle($this->tasks);
		shuffle($this->ppl);
	}

	public function assign(){
		$i = 0;
		foreach($this->tasks as $task){
			$this->ppl[$i]->terms[] = $task;
			$i++;
			if(!isset($this->ppl[$i])){
				$i = 0;
			} 
		}
	}

	public function output(){
		//var_dump($this->tasks);
		//var_dump(json_encode($this->ppl));
		$this->confirm();
		$this->toMd();
	}

	public function toMd(){
		echo 'outputing file';
		$out = [];
		foreach($this->ppl as $p) {
			$out[] = '##' . $p->name;
			foreach($p->terms as $term) {
				$out[] = '-' . $term;
			}
			$out[] = '';
		}

		echo join("\n", $out);
	}

	public function confirm(){
		echo "Ecrire le fichier md?  (y/N): ";
		$handle = fopen ("php://stdin","r");
		$line = fgets($handle);
		fclose($handle);
		if(trim($line) != 'y'){
		    echo "ABORTING!\n";
		    exit;
		}
		echo "\n"; 
		echo "Thank you, continuing...\n";
	}

}

class Human {

	public $name;
	public $terms = [];

	public function __construct($humanObject){
		$this->name = ucfirst($humanObject->first_name) . ' ' . substr(ucfirst($humanObject->last_name),0,1) .'.';
	}

}


new AssignPeople();