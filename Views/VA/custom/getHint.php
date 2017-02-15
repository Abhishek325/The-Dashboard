<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "userdb"; 

if($_SERVER['REQUEST_URI']=="/Views/VA/custom/getHint.php")
{
 echo "<h3>Nothing set.<br>Script terminated !!!</h3>";
 exit();
}  
$c=mysqli_connect($dbhost, $dbuser, $dbpass); 
mysqli_select_db($c,$dbname) or die(mysql_error()); 
$word = $_GET['word'];   
$word = mysqli_real_escape_string($c,$word);  
search($word,$c);

//Magic is here:
function search($word,$c)
{ 
 if(strpos($word," ")) 
 { 
	 $words=str_split($word);
	 $nxtString=""; 
	 $j=0;$l=0;
	 for($j=0;$j<strlen($word);$j++) {     
	 	if($words[$j]==' ')
	 	{
	 	  while($words[$j]==32)
	       $j=$j+1;  
	      break;
	 	}  
	 }  
	 $l=($j+1);
	 for($j=$l;$j<strlen($word);$j++)   
	 { 
	  $nxtString=$nxtString.$words[$j];   
	 }     
	 search($nxtString,$c); 
  } 
	$query = "SELECT value FROM words WHERE value like '$word%' order by value LIMIT 8";  
	$qry_result = mysqli_query($c,$query) or die(mysql_error()); 
	echo "<style>.suggestion{padding:4px;font-size:20px;text-indent:4px;cursor:pointer}
				 .suggestion:hover{background:#bbb;}
		  </style>";
	$display_string="";
	$i=5;
	while($row = mysqli_fetch_array($qry_result))
	{
	 $i=$i+1;	  
	 $row['value']=str_replace("'", "&squo;", $row['value']);
	 $display_string.= "<div class='suggestion' id='".$i."' onclick='setSuggestion(\"".$i."\")'>$row[value]</div>";  
	} 
	echo $display_string;
}

?>