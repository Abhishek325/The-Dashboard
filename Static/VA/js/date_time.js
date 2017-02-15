 var f=0,notify=0,ann=0;
function startTime() {
            var today=new Date();
            var h=today.getHours();
            var m=today.getMinutes();
            /*for testing and debugging
            if(m>=60)
            {
              m=m-60;
              h=h+1;
            }
            if(h>=24)
              h=0;
            */
            var s=today.getSeconds(); 
            m=checkTime(m);
            s=checkTime(s); 
            if(h==0&&m==0&&f==0)
            {
              f=1;
              //alert('Inside the bl0ck..');
              showDay();
              sdate();
              if(notify==0)
              {     
               notify=1; 
              }
            }
            if(h==0&&m>0&&f==1)
            {
              //Retain all initial values.
              f=0;
              notify=0;
              ann=0;
              //alert('f initialized');
            }
            if(h<10)
              h='0'+h;
             document.getElementById('time').innerHTML=h+':'+m+':'+s;
            if(m==0&&ann==0)
            {
              //Materialize.toast('The time is '+h+'<b> : </b>'+m,10000);
              var audio = document.getElementById('hour');
               audio.play(); 
              ann=1;
            }
            t=setTimeout(function(){startTime()},500);
     }
        function checkTime(i){
            if (i<10){i='0' + i;}
            return i;}
      
    function showDay() {
    var d = new Date();
    var weekday = new Array(7);
    weekday[0] = 'Sunday';
    weekday[1] = 'Monday';
    weekday[2] = 'Tuesday';
    weekday[3] = 'Wednesday';
    weekday[4] = 'Thursday';
    weekday[5] = 'Friday';
    weekday[6] = 'Saturday';
    var n = weekday[d.getDay()];
   document.getElementById('day').innerHTML=n; 
   document.getElementById('day1').innerHTML=n;
}
  
  function sdate(){var d = new Date();
  //Format the date:
  var day=d.getDate();
  var mon=d.getMonth();
  var month=new Array(12);
  month[0]='January';
  month[1]='February';
  month[2]='March';                                                      
  month[3]='April';                                                      
  month[4]='May';                                                      
  month[5]='June';                                                      
  month[6]='July';                                                      
  month[7]='August';                                                      
  month[8]='September';
  month[9]='October';
  month[10]='November'; 
  month[11]='December';
  var year=d.getFullYear();
  var cdate=month[mon]+' '+day+', '+year;
  document.getElementById('date1').innerHTML=cdate;}  

 function mapmonth(monthnum)
 { 
     if(monthnum== 1) return "Jan";
     else if(monthnum== 2) return "Feb";
     else if(monthnum== 3) return "Mar";
     else if(monthnum== 4) return "Apr";
     else if(monthnum== 5) return "May";
     else if(monthnum== 6) return "Jun";
     else if(monthnum== 7) return "Jul";
     else if(monthnum== 8) return "Aug";
     else if(monthnum== 9) return "Sept";
     else if(monthnum== 10) return "Oct";
     else if(monthnum== 11) return "Nov";
     else if(monthnum== 12) return "Dec"; 
 }
var sec=1,mn=0,hr=0,hf=0,mf=0,pf=0,stop=0;
function init()
{
  stop=0;  
  pf=0;
  //Materialize.toast('Starting the clock...', 1000);  
  document.getElementById('start').disabled=true;
  document.getElementById('start').style.color="#777";
  document.getElementById('clockstatus').innerHTML="Running";  
  stopWatch();
}
function stopWatch() {  
             if(sec==60)
             {
              sec=0;
              mn++; 
              mf=0;//each minute reset this..Refer thr bug mentioned below for more details.
             }
             if(mn==60)
             {
              sec=0;
              mn=0;
              hr++;
              mf=0;
              hf=0;//each hour reset this..Refer thr bug mentioned below for more details.
             } 
             sec=checkTime(sec); 
             /*Bug is that these two conditions are true from the very first second...so when the right time comes, flags
             are already set and  min and hr values are not augmeted by 0.*/
             if(hr<10&&hf==0)
             { 
              hr='0'+hr;
              hf=1;
             }
             if(mn<10&&mf==0)
             {
              mn='0'+mn;
              mf=1;
             }  
             document.getElementById('StopWatch').innerHTML= hr+':'+ mn +':'+sec;   
             sec++;
             if(stop==0)
               t=setTimeout(function(){stopWatch()},1000);
     }
  function PauseClock()
  {
    if(pf==0&&sec>1)
    {  
     document.getElementById('StopWatch').innerHTML=  hr+':'+ mn +':'+sec;   
     stop=1;
     document.getElementById('start').disabled=false;
     document.getElementById('start').style.color="#343434"; 
     document.getElementById('clockstatus').innerHTML="Paused"; 
     //Materialize.toast('Clock Paused.',3000); 
      pf=1;
    }
  }
      
  function stopTheClock()
  {
    if(sec>1)
    { 
     var RunTime=(sec-1)+mn*60+hr*60*60;
     //Materialize.toast('Clock stopped after '+RunTime+' seconds.', 5000);
    }
    sec=0;
    mn=0;
    hr=0;
    mf=0;
    hf=0;
    stop=1; 
    document.getElementById('start').disabled=false;
    document.getElementById('start').style.color="#343434";
    document.getElementById('clockstatus').innerHTML="Ready";
    document.getElementById('StopWatch').innerHTML=  "00:00:00"; 
  } 
  function activityAnalyzer()
  { 
    dormantCount--; 
    if(dormantCount<10)
            { 
               //Materialize.toast('System inactive for too long...logging out in '+dormantCount+'s',700 );
               if(dormantCount==0)
                document.location='/members/automated-session-logout';
            }
            t=setTimeout(function(){activityAnalyzer()},1000);
  }
  function setdays()
  { 
    document.getElementById("mys").length=0; 
    var eventmonth=document.getElementById("emonth").value;  
    if(eventmonth==1 || eventmonth==3 || eventmonth==5 || eventmonth==7 || eventmonth==8 || eventmonth==10 || eventmonth==12) 
    { 
              var i=0;
              while(i!=31)
              {
                document.myform.mys.options[i]=new Option(i+1, i+1,false, false);
                i++;
              }
    }
    else if(eventmonth==4 || eventmonth==6 || eventmonth==9 || eventmonth==11)
    {
              var i=0;
              while(i!=30)
              {
                document.myform.mys.options[i]=new Option(i+1, i+1,false, false);
                i++;
              } 
    } 
    else//February :|
    {
       var d=new Date();
       var day=d.getDate(); 
       var curyear=d.getFullYear(); 
       if(curyear%4==0)
       {
        //Leap year 
        var i=0;
              while(i!=29)
              {
                document.myform.mys.options[i]=new Option(i+1, i+1,false, false);
                i++;
              } 
       }
       else
       {
         var i=0;
              while(i!=28)
              {
                document.myform.mys.options[i]=new Option(i+1, i+1,false, false);
                i++;
              }
       } 
    }  
  }
  var todayset=0;
  function settoday()
  {
    var d=new Date();
    var day=d.getDate();
    var mon=d.getMonth(); 
    document.getElementById("emonth").selectedIndex=mon+1;
    setdays();
    document.getElementById("mys").selectedIndex=(day); 
    if(todayset==0)
     //Materialize.toast('Set to tomorrow. Please submit to confirm.',3000); 
    todayset=1;
  }
  /*    
  function reminder()
  {
    var today=new Date();
    var h1= 2;
    echo "asadsl";
    /*var m1=1;
    var s1=00;
            var h=today.getHours();
            var m=today.getMinutes();
            var s=today.getSeconds(); 
            m=checkTime(m);
            s=checkTime(s);
            if(h==h1&&m1==m)
            {
              alert('This is the time'); 
            }
            else  
             document.getElementById('rem').innerHTML=(h1-h)+':'+(m1-m)+':'+(60 -s);
            t=setTimeout(function(){reminder()},500); 
            //alert(h1);
  }*/