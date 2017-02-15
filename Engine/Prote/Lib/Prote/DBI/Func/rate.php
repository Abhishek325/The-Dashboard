<?php
namespace Prote\DBI\Func;
use DIC\Service;

class rate{
    private $Service=NULL;
    public $Db=NULL; 

    public function __construct(Service $Service){
        $this->Service=$Service;
        $this->Db=$this->Service->Database();
    } /*
    public function rating()
    {
    	$text=array();
    	$intensity=0;
		$c=$this->Db->find_many("SELECT * from diary where type='personal' ");
		#Load the posts.
		foreach ($c as $data)  
		 array_push($text, $data->text); 
	    /*foreach($text as $val) 
		 echo $val."<br>";    */
    	//$expr=array();
     /*
		$c=$this->Db->find_many("SELECT * from express");
		#Load tags from database.
		foreach ($c as $data)  
		 array_push($expr, $data->value); 
		/*foreach($expr as $val) 
		 echo $val."<br>";*/
		/*
		 Now $text as all the posts and $expr has all expressions.
		 one to one mapping to be used.  
        foreach ($text as $str) {
          foreach ($expr as $val)
          	if(strpos($str,$val)!==false)
          	{
          		echo $val." matched in ".substr($str, 3,30)."...<br>";
          	}	
        }
     }*/
     public function computeRating($cid)
     {  
        $this->Db->set_parameters(array($cid));
        $c=$this->Db->find_one("SELECT `text` from diary where type='personal' and cid=?;"); //get the body of the post. 
         $text=$c->text;//Initialize the text under computation.
       $expr=array();
       $c=$this->Db->find_many("SELECT * from express");
       #Load tags from database.
       foreach ($c as $data)  
        array_push($expr, $data->value);    
       $rate=0;
       foreach ($expr as $val)  
       if(strpos($text,$val)!==false)//if there is a match
       {
            $this->Db->set_parameters(array($val));
            //echo $val." matched in ".substr($str, 3,30)."...<br>";
           $c=$this->Db->find_one("SELECT `type` from express where value=?"); //get the body of the post. 
           if($c->type=='n')
            $rate--;
           else if($c->type=='p')
            $rate++;  
       }
       return $rate;
     } 
  public function install(){
        $payload1="CREATE TABLE IF NOT EXISTS `express` (
                  `id` int(255) NOT NULL AUTO_INCREMENT,
                  `value` varchar(255) NOT NULL,
                  `type` varchar(255) NOT NULL,
                  PRIMARY KEY (`id`)
                 )ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;";
        $payload2="INSERT INTO `express` (`id`, `value`, `type`) VALUES
(1, 'cry', 'n'),
(2, 'sad', 'n'),
(3, 'pain', 'n'),
(4, 'problem', 'n'),
(5, 'upset', 'n'),
(6, 'bad', 'n'),
(7, 'wish', 'p'),
(8, 'cried', 'n'),
(9, 'laugh', 'p'),
(10, 'happy', 'p'),
(11, 'good', 'p'),
(12, 'cool', 'p'),
(13, 'better', 'p'),
(14, 'recovery', 'p'),
(15, 'heal', 'p'),
(16, 'tears', 'n'),
(20, 'acceptance', 'p'),
(21, 'admiration', 'p'),
(22, 'adoration', 'p'),
(23, 'affection', 'p'),
(24, 'afraid', 'n'),
(25, 'agitation', 'n'),
(26, 'agreeable', 'p'),
(27, 'aggressive', 'n'),
(28, 'aggravation', 'n'),
(29, 'alarm', 'ne'),
(30, 'alienation', 'n'),
(31, 'amazement', 'n'),
(32, 'amusement', 'n'),
(33, 'anger', 'n'),
(34, 'angry', 'n'),
(35, 'anguish', 'n'),
(36, 'annoyance', 'n'),
(37, 'anticipation', 'y'),
(38, 'anxiety', 'n'),
(39, 'apprehension', 'n'),
(40, 'assertive', 'n'),
(41, 'assured', 'p'),
(42, 'astonishment', 'ne'),
(43, 'attachment', 'ne'),
(44, 'attraction', 'ne'),
(45, 'awe', 'n'),
(46, 'beleaguered', 'n'),
(47, 'bewitched', 'ne'),
(48, 'bitterness', 'n'),
(49, 'bliss', 'p'),
(50, 'blue', 'ne'),
(51, 'boredom', 'ne'),
(52, 'calculating', 'ne'),
(53, 'calm', 'p'),
(54, 'capricious', 'ne'),
(55, 'caring', 'p'),
(56, 'cautious', 'p'),
(57, 'charmed', 'p'),
(58, 'cheerful', 'p'),
(59, 'closeness', 'p'),
(60, 'compassion', 'p'),
(61, 'complacent', 'p'),
(62, 'compliant', 'p'),
(63, 'composed', 'p'),
(64, 'contempt', 'n'),
(65, 'conceited', 'p'),
(66, 'concerned', 'p'),
(67, 'content', 'ne'),
(68, 'contentment', 'p'),
(69, 'crabby', 'n'),
(70, 'crazed', 'n'),
(71, 'crazy', 'p'),
(72, 'cross', 'ne'),
(73, 'cruel', 'n'),
(74, 'defeated', 'ne'),
(75, 'defiance', 'n'),
(76, 'delighted', 'p'),
(77, 'dependence', 'ne'),
(78, 'depressed', 'n'),
(79, 'desire', 'ne'),
(80, 'disappointment', 'n'),
(81, 'disapproval', 'n'),
(82, 'discontent', 'n'),
(83, 'disenchanted', ''),
(84, 'disgust', 'n'),
(85, 'disillusioned', 'p'),
(86, 'dislike', 'n'),
(87, 'dismay', 'n'),
(88, 'displeasure', 'n'),
(89, 'dissatisfied', 'n'),
(90, 'distraction', 'n'),
(91, 'distress', 'n'),
(92, 'disturbed ', 'n'),
(93, 'dread', 'n'),
(94, 'eager', 'ne'),
(95, 'earnest', 'p'),
(96, 'easy-going', 'p'),
(97, 'ecstasy', 'p'),
(98, 'elation', 'p'),
(99, 'embarrassment', 'n'),
(100, 'emotion', 'n'),
(101, 'emotional', 'n'),
(102, 'enamored', 'p'),
(103, 'enchanted', 'p'),
(104, 'enjoyment', 'p'),
(105, 'enraged', 'n'),
(106, 'enraptured', 'p'),
(107, 'enthralled', 'p'),
(108, 'enthusiasm', 'p'),
(109, 'envious', 'n'),
(110, 'envy', 'n'),
(111, 'equanimity', 'p'),
(112, 'euphoria', 'p'),
(113, 'exasperation', 'n'),
(114, 'excited', 'p'),
(115, 'exhausted', 'n'),
(116, 'extroverted', 'p'),
(117, 'exuberant', 'p'),
(118, 'fascinated', 'p'),
(119, 'fatalistic', 'n'),
(120, 'fear', 'n'),
(121, 'fearful', 'n'),
(122, 'ferocity', 'p'),
(123, 'flummoxed', 'ne'),
(124, 'flustered', 'n'),
(125, 'fondness', 'p'),
(126, 'fright', 'n'),
(127, 'frightened', 'n'),
(128, 'frustration', 'n'),
(129, 'furious', 'n'),
(130, 'fury', 'n'),
(131, 'generous', 'p'),
(132, 'glad', 'p'),
(133, 'gloating', 'p'),
(134, 'gloomy', 'n'),
(135, 'glum', 'n'),
(136, 'greedy', 'n'),
(137, 'grief', 'n'),
(138, 'grim', 'n'),
(139, 'grouchy', 'n'),
(140, 'grumpy', 'n'),
(141, 'guilt', 'n'),
(142, 'happiness', 'p'),
(143, 'happy', 'p'),
(144, 'harried', 'n'),
(145, 'homesick', 'n'),
(146, 'hopeless', 'n'),
(147, 'horror', 'n'),
(148, 'hostility', 'p'),
(149, 'humiliation', 'n'),
(150, 'hurt', 'n'),
(151, 'hysteria', 'n'),
(152, 'infatuated', ''),
(153, 'insecurity', 'n'),
(154, 'insulted', 'n'),
(155, 'interested', 'p'),
(156, 'introverted', 'n'),
(157, 'irritation', 'n'),
(158, 'isolation', 'n'),
(159, 'jaded', 'n'),
(160, 'jealous', 'n'),
(161, 'jittery', 'n'),
(162, 'jolliness', 'p'),
(163, 'jolly', 'p'),
(164, 'joviality', 'p'),
(165, 'jubilation', 'p'),
(166, 'joy', 'p'),
(167, 'keen', 'p'),
(168, 'kind', 'p'),
(169, 'kindhearted', 'p'),
(170, 'kindly', 'p'),
(171, 'laid back', 'p'),
(172, 'lazy', 'n'),
(173, 'like', 'p'),
(174, 'liking', 'p'),
(175, 'loathing', 'n'),
(176, 'lonely', 'n'),
(177, 'longing', 'p'),
(178, 'loneliness', 'n'),
(179, 'love', 'p'),
(180, 'lulled', 'p'),
(181, 'lust', 'n'),
(182, 'mad', 'p'),
(183, 'merry', 'p'),
(184, 'misery', 'n'),
(185, 'modesty', 'p'),
(186, 'mortification', 'n'),
(187, 'naughty', 'n'),
(188, 'neediness', 'ne'),
(189, 'neglected', 'n'),
(190, 'nervous', 'ne'),
(191, 'nirvana', 'p'),
(192, 'open', 'p'),
(193, 'optimism', 'p'),
(194, 'ornery', 'n'),
(195, 'outgoing', 'ne'),
(196, 'outrage', 'n'),
(197, 'panic', 'n'),
(198, 'passion', 'p'),
(199, 'passive', 'ne'),
(200, 'peaceful', 'p'),
(201, 'pensive', 'p'),
(202, 'pessimism', 'n'),
(203, 'pity', 'p'),
(204, 'placid', 'p'),
(205, 'pleased', 'p'),
(206, 'pride', 'p'),
(207, 'proud', 'p'),
(208, 'pushy', 'p'),
(209, 'quarrelsome', ''),
(210, 'queasy', ''),
(211, 'querulous', ''),
(212, 'quick-witted', ''),
(213, 'quiet', ''),
(214, 'quirky', ''),
(215, 'rage', 'n'),
(216, 'rapture', 'p'),
(217, 'rejection', 'n'),
(218, 'relief', 'p'),
(219, 'relieved', 'p'),
(220, 'remorse', 'n'),
(221, 'repentance', 'n'),
(222, 'resentment', 'n'),
(223, 'resigned', 'n'),
(224, 'revulsion', 'n'),
(225, 'roused', 'p'),
(226, 'sad', 'n'),
(227, 'sadness', 'n'),
(228, 'sarcastic', 'n'),
(229, 'sardonic', 'p'),
(230, 'satisfaction', 'p'),
(231, 'scared', 'n'),
(232, 'scorn', 'n'),
(233, 'self-assured', 'p'),
(234, 'self-congratulatory', 'p'),
(235, 'self-satisfied', 'p'),
(236, 'sentimentality', 'p'),
(237, 'serenity', 'p'),
(238, 'shame', 'n'),
(239, 'shock', 'n'),
(240, 'smug', 'p'),
(241, 'sorrow', 'n'),
(242, 'sorry', 'n'),
(243, 'spellbound', 'p'),
(244, 'spite', 'n'),
(245, 'stingy', 'n'),
(246, 'stoical', 'p'),
(247, 'stressed', 'n'),
(248, 'subdued', 'p'),
(249, 'submission', 'ne'),
(250, 'suffering', 'n'),
(251, 'surprise', 'ne'),
(252, 'sympathy', 'p'),
(253, 'tenderness', 'p'),
(254, 'tense', 'n'),
(255, 'terror', 'n'),
(256, 'threatening', 'n'),
(257, 'thrill', 'p'),
(258, 'timidity', 'n'),
(259, 'torment', 'n'),
(260, 'tranquil', 'p'),
(261, 'triumphant', 'p'),
(262, 'trust', 'p'),
(263, 'uncomfortable', 'n'),
(264, 'unhappiness', 'n'),
(265, 'unhappy', 'n'),
(266, 'vain', 'ne'),
(267, 'vanity', 'p'),
(268, 'venal', 'n'),
(269, 'vengeful', 'ne'),
(270, 'vexed', 'n'),
(271, 'vigilance', 'ne'),
(272, 'vivacious', 'p'),
(273, 'wary', 'p'),
(274, 'watchfulness', 'p'),
(275, 'weariness', 'ne'),
(276, 'weary', 'ne'),
(277, 'woe', 'n'),
(278, 'wonder', 'p'),
(279, 'worried', 'n'),
(280, 'wrathful', 'n'),
(281, 'zeal', 'p'),
(282, 'zest', 'p');";
 $payloads=(array($payload1,$payload2));
 $this->Db->drop_payload($payloads,$this);
    }
  }
?>
