<?php
namespace Prote\DBI\Func;
use DIC\Service;

class activity {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function add($id,$activity,$type){
        $this->Db->set_parameters(array($id,$activity,$type)); 
        return $this->Db->Insert('INSERT INTO `activity` (`uid`,`id`, `act_des`, `time`,`type`) VALUES (?,NULL,?, CURRENT_TIMESTAMP,?);');
    }                           

    public function remove($id){ 
        $this->Db->set_parameters(array($id));
         if($this->Db->query('DELETE from activity where uid=?;')){
            return 1;
        }else
            return 0;   
    }
    public function countActivity($id){ 
        $this->Db->set_parameters(array($id));
         if($data=$this->Db->find_one('SELECT count(*) as count from activity where uid=?;')){
            return $data->count;
        }
        else 
            return 0; 
    } 

    public function install(){
    	$payload1="CREATE TABLE IF NOT EXISTS `activity` (
                    `uid` int(255) NOT NULL, 
 				    `id` int(255) NOT NULL AUTO_INCREMENT,
 				    `act_des` varchar(255) NOT NULL,
 				    `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `type` varchar(255) NOT NULL DEFAULT 'info',
 				    PRIMARY KEY (`id`),
                    FOREIGN KEY(`uid`) references users(`id`) 
				   ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
          $payloads=(array($payload1));
        $this->Db->drop_payload($payloads,$this);
    }

}