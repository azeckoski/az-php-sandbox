<?php
/*
 * file: skin_contest_rules.php
 * Created on Mar 10, 2006 2:26:49 PM by @author aaronz
 * 
 * Aaron Zeckoski (aaronz@vt.edu) - Virginia Tech (http://www.vt.edu/)
 */
?>
<?php
require_once 'include/tool_vars.php';

$PAGE_NAME = "Introduction";
$Message = "";

// connect to database
require 'sql/mysqlconnect.php';

// check authentication
require $ACCOUNTS_PATH.'include/check_authentic.php';

// add in the help link
$EXTRA_LINKS = " - <a style='font-size:.8em;' href='$HELP_LINK' target='_HELP'>Help</a><br/>";
?>

<?php include $ACCOUNTS_PATH.'include/top_header.php'; // INCLUDE THE HTML HEAD ?>
<script>
<!--
// -->
</script>
<?php include 'include/header.php'; // INCLUDE THE HEADER ?>

<h2>Sakai Skin Contest - Round <?= $ROUND ?></h2>

<h3>Purpose</h3>
<p>The purpose of the contest is to solicit creative new ideas for a default skin with the goal of improving 
Sakai's out-of-the box usability and visual appeal. The new default skin will be used in the Sakai 2.2 release. 
The top contest entry will be included in the Sakai 2.2 bundle as the default skin. 
The 2nd and 3rd place entries will be included in the enterprise bundle as options.</p>

<h3><a name="SakaiSkinContest-Eligibility">Eligibility</a></h3>
<p>The contest is open to any individual, group, or institution.</p>

<h3><a name="SakaiSkinContest-Dates">Dates</a></h3>

<ul>
	<li>Begin Date: The contest will begin on <?= date($DATE_FORMAT,strtotime($ROUND_START_DATE)) ?>. 
	The default starting skin (with the appropriate tags and layout) will be released to the 
     community to modify on the first day of the contest (see <a href="http://bugs.sakaiproject.org/confluence/x/NTE" target="_new">quickstart package</a>).</li>
	<li>End Date: The contest will end on <?= date($DATE_FORMAT,strtotime($ROUND_CLOSE_DATE)) ?>. Any skins 
	received by <?= date($DATE_FORMAT,strtotime($ROUND_VOTE_DATE)) ?> EST will be eligible for consideration.</li>
	<li>Vote Date: Voting will begin as soon as the WG can get the submitted skins into a system where they 
	can be voted on. Voting on submitted skins will close at  
	<?= date($DATE_FORMAT,strtotime($ROUND_END_DATE)) ?>.</li>
	<li>Selection Date: The top 3 skins will be announced at the Vancouver conference on 
	June 1, 2006 (the method of announcing the top skins is to be determined).</li>
	<li>Cleanup Date: The top 3 skins will be reviewed and cleaned up (if necessary) by 
	the <a href="http://bugs.sakaiproject.org/confluence/x/9yc" target="_new">Default Skin WG</a> 
	before the Sakai 2.2 release date. Instructions for activating one of the included skins will be written by the WG.</li>
</ul>


<h3><a name="SakaiSkinContest-Scope">Scope</a></h3>
<p>Submitted skins will encompass an implementation of the CSS class definitions (properties and values) for the 
portal (portal.css) and tools (tool.css) along with any image files. The XHTML and CSS selectors are 
predefined in css files in the <a href="http://bugs.sakaiproject.org/confluence/x/NTE" target="_new">quickstart package</a>
(more info about the quickstart at the bottom).</p>
<div class="code"><div class="codeContent">
<pre class="code-java">selector {           &lt;--out of scope
    property: value  &lt;--in scope
}</pre>
</div></div>

<h3><a name="SakaiSkinContest-DesignGoals">Design Goals</a></h3>

<i>The Default Skin working groups recommends these but they are not required.</i>

<ul>
	<li>Submitted skins should take into account 
	<a href="http://bugs.sakaiproject.org/confluence/x/SCo" title="Design Standards" target="_new">Design Standards</a> established by the Sakai UI DG.</li>
	<li>Take a minimalist (keep-it-simple-stupid) approach in both the graphic and CSS code design.</li>
	<li>Make the navigation scheme visually intuitive (e.g. tabs should signify a "multiple site" concept).</li>
</ul>


<h3><a name="SakaiSkinContest-SkinSubmissionRules">Skin Submission Rules</a></h3>
<ul>
	<li>Anyone submitting a skin will be referred to as a participant</li>
	<li>The participant who submits a specific skin will be referred to as the owner of that skin</li>
</ul>


<h4><a name="SakaiSkinContest-Generalrules">General rules</a></h4>
<ol>

	<li>Anyone can submit a skin: individuals, organizations, institutions, etc... (i.e. skins do not have to be the official skin of a Sakai partner institution)</li>
	<li>Participants can submit as many skins as they want - but each should be quite different (no variations on a theme, please)</li>
	<li>The skin must be submitted as an archive file (zip or tar.gz) which includes all materials in the original default starting skin and in the same directory structure, the archive file name should include the participant email address and the name of their institution and if more than one, numbered - e.g. aaronz_at_vt.edu_virginiatech1.zip, aaronz_at_vt.edu_virginiatech2.zip, aaronz_at_vt.edu_virginiatech3.zip. The skin will be refered to by the skin name supplied in the readme detailed below to preserve anonimity.</li>
	<li>Please use the <a href="http://www.sakaiproject.org/images/stories/conferenceLogos/logoslate160x89.jpg" target="_new">sakai logo</a> in your skin and not your institutional logo</li>
	<li>All images should be original artwork or represent no copyright problems</li>
</ol>

<h4><a name="SakaiSkinContest-Technicalrules">Technical rules</a></h4>
<ol>
	<li>mostly CSS1 prefered - limit CSS2 use only to the most widely supported elements</li>
	<li>skin should work well on standards compliant browsers and Internet Explorer for Windows</li>
	<li>css should validate</li>
	<li>css should be formatted to be easily readable (a line per each property:value pair for all selectors)</li>
	<li>css should be lavishly commented</li>
	<li>css will be examined for elegance and non-redundancy</li>
	<li>css should be saved in a unicode text format</li>
	<li>Participants should add a text file to the archive which includes the following information:
<div class="code"><div class="codeHeader"><b>readme.txt</b></div><div class="codeContent">
<pre class="code-java">Submitted by
Name: 
Email: 
Affiliation: 

Skin Name: (something <span class="code-object">short</span> and descriptive)</pre>
</div></div></li>
</ol>



<h3><a name="SakaiSkinContest-VotingRules%3A">Voting Rules:</a></h3>
<ul>
	<li>Anyone voting for a skin will be referred to as a voter</li>
</ul>
<ol>
	<li>Each voter may submit 1 vote only for their top choice</li>
	<li>All votes must be in by the final voting date (see Dates above)</li>

	<li>Users may change their vote up until the final voting date</li>
</ol>


<h3><a name="SakaiSkinContest-Top3skinsresolution">Top 3 skins resolution</a></h3>
<ul>
	<li>The top skin will be the submission receiving the most votes</li>
	<li>The number 2 skin will be the one receiving the second highest number of votes</li>
	<li>The number 3 skin will be the one receiving the third highest number of votes</li>

	<li>In case of a tie for any position, the Default Skin WG will break the tie</li>
</ul>


<h3>License Agreement Requirement</h3>
<ul>
	<li>The top skins which are planned to be included in the Sakai 2.2 release must have an accompanying 
	contribution agreement (<a href="http://bugs.sakaiproject.org/confluence/x/aSs" title="License Management Practice">License Management Practice</a>)</li>
	<li>If the skin owner does not complete a contribution agreement within 10 days of the contest 
	selection date, the next ranked skin which does have a contribution agreement completed will be included in its place</li>

</ul>


<h3><a name="SakaiSkinContest-Votingdisplay">Voting display</a></h3>
<p>Voting will occur online using some kind of voting software. <br/>
The voting will work as follows:</p>
<ul>
	<li>Each entry will be displayed in the order in which it was submitted</li>
	<li>Each entry will have 4 images along with a description of the skin
	<ol>
		<li>An image of the Sakai gateway page (/portal)</li>

		<li>An image of the My Workspace -&gt; Home</li>
		<li>An image of Resources (Legacy Tool)</li>
		<li>An image of Gradebook (New Tool)</li>
	</ol>
	</li>
	<li>Voters can click through to a site that is actually running the skin.<br/>

Sites will be hosted here: <a href="http://garden.dmc.dc.umich.edu/portal" target="_new">http://garden.dmc.dc.umich.edu/portal</a><br>
This way we will allow the hard work beyond the image to be displayed as well. The site should have some users and content that allows better representation of the skin (the content will be created by the WG).</li>
</ul>


<h3>Suggested voting criteria</h3>
<ul>
	<li>This is still being worked on, see <a href="http://bugs.sakaiproject.org/confluence/x/SCo" title="Design Standards" target="_new">Design Standards</a></li>

</ul>


<h3><a name="SakaiSkinContest-Materials">Materials</a></h3>
<ul>
	<li><a href="http://bugs.sakaiproject.org/confluence/x/NTE" target="_new">Quickstart Sakai</a> - includes installation instructions and a custom Sakai quickstart with the new stylesheet format for 2.2</li>
</ul>


<p><b>Software recommendations for CSS work</b></p>
<ul>

	<li>TopStyle Lite 3.10 - <a href="http://www.bradsoft.com/download/" target="_new">http://www.bradsoft.com/download/</a> (PC only)</li>
	<li>Xyle Scope - <a href="http://www.culturedcode.com/xyle/" target="_new">http://www.culturedcode.com/xyle/</a> (Mac)</li>
	<li>Firefox Web Developer Extension - <a href="http://chrispederick.com/work/webdeveloper/" target="_new">http://chrispederick.com/work/webdeveloper/</a></li>
	<li>Firebug (CSS debugging) - <a href="https://addons.mozilla.org/extensions/moreinfo.php?application=firefox&amp;id=1843" target="_new">https://addons.mozilla.org/extensions/moreinfo.php?application=firefox&amp;id=1843</a></li>
</ul>

<?php include 'include/footer.php'; // Include the FOOTER ?>