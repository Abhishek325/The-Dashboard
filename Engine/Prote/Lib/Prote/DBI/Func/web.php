<?php
namespace Prote\DBI\Func;
use DIC\Service;

class web {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function add($web,$url){ 
        $this->Db->set_parameters(array($web,$url));
        //return $this->Db->Insert('INSERT INTO `comments`.`web` (`name`, `url` ) VALUES (?,?);');
        $this->Db->Insert('INSERT INTO `web` (`name`, `url` ) VALUES (?,?);');
        return 1;
    }    
    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `web` (
                   `name` varchar(255) NOT NULL,
                   `url` varchar(255) NOT NULL,
                   `freq` int(10) NOT NULL DEFAULT '0',
                   PRIMARY KEY (`name`)
                   ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

        $payload2="INSERT INTO `web` (`name`, `url`, `freq`) VALUES
                   ('Google', 'http://www.google.com', 0),
                   ('Gmail', 'http://mail.google.com', 0),
                   ('Facebook', 'http://www.facebook.com', 0) ;";
        $payloads=(array($payload1,$payload2));
        $this->Db->drop_payload($payloads,$this);
    }
    
}