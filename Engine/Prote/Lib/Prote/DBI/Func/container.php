<?php
namespace Prote\DBI\Func;
use DIC\Service;
class container {
	private $Storage=array();
	private $Service;

	public function __construct(Service $Service){
		$this->Service=$Service;
	}

	public function available($class){
		if(isset($this->Storage[$class]))
			return true;
		else
			return false;
	}

	public function load($name,$path){
		if($this->available($name))
			return $this->Storage[$name];
		else
			return $this->Storage[$name]=new $path($this->Service);
	}

	public function users(){
		return $this->load('users','\Prote\DBI\Func\users');
	}
    public function notes(){
		return $this->load('notes','\Prote\DBI\Func\notes');
	}
    public function acct(){
		return $this->load('acct','\Prote\DBI\Func\acct');
	}
	public function web(){
		return $this->load('web','\Prote\DBI\Func\web');
	}
	public function thought(){
		return $this->load('thought','\Prote\DBI\Func\thought');
	} 
    public function reminder(){
		return $this->load('reminder','\Prote\DBI\Func\reminder');
	}
    public function alarm(){
		return $this->load('alarm','\Prote\DBI\Func\alarm');
	}
	public function comment(){
		return $this->load('comment','\Prote\DBI\Func\comment');
	}
	public function custom(){
		return $this->load('custom','\Prote\DBI\Func\custom');
	}
	public function rate(){
		return $this->load('rate','\Prote\DBI\Func\rate');
	}  
	public function activity(){
		return $this->load('activity','\Prote\DBI\Func\activity');
	}  
	public function notification(){
		return $this->load('notification','\Prote\DBI\Func\notification');
	}  
	public function event(){
		return $this->load('event','\Prote\DBI\Func\event');
	}

	public function projects(){
		return $this->load('projects','\Prote\DBI\Func\projects');
	}
}