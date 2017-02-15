<?php

namespace Database;
use Database\Blueprints\Database as Database_Blueprint,
DIC\Service;
class Database extends Database_Blueprint{

	private $result=NULL;
	private $Container;

	public function __construct(Service $Service){
		$this->Service=$Service;
		$this->Config=$this->Service->Config();
		parent::__construct();
	}

	public function drop_payload($payloads,$class=NULL){
		if($class==NULL){
			$caller=get_class();
		}else{
			$caller=get_class($class);	
		}
		$i=1;
		// $caller=get_called_class();
		echo "<div style='background:#000;color:#fff;padding:7px;'>";
		foreach($payloads as $payload){
			// var_dump($payload);
			echo "<div style='font-size:20px;'> &rsaquo;&rsaquo; Dropping payload <code style='font-size:18px;font-weight:300;'>".$i."</code> for ".$caller.".";
			$this->query($payload);
			echo "</div>";
			$i++;
		}
		echo "<em style='color:#0f0;'>&nbsp;&nbsp;&nbsp;&nbsp;Sequence complete.</em></div>";
	}

	public function check_dependencies($payloads,$class=NULL){
		if($class==NULL){
			$caller=get_class();
		}else{
			$caller=get_class($class);	
		}
		$i=1;
		foreach($payloads as $payload){
			echo "checking dependency ".$payload." for ".$caller.".";
			$this->set_parameters(array($this->Config->get_database_name(),$payload));
			if($this->find_one('SELECT TABLE_NAME as T FROM information_schema.tables WHERE table_schema = ? AND table_name = ? LIMIT 1 ')->T){
				echo "Dependency met.<br>";
			}else{
				echo "Dependency not met.<br>Prote Out.";
				exit();
			}
			echo "<br>";
			$i++;
		}
	}


	public function get_result_by_usn($usn){
		if ($this->result!=NULL && $this->result->usn_code==$usn){
			return $this->result;
		}
		$this->connect();
		$this->set_parameters(array($usn));
		// $result=$this->query("Select * FROM exam_Va WHERE usn_code=?");
		$result=$this->find_one("Select * FROM exam_Va WHERE usn_code=?");
		return $result;
	}

	public function get_name_by_usn($usn){
		$this->connect();
		$this->set_parameters(array($usn));
		$result=$this->query("Select st_name FROM student WHERE usn_code=?");
		// var_dump($result);
		return $result->st_name;
	}

	
}

?>
