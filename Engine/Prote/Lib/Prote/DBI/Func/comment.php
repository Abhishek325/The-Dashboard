<?php
namespace Prote\DBI\Func;
use DIC\Service;

class comment{
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    }

    public function add($about,$title,$content,$tags,$user){ 

     /*if(strpos($title,"<")==0 || strpos($title,">")==0)
     { 
      echo "Invalid characters in the title of your post.<br>Please try again.";
      header("refresh:2;url=/members/write-post");
      exit();
     }*/

    $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
    mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");    
    //insert post attributes into the database
     $content = preg_replace("/'/", "&#8217;", $content);
    $content = preg_replace('/"/', "&quot;", $content);
    $content = preg_replace('/</', "&lt;", $content);
    $content = preg_replace('/>/', "&gt;", $content);

    $sql="SELECT count(*) as count from post where postTitle='".$title."' and postAbout='".$about."'";
        $result = mysqli_query($conn,$sql); 
        $row=mysqli_fetch_assoc($result);     
        if($row['count']!=0) 
        {   
            $_SESSION['msg'] = "This post's title and about</b> already exists. Please change to create your unique post."; 
            header("location:/members/write-post");            
        }

    $sql = "INSERT INTO `post` (`postId`, `postAbout`, `postTitle`, `postContent`, `postTimeStamp`, `postOwner`) VALUES (NULL,'".$about."', '".$title."', '".$content."', CURRENT_TIMESTAMP, '".$user."');"; 
    $result = mysqli_query($conn,$sql);

    //lets get the last inserted postid 
    $sql="SELECT max(postId) as pid FROM `post`";
    $result = mysqli_query($conn,$sql); 
    $row=mysqli_fetch_assoc($result);     
    $postMapId=$row['pid'];

    //get all the tags for the post and map them to their corresponding post ids
    $index=0;
    while($data=str_getcsv($tags))
        {
            for ($i=0; $i < count($data); $i++) {   
                $tagList[$index++]=$data[$i];
            } 
            break;
        }  
        for ($i=0; $i < count($tagList); $i++) {  
         $posttag=$tagList[$i];   
         $sql = "INSERT INTO `posttagmap` (`postId`, `tags`) VALUES ('".$postMapId."', '".$posttag."');"; 
         $result = mysqli_query($conn,$sql);  
        }   
    return $result;
    }    


    public function save($about,$title,$content,$tags,$user){ 
    $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
    mysqli_select_db($conn,"jargons_db") or die("Unable to connect to the database !!");    
    $about=htmlspecialchars($about, ENT_QUOTES);
    $title=htmlspecialchars($title, ENT_QUOTES);
    $tags=htmlspecialchars($tags, ENT_QUOTES); 

    $sql="SELECT count(*) as count from posttemp where postOwner='".$user."'";
        $result = mysqli_query($conn,$sql); 
        $row=mysqli_fetch_assoc($result);     
        if($row['count']!=0) 
        {   
          $sql="UPDATE `posttemp` SET `postAbout`='".$about."',`postTitle`='".$title."',`postContent`='".$content."',`tags`='".$tags."',`postTimeStamp`=CURRENT_TIMESTAMP where `postOwner`='".$user."';";  
          $result = mysqli_query($conn,$sql);   
          return;
        }

    $sql = "INSERT INTO `posttemp` (`postId`, `postAbout`, `postTitle`, `postContent`, `postTimeStamp`, `postOwner`, `tags`) VALUES (NULL,'".$about."', '".$title."', '".$content."', CURRENT_TIMESTAMP, '".$user."','".$tags."');"; 
    $result = mysqli_query($conn,$sql);     
    return $result;
    }    

    public function userSavedData($user)
    {
       $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargons_db") or die("Unable to connect to the database !!");    
        $sql="SELECT count(*) as count from posttemp where postOwner='".$user."';";
        $result = mysqli_query($conn,$sql); 
        if($row=mysqli_fetch_assoc($result))      
         return $row['count']; 
        else
         return "";
    }

    public function getSavedData($user,$data)
    {
       $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargons_db") or die("Unable to connect to the database !!");    
        $sql="SELECT ".$data." as data from posttemp where postOwner='".$user."';";
        $result = mysqli_query($conn,$sql); 
        if($row=mysqli_fetch_assoc($result))      
         return $row['data']; 
        else
         return ""; 
    }

    public function addImageMap($pid,$image)
    {
     $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="INSERT INTO `jargonsblog`.`postimagemap` (`postId`, `image`) VALUES ('".$pid."', '".$image."');";   
        $result = mysqli_query($conn,$sql); 
        return $result;
    }
    public function getCurPostId($user)
    {
        $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="SELECT max(postId) as pid FROM `post` where postOwner='".$user."'";
        $result = mysqli_query($conn,$sql); 
        $row=mysqli_fetch_assoc($result);     
        $postMapId=$row['pid'];
        return $postMapId;
    }

    public function addPostSecondaryImagesMap($postid,$image)
    {
        $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="INSERT INTO `postsecondaryimagemap` (`postId`, `image`) VALUES ('".$postid."', '".$image."');";   
        $result = mysqli_query($conn,$sql);   
    } 

    public function addUserValues($status,$title,$user)
    {
        $status = preg_replace("/</", "&lt;", $status);
        $title = preg_replace("/>/", "&gt;", $title);
        $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        if($this->checkUserInitValues($user)==1)
        {
          header("location:/members/write-post");
          exit();
        }
        $sql="INSERT INTO `userpostinit` (`uname`, `title`, `status`) VALUES ('".$user."', '".$title."', '".$status."');";   
        $result = mysqli_query($conn,$sql);   
        return $result;
    }

    public function updateUserValues($status,$title,$user)
    {
        $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="UPDATE `userpostinit` SET `status`='".$status."',`title`='".$title."' where `uname`='".$user."';";  
        $result = mysqli_query($conn,$sql);   
        return 1;
    }
     
    public function updateUserPic($user,$file)
    {
        $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="UPDATE `userpostinit` SET `userdp`='".$file."' where `uname`='".$user."';";  
        $result = mysqli_query($conn,$sql);   
        return 1;
    }

    public function checkUserInitValues($user)
    {
      $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="SELECT count(*) as count from userpostinit where uname='".$user."'";
        $result = mysqli_query($conn,$sql); 
        $row=mysqli_fetch_assoc($result);     
        if($row['count']!=0) 
          return 1;
        return 0; 
    }

    public function getImageName($user)
    {
      $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="SELECT userdp from userpostinit where uname='".$user."'";
        $result = mysqli_query($conn,$sql); 
        $row=mysqli_fetch_assoc($result);      
          return $row['userdp'];
        return 0; 
    } 
    
    public function getAllPosts()
    {
      $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="SELECT postTitle,postContent from post ";
        $result = mysqli_query($conn,$sql);  
        return $result; 
    } 

    public function getPostTitle($id)
    {
      $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="SELECT postTitle from post where postId=".$id;
        $result = mysqli_query($conn,$sql);   
        $row=mysqli_fetch_assoc($result);   
        return $row['postTitle']; 
    } 
    public function getPostContent($id)
    {
      $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="SELECT postContent from post where postId=".$id;
        $result = mysqli_query($conn,$sql);   
        $row=mysqli_fetch_assoc($result);   
        return $row['postContent']; 
    } 
    
    public function makeComment($pid,$comment,$user)
    {
      $conn = mysqli_connect("localhost","root","") or die(" Error connecting to the server !!!");
        mysqli_select_db($conn,"jargonsblog") or die("Unable to connect to the database !!");   
        $sql="INSERT INTO `postcommentmap` (`postId`, `comment`, `uname`) VALUES ('".$pid."', '".$comment."', '".$user."');" ;
        $result = mysqli_query($conn,$sql);    
        return $result; 
    } 

    /* 
    ALTER TABLE `posttemp` ADD `tags` VARCHAR(500) NOT NULL ;
*/
}