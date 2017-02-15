<?php
namespace Prote\DBI\Func;
use DIC\Service;

class notes {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function add($text,$id){  
       $text=preg_replace ("/ +/", " ", $text);//All multispaces converted to single space.
       //Save the planet.  Prevent injections.
       $sym=array("<div>","</div>","<script>","</script>");
       $map=array("&lt;div&gt;","&lt;/div&gt;","&lt;script&gt;","&lt;/script&gt;");
       $text=str_replace($sym,$map,$text);
       $text=preg_replace ("/< *script *>/", "&lt;script&gt;", $text);
       $text=preg_replace ("/< *\/+script *>/", "&lt;/script&gt;", $text); // \div
       $text=preg_replace ("/< *div *.*>/", "&lt;div&gt;", $text);//div   
       $text=preg_replace ("/< *\/+div *>/", "&lt;/div&gt;", $text); // \div
       $text=preg_replace ("/< *h/", "&lt;h", $text);     //Headers
       $text=preg_replace ("/< *\/+h/", "&lt;/h", $text);     
       $text=preg_replace ("/< *p/", "&lt;p", $text);     //paragraphs
       $text=preg_replace ("/< *\/+p/", "&lt;/p", $text);
       $text=preg_replace ("/< *input/", "&lt;input", $text); //inputs 
       $text=preg_replace ("/.*margin/", " ", $text); //inputs 
       $text=preg_replace ("/\"+/", "&quot;", $text); //multiple occurences of quotes.
       if($text==" ")
       {
         echo "Invalid Input.<br><b>Redirecting to dashboard.</b><br>"; 
          return 0;
       } 
        else
        { 
        $this->Db->set_parameters(array($id,$text)); 
        return $this->Db->Insert('INSERT INTO `todo` (`uid`,`id`, `text`) VALUES (?,NULL, ?);');
        }
    }
    public function get_access_time($id){
      $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_one('select substring(`time`,12) as time from todo where uid=?')){
            return $data->time;
        }else{
            return 0;
        }
    } 
    
    public function get_access_date_month($id){
      $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_one('select substring(`time`,6,2) as time  from todo where uid=?')){
            switch($data->time)
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
        }else{
            return 'Invalid data entry';
        }
    } 
    public function getcount($id){
      $this->Db->set_parameters(array($id)); 
        if($data=$this->Db->find_one('select count(id) as count from todo where uid=?')){
            return $data->count;
        }else{
            return 0;
        }
    }
   //UPDATE `comments`.`admin` SET `login_attempt` = '1' WHERE `admin`.`Id` = 1;

    /*   public function prompt(){
        $msg='<form action="/restore" method="post"><button type="submit"  style="color:#000;font-weight:500;text-decoration:none;background:none;border:none;">Restore</button></form>' ;
        $this->Db->set_parameters(array($msg));
        $this->Db->query('UPDATE `comments`.`todo` SET `temp` = `text` WHERE `todo`.`delflag` = 1');
        if($this->Db->query('UPDATE `comments`.`todo` SET `text` = ? WHERE `todo`.`delflag` = 1')){
            return 1;
        }else{
            return 0;
        }
    }
     public function restore(){
        $this->Db->set_parameters(array());
        if($this->Db->query('UPDATE `comments`.`todo` SET `text` = `temp` WHERE `todo`.`delflag` = 1')){
            return 1;
        }else{
            return 0;
        }
    }  */
   public function remove($id,$uid){
      $this->Db->set_parameters(array($id,$uid));  
        if($this->Db->query('DELETE FROM `todo` WHERE id=? and uid=?')){
            return 1;
        }else{
            return 0;
        }
    }  

    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `todo` ( 
                   `uid` int(255) NOT NULL,
                   `id` int(255) NOT NULL AUTO_INCREMENT,
                   `text` text NOT NULL, 
                   PRIMARY KEY (`id`),
                   FOREIGN KEY(`uid`) references users(`id`) 
                  ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;"; 
        $payloads=(array($payload1));
        $this->Db->drop_payload($payloads,$this);
    }
 
}