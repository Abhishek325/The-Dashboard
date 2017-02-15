<?php
namespace Prote\DBI\Func;
use DIC\Service;

class event {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function add($name,$day,$month,$type,$id){ 
        $this->Db->set_parameters(array($id));
        $c=$this->Db->find_many("SELECT * from event where uid=?");
        foreach ($c as $data)
        {
            if($data->ename==$name&&$data->day==$day&&$data->month==$month)
            { 
              echo "The event <b>".$name." already exists !!!<br>Please wait.."; 
              header("refresh:3;url=/members/event");
              return 0;
            }
        }  
        $name=str_replace("<","&lt;",$name);
        $name=str_replace(">","&gt;",$name);
        $name=str_replace("'","&rsquo;",$name);
        $name=str_replace("\"","&quot;",$name);
        $this->Db->set_parameters(array($id,$name,$day,$month,$type));
        return $this->Db->Insert('INSERT INTO `event` (`uid`,`eid`, `ename`, `day`, `month`,`type`) VALUES (?,NULL,?,?,?,?);');
    } 

    public function getEvents($day,$month,$id){
        $this->Db->set_parameters(array($day,$month,$id));
        if($data=$this->Db->find_one('SELECT `ename` as event FROM `event` WHERE day=? and month=? and uid=?;')){
            return $data->event;
        }else{
            return 0;
        }
    }
    public function getCurrentDayEvents($day,$month,$id){
        $this->Db->set_parameters(array($day,$month,$id));
        if($data=$this->Db->find_many('SELECT * FROM `event` WHERE day=? and month=? and uid=?;')){
            return $data;
        }else{
            return 0;
        }
    } 
    public function getAllEvents($id){ 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_many('SELECT * FROM `event` where uid=?;')){
            return $data;
        }else{
            return 0;
        }
    }
    public function getEventName($id,$uid){ 
        $this->Db->set_parameters(array($id,$uid));
        if($data=$this->Db->find_one('SELECT ename FROM `event` where eid=? and uid=?;')){
            return $data->ename;
        }else{
            return 0;
        }
    } 
    public function getEventMonth($month){ 
            switch($month)
            {

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
    }
    public function getEventCount($day,$month,$id){
        $this->Db->set_parameters(array($day,$month,$id));
        if($data=$this->Db->find_one('SELECT count(`ename`) as count FROM `event` WHERE day=? and month=? and uid=?;')){
            return $data->count;
        }else{
            return 0;
        }
    }
    public function countEvents($id){
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT count(*) as count FROM `event` WHERE uid=?;')){
            return $data->count;
        }else{
            return 0;
        }
    } 
    public function getEventType($id,$uid){
        $this->Db->set_parameters(array($id,$uid));
        if($data=$this->Db->find_one('SELECT `type` from event where id=? and $uid=?')){
            return $data->type;
        }else{
            return 0;
        }
    } 
    public function getNextEventDay($day,$month,$id){ 
        $this->Db->set_parameters(array($day,$id));  
        if($data=$this->Db->find_one('SELECT day FROM `event` WHERE day>? and uid=? order by day LIMIT 1;')){
            return $data->day;
        }else{
            return -1;
        }
    }
    public function getNextEventMonth($day,$month,$id){ 
        $this->Db->set_parameters(array($day,$id));   
        if($data=$this->Db->find_one('SELECT month FROM `event` WHERE month>=? and uid=? order by month LIMIT 1;')){
            return $data->month;
        }else{
            return -1;
        }
    }
    public function delEvent($id,$uid){
        $this->Db->set_parameters(array($id,$uid));
        if($this->Db->query('DELETE from event where eid=?  and uid=? ;')){
            return 1;
        }else{
            return 0;
        }
    } 
    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `event` (
                  `uid` int(255) NOT NULL,
                  `eid` int(255) NOT NULL AUTO_INCREMENT,
                  `ename` varchar(255) NOT NULL,
                  `day` int(2) NOT NULL,
                  `month` int(2) NOT NULL,
                  `type` varchar(100) NOT NULL,
                  PRIMARY KEY (`eid`), 
                  FOREIGN KEY(`uid`) references users(`id`) 
                ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;";
        $payload2="ALTER TABLE `admin` ADD `autologout` INT(2) NOT NULL DEFAULT '61' ;";
        $payloads=(array($payload1,$payload2));
        $this->Db->drop_payload($payloads,$this);
    }
}