<?php
namespace Prote\DBI\Func;
use DIC\Service;

class thought {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function add($t,$a,$uid){
       $t=preg_replace("/ +/", " ", $t);
       $a=preg_replace("/ +/", " ", $a);
       //Save the planet.  Prevent injections.
       $sym=array("<",">");
       $map=array("&lt;","&gt;"); 
       $t=str_replace($sym,$map,$t);
       $a=str_replace($sym,$map,$a); 
        $this->Db->set_parameters(array($uid)); 
        $c=$this->Db->find_many("SELECT * from thought where uid=?");
        foreach ($c as $data)
        {
            if($data->thought==$t)
            { 
              echo "This thought aleady exists.<by>Can't believe <b>you are thinking same thing <b>for second time.....<br>Please wait..";
              header("refresh:3;url=/dashboard");
              return 0;
            }
        }
        if($t==" "||$a==" ")
        {
             echo "Invalid Input.<br><b>Redirecting to dashboard.</b><br>";
             header("refresh:2;url=/dashboard");
        }
        else
        {
        $this->Db->set_parameters(array($uid,$t,$a)); 
        return $this->Db->Insert('INSERT INTO `thought` (`uid`,`tid`, `thought`, `author`) VALUES (?,NULL, ?, ?);');
        }
    } 

    public function getThoughts($id){
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_many('SELECT * FROM `thought` where uid=?;')){
            return $data;
        }else{
            return 0;
        }
    }
    public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `thought` (
                  `uid` int(255) NOT NULL ,
                  `tid` int(255) NOT NULL AUTO_INCREMENT,
                  `thought` varchar(255) NOT NULL,
                  `author` varchar(30) NOT NULL DEFAULT 'Anonymous',
                  PRIMARY KEY (`tid`),
                  FOREIGN KEY(`uid`) references users(`id`)
                 ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";

        $payload2=" INSERT INTO `thought` (`tid`, `thought`, `author`) VALUES
                    (1, 'Always be yourself, express yourself, have faith in yourself, do not go out and look for a successful personality and duplicate it.', 'Bruce Lee'),
                    (2, 'Anyone can count the seeds in an apple. No one can count the apples in a seed.', '-'),
                    (3, 'That which does not kill us makes us stronger.If you are good at something never do it for free.I am not a monster I''m just ahead of the curve', 'Friedrichn'),
                    (4, 'Man is least himself when he talks in his own person.Give him a mask and he will tell you the Truth ', 'Anonymous'),
                    (5, 'Unexpressed emotions will never die. They are buried alive and will come forth later in uglier ways.', 'Sigmund Freud'),
  (6, 'To accomplish great things, we must not only act, but also dream, not only plan, but also believe.', 'None'),
  (7,'But darling, in the end, you have got to be your own hero, because everyone is busy trying to save themselves.','Anonymous');";
        $payloads=(array($payload1,$payload2));
        $this->Db->drop_payload($payloads,$this);
    }
 
}