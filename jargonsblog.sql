-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2017 at 09:32 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jargonsblog`
--

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `postId` int(255) NOT NULL AUTO_INCREMENT,
  `postAbout` varchar(200) NOT NULL,
  `postTitle` varchar(255) NOT NULL,
  `postContent` varchar(2000) NOT NULL,
  `postTimeStamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `postOwner` varchar(50) NOT NULL,
  PRIMARY KEY (`postId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postId`, `postAbout`, `postTitle`, `postContent`, `postTimeStamp`, `postOwner`) VALUES
(1, 'This is how we did our first computer vision based project', 'Project at ITC - The internship', 'The project was based on ADAS (Automated Driver Assistance Systems). We were asked to deploy as system that could recognize text part of the scene captured from the dashboard cameras of automobiles in order to automate certain decisions that would be useful to the drivers during, offcourse driving, the vehicle. \nThe implementation:\nPhase 1: plex-master\nWe had started with plex-master, the project repository on GitHub of Googler. Tried to setup the environment and the libraries for 3 days, but didn''t work the way it was supposed to be. Actually , we couldn''t make it to work. Reasons, "excused" internet access to trainee systems, our guide, apparently, didn''t show much interest at the beginning etc.\nPhase 2: Template matching\nPerformed all the template matching techniques (that were available in OpenCV ) on some image sets. Results were too good to be integrated on real time. 693 templates (for numbers 0-9) from the plex-master was used here on one single image for matching. And, even this time results didn''t give that smug that we had always worked for. \nPhase 3: Got "the" stuff\nStarted with face-detection modules. Actually, we were just enjoying our time by irritating the API. I went through the documentation and converted it to live streaming face-detection. And yes, it worked.\nAfter some days of reading and homework (2-4 days, not more than that), I got tesseract , the API that was used for converting images to texts (Even I thought they could have came up with better definition). \nWe started with testing tesseract, it was working really good but for us the best part was, it was working, seriously. Now my favorite job was under execution...complicating the stuffs. I fused face-detection module with tesseract program to start live-stream text recognition. By now things started working, can say we made them to. This entire system (fusion) was tested on our "VISITOR" passes that were provided to interns after security checks at ITC. The results were appreciable.  \n', '2016-07-06 08:27:25', 'Abhishek'),
(2, 'A night out of overthinking..', 'The sleepless nigh', '<div>It &nbsp;had been an hour...i had been tossing and turning and fooling myself into sleep. But this sudden unrest..these unsettled thoughts...like there were &nbsp;knots in&nbsp;</div><div>my head that needed to be resolved...the restlessness...the urge...i still tried to ignore it all and shut my eyes...count 10000&#8217;s of sheep..count 1 to n and&nbsp;</div><div>back to 1.... but none of that seemed to work...</div><div>finally unable to control all the conflicts...i got up.&nbsp;</div><div>Like a ghost i sat up on my bed.through darkness just wondering what&#8217;s wrong....what&#8217;s going on?...why so much restlessness! while whole of the world around me had</div><div>&nbsp;dropped to death of silence...no bird...no distant car..let alone traffic...no sound..nothing..nothing at all...still my head hurt.... thanks to the blaring ,</div><div>unsettling, blur thoughts...</div><div><br></div><div>I moved closer to the window...and stared blank at the never ending sky...A part of me had always found solace and peace looking at it. The cool breeze like a friend&nbsp;</div><div>swept across my face...trying to restore some calmness some balance in me...But it didn&#8217;t work..not this time...I looked at the clock &quot;4:40 am&quot;.</div><div><br></div><div>Confused and unable to breathe i got up....and out .</div><div><br></div><div>The weather outside was calm...was cool...totally opposite to how i was feeling inside. Wilderness surrounded me...no shops..no homes...no traffic....no hopes....</div><div>no greed....no hypocrites...no people(thank god!)....no judgments....no decisions....just me .</div><div>I started walking slowly then broke into a jog...hoping it would help me think &nbsp;something...think whatever...think clearer....</div><div>My heart... i thought would start crying out of anxiety....my head just seemed to have no possible answers taken aback by the daze in the early morning.</div><div>Alone i just shot past the trees....and into the for', '2016-07-17 06:16:11', 'Abhishek'),
(3, 'asd', 'dadasdf sdlkf', 'dasdasd', '2016-08-15 12:23:04', 'Abhishek'),
(4, 'asd', 'dasdad', 'dadklasd', '2016-08-15 12:50:12', 'Abhishek'),
(5, 'test', 'this is a test', '', '2016-11-20 13:19:07', 'Abhishek'),
(6, '', '', '&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;table border=&quot;1&quot; cellpadding=&quot;1&quot; cellspacing=&quot;1&quot; style=&quot;width:500px&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td dir=&quot;rtl&quot;&gt;\r\n			&lt;p style=&quot;margin-right:560px&quot;&gt;&lt;input checked=&quot;checked&quot; name=&quot;test&quot; type=&quot;radio&quot; value=&quot;test&quot; /&gt;sdadasd&lt;input type=&quot;text&quot; /&gt;&lt;/p&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n\r\n&lt;p&gt;&nbsp;&lt;/p&gt;\r\n', '2016-11-26 10:17:45', 'Abhishek'),
(7, '', '', '&lt;p dir=&quot;rtl&quot;&gt;&nbsp;&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;p&gt;&nbsp;&lt;/p&gt;\r\n\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;hr /&gt;\r\n&lt;table border=&quot;1&quot; cellpadding=&quot;1&quot; cellspacing=&quot;1&quot; style=&quot;width:500px&quot;&gt;\r\n	&lt;tbody&gt;\r\n		&lt;tr&gt;\r\n			&lt;td dir=&quot;rtl&quot;&gt;\r\n			&lt;p style=&quot;margin-right:560px&quot;&gt;&lt;input checked=&quot;checked&quot; name=&quot;test&quot; type=&quot;radio&quot; value=&quot;test&quot; /&gt;sdadasd&lt;input type=&quot;text&quot; /&gt;&lt;/p&gt;\r\n			&lt;/td&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n		&lt;tr&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n			&lt;td&gt;&nbsp;&lt;/td&gt;\r\n		&lt;/tr&gt;\r\n	&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n\r\n&lt;p&gt;&nbsp;&lt;/p&gt;\r\n', '2016-11-26 10:19:17', 'Abhishek'),
(8, 'test123', 'testing,testing,testing,', '&lt;p&gt;testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing&lt;em&gt;,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testi', '2016-12-03 11:11:47', 'Abhishek'),
(9, 'test123', 'testing,testing,testing,', '&lt;p&gt;testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing&lt;em&gt;,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testi', '2016-12-03 11:15:51', 'Abhishek'),
(10, 'test123', 'testing,testing,testing,', '&lt;p&gt;testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing&lt;em&gt;,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testing,testi', '2016-12-03 11:34:52', 'Abhishek');

-- --------------------------------------------------------

--
-- Table structure for table `postcommentmap`
--

CREATE TABLE IF NOT EXISTS `postcommentmap` (
  `postId` int(255) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `uname` varchar(25) DEFAULT NULL,
  KEY `postId` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postcommentmap`
--

INSERT INTO `postcommentmap` (`postId`, `comment`, `uname`) VALUES
(1, 'This is awesome', 'Abhishek'),
(1, 'asdas', 'Abhishek'),
(1, 'asdas', 'Abhishek'),
(1, 'test123', 'Abhishek'),
(1, 'test123', 'Abhishek'),
(1, 'test', 'Abhishek'),
(1, 'test', 'Abhishek'),
(1, 'adsdasd', 'Abhishek'),
(1, 'terst123', 'Abhishek'),
(1, 'terst123', 'Abhishek'),
(1, 'terst123', 'Abhishek'),
(2, 'test 123', 'Abhishek'),
(2, 'test 345', 'Abhishek'),
(2, 'TEST 5667', 'Abhishek'),
(2, 'test 007', 'Abhishek'),
(2, 'test 008', 'Abhishek'),
(2, 'test 009', 'Abhishek'),
(2, 'test 567', 'Abhishek'),
(2, 'test 0010', 'Abhishek'),
(2, 'test 0010', 'Abhishek'),
(2, 'test 0010', 'Abhishek'),
(2, 'etst 11', 'Abhishek'),
(2, 'test 1â‚¹2', 'Abhishek'),
(2, 'test 1â‚¹2', 'Abhishek');

-- --------------------------------------------------------

--
-- Table structure for table `postimagemap`
--

CREATE TABLE IF NOT EXISTS `postimagemap` (
  `postId` int(255) NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  KEY `postId` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postimagemap`
--

INSERT INTO `postimagemap` (`postId`, `image`) VALUES
(1, 'newpic577cb83eb9183Screenshot from 2015-08-12 17_30_18.png'),
(2, 'newpic578b22ab4fe1ainsomnia-clipart-13365870-cant-sleep.jpg'),
(5, 'newpic5831a2cb2a514search.PNG'),
(8, 'newpic5842a8737c17cST25i341.JPG'),
(9, 'newpic5842a96759ff4ST25i341.JPG'),
(10, 'newpic5842addccdefbST25i341.JPG');

-- --------------------------------------------------------

--
-- Table structure for table `postsecondaryimagemap`
--

CREATE TABLE IF NOT EXISTS `postsecondaryimagemap` (
  `postId` int(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  KEY `postId` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postsecondaryimagemap`
--

INSERT INTO `postsecondaryimagemap` (`postId`, `image`) VALUES
(1, 'newpic577cc16ed6ca1click.png'),
(1, 'newpic577cc16eea16crotation.png'),
(1, 'newpic577cc16eee536Screenshot from 2015-08-07 05_32_02.png'),
(1, 'newpic577cc16f0e5c5Screenshot from 2015-08-12 17_30_18.png'),
(2, 'newpic578b25437850finsomnia.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `posttagmap`
--

CREATE TABLE IF NOT EXISTS `posttagmap` (
  `postId` int(255) DEFAULT NULL,
  `tags` varchar(75) DEFAULT NULL,
  KEY `postId` (`postId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posttagmap`
--

INSERT INTO `posttagmap` (`postId`, `tags`) VALUES
(1, 'Image Processing'),
(1, ' Computer Vision'),
(1, ' Swarm Intelligence'),
(2, 'Insomnia'),
(2, 'sleeplessness night '),
(3, ' adfklaa'),
(4, 'dasad'),
(5, 'test1'),
(5, 'test2'),
(6, ''),
(7, ''),
(8, 'testing1'),
(8, 'testing2'),
(9, 'testing1'),
(9, 'testing2'),
(10, 'testing1'),
(10, 'testing2');

-- --------------------------------------------------------

--
-- Table structure for table `userpostinit`
--

CREATE TABLE IF NOT EXISTS `userpostinit` (
  `uname` varchar(30) NOT NULL,
  `title` varchar(25) NOT NULL,
  `status` varchar(250) NOT NULL,
  `userdp` varchar(100) NOT NULL DEFAULT 'default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userpostinit`
--

INSERT INTO `userpostinit` (`uname`, `title`, `status`, `userdp`) VALUES
('Abhishek', 'Traveler,web deveoper', 'The word nature is derived from the Latin word natura, or "essential qualities, innate disposition", and in ancient times, literally meant "birth".', 'user577b9a87639f0IMG_20160330_124407.jpg'),
('abhisheks', 'I am  just testing...', 'This is my test quotes', 'default.jpg');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `postcommentmap`
--
ALTER TABLE `postcommentmap`
  ADD CONSTRAINT `postcommentmap_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`);

--
-- Constraints for table `postimagemap`
--
ALTER TABLE `postimagemap`
  ADD CONSTRAINT `postimagemap_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`);

--
-- Constraints for table `postsecondaryimagemap`
--
ALTER TABLE `postsecondaryimagemap`
  ADD CONSTRAINT `postsecondaryimagemap_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`);

--
-- Constraints for table `posttagmap`
--
ALTER TABLE `posttagmap`
  ADD CONSTRAINT `posttagmap_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `post` (`postId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
