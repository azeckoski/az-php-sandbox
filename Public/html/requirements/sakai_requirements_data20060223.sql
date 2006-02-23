/* output from jira2sql.xsl */
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-1','Selective release of assignments in Gradebook','Instructors can decide whether or not to release any assignment column to students either while creating the assignment or any time after it has been created.<br/>
Instructors can hide any assignment column at any time after it has been released.','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-2','Spreadsheet export should be configurable to meet local registrar system requirements for grade submissions','1. System administrator can configure the course grade spreadsheet export to meet local institutional format and data requirements for course grade submissions to the registrar''s system.<br/>
2. Instructor can export and download all course grade data to a single file that does not require further editing (assuming all required data can be provided by Sakai) before it is submitted to the registrar''s system. <br/>
','Sakai administrators|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-3','Gradebook should focus on getting data in','The current gradebook seems to focus much of its attention on evaluating scores, i.e. presenting % of right, current cumulative grade, etc. Given limited manpower, it should be focused on gathering data. Faculty use different ways of combining scores. Some are incredibly subjective. Many of them don''t want to show anything other than scores on assignments. Those that would be happy to show a cumulative grade would need great flexiblity in how it''s calculated, such as weighting, dropping lowest assignments, etc. But those faculty say they would be happy to download the data to excel, do calculations there, and upload the actual grade. Thus what we need is:
<br/>

<br/>
* The ability to disable showing anything other than raw scores
<br/>
* Accurate scores from tests/quizzes and assignments
<br/>
* An additional column next to the username that can be loaded by the external providers with an institutional ID (typically student number). This is needed to let us corollate data in Sakai with data in University student systems, which operate by ID number rather than Sakai username.
<br/>
* Ability to upload a column of data from a spreadsheet or other external source [would need to upload 2 columns, the data plus the username]
<br/>
* Ability to create a column via a web service, so we can feed from other systems [ex: attendance taking]
<br/>
* Ability to delete a column
<br/>
* Ability to move columns
<br/>
* Ability to assign categories to columns (e.g. to separate test, homework and attendance) and to use those to group display if desired
<br/>
* Ability to add text columns or some other way to provide explanations of special cases for students
<br/>
','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-4','Allow users to specify their default WYSIWYG editor preference','Allow users to select the WYSIWYG editor of their choice (HtmlArea, FCK Editor, Sferyx, etc.).  This could be surfaced under Prefereces.  The setting should make their editor of choice the default in all Sakai tools in the user''s sites. (This setting presumes that a Sakai tools'' functionality will not be dependent on a particular WYSIWYG editor.) It may also be desirable to have the list of possible WYSIWYG editors configurable as a system-wide setting, i.e., in the sakai.properties file.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* Scientific users might want a WYSIWYG with good equation support.
<br/>

<br/>
* Project site users might want a WYSIWYG with complex formating support.
<br/>

<br/>
* Foreign language users might want a WYSIWYG with good spell-checking and internationalization support.
<br/>

<br/>
* Support resources maybe limited, so one might want to limit the number of different WYSIWYG editors on a system-wide basis.','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Preferences ''WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-5','Site Usage Statistics Tool','Our version of Blackboard has a tool which instructors prize: it generates reports of site usage and activity.  The different sorts of things they can learn from this tool may stand as use cases:
<br/>
- A breakdown (pie chart) of which areas of the site have been accessed most often
<br/>
- A breakdown of site visits by hour of the day or day of the week
<br/>
- The ability to constrain the dates of the reporting (e.g. how many students went to the discussion board during the week preceding the mid-term)
<br/>
- The ability to constrain the reporting to a single student or subset of students
<br/>

<br/>
These reports have served a valuable diagnostic role for instructors rethinking the use of their sites.  But it might also be useful to extend this reporting for department administrators or support staff, covering a set of sites or even the system as a whole.
<br/>

<br/>
Using a worksite statistics tool, a maintainer, instructor or admin could determine who has accessed the worksite and what was accessed for a specified time period. The statistics would be reported by the tool in the forms of tabular data as well as graphical bar charts.
<br/>

<br/>
The worksite statistics tool would allow the instructor to specify which statistics to query, such as:
<br/>
Start Date
<br/>
End Date
<br/>
Users (individual, multiple selections, or all)
<br/>
Area (individual, multiple selections, or all)
<br/>

<br/>
Areas that would be queried for statistics would include:
<br/>
Announcements
<br/>
Assignments
<br/>
Chat Room
<br/>
Discussion Board
<br/>
Gradebook
<br/>
Presentation
<br/>
Resources
<br/>
Schedule
<br/>
Syllabus
<br/>
Test &amp; Quizzes
<br/>
Web Content ','Instructors|Staff (administrative)|Sakai administrators',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-7','Gradebook as grading schema provider/helper','Since grading schemas can be common across multiple tools, I think gradebook should provide a service and/or a helper tool so that other tools can draw from some common set of grading schemas.  Such a service should provide a way to define a customizable and extendable set of schemas.  Other tools then can incorporate this functionality or build upon it, instead of writing tool-specific schemas.  Users, administrators and developers of the system benefit when common tasks are handled in a uniform manner (they don''t have to recreate grading schemas for different tools, with potentially unfamiliar UI''s).
<br/>

<br/>
It would be nice if the common set of grading schemas was easily configurable, perhaps similar to the way other lists of things are handled in sakai.properties. For example,
<br/>

<br/>
gradescales.count=4
<br/>
gradescale.1=A,B,C,D,I,W
<br/>
gradescale.2=Pass,Fail
<br/>
gradescale.3=A+,A,A-,B+,B,B-,C+,C,C-,D+,D,D-,F
<br/>
gradescale.4=5,4,3,2,1
<br/>

<br/>
and then Assignments, Gradebook, T&amp;Q would provide those scales for use and limit the acceptable values to those specified when the scale is not a point range.','Sakai administrators|Instructors|Sakai developers','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-8','Need the ability to deny permissions','A deny permission is needed in order to be able to control read/write access to subfolders. Without it, read access to a subfolder can''t be prevented since you can''t take away a permission granted at the parent folder, and in order to get to the subfolder, you need readd access at the parent.  A deny capability would also be useful in conjunction with the !site.helper realm, to deny certain permissions to a role in all sites. See SAK-1609 for further details.','Researchers|Staff (administrative)|Sakai administrators|Instructors','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-9','Structuring content for presentation','Current the Resources tool is the only place other than Melete where we can put content. Many faculty want the ability to structure the way material is presented. The commercial tools all have some way to construct an &quot;organizer page&quot; (called different things) where items can be placed. Unlike the current Resources tool, organizer pages are constructed to present content rather than maintain it. So an entry will normally have a title and a description, but not the various icons present in Resources.<br/>
<br/>
I am not sure whether the right way to do this is to provide an alternative view into Resources folders or a completely separate tool. However I suspect that it makes sense to use the resources tool for maintenance, to avoid giving faculty two different ways to do essentially the same thing.<br/>
<br/>
Faculty see the left margin as part of the way content is organized. Thus we also need a tool for adding items and changing the order in the left margin. I would try to make that interface look as close as possible to the interface for maintaining organizer pages.<br/>
<br/>
Which ever approach you take, here are some things needed for the organizer page:<br/>
<br/>
* items should be any of the items in a current resources folder; plus pointers to any tool, and to individual entries such as an assignment, a discussion item, an RSS item, another organizer page or a quiz; plus choices from a set of items defined by the local administrator (links to the Library and other common things at the University)<br/>
* it must be easy to change the order of items on the page<br/>
* there should be a choice of presenting items in a Sakai iframe or in a new window<br/>
* it must be easy to put a link from the left margin to one of these pages<br/>
* it must be easy to change the order of items in the left margin<br/>
* for items in the left margin it shoulbe possible to choose whether to present the item in a Sakai iframe or a new window<br/>
<br/>
If you create a new tool for this, i.e. you leave the current Resources tool alone, faculty will still want the ability to control the order in which items in resources are presented.<br/>
<br/>
I am also concerned about the ability to share content in Resources and other content presentation. Not all content is specific to an individual course. E.g. our language departments have constructed an environment where students see content from a course, from the specific language department, and from the system as a whole. <br/>
<br/>
We need a place to maintain shared content (an obvious choice would be a site not associated with any one course), and the following sorts of facilities:<br/>
<br/>
* something like a symbolic link, that would let a course import either individual items or whole resource folders/organizer pages, and get the current version even if it changes. It must be possible to put such links in the left margin or on organizer pages.<br/>
* the ability to import portions of the left margin (actually, it might be better to have the ability to put it somewhere else, such as the right margin). To see what I''m looking for, take a look at <a href="http://fas-digiclass.rutgers.edu/page.jsp?dept=french">http://fas-digiclass.rutgers.edu/page.jsp?dept=french</a>  The &quot;reference&quot; section on the right should show in all French courses. [At some point we''re going to have to move this site into Sakai. At the moment I don''t think we could do it.]<br/>
<br/>
Some thought needs to go into authorization. While a lot of the shared material is public, we need to assume that not all of it will be. The lowest level of authorization would be attaching a list of rosters to the shared sites. This could be done simply by making them course sites. However there are issue with this. (1) The maintaners of these sites are not always authorized to see the students in all the rosters. (2) Maintain a list of all individual sections using the shared content could become burdensome. You''d really like the ability to define one or most sites that can use the shared content, with the ability for course sites to use wildcards (so you can say any site associated with a course in a specific discipline).<br/>
<br/>
<br/>
<br/>
','Students|Instructors|Staff (administrative)','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-10','Support for HTML editors','There have been reports that you are going to provide a single place for interfacing HTML editors. We certainly need this. However we need more than just a place to plug in an editor. We also need some facilities in the core to support an HTML editor. Here are some things we''ve found that we need. In reading these requirements, note that the HTML editor will be used for preparing HTML pages in Resources, but also portions of pages in announcements, quizes, etc.<br/>
<br/>
* a file picker. People want to put links in their HTML document. Most HTML editors have buttons to insert a normal link and an image. Many HTML editors have a &quot;browse&quot; button in the tools. We need a URL that the browse function can go to. At a minimum that should give you a directory listing of Resources, with a button next to each item that lets you choose it in Javascript. It might be a good idea for the file picker to be able to choose among several different areas, e.g. Resources for the course, for the faculty member creating the page, and from sites in which shared content is housed.<br/>
<br/>
* support for HTML editors that create images and equations. This includes support for uploading files through HTTP POST. However you should also consider where images should go. The obvious approach is an images folder in Resources. However there are reasons for students not to be able to get a listing of images. If you are preparing a test, images may include equations and other items that would help a student guess what is going to be on the test. Either you need to be able to protect the images directory in resources from browsing by students, or it should go in a separate place which the faculty member can browse but the student cannot.<br/>
','Students|Researchers|Instructors','WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-12','Sakai Import and Export using IMS Content Packaging','Sakai currently uses its own proprietary import and export.  It would be nice to support IMS Content Packaging import/export in Sakai as well.  An imprortant first-step is support for the IMS Common Cartridge, which is a profile of IMS Content Packaging. 
<br/>

<br/>
Use Case:
<br/>

<br/>
* Import and export content using IMS Content Packing.
<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Global ''Site Archive (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-14','Sakai services should minimize dependencies and references to other services','Sakai services should strive to model data management for a set of objects and minimize the use of other Sakai services in both the API and implementations.  By clearly separating concerns, this will lead to Sakai services being more modular and easier to adapt services for enterprise integration.  Since Sakai services are layered, no sakai service should ever reference a higher level service.  Even references at the same level should be avoided unless absolutely necessary.<br/>
','Sakai developers','Providers ''Sakai APIs ''Sakai Application Framework ''Web Services ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-15','Comprehensive ''remove user'' functionality','There is a need for a more comprehensive &quot;remove user&quot; fucntionality than currently exists.  One that not only deletes the user, but all the appropriate, associated data, such as their MyWorkspace site, their memberships, etc., rather than leaving it orphaned in the db.  Note that for some cases, such as users from external providers, it may not be desireable to delete all the related artifacts when deleting the internal user representation in Sakai, so support should be provided for both the current and the proposed delete user functionality.  This likely to be a larger problem in projects than in course sites, where users from outside the orginization are likely to be using guest accounts.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* Deleting a user and all their associated material
<br/>
* Deleting just the Sakai, internal user account, but not their associated material
<br/>

<br/>
----------------------------------------
<br/>
Original Description:
<br/>

<br/>
When a user is deleted through the GUI (Users tool, ''Remove user''), not all artefacts and associations of the user are removed. For example, the user''s my workspace site remains, as does realm membership or any sites of which the user was a member.
<br/>

<br/>
In some cases, this behaviour is desirable (for example where a user was created internally but also exists through a provider), whereas in other cases it is undesirable, leaves behind orphaned data in the db and/or may have security implications (OOTB configurations and configurations where userids of internal users may not be unique across the lifespan of the application, e.g. guest accounts where the email address is the userid).
<br/>

<br/>
The issues are described further in these JIRA items:
<br/>

<br/>
<a href="http://bugs.sakaiproject.org/jira/browse/SAK-655">http://bugs.sakaiproject.org/jira/browse/SAK-655</a>
<br/>
<a href="http://bugs.sakaiproject.org/jira/browse/SAK-1535">http://bugs.sakaiproject.org/jira/browse/SAK-1535</a>
<br/>
<a href="http://bugs.sakaiproject.org/jira/browse/SAK-1456">http://bugs.sakaiproject.org/jira/browse/SAK-1456</a>
<br/>
<a href="http://bugs.sakaiproject.org/jira/browse/SAK-2973">http://bugs.sakaiproject.org/jira/browse/SAK-2973</a>
<br/>

<br/>
A more comprehensive ''remove user'' capability is required (whether invoked via the GUI, web services or API), which is flexible or configurable enough to cope with various deployment scenarios, i.e. ways in which the Sakai internal user db and external providers interact.
<br/>
','Students|Instructors|Researchers|Sakai administrators','Providers ''Realms (Admin Site Management)''Sakai Application Framework ''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-16','Template capability for email messages','In cases where Sakai sends outgoing email messages and possibly in some other instances, blocks of text are constructed in java code. This means that for sites to customize the text of email messages (whether for language translation or local context), it is necessary to change the java source code, rebuild and redeploy.<br/>
<br/>
It would be significantly simplify Sakai deployment and subsequent customization if email messages could be generated from templates. This would allow templates to be customized either in the filesystem, or through the UI itself if the templates were stored in the database or ContentHosting. A case where the latter might be desirable is to allow site owners to customize the email invitation sent when adding new guest users to a site.<br/>
<br/>
A generic templating capability would allow a template which included replaceable parameters identified by name, e.g.<br/>
<br/>
-------<br/>
Dear $Firstname,<br/>
<br/>
Welcome to the $SiteFullName worksite on $SakaiServiceName.<br/>
...<br/>
-------<br/>
','Sakai administrators|Sakai developers','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-19','Make storage and display of assessment scores consistent','1: Scores should be stored and transmitted between tools (as opposed  <br/>
to displayed) with the highest possible accuracy (i.e. doubles).<br/>
2: The default display of scores should be 2 decimal places. For  <br/>
example, 1 out of 3 is displayed as &quot;.33&quot;<br/>
<br/>
Assignments, Tests &amp; Quizzes (Samigo), and Gradebook currently store  <br/>
and display point-based assessment values in different maners. A  <br/>
recent discussion in the email thread in sakai- <br/>
<a href=''mailto:assessment@collab.sakaiproject.org''>assessment@collab.sakaiproject.org</a> called  &quot;Consistant grading  <br/>
(SAK-2848)&quot; illustrated why this is a problem and had the above  <br/>
consensus.<br/>
<br/>
To see the majority of this thread/discussion please see the  <br/>
attached file (above) consistentGradingTread.rtf.<br/>
<br/>
-----------------------------<br/>
Original Description:<br/>
Assignments, Tests &amp; Quizzes (Samigo), and Gradebook currently store and display point-based assessment values in different maners.  The recent discussion in the email thread in the &quot;Sakai DG: Assessment Tools&quot; illustrates why this is important and suggests appropriate resolutions.  Exisiting assessment tools and any new related tools should conform as best as possible to a standard approach to point-based storage and display.  <br/>
<br/>
In particular, the developing consensus for storing point-based assessments values appears to be doubles.  By storing with as much percision as possible, then round-off errors are less likely to generate confusion for students and instructors.<br/>
<br/>
For the display of points, the developing consensus is for two decimal places.  This will help also help reduce confusion related to round-off errors.  For example, 0.33 or 0.67 perhaps more clearly indicate you received one-third or two-thirds of a point, respectively, on an assessment item.  A desire for configuring the number of decimal places, at the system-wide and/or site-wide levels, has also been expressed; as has the desire not to allow such configuration.','Instructors|Students','Assignments ''Gradebook ''Tests & Quizzes (Samigo)''UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-20','Standardize URL input fields','Different validation rules and hints are applied to URL input fields across the various tools in Sakai, such as automatically adding http:// or not, pre-loading the input field with the http:// prefix, etc.  It would be nice to standarize the rules, at least for the core/bundeled tool set.','Students|Researchers|Sakai administrators|Instructors|Sakai developers','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-21','Standard Calendar Widget','Tools should strive to use a common date-time picker or calendar widget.  For example, Schedule, Assignments, and Tests &amp; Quizzes (Samigo) all use a different approach right now. The attached document points out some of the differences in how the calendar widget works in several Sakai tools. This requirement would change the style guide suggestion for the calendar widget and create a Sakai JSF widget which can be shared by all tools that use calendaring. ','Students|Instructors|Sakai developers|Researchers','Global ''JSF ''Style Guide ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-23','Support for directly entering images and rich text in "Worksite Information"','Site owners often want to include a richer description of their course or project besides just text.  While one could currently do this by creating an HTML document outside of Sakai or in the site''s Resources, and then using the URL, it would be better practice to be able to create and edit such a rich Worksite Information page in the tool itself, or when editing or creating the Descirption initially in Site Info or Worksite Setup.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* Site owners would like to create and edit &quot;Worksite Information&quot; that includes rich text and images.
<br/>

<br/>
----------------------------
<br/>
Original Description:
<br/>

<br/>
Faculty at UC Berkeley would like to be able to add images and rich text to the descriptions of their sites. Many consider the ability to place image(s) on the HOME page an important feature that is currently missing from bSpace. They would like to be able to better personalize their sites with image(s) that represent their classes/subject matter.','Instructors|Researchers','Home ''Site Info ''Sites (Admin Site Management) ''Worksite Information ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-24','Case Sensitivity of Sorting','Sakai currently uses a case-senstive sort for lists, which is typical of ASCII sorting rules; upper-case letters sort higher than lower-case.  Sorting could also be done on a case-insenstive basis.','Sakai developers|Instructors|Researchers|Students','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-25','View Site as if in a Different Role','The ability for a user to view the site as it would be viewed by a user with a different role in the site.  For example, an instructor being able to view a site as their students see it.<br/>
<br/>
This is similar to, but not the same as the SUTool, which allows admin users to view the site as a specific user would see it.','Students|Instructors','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-26','Emails Should Contain Site URL and Item URL','When an email is sent from a site (e.g., an auotmated message, and email forwarded by tool Email Archive tool) it should contain the URL for the Site and the direct URL for the item the message references (e.g., an email in Email Archive, an announcement, a resource).  This will enable the recipient to either easily access the site and some work the message reminded them of or to directly access the item in the context of the site and start their work from there.','Students|Instructors|Researchers|Sakai developers','Global ''Style Guide ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-27','Import/Export/Synchronize Schedule Data','Support for the ability to import/export/synchronize schedule data with external applications, or to integrate in general an exisiting enterprise calendar system for use with Sakai.   Many schools already have an enterprise calendar system that users are working with outside of Sakai and would a like a way to exchange data between the two so they can have their schedule in &quot;one place&quot;.  Many users also have PDAs or cell phones with scheduling programs they would like to be able to view all their scheduling data in.<br/>
<br/>
Some external scheduling applications also have web interfaces, which could be placed in a Sakai Web Content tool; however, that doesn''t achieve any direct integration, such as creating an Assignment whose open date would be posted to the external scheduling software.','Instructors|Researchers|Students','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-28','Email Notification When Submitting High-Risk Items','Send a confirmation email when Sakai has successfully received a high-risk item.  For instance, when a student submits an Assignment, they should get an email receipt that the system completed the process.  The email can include an appropriate reference ID and time-stamps.  This option could be configured to be system-wide, by site, or by student; a good default would be to have it on system-wide.','Researchers|Instructors|Students','Assignments ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-29','Option to Enforce Unique Site Titles','It would be nice to have support for enforcing unique site titles, currently Sakai allows one to have multiple sites with the same title, which can lead to confusion.  (There are Sakai installations that are interested in multiple sites with the same title, so this could be implemented as an option.)
<br/>

<br/>
Use Cases:
<br/>

<br/>
* Instructors often teach the same course over and over.  If their course site doesn''t have a title with temporal information, such as GS-440 versus GS-440-F06, then it becomes confusing as to which site is which after a couple semesters of teaching the same course.  (Instructors don''t necessarily always want to delete old sites either, as it may have material from students they wish to reference, or their university may require that keep old student material on-hand for a certain time period.)
<br/>

<br/>
* Members of ad-hoc groups, such as project sites, which aren''t uniquely named can also be confused as to which site is which.  For instance, someone might be end up in multiple &quot;Study Group&quot; or &quot;Lab Group&quot; sites.
<br/>

<br/>
* Folks searching for sites on the Gateway or trying to join sites in the Membership tool also have problems telling which site is which when the name is the same.  (Some help is provided if the Term field is used in the Gateway for course sites but not project sites, and in the Membership tool the Description is displayed, but only if it is simple text.)','Students|Instructors|Researchers','Site Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-30','Join Site by Requesting Membership','Add the additional option for sites to be joinable only by request.  In otherwords, a user could browse the list of joinable sites, but instead of being able to join immediately, they would have to go through some soft of approval process.   For instance, they could click on a link next to a site in the Membership tool that would provide them with a little form to fill out, whichi would then generate an email to the site owner(s), who could then click on a link in the email to accept or deny the join request (and maybe add a comment to the automate message and instructions), which in turn would generate an appropriate email back to the requestor.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* A project site where you don''t know right away who all will be joining the site, but you don''t want it to be wide-open for anyone to join.  Receiving a request to join from someone would be a good enough threshold for them to have to cross to get in.
<br/>

<br/>
* A site might have some pre-requisite for joining that can be validated through the join request.
<br/>

<br/>
* A site you want to control access to, but not have to rely on Sakai administrators or out-of-band email requests to handle.','Researchers|Students|Instructors','Membership ''Site Info ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-31','Offline component for learners to study while not connected to the internet','One of the factors hindering the implementation of e-learning in Africa (and South Africa) is  limited and expensive Internet connections.  Low bandwidth remains an issue and prevents the delivery of rich media to learners. An alternative to increasing bandwidth to cater for this problem is the dissemination of learning content from a central server during off-peak hours.  Internet connections can be used to keep learning content up to date on the remote computers. Because content can be downloaded once and studied without the need to remain on-line for extended periods costs can be greatly reduced for the learners.  The learner can however still connect to the central server for learning activities such as discussion groups, reading of announcements etc.<br/>
<br/>
What is needed is an intelligent off-line client that can update content from time to time as is needed.  This client will provide the learner with most (all?) of the same functionalities as he/she will find on-line.','Students',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-32','Shift Site''s Dated Material Forward for Re-Use in Future Semesters','In order to re-use a site in future semesters, whether by editing it or duplicating it, one of the big tasks is updating all the timed-related content.  For instance, while the content of Assignments may remain mostly unchanged from semester to semester, the timing of their delivery, due dates, closing, etc., is always going to be different.  Another example would be events in Schedule which represent the course''s meeting times, and perhaps contain links to the appropriate lecture notes for each particular time.  It would be nice to have a way to bulk move such time-dependent content forward for a new semester.  For instance, it would be nice to be able to specify a new &quot;first day&quot; for a course, and have all the Schedule events moved relative to the difference with the old firest day; taking into account, of course, the differences such as university-wide off-days defined in a system-wide calendar.','Instructors|Students|Researchers','Assignments ''Global ''Schedule ''Syllabus ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-33','System Administrator GUI for Configuring Sakai','A GUI for configurating Sakai while running, rather than manually editing the property file.  Some settings might require a restart.','Sakai administrators|Sakai developers',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-35','Enable/Disable Site Info/Worksite Setup''s "guest" section','Offer the ability to disable the add participants &quot;guest&quot; section in the Site Info/Worksite Setup tool.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* Prevent instructors from being able to create guest accounts','Instructors|Researchers|Staff (administrative)|Sakai administrators|Sakai developers','Section Info ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-36','Image Repository in Resources for Easy Access from WYSIWYG Editors','It would be nice to have a folder in Resources in which one could store items, particularly images, which could then be easily referenced in the WYSIWYG without having to fully specify an absolute URL to the Resource item. Images placed in the appropriate Resource folder could be referenced by a relative URL in the WYSIWYG.','Instructors|Students|Researchers','Resources ''WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-37','Sakai Saving State - Moving between tools and within pages of a tool should behave conistently for users.','User need a consistent model for what will happen when they &quot;go someplace else&quot; within Sakai.  <br/>
<br/>
Currently, when you move between tools sometimes the tool the user left remains in the same state so when the user returns, they are dropped in the middle of a tool.  For other tools, the tool resets itself when a user leaves it so when the return to the tool they arrive at the main page.<br/>
<br/>
There is similar inconsistency with navigating within a tool.  Sometimes, moving away from a page (but staying within the tool) saves the users data on page (a form for instance) until they come back.  And in other tools, if the user moves away from a page without saving, the data will not be saved and the next time they visit that page it will be refreshed.<br/>
<br/>
Original requirement below before combining this one with another:<br/>
<br/>
Currently Sakai saves the state of a tool when you navigate away from it.  For instance, if you are part way through creating a Resource and you click on the Schedule, when you come back to Resources, you''ll find yourself right where you left off creating a new Resource, which can lead to confusion if you do not want to resume the process, are looking to do something different in Resources now, and are not familiar with the reset button for tools.  Another approach is to reset a tool, and not save its state, when you navigate away from it, which means when you come back, if you want to resume your process, then you''ve lost everything you''ve done up to that part and have to start over.  (Some other aspects of Sakai''s behavior, which may compound the problems experienced here, include lack of support for the browser''s back button and the percieved expectation that clicking on a tool in the left-hand menu, when already viewing the tool, should reset the tool, as opposed to learning about the little reset-icon in the top-left of the tool.)<br/>
<br/>
<br/>
There has always been a lot of debate over which model to adopt.  The choice of saving state or not should be a system-wide configuration option.','Students|Sakai developers|Researchers|Instructors','Global ''Style Guide ''UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-39','Hotlink Items in Synoptic Views','When a tool provides a Synoptic View of its contents then the synopsized items should be linked to their full view.  For example, clicking on a synopsized announcement on a site''s Home should take you to the full view of that item in the Announcement tool.','Students|Instructors|Researchers|Sakai developers','Announcements ''Chat Room ''Discussion ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-40','Section and Group-Enable Existing Sakai Tool Set and Require it of New Tools','Implement support for section and group awareness in the existing Sakai Tools and require it of new tools to become part of the Sakai core bundle.','Students|Instructors|Researchers|Sakai developers','Assignments ''Chat Room ''Discussion ''Drop box ''E-mail Archive''Global ''Home ''News (RSS)''Presence ''Presentation ''Resources ''Roster ''Rwiki ''Schedule ''Section Info ''Site Info ''Syllabus ''Tab Management ''Tests & Quizzes (Samigo)''Twin Peaks ''Web Content ''Worksite Information ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-41','Allow multiple email addresses per user','Users should be allowed to specify a primary email address, where Sakai-generated email is sent (e.g., notifications, email archive messages).  Users should also be allowed to specify multiple secondary email addresses, which are used by Sakai when validating permission to send email to Sakai, such as to a site''s Email Archive.','Students|Instructors|Researchers','Account ''E-mail Archive''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-42','Aggregated Upload/Download of Resources','As an alternative to WebDAV, it would be nice to be able to upload and download aggregations of files/folders to/from Resources using archive files (e.g., .zip, .gz, .sit).  If one uploads an archive to Resources, one could have the option of exploding the archive in place in Resources.  If one wanted to download a collection of files and/or folders, then one could go through a picking process, select the desired items, choose the type of archive, and then download it.','Instructors|Researchers|Students','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-43','Instant Messaging','Instant Messaging support in Sakai is an oft requested feature.  There are a variety of approaches suggested.<br/>
<br/>
(1) Convert the Users Present List into a Buddy List for the site; or for the system, with users in the site you are currently in differentiated somehow from users in other sites in which you are a member.  Clicking on a name starts a chat with that person; or enters the default chat room for the site.<br/>
<br/>
(2) Integrate with existing IM clients.<br/>
<br/>
(3) For sites not using &quot;user presence&quot; build an IM tool; very similar in that case to existing chat, but supporting private conversations too.<br/>
<br/>
(4) When messages are sent in Chat display some sort of notification to other site participants who are logged in.','Instructors|Students|Researchers',' New Tool''Chat Room ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-44','Site-Specific and Tool-Specific Notification Preferences','Currently the &quot;Preferences&quot; tool appears only once for each user, in that user''s &quot;My Workspace&quot;. Preferences for email notification of changes are set there and apply to all worksites.
<br/>

<br/>
Sakai should also support worksite-specific preferences which can override the default preferences.
<br/>

<br/>
This need will become critical as the number of worksites an individual is likely to be participating in grows.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* You want daily-digests to monitor emails from one extremely chatty site, but need instant individual emails from another in which you play a leadership role.
<br/>

<br/>
* You''ve joined a site to hear about upcoming events. You want to receive Announcement notifications from that site, but not Resource or Email notifications.
<br/>
','Students|Instructors|Researchers|Staff (administrative)','Announcements ''E-mail Archive''Global ''Preferences ''Resources ''Syllabus ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-45','All Tools Should be Skinnable','A requirement for tools is that they should be skinnable.  For example, the current help tool only uses the default skin.','Instructors|Students|Sakai developers|Researchers','UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-46','Help Context-Senstive to Permissions','The help displayed by the Help tool should be senstive to what permissions a user has in a tool.  For instance, if they do not have permission to create announcements, then they should not see that section of help.','Sakai developers|Researchers|Students|Instructors','Global ''Help ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-47','Tool Menu (Left-hand Buttons) Permission Senstive','The list of tools appearing in the left-hand menu should be senstive to the users permissions.  If they cannot access the content of the tool, because its permssions have been set that weay, then they should not see that tool in their list.','Researchers|Students|Instructors','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-48','Dock/Undock Tools','Restore the ability to dock/undock tools into their own browser windows.  This was present in 1.x versions of Sakai.','Researchers|Students|Instructors','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-49','Split up Functionality of site.upd Permssions','Finer grained permssions are needed on edit fuctions for site.upd.  Currently it allows a user to add, remove, and mark active/inactive other useres in a site.  It would be better, however, if you could grant the ability to mark a user active/inactive without the ability to remove them, as you don''t want instructors accidently removing a user and their work from a site.','Researchers|Students|Instructors','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-50','Manage Users and Courses Tool','A refinement of current admin tools, both UI and functionality.  An admin tool that will list users and display courses or list courses and display users associated with course.<br/>
<br/>
a. ability to link user to all courses or link course to all users<br/>
b. paging for all list views (currently a very long roster will break the html at Realms) <br/>
c. showing X-of-Y for list pages (currently, when we do get paging we only get Previous and Next.  No clue how many pages we''re leafing through.<br/>
d. a way to export any list in admin as .txt<br/>
e. the tool list at Sites &gt; Pages &gt; Tools &gt; New Tool as a dropdown menu.<br/>
','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-51','Admin Copy Tool','An admin tool that will copy a course or a site for Faculty not Admins thus freeing up admins for this function.  Faculty will still want to copy courses or sites even with the WebDav respository.  The batch import/export tool does not allow instructors or site maintainers to target specific areas.<br/>
<br/>
The copy tool for instructors should do the following:<br/>
- identify the course/site to be copied<br/>
- identify the target to be copied to (new course, existing course)<br/>
- identify areas of the course to be copied allowing specific material or areas to be copied (includes assessments, images, etc.)<br/>
- will be able to copy user data (optional) if desired','Researchers|Instructors',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-52','Merge Course/Site Tool','An admin and instructor tool that will merge courses or sites into a target course, however, this tool is for instructors not admins.  It would allow instructors to merge one course into another to allow teaching of several sections of courses within one sakai course.<br/>
<br/>
The merge tool should do the following:<br/>
- identify the course/site to be the target or repository of the course sections<br/>
- identify or select the courses to be merged into the target course<br/>
- merge the enrollments into the target course for all roles (stdts, instructors, GTAs, etc) and data updates will automatically take effect within the target course<br/>
- this action (the merge) can be undone<br/>
- still identify students which were enrolled in the pre-merge sites<br/>
<br/>
Use case:<br/>
Instructor A is teaching 2 courses that meet on different days. He would like to post all course materials, tests, etc... on one worksite. He would like to also be able to send announcements to all students, or just students in the class that meets on the first day. At the end of the semester, he will split the site back into the 2 original sites and post final exam information. When the classes are split, the course materials and data should be duplicated in both classes.','Instructors|Sakai administrators',' New Tool''Section Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-54','Log Searching Tool','An admin tool that will allow admins to check the logs in order to know when a person took a quiz, accessed an area, and what they did when they accessed said area.<br/>
<br/>
The search should be able to be limited by users, sites, and dates. For example, I want to search the logs for the last week for site &quot;Test site A&quot; and user &quot;student B&quot; with a search term &quot;quiz 4&quot;.<br/>
<br/>
Use Case:<br/>
A student claims to have taken an online quiz 2 weeks ago but they have no grade in the gradebook. The admin (helpdesk support person) needs to be able to search the logs (through the interface) to see if there are any indications that the student took the quiz but the data was lost or removed.','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-55','Indicate Read/Unread Messages','In tools like Discussion, Announcements, etc. there should be an indication of whether items have been read or remain unread. ','Students|Researchers|Instructors','Announcements ''Assignments ''Discussion ''E-mail Archive''MOTD ''Resources ''Schedule ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-56','Use a Single "Name" to identifiy Resources','A continuing source of confusion for users is the lack of correlation between the Title of a Resource and the ID by which the system knows the Resource.  In general, users are expecting Resources to behave in a manner similar to their computers file system.  Resources violates this by only looking at a Resource''s system ID and ingoring the Title when a user performs actions which result in duplicate names.  For example, users can end up with two or more Resources with identical Titles.  The system knows the Resources are different because each was assigned a unique ID when it was uploaded, however, the user cannot necessarily tell from the UI what''s going on.  Also, they may attempt to upload a new version of a file using the same Title assuming that it will replace the old version; it does not, instead you end up with two identically named Resources.<br/>
<br/>
A signle &quot;name&quot; or &quot;ID&quot; should be used to identify Resources for the purposes of listings, warning users about replacing an existing Resource during uploads, preventing more than one Resource having the same Title, etc.<br/>
<br/>
','Sakai developers|Students|Researchers|Instructors','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-57','Google Indexing of Email Archives','Email Archive contents should be google indexable if site is public.','Instructors|Researchers|Students','E-mail Archive');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-59','Allow a user to disable email notifications','We would like a setting in the preferences tool that allows a user to specify that no mails should be sent from the sakai system to his/her mail account.<br/>
<br/>
There should also be an option to turn off this control at an institutional level (probably controled through sakai.properties) and to override it at a site level.<br/>
<br/>
Use Case:<br/>
Student A is tired of getting email, they turn off their notifications. They should receive a series of warnings before they are allowed to turn it off that indicate they may miss important announcements. It should also indicate that the site owner can override the setting.<br/>
Use Case 2:<br/>
The instructor wants to send out a notification about class being cancelled. He knows that some students have turned off their notifications. He should be able to override the flag and send a notification that will reach all students.<br/>
Use Case 3:<br/>
Institution B wants to force students to always get notifications in Sakai. They turn on the notification globally and the control disappears. All settings are maintained and if the global flag is turned off, the users who turned off notifications will not get new messages.','Instructors|Sakai administrators|Staff (administrative)|Students','E-mail Archive''Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-60','Redesign the resources tool to be more fdocument and student centered','The resources tool, as it is right now is folder centred. This means I can categorise my documents in only one category. For instance if I make a folder for each course I''m in and one of my documents is essential for two or more courses I''ll have to make a copy of the document for each folder it needs to be in. I would like Sakai to be document centred and to enable me to categorise/organise my documents in more than one way.<br/>
<br/>
The resources tool is worksite centred. Sakai is about collaboration and collaboration in Sakai takes place in worksites. If I want to share my documents with other students and faculty the only way to do this is by starting or participating in a worksite. And I''ll have to make a copy of the document for each worksite I want to publish it in. I would like Sakai to support ad hoc collaboration without the need to start a worksite and to enable me to share my documents without the need to copy them.<br/>
<br/>
The OSP FX (functional requirements) group made a description of a resources tool that is more flexible and student centred, enabling collaboration in worksites and ad hoc collaboration. I would like this vision to be in the centre of Sakai. Mock-ups can be found at <a href="http://portfolios.itd.depaul.edu/ospi/Prototypes/OSPInterfacePrototypes.htm">http://portfolios.itd.depaul.edu/ospi/Prototypes/OSPInterfacePrototypes.htm</a>. Of special interest for this discussion are the links ''Manage a Collection'' and ''Publish a portfolio''.','Researchers|Instructors|Staff (administrative)|Students','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-61','Display the name of the current user in the site navigation','Our interaction design requires that the name of the curent user is displayed on the screen. The purpose of this is to give the user a sense of ''mine'' when they use sakai. This is different from the presence tool because only your own name would be displayed. We will be displaying this in the mast-head area of the page<br/>
<br/>
This will be something that we are going to look into our selves. We hope other people share this requirement and that is can be made a part of Sakai.<br/>
<br/>
This should also be able to be turned off globally using a flag in sakai.properties or something like that.','Instructors|Researchers|Students|Staff (administrative)|Sakai administrators','Global ''JSF ''Style Guide ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-62','Hide pages in navigation from specific roles','In most tools the permissions can be set to specify what users of each role can do with a tool. In some cases there can be roles for which a tool has no usefull purpose at all. It would be nice to be able to hide those tools or, even better, the page they are on from users of those roles.<br/>
<br/>
Samples of tools that you may decide students don''t need access to are:<br/>
<br/>
-osp.legacy.review<br/>
-osp.presTemplate <br/>
<br/>
Since most tools are on a separate page it would be preferable to be able to hide pages.<br/>
','Students','Portal ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-63','Structured presentation of course content','Course content must be presented to the students structured in a hierarchical way - similar to Windows explorer. See attached file for an example. We also need a way of importing course content into SAKAI from a standard (IMS).<br/>
<br/>
Further, creation of this content from the SAKAI environment by lecturers. The lecturers see a similar screen, but have additional functionality for creating new topics. Topics can be created within topics. See attached file for an example.<br/>
','Students|Instructors','Web Content ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-65','Email Archive should be deep-linkable/bookmarkable','It is currently impossible to &quot;link&quot; to a message, because the tool state is (apparently) in the session.<br/>
<br/>
The use cases are myriad, but for example:<br/>
<br/>
A student asks &quot;what were the requirements for the robot-building contest?&quot;.  Another student replies with a link to the message in the email archive where the professor states the requirements.  Currently that is impossible.<br/>
<br/>
Even I as a sakai implementor would love to be able to send a link to  (or bookmark) various sakai-dev emails.  Currently one cannot do that.<br/>
<br/>
At the very least (although it is really not totally sufficient either) the email could be handled like resources are, we there are &quot;canonical&quot; urls to retrieve them.  Although really, the link should place the user in the context of the site and mail archive tool not just deliver the text of the message. However, currently there is no way to do that in Sakai in general, so maybe this is even a bigger requirement!<br/>
<br/>
I am marking this as &quot;Essential immediately&quot; because, really the email archive tool is only useful for casual browsing without it.  And really, given the slowness of the archive, it is not really useful for that either.<br/>
','Researchers|Sakai administrators|Sakai developers|Staff (administrative)|Instructors|Students','E-mail Archive');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-66','be able to delete several messages at once in Email Archive','when emptying an email archive one has to go deleting message by message, whereas a checkbox would allow for selecting to delete several messages at once.','Students|Researchers|Instructors','E-mail Archive');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-67','Be able to export and print the Roster','Goal:
<br/>
Allow instructors to export the roster (with the photos) to an Excel or CSV file. Include a &quot;print-friendly&quot; button of the roster list and photos.','Instructors','Roster ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-68','be able to watch Drop Boxes, getting alerts on uploads','a recurrent request we have; be able to keep watching Drop Boxes, eventually on a site basis, not an individual one.<br/>
When a document is upload, the instructor gets a message.','Researchers|Instructors','Drop box ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-70','be able to see profile of User','The personal data which is edited and displayed by the &quot;Profile&quot; tool is more extensive than the data which is edited and displayed by the &quot;Users&quot; tool. However, the only way to see &quot;Profile&quot; data for a user other than oneself is via the &quot;Roster&quot; tool on a particular site. Administrators have no way to access it. Since the Profile data is system-wide, there should be a system-wide way to see it.
<br/>

<br/>
(Behind the scenes, the &quot;Users&quot; and &quot;Account&quot; tools access legacy user data whereas the &quot;Roster&quot; and &quot;Profile&quot; tools access newer core services for EduPerson-style data.)
<br/>

<br/>
One way to approach this would be to add &quot;Profile&quot; links in the administrative &quot;Users&quot; tool. Another way would be to implement a replacement for the legacy &quot;Users&quot; tool which takes advantage of the newer data and provides more services.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* The system administrator sees that a user has been causing dozens of crashes over the past two days. There''s no response from the user''s email account. The admin goes to the user''s profile to find their phone number, department, and possible IM information.
<br/>
','Sakai administrators','Account ''Preferences ''Profile ''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-71','prevent users from login','for several reasons it can be usefull to prevent users from login, without having to delete them or to keep black lists outside Sakai. It can be though of as a soft delete, as it happens with resources.','Sakai administrators','Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-72','be able to specify site quotas on a user, user type, or site basis','it should be possible to specify quotas to My Workspaces and Sites on a User Type, and Site Type basis using the admin<br/>
interface (something like working with realms).','Staff (administrative)|Sakai administrators','Account ''Drop box ''Global ''My Workspace ''Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-73','Specify AM/PM or 0-23 hour format sakai-wide','the hour format could be settable, either in sakai.properties, or on user preferences. AM/PM can be confusing for users not used to it.','Instructors|Researchers|Students','Preferences ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-74','Ad-Hoc Group Management','As with sectioning, the full implications are bigger than a single tool, but this place is as good as any.<br/>
<br/>
Instructors need to be able to create ad-hoc groups and *group spaces* (group collaboration areas), and they need to be able to manage these within their course sites.<br/>
<br/>
Use Cases:<br/>
- An instructor or TA creates an ad-hoc group of a subset of site users.  Following creation group membership can be adjusted.<br/>
- Each group has their own collaboration space which includes the usual collaboration tools.  <br/>
- Since students may typically spend more time in a group space than a course space, the group site should not require navigation through the course site.<br/>
- An instructor has an option to import groups from another site (i.e. groups may span multiple sites)<br/>
- An instructor or TA wants to send emails/messages/announcements to specific groups, and not have to remember an email address for each group.<br/>
- Assignments and the gradebook should be &quot;group-aware&quot; to the extent that group projects may be submitted for grading, and feedback may be received on either an individual or group basis.','Instructors|Students','Global ''Section Info ''Sites (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-75','Weighted Grades','- An instructor needs to be able to set - and adjust - the relative weighting of a column for computing a final score','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-76','Numerical Final Grades','The  current gradebook only allows letter grades for its final reports.  It seems to be based on the assumption that the gradebooks reports should somehow be &quot;official&quot; (or as close to official as possible) grade reports.  Faculty often however just want to get an Excel export of the final numbers, and they''ll fiddle with the final grades more subjectively later.  There should be an option to have numerical final grades, even for the export.','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-77','A list of who has not submitted an assignment','The current Assignments tool only displays a list of submissions for an assignment, and does not afford the faculty member a list of who has *not* submitted an assignment at all.  They have to do their own manual checking against the course roster to figure this out.<br/>
Use Case:<br/>
- an instructor wants to send an email to every student who failed to submit an assignment, and wants a list of such students displayed in the Assignments tool.','Instructors','Assignments ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-79','Browser back-arrow behaves as expected','The back arrow in a browser does not allow a user to navigate backward through successive pages of a tool''s workflow.  This proves to be highly disorienting and frustrating for users, who have to re-educate their learned web behavior simply to accommodate Sakai.','Instructors|Staff (administrative)|Students|Researchers','Global ''JSF ''Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-82','Contact/Help tool that records user state','An online help form that captures the user system info as well as the referring URL or siteID.
<br/>
- referring URL or site ID
<br/>
- Platform and OS
<br/>
- connection or ISP
<br/>
- Browser and version
<br/>
- username
<br/>
- firewall info
<br/>
- description of problem/issue/question
<br/>

<br/>
Ideally, this form would capture information about what tool the user is currently in, what site they are in, any information that can be pulled from the browser about their system, and anything that might help troubleshoot the problem they are having.
<br/>

<br/>
The email address where the help request is sent should be configurable.
<br/>

<br/>
Use Case:
<br/>
A user encounters a problem while using sakai. They click on the &quot;request assistance&quot; link at the top (or some other name) and a pop up window appears. The window contains information about the user and what they were doing before they clicked on the help link. They fill in a description of their problem or question and then click a button to send this to a helpdesk email address.
<br/>
','Students|Instructors|Researchers|Sakai administrators',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-83','Admin Tool "lite" for a college division admins','Some admin tasks that we currently handle university-wide could be offered/delegated to the college or school affiliates.  <br/>
Give these users &quot;soft&quot; versions of the Sites and Realms tools but limit access to sites over which they have dominion','Sakai administrators','Permission Widget ''Realms (Admin Site Management)''Sakai Application Framework ''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-86','Course Section folders created automatically in dropbox','When an instructor creates course sections in his course, the dropbox will create a folder hierarchy based on these sections.  For example, if the instructor creates Lab 1 and Lab 2, the dropbox will reflect these sections:<br/>
<br/>
folder SMPL 001 001 W06 dropbox<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Lab 1<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Bob Jones<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Ann Smith<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Lab 2<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Joe Jackson<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Kate Klein<br/>
<br/>
This will allow TAs and instructors assigned to individual sections an easier and more organized method for accessing the students in their section<br/>
<br/>
','Instructors|Students','Drop box ''Section Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-87','Recent Activity (What''s New) Tool','When any user (regardless of type) accesses a worksite, they will have access to a tool which summarizes worksite activity and updates since their last login.  This new tool will list to the user any changes (new or updates) in the following areas:<br/>
-announcements<br/>
-assignments<br/>
-chat<br/>
-dropbox<br/>
-email archive<br/>
-presentation<br/>
-resources<br/>
-schedule<br/>
-syllabus<br/>
-test &amp; quizzes<br/>
-web content<br/>
-newly added users<br/>
<br/>
This will allow users to easily identify any new or updated materials without having to search throughout the website for changes.  I<br/>
<br/>
f nothing changed since the last login, the tool would report &quot;No new changes or additions since last login&quot;','Instructors|Researchers|Students|Staff (administrative)',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-89','User Profile Tool','In the User Profile Tool, each Sakai user could upload:<br/>
-an image of themselves <br/>
-information about themselves<br/>
<br/>
This tool would be linked with the &quot;Users Present&quot; feature currently in Sakai.  Each name in the &quot;Users Present&quot; area would be clickable by other worksite users.  When a name is clicked it would open the user profile in a separate window.  The user''s image &amp; text introduction about themselves would be displayed.<br/>
<br/>
This type of tool would be beneficial as it would assist in the formation of an online community.','Staff (administrative)|Students|Researchers|Instructors','Account ''Sites (Admin Site Management) ''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-90','Migration tool to move data from Blackboard v6(+) to Sakai','As I know Sakai already has a migration tool for Blackboard 5.5. But since Blackboard 5.5 is quite different with v6.3 and v7. I think the migration tool need to be upgraded. <br/>
Our university plans for first pilot during summer semester. We need this migration tool as early as possible. (unfortunatly we do not have resource work on this now) <br/>
We talked about this during Austin conference. Zach Thomas (University of Texa) primary involved the tool development for v5.5. I have a impression seems like the new version tool will be ready by end of 1st Q. Has this been scheduled? <br/>
&nbsp;<br/>
 <br/>
','Sakai developers|Instructors|Sakai administrators',' New Tool''Site Archive (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-93','Worksite Menu Items Can Be ReOrganized.','The worksite instructor or maintainer will be able to re-order the worksite menu items.  For example, if the instructor wants one course menu to read &quot;Announcements, Dropbox, Discussion, Schedule, Assignments&quot; he will be able to rearrange the order through a pull-down menu system.  Benefits of this:<br/>
<br/>
-instructors &amp; maintainers have control over the &quot;flow&quot; of their course and are not restrained by the global menu properties<br/>
<br/>
-worksites will have more variety in their appearance ','Instructors|Researchers|Students','Site Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-94','Change the default name of "Tests & Quizzes" to "Assessments"','There is a desire to change the _default_ name of SAMigo* from &quot;Tests and Quizzes&quot; to &quot;Assessments&quot; in the tool registration configuration file.<br/>
<br/>
The main rationale for this name change is that SAMigo is often used for more generic assessment purposes in non-course sites like surveys. While the default name for any tool can be configured within Sakai, the gravity of a default name can be substantial (there is power in words :) and it is probably better when a default name meets the most, likely uses cases.<br/>
<br/>
A little history on the name &quot;Tests &amp; Quizzes&quot;, so that it doesn''t seem so arbitrary to detractors: before SAMigo was introduced into Sakai 1.5 it had been assumed that SAMigo would be called &quot;Assessments&quot;. However, there was desire from some core schools to better distinguish its name and purpose from the existing &quot;Assignments&quot; tool, so it was &quot;Tests &amp; Quizzes&quot; was adopted to better accomodate that desire.<br/>
<br/>
* For those who might not know the history of the name &quot;Samigo&quot;, this the code/project name of what was originally intended to be the Sakai Assessment Manager (SAM). When it was discovered that a proprietary software already existed, (possibly Significance Analysis of Microarrays <a href="http://www-stat.stanford.edu/~tibs/SAM/)">http://www-stat.stanford.edu/~tibs/SAM/)</a> another name had to be coined. <br/>
<br/>
Well, since the SAM project was the child of the Navigo project: SAM + igo = SAMigo ;)','Students|Sakai administrators|Researchers|Instructors','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-95','Percentage based grading','Allow instructors to set up their gradebooks based on percent weighted assigments, rather than (or as an alternative to) the current point-weighted assignments method.<br/>
<br/>
Real life example from management class syllabus:<br/>
<br/>
Students will be graded according the follwing formula: <br/>
&nbsp;&nbsp;&nbsp;&nbsp;Organization project report: 35%<br/>
&nbsp;&nbsp;&nbsp;&nbsp;Issue project report    35%<br/>
&nbsp;&nbsp;&nbsp;&nbsp;Student project presentation: 15%<br/>
&nbsp;&nbsp;&nbsp;&nbsp;Student overall Class participation: 15%<br/>
<br/>
(end of example)<br/>
<br/>
In the current GB the instructor would enter the numbers as points rather than percentages, but would then need to grade reports as a number between 0 and 35. In a percentage based system an instructor would grade all of the assignments from 0-100. The gradebook shoud then do the calculations based on the weights given. <br/>
<br/>
This is the grading method that predominates at MIT.<br/>
<br/>
','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-96','Users should be able to change their username and retain access to user data saved under the old username','When a user changes his username, the user no longer has access to data saved under the old username.  Presently, this is a problem that is not easily solved because Sakai associates user data with the user''s username.  Therefore, to associate the data with a new username, the username would need to be changed for every tool that stores user data. Some of this data is stored in xml blobs, which is not easily accessible.  To resolve this problem, Sakai can associate the user data with a randomly generated ID that is unique to the user rather than the user''s username.  This ID would be related to the user''s username, which would allow the user''s username to be changed in one table.<br/>
<br/>
Requirements:<br/>
Sakai can associate user data with a randomly generated ID that is unique to the user<br/>
Sakai can associate the randomly generated ID with the user''s username<br/>
Sakai administrators can change a user''s username<br/>
User can still retain access to user data saved under the old username when logged in with the new username<br/>
','Students|Sakai administrators|Staff (administrative)|Instructors|Researchers','Account ''Database ''Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-97','Instructors should be able to disable a user''s access to a site without removing the user from the site','An instructor may wish to disable a student''s access to a site for an indefinite period of time because the student has not been participating as expected.  It is possible to remove a student from a site, however, for universities that receive a daily load of registered students, this functionality would not satisfy the need in this situation.<br/>
<br/>
Requirements:<br/>
Instructor can disable a user''s access to a site without removing the user from the site<br/>
Instructor can include a message to the user indicating why his access has been disabled<br/>
Sakai can display a message to the user indicating why his access has been disabled<br/>
Instructor can enable a user''s access to a site<br/>
','Instructors','Site Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-98','User should be able to indicate a preference to order site tabs by most recent semester','Currently, Sakai adds new semester sites to the bottom of the list of tabs for a user.  Some users would prefer that the most recent semester sites are added directly after the My Workspace tab, making them easily accessible when the new semester begins.  While users do have the ability to reorder their tabs, by setting this preference, users would not need to reorder their tabs at the beginning of each new semester.<br/>
<br/>
Requirements:<br/>
Users can indicate a preference to order site tabs by the most recent semester <br/>
Sakai can display most recent semester site tabs first<br/>
<br/>
','Instructors|Students|Sakai administrators|Staff (administrative)|Researchers','Preferences ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-99','User can restrict profile information based on system role','Requirements:<br/>
User can restrict public and/or personal information to a specific role<br/>
Sakai can display/hide public and/or personal information to given role(s) based on user defined preference<br/>
<br/>
&lt;example&gt;<br/>
A student would like for all of his instructors to have access to his personal information (e.g., email address, phone number).  However, he does not want other students to have access to this information, but he doesn''t mind if they have access to his public information (e.g., name, major).<br/>
&lt;/example&gt;','Students|Sakai administrators|Staff (administrative)|Instructors|Researchers','Profile ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-101','Instructor should be able to make schedule items available to the general public','Requirements:<br/>
Instuctor can make a schedule item available to the general public<br/>
Sakai can display a schedule item to the general public that an instructor has made available<br/>
<br/>
&lt;example&gt;<br/>
Perhaps an instructor would like his/her course materials, such as the schedule item to be available to students who may be thinking about taking her class in the future.  By making the schedule items available to the general public, future students would have the chance to review them to determine if this class is the right fit for him.<br/>
&lt;/example&gt;','Researchers|Students|Staff (administrative)|Instructors','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-102','Use of middlename','In Dutch and other languages the use of ''Middlenames'' is quite important and is being used different depending on the situation.<br/>
An example:<br/>
We have someone called ''Victor van Dijk''<br/>
The name could be defined as:<br/>
FIRSTNAME = ''Victor''<br/>
MIDDLENAME = ''van''<br/>
LASTNAME = ''Dijk''<br/>
<br/>
Usage of this name would be as follows:<br/>
If you greet someone it would be:<br/>
''Hello [FIRSTNAME] [MIDDLENAME] [LASTNAME]''  -&gt; ''Hello Victor van Dijk''<br/>
or<br/>
''Hello Mr. [MIDDLENAME] [LASTNAME] -&gt; ''Hello Mr. Van Dijk'' (mind the use of the capitol ''V'')<br/>
<br/>
When we alphabetize, a list of students in a gradebook for example, it would be:<br/>
[LASTNAME], [FIRSTNAME] [MIDDLENAME]-&gt; ''Dijk, Victor van''<br/>
and NOT(!) like<br/>
[MIDDLENAME] [LASTNAME], [FIRSTNAME] -&gt; ''Van Dijk, Victor''<br/>
This last example is how Blackboard handles ''Middlenames'' and is the reason why out first instructors are walking away from Blackboard. It is not doable for them to administrate 300 students in a gradebook with faulty alphabetization.<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
','Staff (administrative)|Students|Instructors','Account ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-103','Restructure Gateway Site Browser tool','The current Sites tool (sakai.sitebrowser) has had performance issues such that we had to remove it from the UM installatiion. We need this tool back essentially as is but with a restructuring that eliminates performance problems it was causing.  Included is the need in this tool as well as others (Worksite Setup for example) to be able to sort by Term when term is one of the columns in a list.<br/>
<br/>
Without the tool, there isn''t a way for non authenticated users to get at content earmarked as public. <br/>
<br/>
There doesn''t need to be any design as the tool exists and has been in use. ','Instructors|Sakai administrators|Researchers|Students|Staff (administrative)','Sites (Gateway)''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-104','Allow optional auto-create groups using class sections that may be in the site via a provider id','Along with REQ-40 and REQ-74 which add group control to other tools, as an option it would be useful to allow auto creating groups from the roster for each class section that might be in a site via a provider id. For example, if a site contained 3 rosters because the provider id was
<br/>
2006,3,A,PSYCH,100,[001,002,003]
<br/>
it would be nice to automatically create a group 001, 002, 003 with the associated rosters, and have those groups change as the enrollment in the given section changes due to drops/adds etc.  Instructors could still add students manually to such groups.','Students|Instructors|Researchers','Section Info ''Site Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-107','Undockable sites','Each site, represented through its tab, should be able to be &quot;undocked&quot; into its own browser window and ?re-docked&quot; back into the window it was launched from','Instructors|Students|Researchers|Staff (administrative)','Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-108','Calendar subscription capability','Add to the Schedule tool the ability to subscribe to iCal feeds. This would allow easy addition of academic and school calendars to a Sakai worksite, or any other calendar that supports iCal.  This could also be used to add class meeting times to class sites, and student schedules to My Workspace schedules.','Students|Instructors|Researchers|Staff (administrative)','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-109','Search across site and sites','A Search capability is needed that allows searching through all content in a site, or through all content in all sites in which the user is a member.','Researchers|Instructors|Staff (administrative)|Students',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-110','More end user control over Page and tool order','Instructors and project site owners would like to customize the page order in the left hand menu column.  Currently they have to call support to get this done.  2.1 fixed problems with the page order not holding a customized order when adjusted by support, but it still takes a support call to make a change from the default order. ','Students|Researchers|Instructors','Site Info ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-111','Resource Viewer Tool','The resources tool is cluttered because it has everything needed to create new resources and edit existing resources as well as giving hierarchical access to large resource collections. Lots of people want different views of resources.  One common request is the ability to create a list of resources (and possibly other types of entities) related to a particular part of a course or subproject.  If we make the resources tool more like that, we break the hierarchical view.  Instead, we should make a new tool that is intended as a resource viewer.  This tool would focus on making it easier for a site maintainer to create a simple list of resources and format it as they see fit.  The list itself would be read-only.    ','Students|Instructors|Researchers',' New Tool''Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-113','Accessibility--Title and Content Frames should be combined','Separate title and content frames creates a situation where tool headings are often redundant and navigation is cumbersome. For example, if a screen reader user has his JAWS settings on default, he will hear the following description:<br/>
<br/>
Beginning of announcements title frame<br/>
Announcements title frame<br/>
Help<br/>
End of announcements title frame<br/>
Beginning of announcements content frame<br/>
Announcements content frame<br/>
Add<br/>
Merge<br/>
Options<br/>
Permissions<br/>
Announcements heading one<br/>
<br/>
','Instructors|Students|Researchers|Sakai administrators|Staff (administrative)','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-114','Anonymous poll tool','A simple but useful tool is one which can quickly survey opinion on a specific topic - a poll tool.<br/>
<br/>
The tool should provide a simple multiple-choice question, allowing respondents to choose one or possibly multiple options.<br/>
<br/>
Aggregate results are immediately available to participants.<br/>
<br/>
The poll tool should be optionally integrated with discussion (ideally targetted at Message Centre) so that it''s possible to follow a link to a topic / thread about the poll. There may also be other integration points and features, e.g. ability to send an email notification of a new poll, or automatically add an announcement about the poll (with a link to take the poll and/or view results).<br/>
<br/>
Some screenshots from an existing CMS illustrating the basic idea are attached.','Students|Instructors|Researchers','Sakai Application Framework ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-115','Online surveys and course evaluations','There are 2 use cases for a tool which can be used for surveys:<br/>
<br/>
1. Research and collaboration groups using Sakai who wish to survey participants or a broader sample of people online<br/>
<br/>
2. Course evaluations<br/>
<br/>
This capability is similar to that currently provided by T&amp;Q, but with some important differences, e.g.:<br/>
- No correct answer<br/>
- No references to grading, assessment, etc.<br/>
- Support for presenting and exporting results in various ways<br/>
<br/>
It is expected that the easiest way of achieving this would be to extend T&amp;Q.<br/>
','Students|Researchers|Instructors','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-116','Password recovery / lost password for guest accounts','Currently guest accounts can be added to Sakai. Guests will receive an email with their password, with which they can login and update their password (My Workspace / Account).<br/>
<br/>
However if a guest loses his/her password, there is no way for the guest to recover a password (e.g. by having a new one emailed to them).<br/>
<br/>
Ad-hoc solutions to this have been implemented separately by Rutgers (<a href="http://rulink.rutgers.edu/sakai/#guest">http://rulink.rutgers.edu/sakai/#guest</a>) and UNISA.<br/>
<br/>
This is an important capability which needs to be in core Sakai, otherwise it creates significant support issues as the guest userbase grows.','Instructors|Researchers','Account ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-117','SMS (text messaging) integration','In a number of countries, a very high percentage of students have cell phones (mobile phones) with text messaging capability (e.g. &gt; 95% of students at University of Cape Town).<br/>
<br/>
There are many applications for using text messaging to communicate with Sakai users both with the existing &amp; future toolset, for example announcements and notifications, and for interactive learning applications such as submitting questions to a possible FAQ tool or forum by SMS.<br/>
<br/>
Supporting SMS capability in Sakai requires:<br/>
- Profile tool to allow students to enter a cellphone number<br/>
- Integration with (minimally) Announcements and notification service<br/>
- User preference settings<br/>
- Site option settings<br/>
<br/>
The support and options available need to be flexible enough to cater for inter alia different types of SMS gateways in use, and different business models applicable in different countries (e.g. sender pays, receiver pays, etc.).<br/>
','Instructors|Researchers|Students|Staff (administrative)','Announcements ''Global ''Preferences ''Profile ''Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-118','Instant messaging support','There are many use cases for good support for and integration with instant messaging technologies (targetting specifically Jabber/XMPP). These include:<br/>
<br/>
- Notifications and alerts by IM<br/>
- Replacement for chat service<br/>
- Enhanced presence awareness<br/>
- Supporting collaborative activities<br/>
<br/>
Minimal integration would include IM-capable Announcements and notification service, updated user profile and preferences to allow IM settings and options.<br/>
<br/>
See initial work on this topic in Confluence: <a href="http://bugs.sakaiproject.org/confluence/pages/viewpage.action?pageId=4580">http://bugs.sakaiproject.org/confluence/pages/viewpage.action?pageId=4580</a>','Students|Instructors|Researchers|Staff (administrative)','Announcements ''Preferences ''Presence ''Profile ''Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-119','Upload user photo','Presently, if a user wishes to add her photo to her profile, she needs to do the following:<br/>
<br/>
- Upload an image into Resources<br/>
- Make the image public (share it)<br/>
- Add the URL of the image in Profile<br/>
<br/>
To make this simpler for users, Profile should allow users to upload a photo, rather than specifying a URL. The uploaded image should also be automatically resized for an appropriate display size. Optionally, the original image could be retained along with the resized image.<br/>
','Students|Instructors','Profile ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-120','Improved Help tool','Two changes to the help tool:<br/>
<br/>
- The current frames layout is clumsy. Specifically users have to resize the search / index frames when using either one. It would be preferable to have Index and Search as tabs, and a top banner which institutions can brand and customize.<br/>
<br/>
- When institutions rename tools (e.g. &quot;Syllabus&quot; to &quot;Course Outline&quot;), there is no easy way to have that name change reflected in the Help index and documents (or if this capacity exists, it is under-documented).<br/>
','Instructors|Researchers|Sakai administrators|Sakai developers|Students','Help ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-121','Add Hierarchy Capability to the Framework','This will add a generic hierarchy backbone within Sakai and allow sites, and other objects to be associated with theis hierarchy.  The primary end-user visible aspect of this will be the ability to have sub-sites, or sites within sites.  Over time, tools may begin to use the hierarchy capability to organize their own objects.','Sakai developers','Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-122','Add IP Filtering to Web Services','WSRP has a configurable IP filtering capability.  This same capability needs to be added to Sakai''s web services.','Sakai developers|Sakai administrators','Web Services ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-123','Support IMS Enterprise','This likely will take the form of finishing the IMS Enterprise Provider as a first step.  In addition, there may need to be a way to upload an IMS Enteirprise document, parse it and inject that information into Sakai.<br/>
<br/>
It will be important to understand which forms of IMS Enterprise are actually in use at the various sites.  Not too much work should be put into this effort until a set of consumers (sites) have been identified that would actually use the capability if available.<br/>
<br/>
Those sites with immediate need for IMS Enterprise will need to clarify the precise form that IMS Enterprise wll need to take within Sakai.','Sakai administrators','Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-124','Add SCORM Player to Sakai','Sakai currently does not have SCORM support.  For some sites (especially commercial) this is a critical feature for a learning system.','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-125','Align Sakai CSS with WSRP/JSR-168 CSS','Currently Sakai has its own CSS - Increasingly as Sakai tools will be integrated into portals throuhg WSRP and JSR-168, we will need to inherit the CSS values from the enclosing portal.  We will either need to change our skin classes or come up with some type of adapter between the skins specified in WSRP and JSR-168.<br/>
<br/>
The largest skin is likely to be the one defined in WSRP 2.0 - this should be consulted in addition to WSRP 1.0 and JSR-168.','Sakai developers','Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-126','Create new proxy tools and a virtual portal for WSRP','This effectively replicates the Sakai JSR-168 portlet capability in a WSRP end point.  The idea is that one can place a WSRP endpoint in a portal and then configure the endpoint to be a proxy for any Sakai site, tool, or page, or even the whole Sakia portal.<br/>
<br/>
This will allow Sakai capabilities to be integrated into non-JSR-168 portals.','Sakai administrators','Portal ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-127','Improve support for Hibernate - Move hibernate aspects out of shared/lib','Currently when a component uses Hibernate all of the Hibernate aspects fo tyhe component must move into shared/lib because of class loader issues.  This also causes some problems when hibernate based components call each other.<br/>
<br/>
This is a requirement because it will require some careful thought to come up with a solution and then may require all of the Sakai components which use Hibernate to make some modifications to make use of the new pattern of Hibernate usage.  Because of the need for release-wide coordination and potential large QA effort, this is something that the community should prioritize.<br/>
<br/>
This may be combined with an update to Hibernate-3 and possibly moving to the latest Spring version.<br/>
','Sakai developers','Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-128','Moodle Integration','Come up with a strategy, design, and development effort to provide some form of integration with Moodle.  A commonly discussed use case is to allow Moodle to be used from  within Sakai using a variant of the IMS Tool Interoperability approach.<br/>
<br/>
This would allow most of a Sakai site to be Sakai tools, but to be able to have buttons within a Sakai site be Moodle tools hosted on any Moodle server.<br/>
<br/>
The key will be autoprivisioning of identity and roles between Sakai and Moodle.','Sakai developers|Students|Instructors',' New Tool''Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-129','Integration with Learning Design and other Work Flow Engines','Refine the Sakai Architecture (likely the Entity Model) in oprder to support the workflow needs oa a learning design engine such as LAMS or Coppercore.  The requirements these engines have range form discovery of entityes, the timed use of entities during LD experiences, and the retrieval of information from entities.<br/>
<br/>
This will be a significant effort, starting with spending some time looking at LAMS'' and Coppercore''s internal APIs and also the IMS LD spec.  It is likely that it will take a long time to understand alll of the dimensions of this integration before work will actually start.','Sakai developers','Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-130','JSF Widget Cleanup','One of the original visions of Sakai was to delegate much of the implementation of the presentation abstraction to JSF components.  <br/>
<br/>
Many projects have used JSF and used a blend of Sakai widgets and their own widgets.<br/>
<br/>
We need to go through a carful effort of bringing these widgets back together so as to end up with a richer set of Sakai widgets so that we can use widgets across tools.<br/>
<br/>
This is often a daunting task because it is more difficultt to write a highly generic variant of a widget versus one which is used in a single place - so some careful architecting is needed to be done in this effort.<br/>
<br/>
','Sakai developers','JSF ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-131','Organize and display resources in topic hierarchies','Some sites may wish to categorise resources according to hierarchical topic categories. Significantly, a resource may belong to more than one topic.<br/>
<br/>
The Resources tool could be extended to support this capability given 2 changes:<br/>
<br/>
- Ability to create a link entry (analogous to a symbolic link on a filesystem) pointing to another resource entry<br/>
- An Resources UI (topic view)<br/>
<br/>
Two screenshots from an existing CMS illustrate this concept. Note in the resource display view (topics-1) that the Resource has been added to mutiple topics.<br/>
','Instructors|Students|Researchers','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-132','Link Resources to discussion about that Resource','Currently it is possible to attach a resource to a discussion entry, but not the other way around: when viewing a resource, there is no link to discussion entries about that resource.<br/>
<br/>
This requirement is to add this reverse-linking (preferably targetted at Message Forums).<br/>
<br/>
A typical use case for this would be a student who is reviewing course resources at the end of a course, views a resource (for example an image in Resources) and wishes to review the discussion about that resource which took place somewhere in the discussion forums (which now have a very large number of messages, such that it''s impractical to read through them all again).<br/>
','Students|Instructors','Discussion ''Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-133','Thumbnails for gallery view of Resources folder','Equivalent functionality to Windows Explorer''s View | Thumbnails, i.e.:<br/>
<br/>
- It is possible to display a set of thumbnails of images in a Resources folder, for purposes of easy navigation and finding the appropriate image.<br/>
<br/>
- The thumbnails should be generated automatically (scaled to an appropriate display size), and then cached for future use (possibly stored with the Resource metadata)<br/>
','Students|Researchers|Instructors','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-134','Internationalize all the tools','All the tools in sakai must be localizable without code changes, only adding new resource boundles with localized messages.<br/>
<br/>
A development manual can be created to explain how to make intertionalizable tools.','Sakai developers','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-135','Bidirectional email gateway for Message Forums','In many cases, users wish to receive discussion items by email rather than logging in to a website daily or more often. Email Archive provides a way of using email discussion, but is too simple for many applications.<br/>
<br/>
Users should therefore have the ability to participate in Forum discussions as if they were email-based mailing lists, i.e. subscribe to a discussion at various levels (forum, topic or thread). Once subscribed, user''s are sent relevant forum postings. <br/>
<br/>
Each email has an appropriate reply address allowing the user to reply to the message by email (in which case the message is inserted into the forum), and also has links which take the user directly to that thread in the forums tool (subject to the usual authentication).<br/>
<br/>
Users can manage their email subscriptions with the forum tool, again either at a forum / topic / thread level, or by managing a list of all current subscriptions for the site.<br/>
','Instructors|Students','Discussion ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-136','Multiple choices of localization','It would be desirable that:<br/>
- A user could choose the localization of their workspace<br/>
- A site admin could choose the localization of the site<br/>
','Students|Instructors','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-137','Hierarchy and date ranges for Syllabus','Syllabus currently provides a reorderable flat view of items. In many cases, lecturers wish to group items according to:<br/>
<br/>
1. Theme<br/>
2. Timeslot (e.g. weeks)<br/>
<br/>
Syllabus should therefore be able to support hierarchies (either unlimited or to depth 3), and some relationship of items to dates, for example if an item is a Lecture, it would have a specific day associated with it. If an item is a week (Week 3), it may have a start and end date.<br/>
<br/>
Syllabus item dates could optionally be added to the Schedule (Calendar). The Syllabus display could also be optimized to show current or forthcoming (near future) items, e.g. Current Week, Forthcoming lectures.<br/>
','Students|Instructors','Schedule ''Syllabus ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-138','Gradebook options to support moderating grades across sections','In large courses (e.g. 500+ students) with many groups/sections and many different people grading assignments (e.g. TAs), institutional assessment policy may require that grades are moderated across groups, i.e. the grading behaviour of different graders should be consistent, and if not, grades possibly adjusted.<br/>
<br/>
To facilitate this, the gradebook should provide a display and export option to produce a table for each assignment showing by group, the TA, and the highest, lowest and average grade given.<br/>
<br/>
This allows a course convenor or assessment moderator to determine if grading has been consistent across groups, and to apply moderation strategies if required.<br/>
<br/>
(The above is in US terminology; in South Africa, grades = marks, TAs = Tutors).<br/>
','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-140','Audio/Video integration','Either through a new tool, or through integration with an existing product such as Horizon Wimba, users will be able to do the following:
<br/>

<br/>
-chat in real time (synchronous) audio/video conferences.  From [REQ-140] which wanted an av chat tool.
<br/>

<br/>
-record audio recordings for inclusion in discussion boards
<br/>

<br/>
-record audio recordings for inclusion in email
<br/>

<br/>
-record audio recordings for inclusion in assessessments (questions &amp; answers)
<br/>

<br/>
','Students|Instructors|Researchers',' New Tool''Discussion ''E-mail Archive''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-141','Electronic Lab Notebook','Either through a new tool or through integration with an existing product, such as Open Source Electronic Lab Notebook <a href="http://www.opensourceeln.org,">http://www.opensourceeln.org,</a> that would allow users (students, instructors, researchers) the ability to keep an electronic notebook of lab experiments:<br/>
<br/>
-users can submit info (kind of like a blog) except no previous info can be changed.  The goal is to create a legal record of lab progress.<br/>
<br/>
-all entries will be date &amp; time stamped and associated with a specific user<br/>
<br/>
-users can attach files to entries<br/>
<br/>
-','Researchers|Students|Instructors',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-143','Calendar with GroupDAV capabilities','Use cases:<br/>
- Create/Update/Delete entries inside sakai<br/>
- Create/Update/Delete entries with other tools (like Mozilla Calendar, Evolution ..) with iCalendar via WebDAV<br/>
','Researchers|Instructors|Students','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-144','Distributed/Remote tool/components support','Use cases examples:<br/>
<br/>
- UserDirectory provider situated outside sakai in another computer<br/>
- Chat tool situated in another computer','Sakai developers|Sakai administrators','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-145','Ability to hide a folder','In some cases it may be desirable to hide a folder, while still making files inside it accessible.<br/>
<br/>
For example, a course site owner may wish to include various images in the Wiki, but doesn''t want a ''WikiImages'' folder visible to students browsing the site.<br/>
<br/>
Folders (optionally files) should therefore have an attribute which can be set by someone with appropriate permissions on the folder, viz. ''Hidden''. Hidden folders are displayed to users who have update permissions on the folder, but are not displayed to users who have read-only access.<br/>
','Instructors|Students','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-147','Add flexibility to Schedule tool configuration','Allow the site''s admin to set:<br/>
- The first day of the week<br/>
- The starting hour of the day','Sakai administrators|Instructors','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-148','Improved handling of attachments','Various tools allow attachments to be added (for example to Schedule items or Assignments). At present, these are stored in a separate attachments area, which has various drawbacks including not being subject to the same authentication context as the item to which they are attached, and the quota policies applied to the site in question.<br/>
<br/>
Attachment handling should be revised to address these issues. Storing attachments within the site folder structure within a protected/hidden folder may be a good starting point.<br/>
','Instructors|Sakai administrators|Students','Announcements ''Assignments ''Attachment Widget ''Discussion ''E-mail Archive''Resources ''Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-149','RSS updates publishing','Each tool that generates updates as Resources, Announcements, Assingments ...<br/>
would inform publishing in RSS<br/>
','Instructors|Sakai administrators|Sakai developers|Students','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-151','Signup for a specific event within a course and assignment context','Certain courses require individuals or teams to complete tasks in (for example) lab settings, where there are is a limited number of lab spaces available (and/or any other constrained resource, e.g. items of equipment).<br/>
<br/>
Students are therefore required to signup for a specific event. Applicable business rules may include:<br/>
<br/>
- Students must sign up in teams of up to X students. Team leaders may sign up themselves and their team members, or individuals may join an existing team which is not full.<br/>
<br/>
- The event may be held in multiple sessions. Only a limited number of students can be accommodated in one session (e.g. a computer lab only has 20 PCs, but there are 60 students in the course, so students have a choice of 3 sessions).<br/>
<br/>
This use case is more complex than students signing up for Sections, in that the events are once-off rather than repeating, and additional business rules may apply.<br/>
<br/>
Lecturers can view the signup sheet for a session (in printable form), lock the session (to prevent additional signups), and enter a mark for all participants / teams in a session (submitted to Gradebook).<br/>
','Students|Instructors',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-152','Server-wide Usage Statistics','Sakai administrators can use this tool to view statistics of access to the platform:
<br/>

<br/>
- Number of global user''s access
<br/>
- Graphical view of access per time period
<br/>
- Number of site''s access
<br/>

<br/>
.[from REQ-177]
<br/>

<br/>
Sakai can display aggregate statistics for each term that would include total number of courses, number of active courses, number of users by role, number of active users by role
<br/>
','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-155','Disallow Users from Unjoining an Unjoinable Site','To disallow students to unjoin a course.<br/>
<br/>
When you create a site as UNJOINABLE, if you include a user in it,<br/>
the user can unjoin the site.<br/>
<br/>
Will be better to allow the admin to choose if the users included in<br/>
an UNJOINABLE site can unjoin the site ro not.','Instructors|Researchers|Students','Membership ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-158','Math symbols in rich text editor','Whichever html editor we use in future (HtmlArea at present), we would like to be able to add Math symbols to the content.','Sakai administrators|Sakai developers','WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-159','Graphical content in rich text editor','We would like the ability to embed graphical content (in a user friendly way) into a rich editor (HtmlArea) on any tool that uses it.','Sakai administrators|Sakai developers','WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-160','User activity information displayed with profile','When viewing a user profile in a site context, it is sometimes helpful to see that user''s contributions to the site, including:<br/>
<br/>
- Messages posted<br/>
- Resources added<br/>
- Assignments submitted<br/>
<br/>
etc. In some cases it may be desirable to have the information available to all site participants (e.g. messages posted) and in other cases only to site owners (e.g. assignments).<br/>
<br/>
The visibility of this information can help in establishing an online community, and in allowing site owners to track participation (esp. in course sites), which can be used for assessment purposes.','Students|Instructors','Assignments ''Chat Room ''Discussion ''Drop box ''E-mail Archive''Gradebook ''Profile ''Resources ''Rwiki ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-161','TurnItIn integration','Our institution subscribes to TurnItIn''s plagiarism detection services (<a href="http://www.turnitin.com/static/plagiarism.html">http://www.turnitin.com/static/plagiarism.html</a>).<br/>
It can be accessed via a web browser but we''ve also integrated it with our home-grown CMS.  In other words when staff creates an assignment in our CMS it automatically create an assignment in TurnItIn with the same name.<br/>
When students submit to our CMS the papers are automatically also submitted to TurnItIn and when the submission reports from TurnItIn are made available, they are accessible from our CMS.<br/>
Some staff has become so used to this feature, since it is easier and far less work than using TurnItIn directly, which will make the decision to migrate to Sakai a difficult one.','Instructors|Staff (administrative)','Assignments ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-162','Institutional Providers','We would generally like providers that will allow a hybrid of the following:<br/>
&nbsp;&nbsp;calendar<br/>
&nbsp;&nbsp;content hosting<br/>
<br/>
Currently, there is a provider that allows us to have both local users and external users.  We would like the same functionality for the items above, that will allow a hybrid of sakai database events, and externally generated events on the calendar (such as exam dates) even if these events are then read-only.<br/>
<br/>
Same with the resources; we have content on other systems, that we currently generate links for and post those links as resources in sakai.  We would like to automate the process by adding a provider between the dbcontenthostingservice and spring, which will allow automatically generated resources in anything that uses the resources tool.','Sakai administrators|Sakai developers','Providers ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-163','Ability to assign aliasses for students within a site','We have a Trade Bargaining course where students are assigned country names and for the duration of the course they represent that country in all activities within the course. <br/>
For the last few years they''ve been using an online environment to do their bargaining, voting, chatting and discussions. Having access to an online environment has become essential to the course and they won''t be able to use Sakai without this feature.<br/>
The alias should be course specific.<br/>
Also the students don''t choose their alias, it is assigned to them<br/>
','Students|Instructors','Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-165','Behavior Change for "Release Grades" function','In the current system, if an instructor saves a draft of an assignment he or she is in the process of grading, and then clicks &quot;Release Grades&quot;, the grade is still sent to the student. <br/>
<br/>
1. Instructor - create an assignment <br/>
2. Student - submit the assignment <br/>
3. Instructor - enter a grade and comments for assignment, click &quot;Preview&quot;, then click &quot;Save draft&quot; <br/>
4. Instructor - click &quot;Release Grades&quot; <br/>
5. Student - grade is displayed<br/>
<br/>
The desired behavior from our perspective would be for ONLY grades that were RETURNED and not SAVED.  It seems that the option SAVE implies that the grading is still in progress and should not be returned back to the student when &quot;Release Grades&quot; is chosen.<br/>
<br/>
A work around that may give more flexibility to this problem would be to allow the instructor the ability to set preferences for the Release Grades option, such that they can choose to release all grades or only returned grades.<br/>
<br/>
This was originally bug SAK-3719<br/>
<br/>
','Instructors|Students','Assignments ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-166','Schedule should allow site owner to set view preference','Instructors can set the default view in the schedule tool to something other than ''Calendar by week''<br/>
<br/>
Some of our instructors would like the default view for the Schedule tool to be set to ''List of events'' instead of ''Calendar by week''.','Researchers|Instructors|Staff (administrative)|Students','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-167','Schedule should allow author to specify order of schedule items','Our users would like the ability to change the order of the schedule items.<br/>
<br/>
Goals:<br/>
Authors of schedule items can specify the order of schedule items<br/>
<br/>
','Researchers|Staff (administrative)|Students|Instructors','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-168','Announcements should allow the author to specify the order','Our users would like the ability to change the display order of the announcements.<br/>
<br/>
Goals:<br/>
Authors of an announcement can change the order of the announcements<br/>
<br/>
instructors want to customize the order of announcements: e.g., have one announcement permanently appear on top<br/>
','Researchers|Staff (administrative)|Students|Instructors','Announcements ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-171','Chat should allow multiple rooms per site','Our instructors would like the ability to create multiple chat rooms per site.  With multiple chat rooms, some students could be participating in the chat on Social Behaviors while others could participate in the chat on Famous Psychologists.  Currently, all students must participate in the same chat discussion.<br/>
<br/>
Goals:<br/>
Instructors can create multiple chat rooms in a site to address different topics','Researchers|Students|Staff (administrative)|Instructors','Chat Room ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-172','Chat should allow private discussions','I''d like to give a quick use case for this requirement.  At IU, there are several online classes, where the instructor conducts the class directly from the chat room.  In this situation, an instructor might need to speak privately with a student about a particular problem the student is experiencing in class while also conducting class.  This is an extremely common occurrence in these online classes.<br/>
<br/>
Goals:<br/>
Users can chat privately, without participating in the group discussion','Instructors|Students|Staff (administrative)|Researchers','Chat Room ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-173','Chat should allow users to search for messages from a particular user','Goal:<br/>
Users can search for messages by name or username','Staff (administrative)|Researchers|Students|Instructors','Chat Room ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-174','Administrator tools should allow administrators to search for sites associated with a specific user','Often our campus and department admins will receive a trouble ticket for a particular user, that has the course number, but not the section number for the course.  At IU, a course number an be associated with many sections, so it would not be useful to know just the course number if searching by course.  However, if the administrator were searching by username, the course number would be more relevant because most likely the user would only be associated with one course (in the situation of a student).  The become user tool is useful to super administrators, but this tool cannot be given to campus and department admins due to the nature of the tool.
<br/>

<br/>
Goals:
<br/>
Administrators can pull up a list of sites associate with a specific user','Sakai administrators',' New Tool''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-175','Administrator tools should allow administrators to import course materials from/to any site to which they have administrative rights','Goals:<br/>
Administrators can import materials from/to any site to which they have administrative rights without having to join the site(s)','Sakai administrators','Sites (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-176','Syllabus should allow user to display syllabus text in plain text','Our instructors are not happy with the way the WYSIWYG displays some of their text and would like the option of displaying the text in plain text, without any applied formatting by the WYSIWYG editor.<br/>
<br/>
Goals:<br/>
Instructors can copy and paste formatted text and choose to display the formatted text in plain text (no formatting)','Instructors|Staff (administrative)|Researchers','Syllabus ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-181','Ability to specify the order the assignments are listed ','Our instructors would like to be able to specify the order the assignments are listed ','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-182','Sakai should display photo id next to user submissions, if available','In my goal description, I''ve specified the student role.  However, this functionality should not be limited to students, but should be available for all roles that will submit assignments, assessments, etc.<br/>
<br/>
Goals:<br/>
Author can see photo id of student when grading that student''s assignment or assessment. This would need to be able to be turned off by users who want to be anonymous and should also be able to be disabled on an institutional or site level.','Researchers|Staff (administrative)|Instructors|Students','Global ''Sites (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-183','Sakai should warn a user before the user''s session times out and data is inadvertently lost','Goals:<br/>
User can indicate he/she is still using Sakai before session times out','Researchers|Students|Instructors|Staff (administrative)',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-184','Enter all assignment grades for 1 user','The ability to enter in all the grades for a specific user.  This could possiblely be accoplished off the roster screen.  Clicking one of the user''s would take the site author to a screen allowing the ability to enter in grades for all assignments for 1 particular user.   ','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-186','Allow comments for each assigned grade','Allow comments for each assigned grade (ie each assignment). <br/>
<br/>
- Comments would be optionally visable to students as this allows instructors the ability to make private or &quot;public&quot; (to individual students) comments<br/>
- Comments should be imported from applicable tools (Assignments/ Tests &amp; Quizzes) to allow student access to appropriate feedback','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-187','Actions Column in Resources Tool','The Actions column in the Resources tool is problematic for the interface.  Its options are wordy, and it tends to take up a great deal of screen real estate in an area where people would most like to see a description of the item instead.<br/>
<br/>
It would be good to find a more compact (and perhaps graphically intuitive) way for actions to be carried out on items.','Researchers|Instructors|Students','Resources ''UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-190','Gradebook should accept spreadsheet imports (csv)','The Gradebook currently has the functionality to export  and the next logical step is to accept spreadsheet imports (csv)<br/>
<br/>
Instructors can create new assignment columns in the gradebook by importing spreadsheet data<br/>
Instructors can keep a backup copy of gradebook data<br/>
Instructors that use a spreadsheet for tracking data can make it easily available to students<br/>
Instructors would be able to easily reuse a gradebook from a previous semester in a new one<br/>
','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-192','Test & Quizzes should provide logs of dates/times assessments were accessed or submitted to Instructors','Goals:<br/>
Instructors can view logs of dates/times assessments were accessed or submitted for each student','Instructors|Staff (administrative)|Researchers|Students','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-193','Tests & Quizzes should allow instructors to export responses, questions, points earned, total score to CSV or XML file for advanced analysis','Goals:<br/>
Instructors can export responses, questions, points earned, total score to CSV or XML file for advanced analysis','Instructors|Staff (administrative)|Students|Researchers','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-194','Tests & Quizzes should provide a printer friendly view of an assessment for an instructor','Goals:<br/>
Instructors can print an assessment created in Tests &amp; Quizzes to give to a student who cannot take the assessment online','Instructors|Staff (administrative)|Researchers|Students','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-195','WYSIWYG should include emoticons','Goals:<br/>
Users can include emoticons in WYSIWYG-enabled text boxes','Students|Instructors|Staff (administrative)|Researchers','WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-196','Import should allow instructors to replace existing items with imported items','Goals:<br/>
Instructors can import items from another course and choose to replace existing items with the imported items','Instructors|Students|Researchers|Staff (administrative)','Site Info ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-197','Import should allow instructors to import section/group shell','Goals:<br/>
Instructor can import groups/sections created in another site and then add the necessary students to these groups','Researchers|Instructors|Students|Staff (administrative)','Site Info ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-198','Provide statistics ','Provide meaningful statistics on data entered in the gradebook for instructor and student review. Instructors should be able to specify whether or not students have this ability.  This would be something that isn''t displayed initially, but could be displayed. <br/>
<br/>
At a glance, Instructors can see how the class is performing.  If students have access, they can compare their performance to that of the class. <br/>
<br/>
For students, the instructor should be able to see - at a glance - <br/>
1) Running grade as a letter (grade calculated based solely on assignments that have a grade entered -  0 vs null)<br/>
2) Running grade as a percent<br/>
3) Total points<br/>
4) points possible (which could vary from student to student depending on what assignments have entered grades)<br/>
<br/>
In addition, on an assignment basis the following should be calculated and displayed<br/>
1) Average<br/>
2) Highest grade<br/>
3) Lowest grade<br/>
4) Standard deviation<br/>
<br/>
All viewable on the same screen - right now the average can be viewed, but none of the student specific data is there for easy comparison.  ','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-199','Sakai should allow instructors to define a parent site and associated child sites','Goals:<br/>
Administrators or Instructors can define a parent site and associated child sites<br/>
Instructors can create non-user related items (Syllabus, Schedule, Announcements, News, Web Content) and those items will automatically be visible in the parent and child sites','Researchers|Staff (administrative)|Instructors|Students','Global ''Section Info ''Sites (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-200','Assignment description','Allow an optional  description to be entered in for an assignment.  Instructors may want a 5 assignments entitled Exam 1, Exam2, ect . . but may want to provide more data on the actual assignment. For instance, Exam 1 covered readings in Chapters 1, 3, 7, ect . . . ','Instructors|Students','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-202','Specify a grade scale based on points','Currently it''s only possible to specify a grade scale based on a percentage.  Users need the specify the number of points rather than the percentage as this allows for different usage and grading styles<br/>
<br/>
Instructors would enter in the total number of points possible in a course, then enter in the lowest possible points needed to get an A+, A, A-, ect . . .The pecentage would automatically calculate.  <br/>
<br/>
To illustrate how you should set up the Grade Scale, let''s assume that a total of 1000 points is available for your class and that you are assigning grades in the following manner: students who earn 980 points or more (98% and higher) receive an A+, students who earn 930-979 points (93% &lt; = percent &lt; 98%) receive an A, students who earn 900-929 points (90% &lt; = percent &lt; 93%) receive an A-, etc. Below is an example of how the Grade Scale would look: <br/>
<br/>
A+ 980 98% <br/>
A 930 93% <br/>
A- 900 90% <br/>
<br/>
The ability to assign only whole letter grades should also be possible: <br/>
The following illustrates how the grade scale would look if you assigned only whole-letter grades. Here is an example: A for 900-1000 points, B for 800-899, C for 700-799, etc. <br/>
<br/>
A+     <br/>
A 900 90% <br/>
A-     <br/>
B+     <br/>
B 800 80% <br/>
B-     <br/>
<br/>
','Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-204','Utilize the home tool to describe what''s new the course or project in a dashboard view.','Allow users to quickly and easily get a snapshot of what has been happening in the site.<br/>
Create a default dashboard layout for site owner to start with and let them decide if they want to customize it.<br/>
Allow the site owner some flexibility in customizing the dashboard so that the most important information for that site is front and center (e.g. if they think recent announcements are most important, then they should be able to make them visually &quot;pop out&quot; at users when they arrive at the site).  <br/>
Help users customize the layout in meaningful way without forcing them to design the page free form.  In other words, ask site owners meaningful questions to determine the site layout  (e.g. what do you want users to notice first when they visit the site?)<br/>
Allow official course information (coming from the registrars office) to be displayed on this page as part of the customization.<br/>
<br/>
In course and project sites, show users relavant information for that site.  <br/>
In ''My Workspace'', by default give users a dashboard view of all the sites they belong to but allow them to &quot;opt out&quot; of sites displaying in the dashboard.  This will help allow them to decide what is most important to them.<br/>
<br/>
','Instructors|Researchers|Students|Staff (administrative)','Home ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-208','Consistently use global action action links as tool navigation between pages.  Currently, these buttons have different models in legacy tools and newer tools.','Conistently use global action links as tool navigation between pages.  This will allow users to build a consistent mental model about getting around in Sakai. <br/>
<br/>
Allow users to use the global action links to move around to different pages within a tool in a consistent manner.  Legacy and newer tools act differently.  In new tools, the global action links (at the top of the page) are persistently available and take users to each page within the tool.  In legacy tools there are a variety of results, sometimes they are used for navigation and others times they are used for actions.  The global action links change depending on what on page you are in within the tool.<br/>
<br/>
Analysis will need to be done to understand the models and behaviors in each of the legacy tools and a new design ','Instructors|Researchers|Staff (administrative)|Students','Global ''Style Guide ''UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-209','''Honor pledge'' specifics should be easily configurable per Sakai instance.','Allow an institution to use normal &quot;honor code&quot; langauage for thier institution.<br/>
Allow an institutions to easily change the term &quot;honor code&quot; referred to in assignment creation to something more appropriate at an institutional level.<br/>
Allow an institution to use the &quot;honor code&quot; for thier institution.   This should be easily configurable on a per instance basis. <br/>
Allow a department to use an honor code specific to them.  A department admin should be able to override the institution honor code if appropriate.','Staff (administrative)|Students|Instructors','Assignments ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-210','Add Support for JSR-170 (Java Content Repository)','This is a long term effort and will need to be fit in within aa sequence of significant framework changes.  The rough approach should be to first evaluate possible solutions/implementations looking at Jakarta JackRabbit or other open source alternatives.<br/>
<br/>
Before commencing on any codeing or porting we will need to carefully evaluate any technology for performance, scalability,and feature set.','Sakai developers','Sakai APIs ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-211','Integrate Content Management Capability into Sakai','The Gateway page is pretty lame in general.  This is one of the reasons that Sakai cannot be used to support <a href="http://www.sakaiproject.org">www.sakaiproject.org</a>.  Sakai needs a content management capability that is nicely integrated into Sakai''s structure and organization.<br/>
<br/>
The basic use case is to use Sakai to produce an organization''s public pages in addition to the private site oriented and personal pages.<br/>
<br/>
Some technologies to consider include <a href="http://incubator.apache.org/graffito/">http://incubator.apache.org/graffito/</a> and <a href="http://hypercontent.sourceforge.net/">http://hypercontent.sourceforge.net/</a>.','Students|Instructors|Researchers|Sakai developers|Staff (administrative)|Sakai administrators','Gateway ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-212','Search for users widget','Sakai users need to be able to search for other users where they need user information.  The search should include any user information that comes in to Sakai through SIS systems.
<br/>

<br/>
In order for this to be consistent behavior, we should have a Sakai widget that can be added to tools that currently need it.  It can be used in future tools.
<br/>

<br/>
The search results should be able to include any basic user information that is stored in Sakai.  However, information the user needs may vary dependent on the situation so which information is surfaced for a specific search should be configurable per use of the widget (e.g. in site info, users need to search for users to add them as particpants to the site.  The only information they need in this case is the email address).
<br/>

<br/>
Allow users to easily choose a user from the results list.
<br/>

<br/>

<br/>

<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators',' New Tool''Membership ''Profile ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-213','Schedule should allow for creating new items in the context of the calendar.','Allow users to choose the date and time of an event in the context of the calendar (like most calendar systems).<br/>
<br/>
Allow users to drag events around on the calendar to change the date and time of the event.<br/>
<br/>
Allow users to change the duration of an event by directly manipulating the event on the calendar.<br/>
<br/>
','Students|Researchers|Instructors|Sakai administrators|Staff (administrative)','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-214','Release widget that allows content created or posted in Sakai to be ''hidden'' until user specifies','Allow users specify a release date for material they post or create in Sakai.  The material is not available to site members until the release date. 
<br/>

<br/>
Allow users to set a date when site material (as they post or create it) is no longer available to site members.
<br/>

<br/>
This functionality is needed in any Sakai tool that that allows content to be posted or created,  like resources, assignments, announcements, discussion items, etc..  For efficiency, the functionality should be a widget that can be added to tools as needed.','Instructors|Researchers|Staff (administrative)|Sakai administrators|Students',' New Tool''Announcements ''Assignments ''Discussion ''Global ''Resources ''Schedule ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-215','More detailed synoptic views in My Workspace','It would be helpful for individuals to be able to see more overviews of site activity and items in My Workspace, including:<br/>
<br/>
- Open/available assignments and assessments (T&amp;Q) across all sites<br/>
- Grades across all sites<br/>
- Participation info across all sites (e.g. messages posted by me in all sites)<br/>
','Students','My Workspace ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-216','Glossary tool','In some disciplines and courses, getting to grips with new terminology is difficult for students.
<br/>

<br/>
Online glossaries can assist this process. A Glossary tool would enable instructors and/or students to add or comment on glossary entries, search the glossary, and retrieve glossary definitions in various ways (e.g. through the web UI, email or SMS).
<br/>

<br/>
Usage data could be used to inform presentation (e.g. display by most frequently accessed words), and for instructor feedback.
<br/>

<br/>
More complex uses could involve using the glossary to overlap course content, highlighting words which are defined in the glossary so that users can access popup definitions, and/or integration with tools such as the wiki (e.g. a macro such as {glossary:someword}
<br/>
','Students|Instructors',' New Tool''Melete');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-217','Ability to import questions in IMS QTI format that contains images','At the moment one is able to import questions into Samigoin QTI format. The problem is that if there are images associated with the question then there is way to import the images as well, or rather keep the link between questions and images.<br/>
<br/>
There are quite a few issues logged in Sakai and Samigo which deals with importing questions into Sakai but I have not seen this listed as a requirement here.<br/>
','Instructors','Samigo - Authoring ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-218','Integration with Respondus','Respondus  (<a href="http://www.respondus.com/">http://www.respondus.com/</a>)  is a program one uses in creating and managing exams that can be printed to paper or published directly to Blackboard, WebCT, eCollege, ANGEL and other eLearning systems.<br/>
<br/>
i.e. you can create quizzes in Respondus, connect to your CMS from within Respondus and upload the questions to a particular course. You can also download questions and quizzes from the CMS.<br/>
<br/>
It also has the ability to export quizzes in IMS QTI format. <br/>
<br/>
Our stats department are heavy users of Respondus and if it possible to have the same ability to upload questions/quizzes directly to Sakai it would make the migration easier.<br/>
<br/>
Going the IMS QTI route is possible, but only if the questions do not contain images. This is filed under another requirement.  (REQ-217)<br/>
<br/>
Also see <a href="http://bugs.sakaiproject.org/jira/browse/SAK-1891">http://bugs.sakaiproject.org/jira/browse/SAK-1891</a>','Instructors','Samigo - Authoring ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-220','Calculated questions','At the moment the calculated question type is missing in Samigo, i.e. the ability to have questions which contains variables,  a method of setting the range of those variables and the number of questions to be generated of that type.<br/>
eg. what is {x} + {y} where  0 &lt; x &lt; 100 and 0 &lt; y &lt; 50 ','Instructors','Samigo - Authoring ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-221','Need easliy configurable grade scales and mechanism to present a given scale to instructor in a particular site','The gradebook supports a letter grade scale currently that is hardcoded. An institution will want to use scales appropriate to their institntuion which may be different. There may be many scales, each used for a different type of course site (e.g., each school may have a different scale, or there m ight be a scale used for freshman classes different from sophmore, or different scales between Lecture and discussion sections, etc.).   There needs to be an easy way to add scales to gradebook, perhaps via sakai.property settings. <br/>
<br/>
','Students|Sakai administrators|Instructors|Staff (administrative)','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-222','Improved Admin tools (Sites and Realms)','Improve admin tools:<br/>
<br/>
* improve performance; response time is often slow when the system contains a large numbers of sites<br/>
<br/>
* improve search capabilities<br/>
<br/>
* improve sorting/filtering capabilities<br/>
<br/>
-------------------------------------------<br/>
Original Descriptoin:<br/>
<br/>
The admin tools are often slow when the system contains large numbers of sites. It is hard to find a realm when only some part of the site name is known - site and realm tool each contain search functions that would be useful in the other or are missing useful search capabilities (search for a realm by knowing part of a site title for example, or search for  sites a user has created). We need to be able to sort/filter by term in the admin in the admin tools as well.','Sakai administrators|Staff (administrative)','Realms (Admin Site Management)''Sites (Admin Site Management) ''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-223','Global system announcement tool','We need a way of pushing a support/administrative announcement to all users immediately rather than relying only on the motd. Such a tool should be able to optionally be targeted to users on a particular app server or servers in a clustered environment. The message would be presented to the user on login or to those already logged in, in a popup. The message would only be delivered once, and would therefore have a start/end time. ','Instructors|Students|Staff (administrative)|Sakai administrators|Researchers',' New Tool''MOTD ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-224','Add feedback capability to Help tool','A feature on each help page to rate the helpfulness of the content will help improve the quality of help documentation.<br/>
<br/>
The current rating of each help item should be visible on each page (after it has been rated by that user, or if the user is an admin).','Instructors|Researchers|Sakai developers|Students|Sakai administrators|Staff (administrative)','Help ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-225','Order tabs by site types, and for course sites, by term','Even with the ability for users to order and hide tabs, there still is the frequent request to put current course site tabs first.  As new term sites are created and a user becomes a participant, the new term sites should rise to the top of the user''s preference list. The preference list of all sites should be ordered by term to make it easy to hide a term''s course sites. Sites which are not associated with a term (e.g., project, or GradTools sites) can be in a separate group in that list.','Staff (administrative)|Students|Instructors|Researchers','My Workspace ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-227','Add a configurable Contact Us form to Help','A ''contact us'' form that is accessible from the Help system needs to be configurable to an institution (whether it''s on or not, what email address the info is sent to). It needs to include information about the user - account name, site they are in, browser they are using, os, etc.','Researchers|Sakai administrators|Instructors|Students|Staff (administrative)','Help ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-228','Schedule tool export and syncing','Schedule tool needs to be enhanced to allow exporting to common formats. <br/>
It needs to allow syncing with other calendars as well, so that importing calendar from another tool a 2nd time doesn''t add duplicate events. ','Sakai administrators|Researchers|Staff (administrative)|Students|Instructors','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-229','Tool reset','It would be useful in tools like Chat, Discussions or others to erase all<br/>
messages, a kind of reset to the initial state.','Instructors|Researchers','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-230','User tool: New features (order by more fields, search and paging)','In the &quot;Users&quot; tool in admin''s My Workspace, the users can be ordered<br/>
only by the Uid.<br/>
<br/>
It would be interesting to:<br/>
- order the list by name, email or type (acending or descending)<br/>
- Search by name, email or type<br/>
- Select the number of items per page<br/>
','Sakai administrators|Instructors','Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-231','Search in resources','Include a search feature in resources tool<br/>
<br/>
Use cases:<br/>
<br/>
Searching by:<br/>
<br/>
- Author<br/>
- Last modified date<br/>
- Title<br/>
- File type','Students|Researchers|Instructors|Sakai administrators','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-232','Resources - greater granularity for permissions','Would like to be able to set permissions on folders to:<br/>
<br/>
1. hide a folder from all students<br/>
2. give read and/or write access to groups of students within the site.  Useful for collaboration in groups.<br/>
3. allow instructor to set a date and time when a folder becomes readable by students.','Researchers|Instructors|Students','Permission Widget ''Realms (Admin Site Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-234','Paging description for List Navigator needs to better explain what to do at boundaries','This was implemented in Sakai in r5861 (post-2.1.1).  So this requirement is really just for the New Tools now; and, if we are going to use the Style Guide or something similar going forward, then it should include a description of this aspect of the paging process.<br/>
<br/>
<br/>
Original Description:<br/>
For the List Navigator a better description of what should happen as one pages through a list and hits a boundary is needed.  The current beahvior in most circumstances is that when you are viewing 20 items at a time from a 33 item list Next will move you from viewing 1-20 to viewing 14-33.  Preference has been expressed for it behaving otherwise and making the boundaries firm so you are not seeing items on multiple pages; view 1-20 and then view 21-33.  No preference has been expressed yet for keeping it the way it currently works.<br/>
<br/>
This requirement should apply to both paging JSF widget and the style guide definition.','Students|Researchers|Instructors|Sakai developers','Global ''JSF ''Style Guide ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-236','Assignment tool improvements','Feature enhancements on Assignment tool:<br/>
- option of populating Schedule with assignments, when creating the assignment (currently there is no integration of the tools)<br/>
- simpler way for graders to open an attached assignment, add comments/grades, and re-post it for students (currently requires downloading local copy, opening it, adding comments and saving new copy, then uploading)<br/>
- in addition to batch download of all submitted assignments, one prof. requested the ability to batch upload the graded assignments<br/>
- students need a way of confirming that the assignment that they''ve submitted has been saved intact in the system<br/>
- option when creating an assignment for re-submission (currently, instructor needs to return the assignment before student can resubmit it; students desire the ability to change their submission before instructors grade it)','Students|Instructors','Assignments ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-237','Documentation:  Need to write an architecture document on the Sakai Event Mechanism','In the docs/architecture areas of Sakai there is a set of documents aimed at developers and deployers of Sakai.  We need a document which descibes the Sakai event system.<br/>
<br/>
This needs ot cover how Events work and are distributed thrgouhgout the system.  Also this needs sample code showing how develoers can make use of the event system.<br/>
<br/>
Event applications which use the Courier also must be described as well as how to create a daemon to listen for events.','Sakai developers','Documentation (other than Help)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-238','Documentation: Need to write an architecture describing how notifications operate','This is a document describing hte Sakai Notification mechanisms and how to hook new applications into the Sakai Notification System.<br/>
','Sakai developers','Documentation (other than Help)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-239','WYSIWYG improvements','WYSIWYG editor could be improved by adding:<br/>
- browse function for locating images (currently requires input of a URL)<br/>
- ability to use style sheets, either locally on individual HTML pages saved in Resources or globally within a course site (WYSIWYG currently strips style definitions from HTML files saved within Resources)<br/>
- capability of parsing MS Word .doc styles when copying-and-pasting in WYSIWYG to create new HTML resources (esp. in the Syllabus tool)','Instructors','WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-240','Documentation: WSRP Architecture Document','We need an architecture document that deccribes how WSRP is architected and how it works in the system.<br/>
<br/>
docs/architecture','Sakai developers','Documentation (other than Help)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-243','Documentation: Need web services architecture document','docs/architecture<br/>
<br/>
This document needs to provide an overview of how web services work - their general model and patterns and how to creat new web services and modify existing web services.<br/>
<br/>
This should also have a section on web services security.<br/>
','Sakai developers','Documentation (other than Help)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-244','Adjust calendar display to show  ''More...'' indicator if there are schedule items beyond current timespan being viewed','When there is a schedule item that occurs later in the day than the default view for the Weekly view is present, there is no indicator to show the person that there is a scheduled event for later in the day. I can look at the schedule for today and see that I have nothing on my schedule, even if there is something scheduled for 7:00pm, there is nothing to indicate that I should scroll down to see that something is there. I do see it, however, when I do a monthly view.','Students|Researchers|Instructors|Staff (administrative)|Sakai administrators','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-245','Display modified date on DropBoxes to show when new content has been uploaded','Right now, the date on the drop box folder reflects the create date. Is there a way for it to show the last time something was uploaded to the folder so an instructor would know that a student put something in there?<br/>
','Staff (administrative)|Sakai administrators|Researchers|Instructors|Students','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-246','Format loss when saving post sent from Email Tool to Email Archive','Email sent from the Email Tool typically contains paragraph breaks.  This formatting is transmitted properly to individual email recipients, but is lost when saved automatically in the Email Archive.  As a result, archived messages are often impossible to read (one huge paragraph).  ','Students|Instructors','E-mail Archive');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-247','Need a way to delete dropboxes more easily when ''shoppers'' drop a course','Our students often ''shop'' many courses at the beginning of the semester, leaving behind their DropBoxes when they do not sign up for a course.  The mess left for the instructor to clean up is problematic.<br/>
<br/>
The instructor has to print a list of ''registered'' students for the course, then go to DropBoxes and delete any non-registered students.<br/>
<br/>
Is there a way to flag a certain ''role'' of site member that can then purge the dropboxes and leave the other dropboxes intact?','Instructors|Sakai administrators','Drop box ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-248','Need better way to control order of ''pages'' on a site','When new tools are added to a site, the site order changes from alphabetical to a seemingly random order.<br/>
<br/>
We are currently using siteorder.xml to force the order of tools in a site, but this leaves out the ability for our users to custom order the tools on the page.  Maybe an ordering column could be added to the sakai_site_page table to allow the site admin to specifiy the order in which something will appear on the page, so that sites could order items more logically.','Researchers|Sakai administrators|Instructors|Staff (administrative)','Presentation ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-249','Scheduling tool','This may be a new tool, but have a way to set up appointments between the student and the instructor via some sort of scheduling tool.<br/>
<br/>
The instructor would need to set ''office hours'' on the calendar and students could sign up for blocks of time.','Students|Instructors',' New Tool''Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-250','Synoptic view of gradebook in My Workspace','Some tools in My Workspace collate all submissions from specific sites (e.g., Schedule in My Workspace lists all site-specific schedule items), but there is no such version of Gradebook.  Students taking several classes may wish to scan all gradebooks at once to find new entries, rather than going site to site.','Students',' New Tool''Gradebook ''My Workspace ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-252','Ability to set Web Content tool as pop-up when tool is added to site ','When adding a new web content tool to a site, add the ability to set it as a ''pop-up'' window instead of having to change the ''Options'' after the tool is created.','Instructors|Researchers|Staff (administrative)|Sakai administrators','Web Content ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-253','Assessment Tools should integrate with other Sakai Tools (i.e., Announcements, Schedule)','From REQ-235:<br/>
<br/>
- simple way for instructors to announce a new assignment; provide a link to the assignment in the body of the announcement; and populate the assignment on the Schedule tool<br/>
<br/>
Assignments does this mostly; it would be nice to have a direct link to the Assignment in the body of the Announcement.  Tests &amp; Quizzes (Samigo) should do this too, as should any new, appropriate assessment tool added to Sakai; in other words, this could be a requirement for provisional tools.<br/>
','Instructors|Sakai developers|Researchers|Students',' New Tool''Announcements ''Assignments ''Schedule ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-254','Case sensitivity of answers','Most answers don''t need to be case sensitive.  However, I teach chemistry and when dealing with elements, case senstivity is important.  &quot;Ho&quot; is the element holmium and very heavy, &quot;HO&quot; is the hydroxide radical and a very different beast.  I need to be able to distinguish between these.','Instructors|Students|Sakai developers','Samigo - Authoring ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-255','appointment sign-up capability for Schedule tool','Several faculty have wanted to use the Schedule tool to:<br/>
- allow students to sign up for slots during office hours<br/>
- allow students to sign up as discussion leaders for certain weeks during a seminar.<br/>
<br/>
In both cases, it would be nice to have permission granularity within the Schedule tool to allow the site owner to designate certain blocks of time for which students would have &quot;revise&quot; capability.  This way, students could modify only certain events in the schedule, rather than having global write or revise permissions in the tool.<br/>
<br/>
Also it would be nice if this revise permission was in effect only for blank fields: once a student has signed up for a slot, others would not have the ability to revise that selection.  Only blank fields in the designated time blocks could be &quot;owned&quot; by students with revise or write permission.<br/>
<br/>
Finally, for the office hour option, it would be nice if students'' displays of the Schedule list only their selected time slot, not every other student''s slot.  A lot to ask, I realize; perhaps this type of scheduling tool should be a new tool, which could then export information into the main class Schedule.    ','Instructors|Students',' New Tool''Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-256','Terminology of the Email Notification Options in Announcements','The email notification options are a little confusing to the end user, &quot;all participants&quot; could mean of a particular space or bspace.  Change the terminology on the preferences.  Make it easier to customize this notification.  Make the preferences apply per site not for the entire user site.  ','Instructors|Students|Staff (administrative)','Announcements ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-257','Allow public access w/o invite','Friendly URL for public resources.  <br/>
','Researchers|Staff (administrative)|Students|Instructors','Gateway ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-258','All tools should indicate new changes.','All of the tools should indicate what new changes have been made on the home page where all announcements are.  For example if 2 new resources have been added then the frontpage section for resources would indicate those resources have been added.','Instructors|Students','Assignments ''Discussion ''Resources ''Syllabus ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-259','No notification if there have been new resources added.','Provide an indication of resources that user has viewed already.  There should also be a function that highlights new resources that have been added on the homepage of the site.<br/>
','Students|Instructors','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-260','Name changes for MyWorkspace collating tools (Schedule, Resources, etc.)','We''ve had a number of users mistakenly upload materials to their personal Resources area, in MyWorkspace, thinking that they were putting them in a course site Resources.  It could be nice to have the option of renaming the tools in MyWorkspace so that they''re not identical to the names of the tools in course sites -- this could help avoid some confusion.  ','Researchers|Instructors','My Workspace ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-261','Announcement links have to be opened to be read.','The whole message should be shown as the default so that the user does not have to click to open every announcement.  The default number of messages should be the past 7 days.','Students|Instructors|Researchers','Announcements ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-262','Instructor puts everything in resources, not helpful','The resources section becomes too cluttered when there is a lot of material that has been added.  Need a way to better organize resources. ','Instructors|Researchers|Students','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-263','Ability to rename a user and/or move one user''s data to another user','We are in the process of changing how we issue userids to faculty and students.  It would be nice if there was a simple way to rename a user within Sakai and/or be able to move data from the old account to the new one.','Students|Sakai administrators|Instructors','Account ''Database ''Global ''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-264','Copyright status - what if prof. is unsure, what goes in "copyright info" box?','Option on choosing copyright status is not clear for professors.  Change the default to be ''Material is subject to fair use'' there is a link to more information - maybe the choices in the drop down should be defined in that link.  <br/>
<br/>
This should be configurable per each institution.','Researchers|Instructors|Students','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-265','Include a print option for all tools.','It is important for students to have an option to print any assignments or resources because reading from a computer screen is not desirable for everyone.  Similarly, Instructors and Researchers may prefer to print out reading material.','Researchers|Staff (administrative)|Instructors|Students','Announcements ''Assignments ''Discussion ''Drop box ''Resources ''Syllabus ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-267','allow calendar entries by clicking the interface','Currently the schedule tool requires users to navigate to a separate window to enter a new calendar event. The norm in many calendars is to click and drag to select the duration of a meeting, or double-clcik a timeframe in the calendar interface to begin adding or editing an entry. <br/>
<br/>
The schedule tool should allow users to click the time the wish to schedule an event to bring up an editing window.<br/>
<br/>
This is similar to functionality available in other calendar tools like iCal, Outlook, and Oracle.','Staff (administrative)|Students|Instructors|Researchers','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-268','Need for "Melete-like" Rich Content Authoring Tool for Fully Online Courses','Please excuse any ignorance as I''m still a bit of a &quot;newbie&quot; at this point in time...<br/>
<br/>
Marist College is currently in a production pilot with Sakai (called iLearn at Marist) with one of our many fully online programs.  From this experience, it is clear to us that having a &quot;Melete-like&quot; tool that allows our faculty to create &quot;rich media&quot; content for online delivery is critical.  <br/>
<br/>
My understanding is that most of the &quot;core institutions&quot; have historically not been heavily involved in offering fully online courses and have primarily used their CMS capabilities to supplement/enhance face-to-face courses.  I feel that this has driven the requirement process towards tools and functionality that is needed in this context of use.  Although there is a good deal of overlap between tools sets needed for fully online and &quot;web-facilitated&quot; courses, I feel that there are some difference as well.  This area is one of them.<br/>
<br/>
Although the capabilities of the Resource Tool is great, we need more than just a place to upload and download files.  Instead, we need a tool that allows faculty to place an &quot;instructional wrapper&quot; around those files and digital content that is upload so that the students have a full and rich learning experience in their online courses.<br/>
&nbsp;','Students|Instructors','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-274','Assignments should accept resubmissions.','Currently instructors can only change the option to accept resubmissions after they have already received a submission from a student.  This option should be moved so that when an instructor creates an assignment they can set whether or not they will accept resubmissions.','Students|Instructors','Assignments ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-277','K-12 Tools','So far, I have not heard too much discussion about using Sakai at the K-12 level but we, at Marist College, believe there is great potential in this area.  We have had some discussions with K-12 groups in our state and are hoping to collaborate with them on some pilot activities next school year.<br/>
<br/>
In talking with these initial contacts, it has become clear that there are additional functionality needs at the K-12 level that would be important to have before Sakai could penetrate too far into this &quot;market&quot;.  One that has surfaced in our discussions is a &quot;test and quiz&quot; tool that was adapted for K-12 needs (e.g. allowed school wide reporting, supported connections to state standards and school district curriculum benchmarks, etc.).','Students|Instructors','Samigo - Authoring ''Samigo - Delivery ''Samigo - Global ''Samigo - Grading ''Samigo - Question Pools ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-281','make calendar event frequency more flexible','Currently, the Schedule tool does not allow users to add events that occur every Monday/Wednesday or Tuesday/Thursday. Additionally, you cannot set an event to happen every third Thursday of the month.<br/>
<br/>
The system should allow the user to choose the frequency of an event with some flexibility. <br/>
','Researchers|Instructors|Students|Staff (administrative)','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-282','Import from Site  Site Info - Clear Indication on Resources from other sites that are added  ','From Site Info there is an option for &quot;Import from site.&quot; The system gives no indication that there are resources to import.  Even if there is a resource to import it doesn''t tell you its been added nor does it give you a choice of resources you want.  It just comes back to Site Info.  Need a way to tell if there is something in there to add and then notification that something was added.  Confirmation similar to the add/ remove tools.  ''You have added 6 items.''<br/>
<br/>
','Researchers|Instructors|Students','Site Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-283','Student View should exist for all Instructor documents to be viewed by students','Instructors should have the ability to see the student view of all the items that will be viewed by students.  For example assignments, syllabus, resources, etc.<br/>
&nbsp;','Sakai developers|Sakai administrators|Instructors','Assignments ''Gradebook ''Resources ''Syllabus ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-284','Gradebook should be able to show categories and weigh them accordingly','Letter grades in Gradebook do not reflect curves used by instructors.','Instructors|Students','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-285','Legacy tools should not save state.','When someone enters information into a form the state should not be saved when they go to another tool.  ','Staff (administrative)|Researchers|Instructors|Students','Announcements ''Assignments ''Discussion ''Drop box ''Resources ''Syllabus ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-286','Gradebook should provide the ability to create categories of assignments','Goals:<br/>
Instructors can create categories of assignments (e.g., Exams, Homework, Attendance)<br/>
Instructors can assign a total number of points or a percentage (REQ-202) to a category <br/>
Sakai will equally distribute the points or percentages amongst the assignments associated with that category','Students|Instructors|Staff (administrative)','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-287','All tools included in the Sakai ''bundle'' should be fully integrated with one another','Our faculty have the expectation that tools should be fully integrated or &quot;aware&quot; of data entered within a course or project site.  While some of the tools in the Sakai bundle are integrated (like test &amp; quizzes is with gradebook) many of them are not.  For example, neither of the assignments tools can make an assignment automatically show up in the syllabus tool, or even in the test &amp; quizzes tool.  Another example is that items in the Test &amp; Quizzes tool do not show up in the schedule or the syllabus.','Students|Instructors','Assignments ''Gradebook ''Samigo - Authoring ''Schedule ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-289','Sakai should allow instructors to combine rosters of two or more sites','Goals:<br/>
Instructors can combine the rosters for two or more sites<br/>
Sakai will display combined rosters as separate sections in a site<br/>
Students tab will indicate the course and section number of the site for which he or she signed up, not the site from which the instructor is delivering the combined content.','Instructors|Students|Staff (administrative)','Roster ''Section Info ''Sites (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-293','Have Syllabus option to either upload file, redirect, or fill out form','Professors need to have a clear indication of options for syllabus creation. Distinct options for either uploading a file, redirecting, or filling in the form. ','Staff (administrative)|Researchers|Instructors|Students','Syllabus ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-294','Need to be able to accept media files','Not able to link directly with the podcst rss feeds.  Instead, you are directed to webcast page and then have to choose link from there.','Students|Instructors','News (RSS)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-296','in year view, remove the dates from a previous month','In the Schedule tool, in the year view, the days from a previous month appear in gray. This is nice. The issue is that the numbers for the days in the previous month also appear. This makes it seem like there is an event on that day.<br/>
<br/>
We recommend that the numbers that indicate days in the previous month are removed from the year view in the calendar.<br/>
<br/>
For example, a calendar grid showing the month of Feb. 2006 starts with <br/>
<br/>
Jan 29<br/>
Jan 30<br/>
Jan 31<br/>
Feb 1<br/>
Feb 2<br/>
Feb 3<br/>
Feb 4<br/>
<br/>
It would be nice to remove the dates for January. I''ve attached a screen shot to illustrate the point. ','Students|Staff (administrative)|Researchers|Instructors','Schedule ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-297','The HTML editor used across many Sakai tools needs to be improved and must work well across the most popular/used browsers','The HTML editor that is used across many Sakai tools must be improved, offer more capabilities than it currently does, and work consistently across the most popular browsers in use today.  Faculty on our campus would like to be able to cut and paste complex html code (that they have previously developed) into Sakai assignments and have them render appropriately.  There is no way to tell what part of the cut and pasted code, is causing the problem, therefore an additional capability needed is some sort of html &quot;debugger&quot;.  As for being compatible with other browsers, the html editor in Sakai does not work well on Internet Explorer.','Instructors|Researchers|Staff (administrative)|Students','WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-298','Apply style guide to worksite setup','The style guide should be applied to Worksite Setup<br/>
<br/>
This was initially reported at UC Berkeley with regard to the Worksite Setup. Instructors and staff were confused about the checkboxes in Worksite Setup because they are so far away from the action buttons. If the style guide were applied, the page would have the following changes -- <br/>
<br/>
(1) checkboxes would move to the right side of the page in a Remove column<br/>
(2) a revise link would appear under each item (this could be changed in the style guide so clicking the item automatically brings up an editable window)<br/>
(3) the add button would remain at the top of the page. ','Researchers|Instructors|Staff (administrative)','Site Info ''Style Guide ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-299','clicking the name of a site in Worksite Setup should direct user to Site Info ','In Worksite Setup, users can click the title of any course or project site in their account. The expectation is that this will bring up the Site Info window for that course or project site. Instead, it navigates the user to the Home page of the site. This is confusing.<br/>
<br/>
Change the link in Worksite Setup so clicking the name of a site leads a user to the Site Info page for that site.','Students|Staff (administrative)|Instructors|Researchers','Site Info ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-300','All content authoring tools need to be able to be integrated with digital repositories that are login protected as well as those that are open','All content authoring tools need to be able to be integrated with digital repositories that are login protected (Twin peaks only works with DR''s that are open).   Content authoring tools in Sakai include:  announcements, assignments, assignments with grades, Modules, syllabus, test &amp; quizzes and discussion board.  Much of the content used in courses has copyrights associated with it , so Sakai needs a digital repository tool that can be integrated with an institution''s library repository that requries a login.','Students|Instructors|Staff (administrative)|Researchers','Announcements ''Assignments ''Discussion ''Resources ''Samigo - Authoring ''Samigo - Delivery ''Syllabus ''Twin Peaks ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-301','Worksite Info on Home page should accept images and text','Instructors should be able to add images and text to the Worksite Information section of the Home page. <br/>
<br/>
Instructors should be able to upload an image, not just point to one that already exists on a website.<br/>
<br/>
This allows them to customize their site a bit.','Instructors|Staff (administrative)|Students|Researchers','Home ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-302','The User Management Tool (In Admin Workspace) needs additional functionality','The User Tool ( In the Admin Workspace ) needs additional functionality:<br/>
<br/>
1)  There needs to be summary at the top of the page that tells the Sys Admin how many users there are (like in the Sites tool)<br/>
2)  There needs to be additional attributes displayed about the user:<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;a) A date that  the user last logged into Sakai<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;b) The date that the user first logged into Sakai<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;c) Roles held by the users<br/>
3)  There needs to be a way to search based on the attributes above<br/>
4)  There should be a way to &quot;PURGE&quot; users who have not logged in in XX amount of days<br/>
5)  There needs to be a mechanism to get a  a &quot;broadcasted or emergency message&quot; out to all users or sets of users ( like just the Instructors) currently on the system (when for example you need to reboot the server) or when you install new course management tools.  <br/>
6)  Additionally, needs to be a way to schedule &quot;SYSTEM DOWN TIME&quot; and have it show up on all user''s schedules','Sakai administrators|Sakai developers|Staff (administrative)','Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-303','instructors should see timestamp in drop box to distinguish which folders have new content','The drop box currently displays a Modified date for each folder. This would be more useful if it also displayed a time stamp. <br/>
<br/>
This would allow instructors to see which folders have new content.','Instructors|Researchers|Students|Staff (administrative)','Drop box ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-305','site owners don''t know what types of files can be imported using Site Info tool','The Site Info &gt; Import from File option does not indicate what type of file can be imported. The browse mechanism is used throughout Sakai to allow users to upload a file, and there is nothing on this page to indicate that there is a restriction on the type of file accepted here. The system only prompts users for a zip file once you try to upload something that is not  a zip.<br/>
<br/>
Instructions would be helpful.','Staff (administrative)|Researchers|Instructors','Site Info ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-306','allow users to order materials in tools','Instructors and site owners want to be able to determine the order of items in a tool. For example, they may want to have serveral folders in the Resources area -- Homework, Assignment Solutions, Images, Maps, Research Resources, etc. Currently, Sakai puts these items in alphabetical order. The site owner should be able to determine the order in which items appear.<br/>
<br/>
This is true for <br/>
Assignments<br/>
Drop Box<br/>
Resources<br/>
Samigo<br/>
Gradebook<br/>
','Staff (administrative)|Instructors|Researchers|Students','Assignments ''Discussion ''Drop box ''Resources ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-307','create visual hierarchy in Resources','It is difficult to distinguish items in a folder from items outside of a folder in the current implementation (2.1) of Resources. This makes it difficult for students to navigate and find course materials.<br/>
<br/>
One solution would be to increase the indent so the hierarchy is more prounounced. ','Instructors|Researchers|Staff (administrative)|Students','UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-308','Ability to set instructor-only access to course site after term (quarter, semester) ends','This feature will prevent students from accessing course sites from previous terms and download assignments/course materials to share with other students who have not yet taken the course.<br/>
<br/>
Instructors can set this option but Sakai administrators and administrative staff can also set this option for the instructor.<br/>
','Students|Instructors|Staff (administrative)|Sakai administrators','My Workspace ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-309','allow customization of Home page ','Instructors should be able to decide which recent items show up on the Home page. Some instructors are interested in having the default tools show up (Announcements, Discussion, Chat), while others are more interested in having Resources, Email Archive or other tools displayed. <br/>
<br/>
Most of the available tools should have the option to display in the Home page.','Students|Instructors|Researchers|Staff (administrative)','Home ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-310','Site maintainers can select an option to make a file or folder visible, or not visible, to site participants.','Use case:  When copying files/folders to another site, instructors can specify whether they wish to hide (make invisible)  the content from students or other site participants. Admin staff (e.g., support staff and sakai admins should be able to do this as well).
<br/>

<br/>
Use case: instructors may upload files/folders for their own use, but not for view by students or other site participants.
<br/>

<br/>
This requirement relates to REQ-145, which concerns the ability to make a folder invisible, while making items within it visible.','Instructors|Staff (administrative)|Sakai administrators','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-311','Function for email notification to all Sakai members','Administrator should be able to send an email notification to all users in a Sakai instance. There should be the ability to choose to send to users with specific site permissions only.<br/>
<br/>
Use Case: Send a message to all users with maintain in at least 1 site.','Sakai administrators|Researchers|Students|Instructors|Staff (administrative)','E-mail Archive''Global ''Realms (Admin Site Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-312','limit internal scroll bars','The scroll bars within the iFrames cause much confusion. There should only be a single set of scroll bars.','Researchers|Instructors|Staff (administrative)|Students','Global ''UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-313','Gradebook integration with other Sakai tools','Complete integration of gradebook with assignment and quiz tools.','Sakai administrators|Students|Instructors','Assignments ''Gradebook ''Samigo - Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-315','Tests & Quizzes should allow instructor to email student comments about test','In the Tests &amp; Quizzes tool, instructors need to be able to email individual students comments about the submitted test. Currently, there is a &quot;Comment&quot; field, but that is only viewable by instructors.<br/>
<br/>
It would be ideal if there was a button called &quot;Email&quot; next to each student listed on the Scores page for a specific assessment. The instructor could click the button and have a window open with parts of the email message pre-populated:<br/>
<br/>
To: &lt;Student email address&gt;<br/>
From: &lt;Instructor email address&gt;<br/>
CC:     ... allow instructor to add TA or other email addresses<br/>
Subject:  Feedback on &lt;Test Title&gt;<br/>
Message:<br/>
Dear &lt;student name&gt;,<br/>
<br/>
','Instructors','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-316','Ability to weight answers within samigo','Ability to assign points on quiz responses that make up the total grade for a quiz item.  For example, on a multiple choice with multiple correct answers, an instructor may select that choosing one of the answers is worth (weighted) more heavily than another.  Conversely, that one answer is so offbase that the student actually receives a negative score for choosing that answer (e.g., -2).','Instructors|Students|Sakai administrators','Samigo - Grading ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-317','allow instructors to control order of buttons in toolbar/nav bar','Each site has the potential to have different tools available. Instructors and site owners should be able to make the tools available in whatever order makes sense for their course. In some cases, the Syllabus tool is the most important. In other cases, the Discussion tool is the most important. ','Students|Researchers|Staff (administrative)|Instructors','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-318','Creation of Local Administrator role','Provide administrative staff in individual departments (e.g., chemistry, engineering) and professional schools (e.g., law, medical, business) the ability to locally administer Sakai.  <br/>
<br/>
Tasks might involve the following:<br/>
<br/>
-Change course title<br/>
-Activate/Inactivate tools<br/>
-Change course to instructor-only access<br/>
-Inactivate courses<br/>
-Copy course content<br/>
<br/>
This would relieve the burden of the central IT team from providing support to the entire campus.','Sakai administrators|Staff (administrative)',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-320','Ability to display current term courses','Provide ability for instructors and students to view course sites by term (e.g., by Fall 2005, Winter 2006, Spring 2006, Summer 2006).<br/>
<br/>
Current view of courses is not user-friendly and difficult to navigate through.','Instructors|Students','Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-321','Tests & Quizzes - support cross-listed classes by allowing instructor to view grades by class','In the Tests &amp; Quizzes tool, instructors can currently view scores on a specific assessment by section.  We also need to be able to support cross-listed classes, and allowing instructors to view scores by a specific cross-listed class.  Two examples of cross-listing:  <br/>
<br/>
1. A class is offered under two codes, one for undergraduates, one for graduates.  Example:  ECON 101 / 201.<br/>
<br/>
2. A class is offered by different departments, e.g.  ECON 101 / PoliSci 101 <br/>
<br/>
The instructors will need to be able to view the scores of all students who enrolled in Econ 101, then of all students in Econ 201 or PoliSci 101. Similar to View by &quot;All Sections / Section xxx / Group&quot;','Instructors|Students','Samigo - Delivery ''Samigo - Grading ''Section Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-322','Tests & Quizzes - support audio recording','The Tests &amp; Quizzes tool needs to support Audio Recording as a method for &quot;answering&quot; a question.  This is the current method used by all the language classes at Stanford University. <br/>
<br/>
The current method with our CourseWork tool is that an instructor creates a question that can be text-based (that the student reads on screen), or where a video or audio clip is played.  When taking the test, the student will read / listen to / watch the &quot;question&quot; and then click a button to begin recording their audio response.  For example, a student might read a text prompt, &quot;Say the days of the week&quot; and then click the Record button, speak into a microphone, and speak the days of the week in the given language.  The student then clicks Stop, and has the option to listen to the recorded audio, and can re-record it, before submitting it.','Students|Instructors','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-323','Ability to customize site ID','Site ID should follow the format of term-department-number.  For example, 1064-CHEM-101-01.<br/>
<br/>
Currently, site ID follows an unintuitive format to target audience.  For example,  52be78bb-2fd4-482d-8071-19ea7a86b5cd.<br/>
<br/>
<br/>
<br/>
','Sakai developers|Instructors|Staff (administrative)|Sakai administrators','Sites (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-324','Order of left hand tool menu should have default alpha order and be configurable within each site by instructor','For left hand menu of tools:  <br/>
1)  Make default order always be alphabetical, so that when new items are added they do not always appear on top of &quot;Site Info&quot; in the middle of the list.  <br/>
2)  Allow instructors to configure order of tools within &quot;Site Info&quot; tool, not only only configurable by administrators in admin tools.','Instructors|Sakai administrators','Site Info ''Sites (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-325','Use same WYSIWYG editor throughout both Sakai and Melete Course Builder.','Use same WYSIWYG editor throughout both Sakai and Melete Course Builder.
<br/>

<br/>
The specifics of the requirement are:
<br/>

<br/>
Currently, Melete and Sakai use two different editors or at least two different versions of one editor.  Also, Vivie Sinou at Foothill DeAnza uses yet another editor, a commercial product.  The other important area for the editor is in Samigo, because some testing requires students to use the editor.
<br/>
&nbsp;
<br/>
Our specific need is for an editor that does two things.
<br/>
&nbsp;
<br/>
1.  Allows for an easy interface for both non-technical people (i.e., faculty and students) who want a WYSIWG interface, and for coders.  The current editor does this, but is not very robust.
<br/>
&nbsp;
<br/>
2.  An editor that can easily incorporate math symbols (i.e., Math ML or similar).  The largest classes (and thus a big user of online learning) and the largest amount of testing on campus is done by science departments--math, chemistry, engineering, physics.  They all need the capability for easy input of equations both in content creation and in testing.','Instructors|Sakai administrators','Melete''WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-326','Add Math/Equation functionality to WYSIWYG editor','Add Math/Equation functionality to WYSIWYG editor throughout both Sakai and Melete Course Builder.','Sakai administrators|Instructors','WYSIWYG Widget ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-328','Sakai should allow for ex/import of CSV or Excel file for complex calculations in gradebook','Sakai should allow for ex/import of CSV or Excel file for complex calculations in gradebook','Sakai administrators|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-330','generate usage reports from within Sakai','Sakai administrators and support staff should be able to easily generate reports from within the system. Reports might include things like:<br/>
<br/>
a) the number of sites created, broken down by project and course (this is currently displayed in the admin view, but requires an extra step of sorting or copying/pasting in another program)<br/>
b) the number of sites per instructor<br/>
c) the number of instructors with active accounts<br/>
d) the number of students with active accounts<br/>
e) the frequency of use for any of the tools (e.g., how many sites use a gradeboo or Assignments or Section Info, etc.)<br/>
','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-331','Resources tool should allow for different access to documents for different users','Allow users to identify who is allowed to access information within Resources based on a drop-down class list. (particularly useful for sharing/collaboration on papers/projects).','Instructors|Sakai administrators|Students','Realms (Admin Site Management)''Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-332','Drop box should be configurable by users to allow access to users other than instructor','Within drop box, allow users to identify other course members for access in addition to the instructor.','Students','Drop box ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-333','Profiles should be able to be displayed within other tools, like the discussion tool','Allow User Profile to be selected in conjunction with other tools. For example, an option in the Discussion tool would be to show user profile including a photo. ','Students|Instructors','Account ''Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-334','Sakai should provide statistics (distribution, histogram) for each grade item ','Provide statistics for each grade item (e.g., distribution, histogram)','Sakai administrators|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-335','Chat tool should allow for archiving and should provide URL for archive','Chat should allow for easy archiving of sessions with archives then given a URL for easy linking.','Instructors|Sakai administrators|Researchers|Students','Chat Room ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-336','Announcement tool should allow instructor to specify the order in which announcements are displayed','Allow the instructor to specify the order in which announcements are displayed.','Instructors|Researchers|Sakai administrators|Students','Announcements ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-337','Sakai should recognize SCORM content packages to allowing populating Resources/Melete','Add SCORM recognition to Sakai, so that SCORM content packages could populate a course (integration to Resources and Melete Course Builder)<br/>
&nbsp;','Instructors|Sakai administrators','Global ''Resources ''Sites (Admin Site Management) ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-338','Sakai should allow users to order tabs across top of frame','User may select order of tabs to display on top navigation (not require alphabetical)','Sakai administrators|Instructors|Students|Staff (administrative)|Researchers','Tab Management ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-339','Site Info enabling/disabling tools should be section aware','Instructors should be able to enable/disable access to any function within sections within a site.  ','Sakai administrators|Instructors','Section Info ''Site Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-340','Gradebook should allow grading basis diversity','&nbsp;Instructor should be able to select grading basis as points, percentage, or letter grade.','Sakai administrators|Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-342','Discussion tool should indicate clearly whether message has been read and should allow message flagging','Indicate read/unread messages and implement flagging of messages within discussion tool','Students|Sakai administrators|Staff (administrative)|Instructors|Researchers','Discussion ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-344','Sakai should allow for aggregate uploading of multiple files at once into Resource through some method other than WebDAV','Ability to collect/aggregate files into a zip and download them OR upload them to another resource area.  Files could be selectively included.  This would replace WebDAV which doesn''t work half of the time.','Instructors|Sakai administrators|Researchers','Resources ''WebDAV ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-345','Sakai should allow for tool access within Modules ','I would like to be able to &quot;modularizing the various tools&quot; into folders and/or sub-folders in the &quot;Modules&quot; area.  For example, a faculty member should be able to create a weekly folder in the modules area and insert direct links to discussion forums, specific assignments (Assignments Tool), quizzes, drop boxes, and/or any type of content.   Sakai could be both organized by tool and by time.','Instructors|Students|Sakai administrators|Researchers','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-346','Assignments tool should create assignments that are stored in Resources, not just within assignments tool.','Assignments tool should create assignments that are stored in Resources, not just within assignments tool.','Instructors|Students|Sakai administrators','Assignments ''Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-347','Cross tool integration should be improved.','Tools should be be better integrated with one another, eg:  <br/>
1) gradebook/assignments, <br/>
2) resources/assignments, <br/>
3) gradebook/discussion, <br/>
etc.<br/>
<br/>
To expand on this requiremnet:<br/>
There needs to be a way to link tools to each other within the sakai framework. In other words, something like &quot;Tool A depends on Tool B version 1.5 and cannot function without it&quot; should be specified in the tool xml file.<br/>
Also, there should be ways for Tool A to pull data from Tool B or send data to Tool B that are standardized and confidured via an XML file contained within the structure of Tool A.<br/>
<br/>
Use-Case:<br/>
I have an attendance tool (AT tool) that I have written. My attendance tool works by interfacing with a system at my university which records attendance using &quot;clickers&quot; that students operate to indicate their presence in class. This data is stored in an external database which is part of the attendance system. The instructor accesses this database through the AT tool. The instructor can use the tool to calculate grades based on the attendance data from the external system and send a grade item and set of grades to the gradebook tool being used in his course site. The grades are calculated based on a set of rules in the AT tool. The instructor may create multiple grade items or choose to update an existing grade item.<br/>
The key is that the AT tool has to be able to get a list of grade items, or send a list of grades and a grade item definition to the gradebook tool. It also needs to be able to send a grade item ID and a set of grades and probably needs to get the updated grades.<br/>
<br/>
This is obviously very complicated and this requirement only talks about it on a fairly non-technical level. The key here is some standardized way of linking tools together and defining input and output of data.','Instructors|Sakai administrators|Sakai developers|Students','OSIDs ''Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-348','Samigo should automatically allow for alternate numerical forms in grading questions','The Assessment creation tool should allow for alternate valid representations of a numerical answer without requiring the answer to be an exact textual match.  For example it would be useful to the sciences for the system to recognize that 0.00357 and 3.57E-3 are equivalent.','Students|Instructors','Samigo - Authoring ''Samigo - Delivery ''Samigo - Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-349','WebCT import filter for multiple versions of WebCT','While the future belongs to content standards, many of us will need support in moving courses off of legacy CMS''s at our institutions.  The sakai project needs to be able to import content from both Bb and WebCT''s earlier versions.  There is already a project for blackboard integration.  It would be good to have a similar project for WebCT integration.   Rutgers is running an older version of WebCT (4.0).  It would be useful to partner with other institutions running different versions of WebCT to create a tool that can handle differences across standard verrsions of WebCT. <br/>
<br/>
Ideally, these tools will merge in to a common import tool that will recognize IMS packacged content, the current versions of WebCT and Blackboard, and older versions of that software as well.','Sakai administrators|Instructors','Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-350','Assignments should allow instructors to grade assignments that were not submitted','Goals:
<br/>
Instructor should be able to assign a grade to a student who did not turn in an assignment through the assignments tool','Students|Instructors|Researchers|Staff (administrative)','Assignments ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-351','Assignments should allow instructors to create assignments that do not require a submission','Goals:<br/>
Instructors can create an assignment that does not require an online submission by the student (e.g., reading assignment, hand in hard copy)','Instructors|Students|Researchers|Staff (administrative)','Assignments ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-352','Usernames should be active links to information','Whever a username or user ID appears in Sakai, it should provide a context menu for access to the user profile, send them an email, IM with them if they are on-line, etc.','Students|Instructors|Researchers','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-353','Class Session/Workflow Tool','Class Workflow<br/>
<br/>
Sakai is currently organized around tools, rather than being organized around class sessions (a.k.a. learning modules). In practice teaching and learning are organized around class sessions.<br/>
<br/>
What would this look like? On setting up a class Sakai would create modules for each class session. So if a class meets every Monday and Wednesday for 15 weeks, 30 modules are generated, each associated with a date. Readings, slide shows, discussion topics, quizzes, homework, etc are then added to the module.<br/>
This approach better matches the way instructors organize classes in their syllabi, and also helps students focus on current work. Rather than having to search through multiple pages, students can see everything that they should be working on today in one place.<br/>
<br/>
Functionality<br/>
<br/>
Aggregated view - Give students a way to see an overview of every thing they should be working on in a given week together.<br/>
<br/>
Tight synching with the Schedule - Class sessions appear on the schedule<br/>
<br/>
Reorganizing modules<br/>
&nbsp;&nbsp;&nbsp;&nbsp;* Have the option to add, remove, edit and merge sessions.<br/>
&nbsp;&nbsp;&nbsp;&nbsp;* Create sessions that are not related to a date<br/>
&nbsp;&nbsp;&nbsp;&nbsp;* Import sessions from other classes (dates would adjust appropriately)<br/>
&nbsp;&nbsp;&nbsp;&nbsp;* Share well crafted sessions in a learning object repository<br/>
<br/>
**This description borrowed from MIT''s thinking of a tool for Stellar.  A tool like this was proposed by the Sakai Tools Team back in the beginning of the project and was #1 on our prioritization list (of over 100 requests).<br/>
','Instructors|Students',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-354','Accessibility: Addition of Accesskeys to common functions','This is a two-part process: 1) standardizing the names of common functions (such as Remove, Delete and Cancel; Edit and Revise; Reply and Respond; View and Preview), and 2) identifying which occur often enough to warrant accesskeys.','Instructors|Students|Sakai administrators|Researchers|Staff (administrative)','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-355','Roles and permissions should be optimized for the most common use cases','Our experience during the Sakai pilot suggests that the current design of authorization is not optimized for the most institutional common use cases (centralized mapping of roles to permissions; occasional override of permissions for individual users), but instead for a relatively rare use case (site-specific mapping of roles to permissions). This introduces administrative and data storage overhead, and contributes to relatively slow execution of a frequently performed query.<br/>
<br/>
See SAK-2660 for detailed scenarios.','Staff (administrative)|Sakai developers|Sakai administrators','Realms (Admin Site Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-356','Database storage of web sessions should be eliminated or redesigned','Sakai currently permanently stores volatile transient information about a user''s web session in the enterprise database. This adds appreciably to the cost and response time of enterprise installations.<br/>
<br/>
For details, see SAK-3794.','Sakai administrators|Staff (administrative)','Sakai Application Framework ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-357','Resource service should use relational database approach rather than XML strings','The central resource service (used by such tools as Resources, OSP, Announcements, and the Drop Box) continues to use CHEF''s XML-encoded approach to metadata storage. This is unmanageable over the long run in a enterprise system.<br/>
<br/>
For details, see SAK-3799.','Staff (administrative)|Sakai developers|Sakai administrators','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-358','Accessibility: Enhanced title tags to include tool names','This is to add the name of the tool to title tags describing page functions, for example:<br/>
<br/>
Instead of &quot;Permissions&quot;, use &quot;Permissions for Announcement Tool&quot;<br/>
Instead of Options, use &quot;Options for Resource Tool&quot;<br/>
<br/>
etc.','Researchers|Staff (administrative)|Students|Instructors|Sakai administrators','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-359','Framework needs to support institutional human-readable user IDs','There''s a pressing cross-institutional need for a configurable institution-specific unique person identifier which is neither the Sakai user account name nor the programmatic UID used in authentication systems. This was discussed during Core Architecture meetings last year, and is a central aspect of course site management and roster views.<br/>
<br/>
For details, see SAK-2924.','Staff (administrative)|Sakai developers|Sakai administrators|Instructors','Users (Admin User Management)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-360','Accessibility: Addition of accessibility elements to JSF widgets','This will require 1) identification of accessibility elements that are missing in JSF (such as &quot;onkeydown&quot;) and 2) customization of Sakai widgets.<br/>
<br/>
The ability of persons with disabilities to use Sakai will be compromised if JSF widgets are not made fully accessible.','Instructors|Staff (administrative)|Researchers|Students|Sakai administrators','JSF ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-362','Accessibility: Extension of heading tags to include form labels and table cells; caption tags to data tables','This will enable persons using assistive technology to better scan tool content. ','Sakai administrators|Instructors|Students|Researchers|Staff (administrative)','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-363','The Sakai portal should not force the use of iframes','From last year''s Core Architecture Team discussions:<br/>
<br/>
On occasion, if input focus is carefully managed, iframes can be useful for embedding simple widget-like tools or views, or to provide independent scrolling handles for different aspects of the same data. They are not suitable for embedding complex interactive web applications. Indiscriminate use of iframes is a massive usability and accessibility problem.<br/>
','Staff (administrative)|Instructors|Sakai developers|Researchers|Students','Portal ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-364','Applications and services need easier access to richer institutional data','Required LMS functionality is missing from Sakai, including but not restricted to the following:<br/>
<br/>
Student data such as IDs, enrollment status, and number of credits sometimes need to be shown. Accurate data for official enrollment status and officially assigned instructors are needed for submitting final grades and for some security decisions. Course catalog information such as department, course title, and course description should be automatically available when creating a course site. Some authorization decisions might need to be made based on institutional roles (e.g., &quot;departmental admin&quot;).<br/>
<br/>
Despite its functional limitations, Sakai''s legacy &quot;provider&quot;-based approach to enterprise integration is complex and has proven difficult for inexperienced developers to handle.<br/>
<br/>
Some way to easily reach richer institutional data is needed. Services should be tailored to optimize common large-scale operations.','Instructors|Sakai administrators|Students|Sakai developers|Staff (administrative)|Researchers',' New Tool''Providers ''Realms (Admin Site Management)''Roster ''Sakai Application Framework ''Section Info ''Worksite Information ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-365','Instructors and administrators need easier and more powerful management of site memberships and roles','Course site user groups and roles should be able to be automatically defined and populated from institutional feeds. These feeds need to be displayed and controlled in ways that are meaningful to end users (e.g., titled sections organized by course numbers and titles). Some services or applications may need to update local data when enrollment data changes. Sakai must support easy reconciliation of manually managed site memberships and roles (e.g., new TAs, visiting scholars, or not-yet-officially-enrolled students) with externally managed memberships and roles.<br/>
<br/>
Over time, both Sakai''s legacy site management UI and Sakai''s legacy membership services have grown complex and inefficient. The new functionality can only be supported by logically separating membership management from other aspects of site setup.<br/>
','Instructors|Staff (administrative)|Researchers|Sakai developers|Sakai administrators',' New Tool''Realms (Admin Site Management)''Roster ''Sakai Application Framework ''Section Info ''Worksite Information ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-367','Bonus questions','Allow instructors to specify a question as &quot;bonus.&quot;  A bonus question''s weight would not be added to the total amount of score points possible although it would be added to a student''s raw score.  With  bonus question a student could score 100% on an exam even without answering the bonus question correctly.  Instructors should be able to set a question to bonus after a test run is complete (or ongoing) and recalculate scores based on the fact that the question has been turned into a bonus question.  Among other use cases, bonus questions are useful when an instructor creates a question pool but realizes after the test run has started that one of his/her questions is testing knowledge that wasn''t adequately disseminated in the class.  <br/>
<br/>
Just for clarification purposes, a bonus question is not a survey question.','Students|Instructors','Samigo - Question Pools ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-368','Kuder Richardson and Discrimination Analysis reporting','Incorporate discrimination analysis reporting and Kuder-Richardson reporting.   Both of these statistical tools can help instructors design and improve the quality of their tests.','Students|Instructors','Samigo - Grading ''Samigo - Question Pools ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-369','Gradebook - Due date on gradebook columns','A due date feature on a column would assign a 0 grade to the student if a score hasn''t been submitted by the due date.  This feature is particularly useful when the column is referenced by a running grade column.   When calculating the running grade, after the due date, any missing scores in this column will be counted as zeros. Prior to that date, if a score is missing this column will not be used to calculate the running grade.','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-370','Gradebook -- Running grades column','Include a running grade column in the gradebook.  A running grade column is like a formula column but it is date sensitive and will exclude particular columns from a formula if the due date of the column in question has yet to pass.  The running grade calculates a grade based on the columns that are currently due or those that have been turned in and scored. If an assignment is not yet due it will not be counted against the student, but will be counted if a score is present. This feature is useful so that students can extrapolate final grades even when not all of the assignments have been turned in.','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-371','Gradebook -- Dropping scores option in a formula column.','A formula or calculated column should have options that allow the lowest score from a group of selected columns to be dropped from the formula''s calculation.  For example, lets say an instructor delivers five quizzes to her students over the course of the semester.  She should be able to specify in the final grade calculation, that the calculation take the four highest quiz scores but drop the lowest.  
<br/>

<br/>
','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-372','Gradebook - Formula Column','Include a formula column that can calculate a grade based on scores in other columns.  
<br/>

<br/>
The formula GUI should allow an instructor to type standard operators (+-*/) into the formula, use parenthesis ( ) to control what gets calculated first, and allow the instructor to type in other columns as variables into the formula.  
<br/>

<br/>
An advanced formula column should also allow an instructor to group other columns together and specify that the lowest score from that group be dropped.   
<br/>

<br/>
A really advanced formula column should be able to extrapolate a final grade based on the work that a student has done up until a particular point in the semester.  These formula columns are sometimes called &quot;running grade columns.&quot;  A good running grade column won''t include columns in a calculation if the column in question is associated with an assignment that isn''t due yet.','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-374','Resources tool should have the ability to store multiple versions of files in Sakai.','Reporter - Charles Severance: Add Versioning Capabilities to Content Hosting, Resources Tool, and WebDav.  Add the ability to store multiple versions of files in Sakai. This will require a GUI design that allows users to manage their multiple versions and possibly technical support tools as well to manage the stored versions of files. This may require modifications to existing user interfaces and the addition of wholenew user interfaces to properly support these features.<br/>
<br/>
Reporter - Clay Fenlason: Document Versioning. Many of our courses involve team projects that involve several people working on the same document. This is awkward to manage without some versioning capability in the Resources tool. I would project that the same thing would be valuable for research collaboration. <br/>
<br/>
Use cases: <br/>
- a collaborator uploads a new file into a location with a file already bearing that name. The new file is stored with a new version number visible through the interface. <br/>
- other collaborators are able to access previous versions of the same document <br/>
- at least one collaborator or manager has the ability to revert the document''s version to a previous version. <br/>
- this versioning capability happens consistently through both WebDAV and the web interface<br/>
','Instructors|Researchers|Students','Resources ''Sakai APIs ''WebDAV ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-375',' Timed Release of documents/files in Resources tool','Faculty want finer grained control over when resources are visible to students. They want to be able to upload resources, yet constrain the dates/times at which they are available and dates/times at which they are no longer available to students. They would like to be able to manually release document(s) that are in the Resources tool but currently hidden<br/>
<br/>
Use cases: <br/>
- An instructor wants to pre-load all her resources at the beginning of the term, but organized into one folder for each week of class, and each folder is automatically &quot;turned on&quot; at the beginning of each week. <br/>
- An instructor wants to upload exam solutions to the site, but set them to be visible only at midnight following the exam day. <br/>
- An instructor wants &quot;stale&quot; content to disappear from the student''s view after two weeks, yet still wants to keep the content visible to teaching assistants and instructors of the site.<br/>
-  An instructor wants to upload lecture notes in one go, but set them to be revealed to students only after the scheduled lecture. <br/>
- An instructor may want to post answer sets to homework assignments, but only make them available after the due date of the homework and would like to post them all at the beginning of the semester.<br/>
','Staff (administrative)|Sakai administrators|Researchers|Instructors|Students|Sakai developers','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-376','viewing /using student email addresses','Instructors want to see / expect to see student email addresses. They also expect that they will be able to send messages to students in the following ways:
<br/>

<br/>
(1) messages to the whole class (currently accomplished at UC Berkeleythrough Announcements)
<br/>
(2) messages to select groups (currently accomplished at UC Berkeley through Assignments + Section/Group Info definitions)
<br/>
(3) messages to individual students (currently not possible &gt; the workaround is to  use another system at UC Berkeley) ','Instructors|Researchers|Staff (administrative)','Global ''Site Info ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-377','Configurable Workflow','The ability to configure workflow in tools, which invovle the handing off of items between users would be useful, such as Assessment tools like Assignments or Samigo.  These tools already have some notion of this, such as their ability to had an assignment back for a student to do it over.  It would be nice to make this workflow more configurable, however, inorder to support other use cases.  For instance, you might just one grade (or Assignment) to reflect work on a paper where first the student submits an outline, you review it and return it, they then submit a rough draft, you review and return it, then they finally submit a paper.  Maybe it goes even further and you allow multiple drafts to be submitted before you finally grade one.  <br/>
<br/>
Another example comes for sharing grading responsibilities on complex submissions, such as exams, where different instructors are responsible for grading specific questions; the old split up the stack of exams and pass them from office to office, which we can avoid hopefully in the electronic world of Sakai.  An individual instructor would like to be able to tell which exams they''ve left to work on, or have already worked on.  It would also be useful to know when the exams are all done; when the instructors have all completed their pieces then whomever is responsible can be notified or see an indication in interface that thing are now ready for their step, such as releasing the grades at the appropriate time.','Students|Instructors',' New Tool''Assignments ''Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-378','Resources tool should allow instructor to set documents/files within and outside a folder, and folders, in a desired order','Instructors should be able to set documents/files within and outside of folders, as well as folders in resources in whatever order they choose, rather than having documents appear in alphabetical order. An instructor may have several folders, and files outside of folders, in the Resources area -- Homework, Assignments, Images, Maps, Research Resources List.  Currently, Sakai puts these items in alphabetical order. <br/>
<br/>
This occasionally forces faculty to rename their resources in manipulative ways simply to have the arrangement of folders and files happen in the way they wish. <br/>
<br/>
The site owner should be able to determine the order in which folders and files appear. The site owner should also be able to determine the order in which documents/files within a folder appear.<br/>
<br/>
Use cases: <br/>
- An instructor sets a &quot;default&quot; ordering for a site''s resources, which need not adhere to any sorting algorithm. <br/>
- a site user can still re-sort the items according to their preferences, but always have a quick way to restore the &quot;default&quot; ordering that the instructor has established.<br/>
<br/>
','Students|Staff (administrative)|Sakai administrators|Researchers|Instructors','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-379','Configurable Display fields for resources, including description field','Faculty often complain that the resources tool does not display the information they most care about. They don''t care about the modified date so much as the description, for example. Faculty would also like to be able to enter instructions related to the document or file, or to display copyright status of a document.<br/>
<br/>
A Description field is now provided when a user uploads a document, but the description is not visible to those accessing the site. Similarly,  the copyright field, which currently exists, is not visible to those accessing the site.  <br/>
<br/>
A solution would be to let users select  &quot;Options&quot;  to decide what columns of data would be displayed, toggling them on and off as appropriate. <br/>
<br/>
<br/>
<br/>
<br/>
','Staff (administrative)|Sakai administrators|Students|Researchers|Instructors','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-380','Accessibility: Alternative Content Presentation for Persons with Disabilities','Persons with disabilities should be provided with alternative renderings upon entering Sakai. Ideally, Sakai should remember their preferences, so they are presented as the default for subsequent visits. The choices, at a minimum, should include:<br/>
<br/>
1. Enlarged text--100%, 200%, 300%, 400%<br/>
2. Reverse type (white on black or yellow on black)<br/>
<br/>
Additional options would be to:<br/>
<br/>
2. Select their own foreground (text) and background colors (replacing 2)<br/>
3. Show &lt;alt&gt; text instead of images<br/>
4. View without CSS<br/>
','Students|Staff (administrative)|Sakai administrators|Instructors|Researchers','Global ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-383','Hierarchical Site Navigation Built on Typologies','The ability to type sites and expose those types to the primary navigation as a hierarchy would greatly improve the most fundamental navigational structure in Sakai. This need will become even greater as time goes on and multiple years and semesters pass. We can easily imagine a user wanting to drill down through:<br/>
<br/>
Courses<br/>
&nbsp;&nbsp;2006<br/>
&nbsp;&nbsp;&nbsp;&nbsp;Fall<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BIO 204<br/>
&nbsp;&nbsp;&nbsp;Spring<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ECON 327<br/>
&nbsp;&nbsp;&nbsp;2007<br/>
Collaborations<br/>
&nbsp;&nbsp;Committees<br/>
&nbsp;&nbsp;&nbsp;&nbsp;Hiring Committee for Computer Engineer (2006)<br/>
&nbsp;&nbsp;&nbsp;&nbsp;Hiring Committee for Computer Engineer (2010)<br/>
&nbsp;&nbsp;&nbsp;Interest Groups<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dogs<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Paleontology of Cambodia<br/>
&nbsp;&nbsp;&nbsp;Study Groups<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Calculus 208<br/>
&nbsp;&nbsp;&nbsp;&nbsp;<br/>
Right now Sakai''s site navigation organizes sites alphabetically. While this might scale tolerably well for 10 or 15 sites, it does not scale for 30 or 40, and over the course of, say, an intstructor''s career, she might have many more than that.   ','Sakai developers|Students|Staff (administrative)|Instructors|Sakai administrators|Researchers','UI''Worksite Information ''Worksite Setup ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-384','Dynamically targetted announcements','Sometimes one wants to communicate something to a subset of all Sakai users, for example:<br/>
<br/>
- Send a message about training opportunities to users who have the role of Site owner, Lecturer or Tutor in one or more course sites<br/>
<br/>
- Send a message about a feature change to users who are site owners of project sites.<br/>
<br/>
It should be possible to specify and combine search constraints for one or more of:<br/>
- Role (within a site type)<br/>
- Site type<br/>
- Account type<br/>
- Sites (select multiple sites)<br/>
- Course codes (i.e. provider IDs)<br/>
<br/>
This would also relate to future work done on Course Management, groups and hierarchy.<br/>
<br/>
This requires an admin message tool which can dynamically construct a list of recipients, and then deliver a message in one or more chosen formats (e.g. IM, email, SMS, popup).<br/>
<br/>
It should also be possible to save a ''recipient profile'', essentially a saved query string, so that instead of reconstructing the recipient query each time, one can simply select a predefined target such as ''Course site managers'', etc.<br/>
','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-385','Move Non-tools Out of Tools Menu','Right now the metaphor ''tool'' does not apply well to ''Home'', ''Section Info'', ''Site Info'', ''Help'', and others. I think it''s worth debating whether the ''Web Tool'' that puts external sites in an iFrame belongs in the Tools Menu as well. We should move the  functions that aren''t properly tools out of the Tools Menu and into another menu - possibly above the title bar and across the top of the site. ','Staff (administrative)|Instructors|Students|Researchers|Sakai administrators|Sakai developers','UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-386','Crumb Trails','We should use crumb trails to indicate the state a tool is in. ','Sakai administrators|Students|Sakai developers|Instructors|Researchers|Staff (administrative)','UI');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-387','Chat Function should be Cross-site and Cross-tool','Right now chat is ''located'', like other tools, within a site. As Chat begins to support person-to-person messaging, as others have proposed the functions of chat need to transcend any particular tool or site. The ''contacts'' or ''buddy list'' needs to be available across sites, and the chat windows themselves could site on layers above any other functionality, as Gtalk now functions inside of Gmail.','Sakai developers|Students|Staff (administrative)|Researchers|Sakai administrators|Instructors','Chat Room ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-388','Drag-and-drop ability to reorder resources','Quote from the original (and now split) requirement:<br/>
&quot;the ability to re-order items that have been uploaded and some equivalent of a drag-and-drop ability to move items in and out of folders&quot;<br/>
<br/>
This ability already exists within WebDAV, but it would appear that this requirement also calls for the drag-and-drop ordering to be reflected in the web interface.  So it may fundamentally be a web interface issue that WebDAV does not address.','Researchers|Students|Instructors','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-390','Instructors can set specific group/section permissions in resources to allow for file-sharing and collaborative work.','Resources should be group and section aware
<br/>
Each group or section should/could have its own resources area.
<br/>
Instructors should be able to set permissions to allow particular individuals/groups/sections access to specific folders or items in resources
<br/>
Instructors should be able to set permissions to allow particular individuals/groups/sections the ability to create/edit/delete items in specific folders in resources—i.e., to allow a group/section to work on shared files.
<br/>

<br/>
Uses:
<br/>
- private file sharing between instructors
<br/>
- private file sharing between a group of students to make a collaborative work
<br/>
- private file space for a group or section within a course or project
<br/>

<br/>
This requirement incorporates the following: REQ-18,  REQ-219, REQ-271
<br/>
It also includes group and section awareness for resources tool,  which is covered in REQ-40
<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Resources ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-393','Indication on DropBox page that new files have been added since last visit.','Indication on DropBox page that new files have been added since last visit.
<br/>

<br/>
Original (split) requirement is REQ-233.','Instructors','Drop box ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-395','Ability to select multiple DropBoxes and delete.','Ability to select multiple DropBoxes and delete.','Instructors','Drop box ');
insert into requirements_data (jirakey,summary,description,audience,component) values ('REQ-396',' Resources should allow user to define permissions at folder level  ','Assumes that Resources is group/section aware
<br/>
Goals:
<br/>
Instructors can define whether a specific role/group/section has access to the items contained with a subfolder of a site 
<br/>
Instructors can give a specific role/group/section permission to add new items to a subfolder of a site without granting this role/group/section access to the entire site''s resources
<br/>

<br/>
The instructor or maintainer of a worksite will have the ability to set permissions for individual folders and files within resources. For example, an instructor could restrict (hide) a folder in Resources until he is ready to make it available to students. The instructor would do:
<br/>
-Resources
<br/>
-Click &quot;Folder Permissions&quot; next to the desired sub folder
<br/>
-Unclick the checkbox next to Student and under &quot;read&quot; (currently this is checked by default and cannot be altered when read is allowed at the site level)
<br/>

<br/>
The current design of requiring instructors to turn off read permissions at the site level to prevent read access to subfolders is undesirable as it is more likely that instructors will want to turn off access to individual folders &amp; files while leaving the majority of documents as read access.
<br/>

<br/>
Incorporates REQ-91, REQ-188
<br/>

<br/>
','Students|Instructors|Researchers|Staff (administrative)','Resources ');
