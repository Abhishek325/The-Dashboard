<?php
namespace Prote\DBI\Func;
use DIC\Service;

class alarm {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function add($h,$m,$id){  
        $this->Db->set_parameters(array($id));
        $c=$this->Db->find_many("SELECT * from alarm where uid=?");
        foreach ($c as $data)
        {
            if($data->hr==$h&&$data->min==$m)
            { 
              echo "Duplication in alarm values....<br>Please wait..";
              header("refresh:3;url=/dashboard");
              return 0;
            }
        }
        $this->Db->set_parameters(array($id,$h,$m));  
        return $this->Db->Insert('INSERT INTO `alarm` (`uid`,`aid`, `hr`, `min`, `done`) VALUES (?,NULL, ?, ?, 0);');
    }  
    public function get_count($id){ 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT aid FROM `alarm` where uid=?')){
            return $data->aid;
        }else{
            return 0;
        }
    } 
    public function get_htime($id){ 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT hr FROM `alarm` WHERE done=0 and uid=? order by hr,min LIMIT 1')){
            return $data->hr;
        }else{
            return 0;
        }
    }  
    public function get_mtime($id){ 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT min FROM `alarm` WHERE done=0 and uid=? order by hr,min LIMIT 1')){
            return $data->min;
        }else{
            return 0;
        }
    }        
    public function remove($id){ 
        $this->Db->set_parameters(array($id));
        if($this->Db->query('DELETE FROM `alarm` WHERE done=1 and uid=?')){
            return 1;
        }else{
            return 0;
        }
    }
    public function removeAllAlarms($id){ 
        $this->Db->set_parameters(array($id)); 
        if($this->Db->query('DELETE FROM `alarm` where uid=?;')){
            return 1;
        }else{
            return 0;
        }
    }

    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `alarm` (
                   `uid` int(255) NOT NULL, 
                   `aid` int(255) NOT NULL AUTO_INCREMENT,
                   `hr` int(255) NOT NULL,
                   `min` int(25) NOT NULL,
                   `done` int(1) NOT NULL DEFAULT '0',
                   PRIMARY KEY (`aid`), 
                   FOREIGN KEY(`uid`) references users(`id`) 
                   ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
        $payloads=(array($payload1));
        $this->Db->drop_payload($payloads,$this);
    }

}