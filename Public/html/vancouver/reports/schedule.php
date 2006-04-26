<?php
/*
 * Created on Apr 26, 2006
 * Susan Hardin 
 * sample room scheduling tool for the vancouver conference
 */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Untitled Document</title>
<style type="text/css">
<!--
body {
font-family:Arial, Helvetica, sans-serif;
font-size: 11px;
}
.blackbar {background: #000000; color:#fff;}

.setup {background:#CCCCCC; color:#000;}

.event {background:#ffcc33; color:#000; font-weight:bold;}

.break {background:#CCCCFF; color:#000; font-weight:bold;}

.keynote {background:yellow; color:#000;}

.closed {background:#666;}

.bof {background:#336699;  color: #eee;}

.coffee {background:tan;  color: #000;}

.time { color:#336600; }
td {  vertical-align:top; }
-->
</style>
</head>

<body><br>
<div>
  <p><strong>NOT WORKING  -- sample display only</strong><br>
    <br>
planned feature/usage (currently vapourware):<br>
1. 
To assign a presentation to a slot, click on that room's 'add' link.  This will bring up a list of presentations that could be put in that box.  If that presentation has already been commited to another box, then you will get a warning that it has already been assigned an you will be asked if this is a repeat of a session. If it is not a repeat but you really want that presentation in that box - it could ask if you want to remove it from where it is currently committed and assisgn it to the current box instead. You could also chose to remove a presenation from a room box. </p>
  <p>2. I will add more features to this calendar - to allow mary to handle the room setup for each of the sessions -- she has given me a list of item she would need to select from.</p>
  <p>3. Once a session is set in this calendar, it is easily pulled in to other web pages with the appropriate associated informatio (ie. the room name, time, etc. will always be associated with the presentation information in lists or tables that appear on the website. This would become the 'master' schedule. changes here would automatically update all site schedule information. </p>
  <p>4. Draft vs official -- since some of the changes will be experimental for the next few weeks we will have a 'working copy' -- which can then be pushed up to the live site as the 'most recent official version'.... so that we are allowed to make mistakes and experiment with room arrangments without making the site change every few minutes. We can talk about the best way to do all this. </p>
  <p>5. BOF- Once we have a solid block of rooms that we will guarantee the BOFS - I will provide the available room blocks to the community to let them chose from that list -- once a room has been selected - it no longer appears on that list. So no other user would mistakenly request the same room/time. </p>
  <p>6. BOF-. A week or two out from the conference when it is as 'final' as it can be - - we could then open up the unused rooms to the bofs and let more users sign up for rooms.</p>
  <p>7. BOF-. Users will submit bof requests just like they submitted the tech demo and proposal requests (that form will be made available late next week). They do not have to commit to a timeslot at that time if they do not want to - but it will at least put them in the 'queue' and let us publish that bof session on the website...,.</p>
  <p>This is all a work in progress and we'll do as much as possible as quickly as possible..... email me comments </p>
  <p>-susan</p>
</div>
<div>
  <form name="form1" method="post" action="">
</form>
</div>
<div>
  <table cellspacing="0" cellpadding="0">
    <tr>
      <td width=12%>&nbsp;</td>
      <td width=6%><strong>Grand A:&nbsp; Faculty</strong></td>
      <td width=6%><strong>Grand B:&nbsp; Implementations</strong></td>
      <td width=6%><strong>Grand C:&nbsp; Standards</strong></td>
      <td width=6%><strong>Grand D:&nbsp; Technical</strong></td>
      <td width=6%><strong>Jr AB</strong></td>
      <td width=6%><strong>Jr C</strong></td>
      <td width=6%><strong>Jr D</strong></td>
      <td width=6%><strong>Gulf BCD</strong></td>
      <td width=6%><strong>Parkville: Tool</strong></td>
      <td width=6%><strong>Chart:&nbsp; BOF</strong></td>
      <td width=6%><strong>Blue:&nbsp; BOF</strong></td>
      <td width=6%><strong>Beluga:&nbsp; BOF</strong></td>
      <td width=6%><strong>Gulf A:&nbsp; BOF</strong></td>
      <td width=6%><strong>Pavillion</strong></td>
    </tr>
    <tr>
      <td class="time"> 7:30-8:30 am</td>
      <td colspan="14" class="coffee">coffee</td>
    </tr>
    <tr>
      <td class="time">8:30-10 am</td>
	  <?php
	  // named anchor can be linked to from longer list for user easy access
	  // join tables:  proposals title type track w/ roomblock (day, time, room name, available, preoposal_pk)
	  //
	  //use same table to add/change equipment info:  equipment, layout, # of panel speakers, etc.
	  //layers/views:  show all, show presenter info, show equipment and layout show size etc.
	  //show/hide for the multi layers
	  //
	  
	  
	  
	  
	  ?>
      <td rowspan="2"><a name="GrAT1a"></a>GrAT1a<br/>
      <br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td rowspan="2">GrBT1a <br/>
      <br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td rowspan="2">GrCT1a <br/>
      <br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td rowspan="2">GrDT1a<br/>
      <br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td rowspan="2">JrABT1a<br/>
      <br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td rowspan="2">JrCT1a<br/>
      <br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td rowspan="2">JrDT1a<br/>
      <br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td rowspan="2">GBCDT1a<br/>
      <br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td>Pa1 <br/><br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td>Ch1 <br/><br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td>Bl1 <br/><br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td>Bg1 <br/><br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td>GA1 <br/><br/> (<a href="#">add</a>|<a href="#">remove</a>)</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time"> 10-10:15 am</td>
      <td colspan="13" class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">10:15am-12pm</td>
      <td rowspan="2">GrAT1b</td>
      <td rowspan="2">GrBT1b</td>
      <td rowspan="2">GrCT1b</td>
      <td rowspan="2">GrDT1b</td>
      <td rowspan="2">JrABT1b</td>
      <td rowspan="2">JrCT1b</td>
      <td rowspan="2">JrDT1b</td>
      <td rowspan="2">GBCDT1b</td>
      <td>Pa2</td>
      <td>Ch2</td>
      <td>Bl2</td>
      <td>Bg2</td>
      <td>GA2</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">  12-1 pm</td>
      <td colspan="13" class="break">lunch</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">1-2:45 pm</td>
      <td rowspan="2">GrAT1c</td>
      <td rowspan="2">GrBT1c</td>
      <td rowspan="2">GrCT1c</td>
      <td rowspan="2">GrDT1c</td>
      <td rowspan="2">JrABT2c</td>
      <td rowspan="2">JrCT2c</td>
      <td rowspan="2">JrDT2c</td>
      <td rowspan="2">GBCDT2c</td>
      <td>Pa3</td>
      <td>Ch3</td>
      <td>Bl3</td>
      <td>Bg3</td>
      <td>GA3</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">2:45-3 pm</td>
      <td colspan="13" class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">3-4:30pm </td>
      <td rowspan="2">GrAT1d</td>
      <td rowspan="2">GrBT1d</td>
      <td rowspan="2">GrCT1d</td>
      <td rowspan="2">GrDT1d</td>
      <td rowspan="2">JrABT2d</td>
      <td rowspan="2">JrCT2d</td>
      <td rowspan="2">JrDT2d</td>
      <td rowspan="2">GBCDT2d</td>
      <td>Pa4</td>
      <td>Ch4</td>
      <td>Bl4</td>
      <td>Bg4</td>
      <td>GA4</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time"></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td class="time"> 5:30-7:30 pm</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td  class="event">Karaoke</td>
    </tr>
    <tr>
      <td colspan="15" class="blackbar">&nbsp;</td>
    </tr>
    <tr>
      <td class="time">7:30-8:30 am </td>
      <td colspan="13" class="coffee">coffee</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">8:30-10 am</td>
      <td rowspan="2">GrA1</td>
      <td rowspan="2">GrB1</td>
      <td rowspan="2">GrC1</td>
      <td rowspan="2">GrD1</td>
      <td rowspan="2">JrAB1</td>
      <td rowspan="2">JrC1</td>
      <td rowspan="2">JrD1</td>
      <td rowspan="2">GBCD1</td>
      <td>Pa5</td>
      <td>Ch5</td>
      <td>Bl5</td>
      <td>Bg5</td>
      <td>GA5</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa6</td>
      <td>Ch5</td>
      <td>Bl6</td>
      <td>Bg6</td>
      <td>GA6</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">10-10:15 am</td>
      <td colspan="13" class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">10:15-11:45 am</td>
      <td rowspan="2">GrA2</td>
      <td rowspan="2">GrB2</td>
      <td rowspan="2">GrC2</td>
      <td rowspan="2">GrD2</td>
      <td rowspan="2">JrAB2</td>
      <td rowspan="2">JrC2</td>
      <td rowspan="2">JrD2</td>
      <td rowspan="2">GBCD2</td>
      <td>Pa7</td>
      <td>Ch7</td>
      <td>Bl7</td>
      <td>Bg7</td>
      <td>GA7</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa8</td>
      <td>Ch8</td>
      <td>Bl8</td>
      <td>Bg8</td>
      <td>GA8</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">11:45-1:15 pm</td>
      <td colspan="13" class="break">lunch</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">1:15-2:45 pm</td>
      <td rowspan="2">GrA3</td>
      <td rowspan="2">GrB3</td>
      <td rowspan="2">GrC3</td>
      <td rowspan="2">GrD3</td>
      <td colspan="3" rowspan="2" class="setup">&nbsp;</td>
      <td rowspan="2">GBCD3</td>
      <td>Pa9</td>
      <td>Ch9</td>
      <td>Bl9</td>
      <td>Bg9</td>
      <td>GA9</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa10</td>
      <td>Ch10</td>
      <td>Bl10</td>
      <td>Bg10</td>
      <td>GA10</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">2:45-3 pm</td>
      <td colspan="13" class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">3-4:30 pm</td>
      <td rowspan="2">GrA4</td>
      <td rowspan="2">GrB4</td>
      <td rowspan="2">GrC4</td>
      <td rowspan="2">GrD4</td>
      <td colspan="3" rowspan="2" class="keynote">Keynote1</td>
      <td rowspan="2">GBCD4</td>
      <td>Pa11</td>
      <td>Ch11</td>
      <td>Bl11</td>
      <td>Bg11</td>
      <td>GA11</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa12</td>
      <td>CH12</td>
      <td>Bl12</td>
      <td>Bg12</td>
      <td>GA12</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">5:30-7:30 pm</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3" class="event">Awards</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="15" class="blackbar">&nbsp;</td>
    </tr>
    <tr>
      <td class="time">7:30-8:30 am </td>
      <td colspan="13"  class="coffee">coffee</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">8:30-10 am</td>
      <td rowspan="2">GrA5</td>
      <td rowspan="2">GrB5</td>
      <td rowspan="2">GrC5</td>
      <td rowspan="2">GrD5</td>
      <td rowspan="2">JrAB3</td>
      <td rowspan="2">JrC3</td>
      <td rowspan="2">JrD3</td>
      <td rowspan="2">GBCD5</td>
      <td>Pa13</td>
      <td>Ch13</td>
      <td>Bl13</td>
      <td>Bg13</td>
      <td>GA13</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa14</td>
      <td>Ch14</td>
      <td>Bl14</td>
      <td>Bg14</td>
      <td>GA14</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">10-10:15 am</td>
      <td colspan="13" bgcolor="#CCCCFF"  class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">10:15-11:45 am</td>
      <td rowspan="2">GrA6</td>
      <td rowspan="2">GrB6</td>
      <td rowspan="2">GrC6</td>
      <td rowspan="2">GrD6</td>
      <td rowspan="2">JrAB4</td>
      <td rowspan="2">JrC4</td>
      <td rowspan="2">JrD4</td>
      <td rowspan="2">GBCD6</td>
      <td>Pa15</td>
      <td>Ch15</td>
      <td>Bl15</td>
      <td>Bg15</td>
      <td>GA15</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa16</td>
      <td>Ch16</td>
      <td>Bl16</td>
      <td>Bg16</td>
      <td>GA16</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">11:45-1:15 pm</td>
      <td colspan="13"  class="break">lunch</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">1:15-2:45 pm</td>
      <td rowspan="2">GrA7</td>
      <td rowspan="2">GrB7</td>
      <td rowspan="2">GrC7</td>
      <td rowspan="2">GrD7</td>
      <td colspan="3" rowspan="2" class="setup">&nbsp;</td>
      <td rowspan="2">GBCD7</td>
      <td>Pa17</td>
      <td>Ch17</td>
      <td>Bl17</td>
      <td>Bg17</td>
      <td>GA17</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa18</td>
      <td>Ch18</td>
      <td>Bl18</td>
      <td>Bg18</td>
      <td>GA18</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">2:45-3 pm</td>
      <td colspan="13" class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">3-4:30 pm</td>
      <td rowspan="2">GrA8</td>
      <td rowspan="2">GrB8</td>
      <td rowspan="2">GrC8</td>
      <td rowspan="2">GrD8</td>
      <td colspan="3" rowspan="2" class="setup">&nbsp;</td>
      <td rowspan="2">GBCD8</td>
      <td>Pa19</td>
      <td>Ch19</td>
      <td>Bl19</td>
      <td>Bg19</td>
      <td>GA19</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa20</td>
      <td>Ch20</td>
      <td>Bl20</td>
      <td>Bg20</td>
      <td>GA20</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">5:30-7:30 pm</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="3" rowspan="2" class="event">Tech DemosTech Demos</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="15" class="blackbar">&nbsp;</td>
    </tr>
    <tr>
      <td class="time">7:30-8:30 am </td>
      <td colspan="13" class="coffee">coffee</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">8:30-10 am</td>
      <td rowspan="2">GrA9</td>
      <td rowspan="2">GrB9</td>
      <td rowspan="2">GrC9</td>
      <td rowspan="2">GrD9</td>
      <td rowspan="2">JrAB5</td>
      <td rowspan="2">JrC5</td>
      <td rowspan="2">JrD5</td>
      <td rowspan="2">GBCD9</td>
      <td>Pa21</td>
      <td>Ch21</td>
      <td>Bl121</td>
      <td>Bg21</td>
      <td>GA21</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa22</td>
      <td>Ch22</td>
      <td>Bl122</td>
      <td>Bg22</td>
      <td>GA22</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">10-10:15 am</td>
      <td colspan="13" class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">10:15-11:45 am</td>
      <td colspan="4" rowspan="2" class="setup">&nbsp;</td>
      <td rowspan="2">JrAB6</td>
      <td rowspan="2">JrC6</td>
      <td rowspan="2">JrD6</td>
      <td rowspan="2">GBCD10</td>
      <td>Pa23</td>
      <td>Ch23</td>
      <td>Bl123</td>
      <td>Bg23</td>
      <td>GA23</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">&nbsp;</td>
      <td>Pa24</td>
      <td>Ch24</td>
      <td>Bl124</td>
      <td>Bg24</td>
      <td>GA24</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">11:45-12:15 pm</td>
      <td colspan="13" class="break">lunch</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">12:15-1:15 pm</td>
      <td colspan="4" class="keynote">Keynote2</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">1:15-1:30 pm</td>
      <td colspan="13"  class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">1:30-2:45 pm</td>
      <td colspan="4" class="keynote">Board Response to Sessions</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">2:45-3 pm</td>
      <td colspan="13"  class="break">break</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">3-4 pm</td>
      <td colspan="4" class="keynote">Executive Director Address</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td class="time">4-5 pm</td>
      <td colspan="4"class="keynote">Conference Feedback</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</div>
<p>&nbsp;</p>
<div>
  <form name="form1" method="post" action="">
    <table border=0 cellpadding=0 cellspacing=0>
      <tr>
        <td style="padding:10px;"><label>Select a day</label>
            <br/>
            <select style="width:100px;" name="rooms" size="4" multiple col="60">
              <option name="room">Tuesday</option>
              <option name="room">Wednesday</option>
              <option name="room">Thursday</option>
              <option name="room">Friday</option>
            </select>
        </td>
        <td style="padding:10px;"><label>Select a room <br/>
          (only available rooms appear)<br/>
          </label>
            <select style="width:200px;" name="rooms" size="6" multiple col="60">
              <option name="room">Grand A: Faculty</option>
              <option name="room">Grand B: Implementations</option>
              <option name="room">Grand C: Standards</option>
              <option name="room">Jr AB</option>
              <option name="room">Jr C</option>
              <option name="room">Jr D</option>
              <option name="room">Gulf BCD</option>
              <option name="room">Gulf A: BOF</option>
              <option name="room">Chart: BOF</option>
              <option name="room">Blue: BOF</option>
              <option name="room">Beluga: BOF</option>
              <option name="room">Parkville: Tool</option>
            </select>
        </td>
        <td style="padding:10px;"><label>Select a time <br/>
          (only unassigned times appear)<br/>
          </label>
            <select style="width:200px;" name="rooms" size="6" multiple col="60">
              <option name="room">8:30-10:00 pm</option>
              <option name="room">10:15-12:00 pm</option>
              <option name="room">1:00-2:45 pm</option>
              <option name="room">3:00-4:30 pm</option>
              <option name="room">room</option>
              <option name="room">room</option>
              <option name="room">room</option>
              <option name="room">room</option>
              <option name="room">room</option>
            </select>
        </td>
        <td style="padding:10px;"></td>
        <td style="padding:10px;"><label>Select a presentation title <br/>
          (only unassigned rooms appear)<br/>
          </label>
            <select style="width:250px;" name="rooms" size="6" multiple col="60">
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
              <option name="room">title</option>
            </select>
        </td>
      </tr>
    </table>
  </form>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
</body>
</html>
