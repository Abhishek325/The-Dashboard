<?php
namespace Prote\DBI\Func;
use DIC\Service;

class reminder {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    } 
    public function add($text,$h,$m,$L,$id){
        $text=preg_replace ("/ +/", " ", $text);
        $sym=array("<",">");
        $map=array("&lt;","&gt;");
        $text=str_replace($sym,$map,$text);  
        $this->Db->set_parameters(array($text,$h,$m,$L));
        if($text==" ")
        {
          echo "Invalid Input.<br><b>Redirecting to dashboard.</b><br>";
          header("refresh:2;url=/dashboard");
        } 
        else
        {  
        $this->Db->set_parameters(array($id));
          $c=$this->Db->find_many("SELECT * from reminder where uid=?");
        foreach ($c as $data)
        {
            if($data->hour==$h&&$data->minute=$m)
            { 
              echo "Another reminder with same time already exists..<br>Please wait.."; 
              header("refresh:3;url=/dashboard");
              return 0;
            }
        }
        //$text=$this->Html()->secure_post_text($text);  
        $this->Db->set_parameters(array($id,$text,$h,$m,$L));
        return $this->Db->Insert('INSERT INTO `reminder` (`uid`,`rid`, `rname`, `hour`, `minute`, `done`, `link`) VALUES (?,NULL, ?, ?, ?,0,?);');
        }
    } 
    public function get_text($id){
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT `rname` FROM `reminder` where uid=? LIMIT 1')){
            return $data->rname;
        }else{
            return 0;
        }
    }  
    public function get_link($id){
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT `link` FROM `reminder` where uid=? LIMIT 1')){
            return $data->link;
        }else{
            return 0;
        }
    }    
    public function get_htime($id){ 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT hour FROM `reminder` WHERE uid=? order by rid')){
            return $data->hour;
        }else{
            return 0;
        }
    }  
   
    public function get_mtime($id){ 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT minute FROM `reminder` WHERE uid=? order by rid')){
            return $data->minute;
        }else{
            return 0;
        }
    } 
    public function get_count($id){
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT rname FROM `reminder` where uid=?')){
            return $data->rname;
        }else{
            return 0;
        }
    } 
   
    public function delete($rid,$id){
        $this->Db->set_parameters(array($rid,$id));
        if($this->Db->query('DELETE FROM `reminder` WHERE rid=? and uid=?')){
            return 1;
        }else{
            return 0;
        }
    }

    public function remove($h,$uid){
        $this->Db->set_parameters(array($h,$uid));
        if($this->Db->query('DELETE FROM `reminder` WHERE hour<? and uid=?')){
            return 1;
        }else{
            return 0;
        }
    }

    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `reminder` (
                 `uid` int(255) NOT NULL, 
                 `rid` int(255) NOT NULL AUTO_INCREMENT,
                 `rname` varchar(255) NOT NULL,
                 `hour` int(2) NOT NULL,
                 `minute` int(2) NOT NULL,
                 `done` int(1) NOT NULL DEFAULT '0',
                 `link` varchar(255) NOT NULL,
                 PRIMARY KEY (`rid`),
                 FOREIGN KEY(`uid`) references users(`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
        $payloads=(array($payload1));
        $this->Db->drop_payload($payloads,$this);
    }
  
}