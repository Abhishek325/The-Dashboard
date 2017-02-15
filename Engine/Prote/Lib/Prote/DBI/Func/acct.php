<?php
namespace Prote\DBI\Func;
use DIC\Service;

class acct {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
        }
    public function install(){
        $payload1="create database comments;";
        $payload2=" CREATE TABLE IF NOT EXISTS `admin` (
          `Id` int(255) NOT NULL AUTO_INCREMENT,
          `type` varchar(25) NOT NULL DEFAULT 'sir',
          `name` varchar(255) NOT NULL,
          `Email` varchar(255) NOT NULL,
          `Pwd` text NOT NULL,
          `Handle` int(1) NOT NULL DEFAULT '1',
          `login_attempt` int(1) NOT NULL DEFAULT '0',
          `pin` int(4) NOT NULL,
          PRIMARY KEY (`Id`)
          ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
 
        $payloads=(array($payload1,$payload2));
        $this->Db->drop_payload($payloads,$this);
    }
}