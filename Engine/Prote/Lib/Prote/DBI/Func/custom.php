<?php
namespace Prote\DBI\Func;
use DIC\Service;

class custom{
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function check_url($url)
    {
       $ch = curl_init($url);  
       curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
       curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
       $data = curl_exec($ch);  
       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
       curl_close($ch);  
       if($httpcode>=200 && $httpcode<300) 
          return 1;
        return 0;     
    }

    public function add($data)
    {
      $this->Db->set_parameters(array($data)); 
       return $this->Db->Insert('INSERT INTO `weather_dump` (`wid`, `data`, `time`) VALUES (NULL,?, CURRENT_TIMESTAMP);');
    }
    public function display_old_data()
    {
      if($data=$this->Db->find_one('select data as dump from weather_dump;')){
            return $data->dump;
        }else{
            return 0;
        }
    }
    public function get_time()
    {
      if($data=$this->Db->find_one('select time  from weather_dump;')){
            return $data->time;
        }else{
            return 0;
        }
    }
     public function remove(){ 
        if($this->Db->query('DELETE FROM `weather_dump` WHERE 1')) {}
            return 1; 
        return 0;
    }
    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `weather_dump` (
                   `wid` int(255) NOT NULL AUTO_INCREMENT,
                   `data` tinytext NOT NULL,
                   `time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                   PRIMARY KEY (`wid`)
                  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
        $payloads=(array($payload1));
        $this->Db->drop_payload($payloads,$this);
    }
  
}
?>