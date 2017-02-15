<?php
namespace Prote\DBI\Func; 
use PHPMailer\PHPMailer;
use DIC\Service;

class users {
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    } 
      
    public function verify($email,$pwd){
        $this->Db->set_parameters(array($email,$pwd));
        if($data=$this->Db->find_one('SELECT `Id` from `users` where Email=? && Pwd=?')){
            return $data->Id;
        }else{
            return 0;
        }
    }

    public function addUser($name,$email,$pwd){  
       $name=preg_replace("/ +/", " ", $name);
       $email=preg_replace("/ +/", " ", $email);
       $pwd=preg_replace("/ +/", " ", $pwd); 
        $pin="1234";
        $this->Db->set_parameters(array($name,$email));
        $c=$this->Db->find_many("SELECT name,Email from users where name=? or Email=?");
        foreach ($c as $data)
        {
            if($data->name==$name || $data->Email==$email)
            { 
              echo "Enterd values already exists.<br>Please wait..";
              header("refresh:3;url=/members/signup");
              return 0;
            }
        }
        $this->Db->set_parameters(array($name,$email,$pwd,$pin));
        if($this->Db->query('INSERT INTO `users` (`Id`, `name`, `Email`, `Pwd`, `pin`) VALUES (NULL, ?, ?, ?, ?);'))
            return 1;
        return 0;
    }

    public function addInterest($interest,$id){ 
        $intid=$this->getInterestId($interest);
        $c=$this->Db->find_many("SELECT interest from interest where interest=?");
        $flag=0;
        foreach ($c as $data)
        {
            if($data->interest==$interest)
            {  
                $flag=1;
                break;
            }
        }
        $intid=$this->getInterestId($interest);
        //Add new interest
        if($flag==0)
         $this->Db->query('INSERT INTO `interest`(`intid`, `interest`) VALUES (NULL,?)');
        $this->Db->set_parameters(array($intid,$id)); 
        if($this->Db->query('INSERT INTO `interestusermap` (`intid`, `uid`) VALUES (?,?);'))
            return 1;
        return 0;
    }

    public function checkUserName($name){ 
        $this->Db->set_parameters(array($name));
        $data=$this->Db->find_one('SELECT `name` from `users` where name=?');
        if(!empty($data->name))
            return true;
        if(empty($data->name))
            return false;
    }

    public function checkUserEmail($email){ 
        $this->Db->set_parameters(array($email));
        $data=$this->Db->find_one('SELECT `Email` from `users` where Email=?');
        if(!empty($data->Email))
            return true;
        if(empty($data->Email))
            return false;
    }

    public function generate_hash($pwd){
        return $this->hash=hash('sha512',$pwd.$this->salt);
    }

    public function make_salt($email,$pwd){
        return $this->salt=crypt($pwd, $email.'5UCK5'.$pwd);    
    } 
    
    public function getName($id)
    { 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT name from `users` where Id=?;')){
            return $data->name;
        }
        else 
            return 0; 
    }
    public function getEmail($id)
    { 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT Email from `users` where Id=?;')){
            return $data->Email;
        }
        else 
            return 0; 
    }
    public function getInterestId($interest)
    { 
        $this->Db->set_parameters(array($interest));
        if($data=$this->Db->find_one('SELECT intid from `interest` where interest=?;')){
            return $data->intid;
        }
        else 
            return 0; 
    }
    public function getpin($id)
    { 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT `pin` FROM `users` where Id=?')){
            return $data->pin;
        }
        else 
            return 0; 
    }
    public function getpwd($id)
    { 
        $this->Db->set_parameters(array($id));
        if($data=$this->Db->find_one('SELECT `Pwd` FROM `users` where Id=?')){
            return $data->Pwd;
        }
        else 
            return 0; 
    } 
    public function getautologouttime($id)
    { 
        $this->Db->set_parameters(array($id));
      if($data=$this->Db->find_one('SELECT `autologout` FROM `users` where Id=?')){
            return $data->autologout;
        }
        else 
            return 0;   
    } 
    public function change_pin($new,$id){
        $this->Db->set_parameters(array($new,$id));
        if($this->Db->query('UPDATE  `users`  SET `pin` = ? WHERE `Id`=?')){
            return 1;
        }else{
            return 0;
        }
    }

    public function change_pwd($new,$id){
        $this->make_salt($_SESSION['email'],$new);
        $new=$this->generate_hash($new);   
        $this->Db->set_parameters(array($new,$id));
        if($this->Db->query('UPDATE `users` SET `Pwd`=? WHERE `Id` = ?')){
            return 1;
        }else{
            return 0;
        }
    }   
    public function resetPwd($email,$new,$id){
        $this->make_salt($email,$new);
        $new=$this->generate_hash($new);   
        $this->Db->set_parameters(array($new,$id));
        if($this->Db->query('UPDATE `users` SET `Pwd`=? WHERE `Id` = ?')){
            return 1;
        }else{
            return 0;
        }
    }   
    public function update($time,$id)
    {
        $timeConv=$time*60+1;
        $this->Db->set_parameters(array($timeConv,$id)); 
         if($this->Db->query('UPDATE `users` SET `autologout`= ? WHERE `Id` = ?;')){
            return $timeConv;
        }else{
            return 0;
        } 
    }
    public function mapUser($email)
    { 
      $this->Db->set_parameters(array($email));
      if($data=$this->Db->find_one('SELECT name from `users` where email = ?;'))
       return $data->name;
      else 
        return "Anonymous"; 
    }

    public function mapUserId($email)
    { 
      $this->Db->set_parameters(array($email));
      if($data=$this->Db->find_one('SELECT id from `users` where email =?;'))
       return $data->id;
      else 
        return "Anonymous"; 
    }
    public function interestInit($id)
    {
      $this->Db->set_parameters(array($id));
      if($data=$this->Db->find_one('SELECT count(1) as count from `interestusermap` where uid =?;'))
       return $data->count;
      else 
        return 0; 
    } 

    public function exitSessions()
    {
        if($this->Db->query('DELETE FROM `protesession` WHERE 1')){
            session_destroy();
            return 1;
        }else{
            return 0;
        }
    } 

    public function sendEmail($body,$email,$subject)
    {
      $mail = new PHPMailer();
      $mail->IsSMTP();                                      // set mailer to use SMTP
      $mail->Host = "jargonsmaze.com";  // specify main and backup server
      $mail->SMTPAuth = true;     // turn on SMTP authentication
      $mail->Username = "mail@jargonsmaze.com";  // SMTP username
      $mail->Password = "c00l+b0y"; // SMTP password

      $mail->From = "mail@jargonsmaze.com";
      $mail->FromName = "JargonsMaze.com";
      $mail->AddAddress($email); 
      $mail->IsHTML(true);                                  // set email format to HTML

      $mail->Subject = $subject;
      $mail->Body    = $body; 

      if(!$mail->Send())
      {
         echo "Email could not be sent. <p>";
         echo "Mailer Error: " . $mail->ErrorInfo;
         exit;
      }  
      return 1;
    }

    public function install(){
        $payload1=" CREATE TABLE IF NOT EXISTS `users` (
          `Id` int(255) NOT NULL AUTO_INCREMENT, 
          `name` varchar(255) NOT NULL,
          `Email` varchar(255) NOT NULL,
          `Pwd` text NOT NULL,  
          `pin` int(4) NOT NULL,
          `autologout` int(2) NOT NULL DEFAULT '61',
          PRIMARY KEY (`Id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0";

        $payload2="CREATE TABLE IF NOT EXISTS `ProteSession` (
                      `session_id` varchar(255) NOT NULL DEFAULT '',
                      `session_data` text NOT NULL,
                      `session_lastaccesstime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                      PRIMARY KEY (`session_id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;"; 
        $payloads=(array($payload1,$payload2));
        $this->Db->drop_payload($payloads,$this);
    }
  
}