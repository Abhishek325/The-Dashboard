<?php
namespace Prote\DBI\Func;
use DIC\Service;

class notification {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }
    public function add($uid,$noti)
    { 
       $done=0;
       $this->Db->set_parameters(array($uid,$noti)); 
       return $this->Db->Insert('INSERT INTO `notification` (`uid`,`id`, `noti`) VALUES (?,NULL, ?);');

    }
    public function get_count($id)
    { 
       $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_one('SELECT count(*)  as total FROM `notification` where uid=?;')){
            return $data->total;
        }else{
            return 0;
        }
    }
    public function get_notification($id)
    { 
       $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_one('SELECT noti FROM `notification` where uid=?;')){
            return $data->noti;
        }else{
            return 0;
        }
    }
    public function remove($id,$uid){
        $this->Db->set_parameters(array($id,$uid));
        if($this->Db->query('DELETE FROM `notification` WHERE id=? and uid=?;')){ 
            return 1;
        }else{
            return 0;
        }
    } 
    public function removeAll($id)
    { 
       $this->Db->set_parameters(array($id)); 
        if($this->Db->query('DELETE FROM `notification` WHERE uid=?;')){
            return 1;
        }else{
            return 0;
        }
    } 
    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `notification` (
                  `uid` int(255) NOT NULL,
                  `id` int(255) NOT NULL AUTO_INCREMENT,
                  `noti` varchar(255) NOT NULL, 
                  PRIMARY KEY (`id`),
                  FOREIGN KEY(`uid`) references users(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;"; 
        $payloads=(array($payload1));
        $this->Db->drop_payload($payloads,$this);
    }
 
}