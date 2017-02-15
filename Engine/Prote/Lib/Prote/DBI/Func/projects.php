<?php
namespace Prote\DBI\Func;
use DIC\Service;

class projects{
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function add($name,$deadline,$type,$desc,$id){
        $this->Db->set_parameters(array($name,$id));
        if($data=$this->Db->find_one('select name from project where name like ? and uid=?')) 
         { 
            return 0;
         }   
        $this->Db->set_parameters(array($id,$name,$deadline,$type,$desc));
        return $this->Db->Insert('INSERT INTO `project` (`uid`,`id`, `name`, `deadline`, `type`,`desc`,`progress`) VALUES (?,NULL, ?,?,?,?,1);');
    }

    public function addProjectMap($id,$module,$uid){
        $this->Db->set_parameters(array($id,$module,$uid));
        $c=$this->Db->find_many("SELECT * from projectmap where id=? and module=? and uid=?");
        foreach ($c as $data)
        {
            if($data->id==$id&&$data->module==$module)
            { 
              echo "The module <b>".$module." already exists!!<br>Please wait.."; 
              header("refresh:1;url=/projects");
              return 0;
            }
        }
        $this->Db->set_parameters(array($uid,$id,$module));
        return $this->Db->Insert('INSERT INTO `projectmap` (`uid`,`id`, `bug`, `module`) VALUES (?,?, NULL,?);');
    } 

    public function getProjectCount($id){  
        $this->Db->set_parameters(array($id));
      if($data=$this->Db->find_one('select count(*) as count from project where uid=?')){
            return $data->count;
        }else{
            return 0;
        }
    }

    public function getProjects($id){  
        $this->Db->set_parameters(array($id));
      if($data=$this->Db->find_many('select * from project where type!=3 and uid=? order by name')){
            return $data;
        }else{
            return 0;
        }
    }

    public function getSecretProjects($id){  
        $this->Db->set_parameters(array($id));
      if($data=$this->Db->find_many('select * from project where type=3 and uid=?')){
            return $data;
        }else{
            return 0;
        }
    } 

    public function getProjectName($id,$uid){  
        $this->Db->set_parameters(array($id,$uid));
      if($data=$this->Db->find_one('select name from project where id=? and uid=?')){
            return $data->name;
        }else{
            return 0;
        }
    }

    public function getProjectId($project,$uid){  
        $this->Db->set_parameters(array($project,$uid));
      if($data=$this->Db->find_one('select id from project where name=? and uid=?')){
            return $data->id;
        }else{
            return 0;
        }
    }  

    public function getProjectDeadlineDay($id,$uid){  
        $this->Db->set_parameters(array($id,$uid));
      if($data=$this->Db->find_one('select substring(`deadline`,9,2) as day from project where id=? and uid=?')){
            return $data->day;
        }else{
            return 0;
        }
    }  

    public function getProjectDeadlineMonth($id,$uid){  
        $this->Db->set_parameters(array($id,$uid));
      if($data=$this->Db->find_one('select substring(`deadline`,6,2) as month from project where id=? and uid=?')){
        $val=$data->month;
        switch ($val) { 
                case 1 :return 'January';
                case 2 :return 'February';
                case 3 :return 'March';
                case 4 :return 'April';
                case 5 :return 'May';
                case 6 :return 'June';
                case 7 :return 'July';
                case 8 :return 'August';
                case 9 :return 'September';
                case 10:return 'October';
                case 11:return 'November'; 
                case 12:return 'December'; 
        }
            return $val;
        }else{
            return 0;
        }
    }  
    
    public function getProjectDeadlineYear($id,$uid){  
        $this->Db->set_parameters(array($id,$uid));
      if($data=$this->Db->find_one('select substring(`deadline`,1,4) as year from project where id=? and uid=?')){
            return $data->year;
        }else{
            return 0;
        }
    } 

    public function getProjectModuleCount($id,$uid){  
        $this->Db->set_parameters(array($id,$uid));
      if($data=$this->Db->find_one('select count(*) as count from projectmap where id=? and uid=?')){
            return $data->count;
        }else{
            return 0;
        }
    }  

    public function getProjectModules($id,$uid){  
        $this->Db->set_parameters(array($id,$uid));
      if($data=$this->Db->find_many('select module  from projectmap where id=? and uid=?')){
            return $data;
        }else{
            return 0;
        }
    }
    public function getProjectProgress($id,$uid){  
        $this->Db->set_parameters(array($id,$uid));
      if($data=$this->Db->find_one('select progress from `project` where id=? and uid=?')){
            return $data->progress;
        }else{
            return 0;
        }
    }  
    
    public function UpdateProgress($id,$val,$uid){  
        $this->Db->set_parameters(array($val,$id,$uid));
      if($data=$this->Db->query('UPDATE `project` SET `progress` = ? WHERE `id` = ? and uid=?;')){
            return 1;
        }else{
            return 0;
        }
    }  
    
    public function removeModule($id,$mod,$uid){
        $this->Db->set_parameters(array($id,$mod,$uid));
        if($this->Db->query('DELETE FROM `projectmap` WHERE id=? and module=?  and uid=?;')){
            return 1;
        }else{
            return 0;
        }
    }

    public function remove($id,$uid){
        $this->Db->set_parameters(array($id,$uid));
        if($this->Db->query('DELETE FROM `projectmap` WHERE id=? and uid=?;')){ 
        if($this->Db->query('DELETE FROM `project` WHERE id=? and uid=?;')){
            return 1;
        }
        }else{
            return 0;
        }
    } 

    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `project` (
                  `uid` int(255) NOT NULL, 
                  `id` int(255) NOT NULL AUTO_INCREMENT,
                  `name` varchar(255) NOT NULL,
                  `deadline` date NOT NULL,
                  `type` int(1) NOT NULL DEFAULT '1', 
                  `desc` text NOT NULL,
                  `progress` int(3) NOT NULL,
                  PRIMARY KEY (`id`), 
                  FOREIGN KEY(`uid`) references users(`id`)
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";

        $payload2="CREATE TABLE IF NOT EXISTS `projectmap` (
                  `uid` int(255) NOT NULL, 
                  `id` int(255) DEFAULT NULL,
                  `bug` varchar(255) DEFAULT NULL,
                  `module` varchar(255) DEFAULT NULL,
                  KEY `id` (`id`), 
                  FOREIGN KEY(`uid`) references users(`id`),
                  FOREIGN KEY(`id`) references project(`id`)  
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
 
        $payloads=(array($payload1,$payload2));
        $this->Db->drop_payload($payloads,$this);
    }
}