/* output from jira2sql.xsl */
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-1','1','Selective release of assignments in Gradebook','Instructors can decide whether or not to release any assignment column to students either while creating the assignment or any time after it has been created.
<br/>
Instructors can hide any assignment column at any time after it has been released.','Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-2','2','Gradebook Export More Configurable','Spreadsheet export should be configurable to meet, for instance, local registrar system requirements for grade submissions
<br/>

<br/>
1. System administrator can configure the course grade spreadsheet export to meet local institutional format and data requirements for course grade submissions to the registrar''s system.
<br/>
2. Instructor can export and download all course grade data to a single file that does not require further editing (assuming all required data can be provided by Sakai) before it is submitted to the registrar''s system. 
<br/>
','Instructors|Sakai administrators','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-3','3','Gradebook should focus on getting data in','The current gradebook seems to focus much of its attention on evaluating scores, i.e. presenting % of right, current cumulative grade, etc. Given limited manpower, it should be focused on gathering data. Faculty use different ways of combining scores. Some are incredibly subjective. Many of them don''t want to show anything other than scores on assignments. Those that would be happy to show a cumulative grade would need great flexiblity in how it''s calculated, such as weighting, dropping lowest assignments, etc. But those faculty say they would be happy to download the data to excel, do calculations there, and upload the actual grade. Thus what we need is:
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-4','4','Allow users to specify their default WYSIWYG editor preference','Allow users to select the WYSIWYG editor of their choice (HtmlArea, FCK Editor, Sferyx, etc.).  This could be surfaced under Prefereces.  The setting should make their editor of choice the default in all Sakai tools in the user''s sites. (This setting presumes that a Sakai tools'' functionality will not be dependent on a particular WYSIWYG editor.) It may also be desirable to have the list of possible WYSIWYG editors configurable as a system-wide setting, i.e., in the sakai.properties file.
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
* Support resources maybe limited, so one might want to limit the number of different WYSIWYG editors on a system-wide basis.','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Preferences|WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-5','5','Site Usage Statistics Tool','Our version of Blackboard has a tool which instructors prize: it generates reports of site usage and activity.  The different sorts of things they can learn from this tool may stand as use cases:
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-7','7','Gradebook as grading schema provider/helper','Since grading schemas can be common across multiple tools, I think gradebook should provide a service and/or a helper tool so that other tools can draw from some common set of grading schemas.  Such a service should provide a way to define a customizable and extendable set of schemas.  Other tools then can incorporate this functionality or build upon it, instead of writing tool-specific schemas.  Users, administrators and developers of the system benefit when common tasks are handled in a uniform manner (they don''t have to recreate grading schemas for different tools, with potentially unfamiliar UI''s).
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
and then Assignments, Gradebook, T&amp;Q would provide those scales for use and limit the acceptable values to those specified when the scale is not a point range.','Instructors|Sakai administrators|Sakai developers','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-8','8','Need the ability to deny permissions','A deny permission is needed in order to be able to control read/write access to subfolders. Without it, read access to a subfolder can''t be prevented since you can''t take away a permission granted at the parent folder, and in order to get to the subfolder, you need readd access at the parent.  A deny capability would also be useful in conjunction with the !site.helper realm, to deny certain permissions to a role in all sites. See SAK-1609 for further details.','Researchers|Staff (administrative)|Sakai administrators|Instructors','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-9','9','Structuring content for presentation','Current the Resources tool is the only place other than Melete where we can put content. Many faculty want the ability to structure the way material is presented. The commercial tools all have some way to construct an &quot;organizer page&quot; (called different things) where items can be placed. Unlike the current Resources tool, organizer pages are constructed to present content rather than maintain it. So an entry will normally have a title and a description, but not the various icons present in Resources.<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-10','10','Support for HTML editors','There have been reports that you are going to provide a single place for interfacing HTML editors. We certainly need this. However we need more than just a place to plug in an editor. We also need some facilities in the core to support an HTML editor. Here are some things we''ve found that we need. In reading these requirements, note that the HTML editor will be used for preparing HTML pages in Resources, but also portions of pages in announcements, quizes, etc.<br/>
<br/>
* a file picker. People want to put links in their HTML document. Most HTML editors have buttons to insert a normal link and an image. Many HTML editors have a &quot;browse&quot; button in the tools. We need a URL that the browse function can go to. At a minimum that should give you a directory listing of Resources, with a button next to each item that lets you choose it in Javascript. It might be a good idea for the file picker to be able to choose among several different areas, e.g. Resources for the course, for the faculty member creating the page, and from sites in which shared content is housed.<br/>
<br/>
* support for HTML editors that create images and equations. This includes support for uploading files through HTTP POST. However you should also consider where images should go. The obvious approach is an images folder in Resources. However there are reasons for students not to be able to get a listing of images. If you are preparing a test, images may include equations and other items that would help a student guess what is going to be on the test. Either you need to be able to protect the images directory in resources from browsing by students, or it should go in a separate place which the faculty member can browse but the student cannot.<br/>
','Students|Researchers|Instructors','WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-12','12','Sakai Import and Export using IMS Content Packaging','Sakai currently uses its own proprietary import and export.  It would be nice to support IMS Content Packaging import/export in Sakai as well.  An imprortant first-step is support for the IMS Common Cartridge, which is a profile of IMS Content Packaging. 
<br/>

<br/>
Use Case:
<br/>

<br/>
* Import and export content using IMS Content Packing.
<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Global|Site Archive (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-14','14','Sakai services should minimize dependencies and references to other services','Sakai services should strive to model data management for a set of objects and minimize the use of other Sakai services in both the API and implementations.  By clearly separating concerns, this will lead to Sakai services being more modular and easier to adapt services for enterprise integration.  Since Sakai services are layered, no sakai service should ever reference a higher level service.  Even references at the same level should be avoided unless absolutely necessary.<br/>
','Sakai developers','Providers|Sakai APIs|Sakai Application Framework|Web Services ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-15','15','Comprehensive ''remove user'' functionality','There is a need for a more comprehensive &quot;remove user&quot; fucntionality than currently exists.  One that not only deletes the user, but all the appropriate, associated data, such as their MyWorkspace site, their memberships, etc., rather than leaving it orphaned in the db.  Note that for some cases, such as users from external providers, it may not be desireable to delete all the related artifacts when deleting the internal user representation in Sakai, so support should be provided for both the current and the proposed delete user functionality.  This likely to be a larger problem in projects than in course sites, where users from outside the orginization are likely to be using guest accounts.
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
','Students|Instructors|Researchers|Sakai administrators','Providers|Realms (Admin Site Management)|Sakai Application Framework|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-16','16','Template capability for email messages','In cases where Sakai sends outgoing email messages and possibly in some other instances, blocks of text are constructed in java code. This means that for sites to customize the text of email messages (whether for language translation or local context), it is necessary to change the java source code, rebuild and redeploy.<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-19','19','Make storage and display of assessment scores consistent','1: Scores should be stored and transmitted between tools (as opposed  
<br/>
to displayed) with the highest possible accuracy (i.e. doubles).
<br/>

<br/>
2: The default display of scores should be 2 decimal places. For  
<br/>
example, 1 out of 3 is displayed as &quot;.33&quot;
<br/>

<br/>
','Students|Instructors','Assignments|Gradebook|Tests & Quizzes (Samigo)|UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-20','20','Standardize URL input fields','Different validation rules and hints are applied to URL input fields across the various tools in Sakai, such as automatically adding http:// or not, pre-loading the input field with the http:// prefix, etc.  It would be nice to standarize the rules, at least for the core/bundeled tool set.','Students|Instructors|Researchers|Sakai administrators|Sakai developers','Global|JSF|Style Guide ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-21','21','Standard Calendar Widget','Tools should strive to use a common date-time picker or calendar widget.  For example, Schedule, Assignments, and Tests &amp; Quizzes (Samigo) all use a different approach right now. The attached document points out some of the differences in how the calendar widget works in several Sakai tools. This requirement would change the style guide suggestion for the calendar widget and create a Sakai JSF widget which can be shared by all tools that use calendaring. ','Students|Instructors|Sakai developers|Researchers','Global|JSF|Style Guide ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-23','23','Support for directly entering images and rich text in "Worksite Information"','Site owners often want to include a richer description of their course or project besides just text.  While one could currently do this by creating an HTML document outside of Sakai or in the site''s Resources, and then using the URL, it would be better practice to be able to create and edit such a rich Worksite Information page in the tool itself, or when editing or creating the Descirption initially in Site Info or Worksite Setup.
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
Faculty at UC Berkeley would like to be able to add images and rich text to the descriptions of their sites. Many consider the ability to place image(s) on the HOME page an important feature that is currently missing from bSpace. They would like to be able to better personalize their sites with image(s) that represent their classes/subject matter.','Instructors|Researchers','Home|Site Info|Sites (Admin Site Management)|Worksite Information|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-24','24','Case Sensitivity of Sorting','Sakai currently uses a case-senstive sort for lists, which is typical of ASCII sorting rules; upper-case letters sort higher than lower-case.  Sorting could also be done on a case-insenstive basis.','Sakai developers|Instructors|Researchers|Students','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-25','25','View Site as if in a Different Role','The ability for a user to view the site as it would be viewed by a user with a different role in the site.  For example, an instructor being able to view a site as their students see it.<br/>
<br/>
This is similar to, but not the same as the SUTool, which allows admin users to view the site as a specific user would see it.','Students|Instructors','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-26','26','Emails Should Contain Site URL and Item URL','When an email is sent from a site (e.g., an auotmated message, and email forwarded by tool Email Archive tool) it should contain the URL for the Site and the direct URL for the item the message references (e.g., an email in Email Archive, an announcement, a resource).  This will enable the recipient to either easily access the site and some work the message reminded them of or to directly access the item in the context of the site and start their work from there.','Students|Instructors|Researchers|Sakai developers','Global|Style Guide ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-27','27','Import/Export/Synchronize Schedule Data','Support for the ability to import/export/synchronize schedule data with external applications, or to integrate in general an exisiting enterprise calendar system for use with Sakai.   Many schools already have an enterprise calendar system that users are working with outside of Sakai and would a like a way to exchange data between the two so they can have their schedule in &quot;one place&quot;.  Many users also have PDAs or cell phones with scheduling programs they would like to be able to view all their scheduling data in.<br/>
<br/>
Some external scheduling applications also have web interfaces, which could be placed in a Sakai Web Content tool; however, that doesn''t achieve any direct integration, such as creating an Assignment whose open date would be posted to the external scheduling software.','Instructors|Researchers|Students','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-28','28','Email Notification When Submitting High-Risk Items','Send a confirmation email when Sakai has successfully received a high-risk item.  For instance, when a student submits an Assignment, they should get an email receipt that the system completed the process.  The email can include an appropriate reference ID and time-stamps.  This option could be configured to be system-wide, by site, or by student; a good default would be to have it on system-wide.','Students|Instructors|Researchers','Assignments|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-29','29','Option to Enforce Unique Site Titles','It would be nice to have support for enforcing unique site titles, currently Sakai allows one to have multiple sites with the same title, which can lead to confusion.  (There are Sakai installations that are interested in multiple sites with the same title, so this could be implemented as an option.)
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-30','30','Join Site by Requesting Membership','Add the additional option for sites to be joinable only by request.  In otherwords, a user could browse the list of joinable sites, but instead of being able to join immediately, they would have to go through some soft of approval process.   For instance, they could click on a link next to a site in the Membership tool that would provide them with a little form to fill out, whichi would then generate an email to the site owner(s), who could then click on a link in the email to accept or deny the join request (and maybe add a comment to the automate message and instructions), which in turn would generate an appropriate email back to the requestor.
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
* A site you want to control access to, but not have to rely on Sakai administrators or out-of-band email requests to handle.','Researchers|Students|Instructors','Membership|Site Info|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-31','31','Offline component for learners to study while not connected to the internet','One of the factors hindering the implementation of e-learning in Africa (and South Africa) is  limited and expensive Internet connections.  Low bandwidth remains an issue and prevents the delivery of rich media to learners. An alternative to increasing bandwidth to cater for this problem is the dissemination of learning content from a central server during off-peak hours.  Internet connections can be used to keep learning content up to date on the remote computers. Because content can be downloaded once and studied without the need to remain on-line for extended periods costs can be greatly reduced for the learners.  The learner can however still connect to the central server for learning activities such as discussion groups, reading of announcements etc.<br/>
<br/>
What is needed is an intelligent off-line client that can update content from time to time as is needed.  This client will provide the learner with most (all?) of the same functionalities as he/she will find on-line.','Students',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-32','32','Shift Site''s Dated Material Forward for Re-Use in Future Semesters','In order to re-use a site in future semesters, whether by editing it or duplicating it, one of the big tasks is updating all the timed-related content.  For instance, while the content of Assignments may remain mostly unchanged from semester to semester, the timing of their delivery, due dates, closing, etc., is always going to be different.  Another example would be events in Schedule which represent the course''s meeting times, and perhaps contain links to the appropriate lecture notes for each particular time.  It would be nice to have a way to bulk move such time-dependent content forward for a new semester.  For instance, it would be nice to be able to specify a new &quot;first day&quot; for a course, and have all the Schedule events moved relative to the difference with the old firest day; taking into account, of course, the differences such as university-wide off-days defined in a system-wide calendar.','Instructors|Students|Researchers','Assignments|Global|Schedule|Syllabus|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-33','33','System Administrator GUI for Configuring Sakai','A GUI for configurating Sakai while running, rather than manually editing the property file.  Some settings might require a restart.','Sakai administrators|Sakai developers',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-35','35','Enable/Disable Site Info/Worksite Setup''s "guest" section','Offer the ability to disable the add participants &quot;guest&quot; section in the Site Info/Worksite Setup tool.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* Prevent instructors from being able to create guest accounts','Instructors|Researchers|Staff (administrative)|Sakai administrators|Sakai developers','Section Info|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-36','36','Image Repository in Resources for Easy Access from WYSIWYG Editors','It would be nice to have a folder in Resources in which one could store items, particularly images, which could then be easily referenced in the WYSIWYG without having to fully specify an absolute URL to the Resource item. Images placed in the appropriate Resource folder could be referenced by a relative URL in the WYSIWYG.','Instructors|Students|Researchers','Resources|WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-37','37','Sakai Saving State - Moving between tools and within pages of a tool should behave conistently for users.','User need a consistent model for what will happen when they &quot;go someplace else&quot; within Sakai.  <br/>
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
There has always been a lot of debate over which model to adopt.  The choice of saving state or not should be a system-wide configuration option.','Students|Sakai developers|Researchers|Instructors','Global|Style Guide|UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-39','39','Hotlink Items in Synoptic Views','When a tool provides a Synoptic View of its contents then the synopsized items should be linked to their full view.  For example, clicking on a synopsized announcement on a site''s Home should take you to the full view of that item in the Announcement tool.','Students|Instructors|Researchers|Sakai developers','Announcements|Chat Room|Discussion ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-40','40','Section and Group-Enable Existing Sakai Tool Set and Require it of New Tools','Implement support for section and group awareness in the existing Sakai Tools and require it of new tools to become part of the Sakai core bundle.','Students|Instructors|Researchers|Sakai developers','Assignments|Chat Room|Discussion|Drop box|E-mail Archive|Global|Home|News (RSS)|Presence|Presentation|Resources|Roster|Rwiki|Schedule|Section Info|Site Info|Syllabus|Tab Management|Tests & Quizzes (Samigo)|Twin Peaks|Web Content|Worksite Information|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-41','41','Allow multiple email addresses per user','Users should be allowed to specify a primary email address, where Sakai-generated email is sent (e.g., notifications, email archive messages).  Users should also be allowed to specify multiple secondary email addresses, which are used by Sakai when validating permission to send email to Sakai, such as to a site''s Email Archive.','Students|Instructors|Researchers','Account|E-mail Archive|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-42','42','Aggregated Upload/Download of Resources','As an alternative to WebDAV, it would be nice to be able to upload and download aggregations of files/folders to/from Resources using archive files (e.g., .zip, .gz, .sit).  If one uploads an archive to Resources, one could have the option of exploding the archive in place in Resources.  If one wanted to download a collection of files and/or folders, then one could go through a picking process, select the desired items, choose the type of archive, and then download it.','Instructors|Researchers|Students','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-44','44','Site-Specific and Tool-Specific Notification Preferences','Currently the &quot;Preferences&quot; tool appears only once for each user, in that user''s &quot;My Workspace&quot;. Preferences for email notification of changes are set there and apply to all worksites.
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
','Students|Instructors|Researchers|Staff (administrative)','Announcements|E-mail Archive|Global|Preferences|Resources|Syllabus ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-45','45','All Tools Should be Skinnable','A requirement for tools is that they should be skinnable.  For example, the current help tool only uses the default skin.','Instructors|Students|Sakai developers|Researchers','UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-46','46','Help Context-Senstive to Permissions','The help displayed by the Help tool should be senstive to what permissions a user has in a tool.  For instance, if they do not have permission to create announcements, then they should not see that section of help.','Sakai developers|Researchers|Students|Instructors','Global|Help ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-47','47','Tool Menu (Left-hand Buttons) Permission Sensitive','The list of tools appearing in the left-hand menu should be senstive to the users permissions.  If they cannot access the content of the tool, because its permssions have been set that weay, then they should not see that tool in their list.','Students|Instructors|Researchers','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-48','48','Dock/Undock Tools','Restore the ability to dock/undock tools into their own browser windows.  This was present in 1.x versions of Sakai.','Researchers|Students|Instructors','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-49','49','Split up Functionality of site.upd Permssions','Finer grained permssions are needed on edit fuctions for site.upd.  Currently it allows a user to add, remove, and mark active/inactive other useres in a site.  It would be better, however, if you could grant the ability to mark a user active/inactive without the ability to remove them, as you don''t want instructors accidently removing a user and their work from a site.','Students|Instructors|Researchers','Global|Sites (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-50','50','Manage Users and Courses Tool','A refinement of current admin tools, both UI and functionality.  An admin tool that will list users and display courses or list courses and display users associated with course.<br/>
<br/>
a. ability to link user to all courses or link course to all users<br/>
b. paging for all list views (currently a very long roster will break the html at Realms) <br/>
c. showing X-of-Y for list pages (currently, when we do get paging we only get Previous and Next.  No clue how many pages we''re leafing through.<br/>
d. a way to export any list in admin as .txt<br/>
e. the tool list at Sites &gt; Pages &gt; Tools &gt; New Tool as a dropdown menu.<br/>
','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-51','51','Admin Copy Tool','An admin tool that will copy a course or a site for Faculty not Admins thus freeing up admins for this function.  Faculty will still want to copy courses or sites even with the WebDav respository.  The batch import/export tool does not allow instructors or site maintainers to target specific areas.<br/>
<br/>
The copy tool for instructors should do the following:<br/>
- identify the course/site to be copied<br/>
- identify the target to be copied to (new course, existing course)<br/>
- identify areas of the course to be copied allowing specific material or areas to be copied (includes assessments, images, etc.)<br/>
- will be able to copy user data (optional) if desired','Researchers|Instructors',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-52','52','Merge Course/Site Tool','An admin and instructor tool that will merge courses or sites into a target course, however, this tool is for instructors not admins.  It would allow instructors to merge one course into another to allow teaching of several sections of courses within one sakai course.<br/>
<br/>
The merge tool should do the following:<br/>
- identify the course/site to be the target or repository of the course sections<br/>
- identify or select the courses to be merged into the target course<br/>
- merge the enrollments into the target course for all roles (stdts, instructors, GTAs, etc) and data updates will automatically take effect within the target course<br/>
- this action (the merge) can be undone<br/>
- still identify students which were enrolled in the pre-merge sites<br/>
<br/>
Use case:<br/>
Instructor A is teaching 2 courses that meet on different days. He would like to post all course materials, tests, etc... on one worksite. He would like to also be able to send announcements to all students, or just students in the class that meets on the first day. At the end of the semester, he will split the site back into the 2 original sites and post final exam information. When the classes are split, the course materials and data should be duplicated in both classes.','Instructors|Sakai administrators',' New Tool|Section Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-54','54','Log Searching Tool','An admin tool that will allow admins to check the logs in order to know when a person took a quiz, accessed an area, and what they did when they accessed said area.<br/>
<br/>
The search should be able to be limited by users, sites, and dates. For example, I want to search the logs for the last week for site &quot;Test site A&quot; and user &quot;student B&quot; with a search term &quot;quiz 4&quot;.<br/>
<br/>
Use Case:<br/>
A student claims to have taken an online quiz 2 weeks ago but they have no grade in the gradebook. The admin (helpdesk support person) needs to be able to search the logs (through the interface) to see if there are any indications that the student took the quiz but the data was lost or removed.','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-55','55','Indicate Read/Unread Messages','In tools like Discussion, Announcements, etc. there should be an indication of whether items have been read or remain unread. ','Students|Instructors|Researchers','Announcements|Assignments|Discussion|E-mail Archive|MOTD|Resources|Schedule|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-56','56','Use a Single "Name" to identifiy Resources','A continuing source of confusion for users is the lack of correlation between the Title of a Resource and the ID by which the system knows the Resource.  In general, users are expecting Resources to behave in a manner similar to their computers file system.  Resources violates this by only looking at a Resource''s system ID and ingoring the Title when a user performs actions which result in duplicate names.  For example, users can end up with two or more Resources with identical Titles.  The system knows the Resources are different because each was assigned a unique ID when it was uploaded, however, the user cannot necessarily tell from the UI what''s going on.  Also, they may attempt to upload a new version of a file using the same Title assuming that it will replace the old version; it does not, instead you end up with two identically named Resources.<br/>
<br/>
A signle &quot;name&quot; or &quot;ID&quot; should be used to identify Resources for the purposes of listings, warning users about replacing an existing Resource during uploads, preventing more than one Resource having the same Title, etc.<br/>
<br/>
','Sakai developers|Students|Researchers|Instructors','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-57','57','Google Indexing of Email Archives','Email Archive contents should be google indexable if site is public.','Instructors|Researchers|Students','E-mail Archive');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-59','59','Allow a user to disable email notifications','We would like a setting in the preferences tool that allows a user to specify that no mails should be sent from the sakai system to his/her mail account.<br/>
<br/>
There should also be an option to turn off this control at an institutional level (probably controled through sakai.properties) and to override it at a site level.<br/>
<br/>
Use Case:<br/>
Student A is tired of getting email, they turn off their notifications. They should receive a series of warnings before they are allowed to turn it off that indicate they may miss important announcements. It should also indicate that the site owner can override the setting.<br/>
Use Case 2:<br/>
The instructor wants to send out a notification about class being cancelled. He knows that some students have turned off their notifications. He should be able to override the flag and send a notification that will reach all students.<br/>
Use Case 3:<br/>
Institution B wants to force students to always get notifications in Sakai. They turn on the notification globally and the control disappears. All settings are maintained and if the global flag is turned off, the users who turned off notifications will not get new messages.','Instructors|Sakai administrators|Staff (administrative)|Students','E-mail Archive|Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-60','60','Redesign the resources tool to be more fdocument and student centered','The resources tool, as it is right now is folder centred. This means I can categorise my documents in only one category. For instance if I make a folder for each course I''m in and one of my documents is essential for two or more courses I''ll have to make a copy of the document for each folder it needs to be in. I would like Sakai to be document centred and to enable me to categorise/organise my documents in more than one way.<br/>
<br/>
The resources tool is worksite centred. Sakai is about collaboration and collaboration in Sakai takes place in worksites. If I want to share my documents with other students and faculty the only way to do this is by starting or participating in a worksite. And I''ll have to make a copy of the document for each worksite I want to publish it in. I would like Sakai to support ad hoc collaboration without the need to start a worksite and to enable me to share my documents without the need to copy them.<br/>
<br/>
The OSP FX (functional requirements) group made a description of a resources tool that is more flexible and student centred, enabling collaboration in worksites and ad hoc collaboration. I would like this vision to be in the centre of Sakai. Mock-ups can be found at <a href="http://portfolios.itd.depaul.edu/ospi/Prototypes/OSPInterfacePrototypes.htm">http://portfolios.itd.depaul.edu/ospi/Prototypes/OSPInterfacePrototypes.htm</a>. Of special interest for this discussion are the links ''Manage a Collection'' and ''Publish a portfolio''.','Researchers|Instructors|Staff (administrative)|Students','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-61','61','Display the name of the current user in the site navigation','Our interaction design requires that the name of the curent user is displayed on the screen. The purpose of this is to give the user a sense of ''mine'' when they use sakai. This is different from the presence tool because only your own name would be displayed. We will be displaying this in the mast-head area of the page<br/>
<br/>
This will be something that we are going to look into our selves. We hope other people share this requirement and that is can be made a part of Sakai.<br/>
<br/>
This should also be able to be turned off globally using a flag in sakai.properties or something like that.','Instructors|Researchers|Students|Staff (administrative)|Sakai administrators','Global|JSF|Style Guide ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-62','62','Hide pages in navigation from specific roles','In most tools the permissions can be set to specify what users of each role can do with a tool. In some cases there can be roles for which a tool has no usefull purpose at all. It would be nice to be able to hide those tools or, even better, the page they are on from users of those roles.<br/>
<br/>
Samples of tools that you may decide students don''t need access to are:<br/>
<br/>
-osp.legacy.review<br/>
-osp.presTemplate <br/>
<br/>
Since most tools are on a separate page it would be preferable to be able to hide pages.<br/>
','Students','Portal ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-63','63','Structured presentation of course content','Course content must be presented to the students structured in a hierarchical way - similar to Windows explorer. See attached file for an example. We also need a way of importing course content into SAKAI from a standard (IMS).<br/>
<br/>
Further, creation of this content from the SAKAI environment by lecturers. The lecturers see a similar screen, but have additional functionality for creating new topics. Topics can be created within topics. See attached file for an example.<br/>
','Students|Instructors','Web Content ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-65','65','Email Archive should be deep-linkable/bookmarkable','It is currently impossible to &quot;link&quot; to a message, because the tool state is (apparently) in the session.<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-66','66','be able to delete several messages at once in Email Archive','when emptying an email archive one has to go deleting message by message, whereas a checkbox would allow for selecting to delete several messages at once.','Students|Researchers|Instructors','E-mail Archive');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-67','67','Be able to export and print the Roster','Goal:
<br/>
Allow instructors to export the roster (with the photos) to an Excel or CSV file. Include a &quot;print-friendly&quot; button of the roster list and photos.','Instructors','Roster ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-68','68','be able to watch Drop Boxes, getting alerts on uploads','a recurrent request we have; be able to keep watching Drop Boxes, eventually on a site basis, not an individual one.<br/>
When a document is upload, the instructor gets a message.','Researchers|Instructors','Drop box ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-70','70','Adminstratiors should be able to view a user''s profile data','The personal data which is edited and displayed by the &quot;Profile&quot; tool is more extensive than the data which is edited and displayed by the &quot;Users&quot; tool. However, the only way to see &quot;Profile&quot; data for a user other than oneself is via the &quot;Roster&quot; tool on a particular site. Administrators have no way to access it. Since the Profile data is system-wide, there should be a system-wide way to see it.
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
','Sakai administrators','Account|Preferences|Profile|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-71','71','Adminstrators should be able to block user login','Adminstrators should be able to disable a user''s access to Sakai. Deleting a user''s local record within Sakai isn''t sufficient given the possibility of an external user directory provider being used to identify the user during login.
<br/>

<br/>
As originally described, this requirement might be met by simply blocking login attempts and giving the usual &quot;invalid login&quot; alert.
<br/>

<br/>
REQ-97 describes a similar requirement, except for user access to a particular site rather than to all of a Sakai installation. It includes the ability to give the &quot;banned&quot; user a message explaining what''s happened, which might be useful here as well.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* An employee has been terminated but is still included in the local LDAP directory. Access to Sakai resources and applications must be immediately revoked.
<br/>

<br/>
* A student appears to be using their local workspace to store and share illegal material. The student''s access should be blocked pending an investigation.
<br/>
','Sakai administrators','Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-72','72','be able to specify site quotas on a user, user type, or site basis','it should be possible to specify quotas to My Workspaces and Sites on a User Type, and Site Type basis using the admin<br/>
interface (something like working with realms).','Staff (administrative)|Sakai administrators','Account|Drop box|Global|My Workspace|Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-73','73','Sakai installations need more flexibility in time format','Currently, Sakai applications display time in an AM/PM format. This convention is best known in the United States and Canada, and can be confusing to users who are accustomed to a 0-23 hour format. The time format needs to to be settable system-wide. Another possibility is to let it be set by user preferences, or via the locale setting in the user''s browser.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* All of the users at an installation at a Portuguese university are used to the 24 hour clock. When installing Sakai, the adminstrators choose to default to Portuguese language conventions. Users who log in with a browser set to a European locale or left at the default will see times expressed as a 24-hour clock rather than an 12-hour clock.
<br/>

<br/>
Related Functional Requests and Bugs include:
<br/>

<br/>
SAK-3823
<br/>
SAK-3829
<br/>
SAK-3830
<br/>
','Students|Instructors|Researchers|Sakai administrators|Sakai developers','Global|UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-74','74','Ad-Hoc Group Management','As with sectioning, the full implications are bigger than a single tool, but this place is as good as any.<br/>
<br/>
Instructors need to be able to create ad-hoc groups and *group spaces* (group collaboration areas), and they need to be able to manage these within their course sites.<br/>
<br/>
Use Cases:<br/>
- An instructor or TA creates an ad-hoc group of a subset of site users.  Following creation group membership can be adjusted.<br/>
- Each group has their own collaboration space which includes the usual collaboration tools.  <br/>
- Since students may typically spend more time in a group space than a course space, the group site should not require navigation through the course site.<br/>
- An instructor has an option to import groups from another site (i.e. groups may span multiple sites)<br/>
- An instructor or TA wants to send emails/messages/announcements to specific groups, and not have to remember an email address for each group.<br/>
- Assignments and the gradebook should be &quot;group-aware&quot; to the extent that group projects may be submitted for grading, and feedback may be received on either an individual or group basis.','Instructors|Students','Global|Section Info|Sites (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-76','76','Numerical Final Grades','The  current gradebook only allows letter grades for its final reports.  It seems to be based on the assumption that the gradebooks reports should somehow be &quot;official&quot; (or as close to official as possible) grade reports.  Faculty often however just want to get an Excel export of the final numbers, and they''ll fiddle with the final grades more subjectively later.  There should be an option to have numerical final grades, even for the export.','Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-77','77','A list of who has not submitted an assignment','The current Assignments tool only displays a list of submissions for an assignment, and does not afford the faculty member a list of who has *not* submitted an assignment at all.  They have to do their own manual checking against the course roster to figure this out.
<br/>
Use Case:
<br/>
- an instructor wants to send an email to every student who failed to submit an assignment, and wants a list of such students displayed in the Assignments tool.','Instructors','Assignments ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-79','79','Browser back-arrow behaves as expected','The back arrow in a browser does not allow a user to navigate backward through successive pages of a tool''s workflow.  This proves to be highly disorienting and frustrating for users, who have to re-educate their learned web behavior simply to accommodate Sakai.','Instructors|Staff (administrative)|Students|Researchers','Global|JSF|Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-82','82','Contact/Help tool that records user state','An online help form that captures the user system info as well as the referring URL or siteID.
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-83','83','Admin Tool "lite" for a college division admins','Some admin tasks that we currently handle university-wide could be offered/delegated to the college or school affiliates.  <br/>
Give these users &quot;soft&quot; versions of the Sites and Realms tools but limit access to sites over which they have dominion','Sakai administrators','Permission Widget|Realms (Admin Site Management)|Sakai Application Framework|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-86','86','The Drop Box tool should work better with course sections','The Drop Box should be changed to give instructors and TAs assigned to individual sections an easier and more organized way to work with students in sections.
<br/>

<br/>
The original requirement description suggested creating Drop Box section folders. When an instructor creates sections in his course site, a Drop Box folder hierarchy would be based on those sections.
<br/>

<br/>
There are some possible issues with that approach, however.
<br/>

<br/>
1) A student can be in more than one section, which means the Drop Box would appear multiple times.
<br/>
2) Because the Drop Box and Resource &quot;Title&quot; sorts only happen within folders, it would become impossible for the instructor to quickly access the drop box for a single student without also knowing what sections the student was in.
<br/>
3) A TA still sees all the drop boxes for students who aren''t in the TA''s assigned sections.
<br/>

<br/>
A different approach to making the Drop Box section aware would be to support filtering by section name (e.g., with a drop-down menu showing the names of all sections that the instructor or TA has access to) and only show TAs sections which are assigned to them.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* An instructor creates Lab 1 and Lab 2 sections. The course site''s Drop Box then displays the following folder tree:
<br/>

<br/>
folder SMPL 001 001 W06 dropbox
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Lab 1
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Bob Jones
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Ann Smith
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Lab 2
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Joe Jackson
<br/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;subfolder Kate Klein
<br/>

<br/>
* An instructor goes to the Drop Box and sees folders for all students. To focus on the students in Lab 2, she selects &quot;Lab 2&quot; from the sections menu.
<br/>

<br/>
* A TA who is assigned to the Lab 2 section goes to the Drop Box and sees folders only for students in the Lab 2 section.
<br/>
','Students|Instructors','Drop box|Section Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-87','87','Recent Activity (What''s New) Tool','When any user (regardless of type) accesses a worksite, they will have access to a tool which summarizes worksite activity and updates since their last login.  This new tool will list to the user any changes (new or updates) in the following areas:<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-90','90','Migration tool to move data from Blackboard v6(+) to Sakai','As I know Sakai already has a migration tool for Blackboard 5.5. But since Blackboard 5.5 is quite different with v6.3 and v7. I think the migration tool need to be upgraded. <br/>
Our university plans for first pilot during summer semester. We need this migration tool as early as possible. (unfortunatly we do not have resource work on this now) <br/>
We talked about this during Austin conference. Zach Thomas (University of Texa) primary involved the tool development for v5.5. I have a impression seems like the new version tool will be ready by end of 1st Q. Has this been scheduled? <br/>
&nbsp;<br/>
 <br/>
','Sakai developers|Instructors|Sakai administrators',' New Tool|Site Archive (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-93','93','Configure Order of Items in Worksite''s Lefthand Menu','The worksite instructor or maintainer should be able to re-order the worksite menu items, or the worksite''s left-hand menu or toolbar, depending on what you like to call it.  For example, if the instructor wants their course''s menu to be ordered &quot;Announcements, Dropbox, Discussion, Schedule, Assignments&quot; they will be able to rearrange the order to fit that need. 
<br/>

<br/>
Use Cases:
<br/>

<br/>
-instructors &amp; maintainers have control over the &quot;flow&quot; of their course and are not restrained by the global menu properties
<br/>

<br/>
-worksites can have more variety in their appearance 
<br/>

<br/>
-one could place the most commonly accessed tools in a worksite near the top
<br/>

<br/>
-tool order should start in a uniform order, such as alphabetical (REQ-324)
<br/>
','Students|Instructors|Researchers','Site Info|Sites (Admin Site Management)|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-94','94','Change the default name of "Tests & Quizzes" to "Assessments"','There is a desire to change the _default_ name of SAMigo* from &quot;Tests and Quizzes&quot; to &quot;Assessments&quot; in the tool registration configuration file.<br/>
<br/>
The main rationale for this name change is that SAMigo is often used for more generic assessment purposes in non-course sites like surveys. While the default name for any tool can be configured within Sakai, the gravity of a default name can be substantial (there is power in words :) and it is probably better when a default name meets the most, likely uses cases.<br/>
<br/>
A little history on the name &quot;Tests &amp; Quizzes&quot;, so that it doesn''t seem so arbitrary to detractors: before SAMigo was introduced into Sakai 1.5 it had been assumed that SAMigo would be called &quot;Assessments&quot;. However, there was desire from some core schools to better distinguish its name and purpose from the existing &quot;Assignments&quot; tool, so it was &quot;Tests &amp; Quizzes&quot; was adopted to better accomodate that desire.<br/>
<br/>
* For those who might not know the history of the name &quot;Samigo&quot;, this the code/project name of what was originally intended to be the Sakai Assessment Manager (SAM). When it was discovered that a proprietary software already existed, (possibly Significance Analysis of Microarrays <a href="http://www-stat.stanford.edu/~tibs/SAM/)">http://www-stat.stanford.edu/~tibs/SAM/)</a> another name had to be coined. <br/>
<br/>
Well, since the SAM project was the child of the Navigo project: SAM + igo = SAMigo ;)','Students|Sakai administrators|Researchers|Instructors','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-95','95','Percentage based grading','Allow instructors to set up their gradebooks based on percent weighted assigments, rather than (or as an alternative to) the current point-weighted assignments method.<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-96','96','Users should be able to change their username and retain access to user data saved under the old username','When a user changes his username, the user no longer has access to data saved under the old username.  Presently, this is a problem that is not easily solved because Sakai associates user data with the user''s username.  Therefore, to associate the data with a new username, the username would need to be changed for every tool that stores user data. Some of this data is stored in xml blobs, which is not easily accessible.  To resolve this problem, Sakai can associate the user data with a randomly generated ID that is unique to the user rather than the user''s username.  This ID would be related to the user''s username, which would allow the user''s username to be changed in one table.<br/>
<br/>
Requirements:<br/>
Sakai can associate user data with a randomly generated ID that is unique to the user<br/>
Sakai can associate the randomly generated ID with the user''s username<br/>
Sakai administrators can change a user''s username<br/>
User can still retain access to user data saved under the old username when logged in with the new username<br/>
','Students|Sakai administrators|Staff (administrative)|Instructors|Researchers','Account|Database|Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-97','97','Instructors should be able to disable a user''s access to a site without removing the user from the site','An instructor may wish to disable a student''s access to a site for an indefinite period of time because the student has not been participating as expected. It is possible to remove a student from a site when the student has been explicitly added as a site participant. However, for universities which integrate site memberships with official course registrations, the student might be re-added automatically.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* A student has been disruptive in a course site and needs to be blocked from the site. However, while the student remains on the official class roster, he continues to show up as a participant in the site. The instructor disables the student''s access to the site without removing the student, and writes a message to explain why. When the student logs in and attempts to access the course site, he sees the message indicating why his access has been disabled.
<br/>

<br/>
* After meeting with the disruptive student, the instructor re-enables the student''s access to the course site.
<br/>
','Staff (administrative)|Students|Instructors','Sakai Application Framework|Site Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-99','99','Users should be able to restrict access to their profile information','Users should be able to restrict access to their public and/or personal information to site members in a specific role.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* A student wants instructors in his course sites to have access to his personal information (e.g., email address, phone number). He does not want other students to have access to this information, but he doesn''t mind if they have access to his public information (e.g., name, major).
<br/>

<br/>
* An instructor shares her Profile with students enrolled in her courses, but not with the student population as a whole.
<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Profile ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-101','101','Instructor should be able to make schedule items available to the general public','Requirements:<br/>
Instuctor can make a schedule item available to the general public<br/>
Sakai can display a schedule item to the general public that an instructor has made available<br/>
<br/>
&lt;example&gt;<br/>
Perhaps an instructor would like his/her course materials, such as the schedule item to be available to students who may be thinking about taking her class in the future.  By making the schedule items available to the general public, future students would have the chance to review them to determine if this class is the right fit for him.<br/>
&lt;/example&gt;','Researchers|Students|Staff (administrative)|Instructors','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-102','102','More flexible person names must be supported by Sakai','In Sakai''s legacy user services, there are only two name fields for a person: &quot;first name&quot; and &quot;last name&quot;. However, proper name ordering varies widely across cultures, and more name fields may be needed to support proper ordering.
<br/>

<br/>
Sakai applications typically show names in two ways.
<br/>

<br/>
1) As a greeting or other full name display. (This is LDAP''s &quot;cname&quot; or &quot;common name&quot;.) In English and most other European languages, the format is &quot;GivenName [SecondGivenName] FamilyName&quot;. In Chinese, Hungarian, and Korean cultures, the format is &quot;FamilyName GivenName&quot;.
<br/>

<br/>
2) As a sorting field. (For example, in a gradebook''s list of students.) For an English name, the format would be &quot;FamilyName, GivenName&quot;; for a Chinese name, &quot;FamilyName GivenName&quot;.
<br/>

<br/>
With middle names (AKA second given name), prepositions (AKA link names, or family name prefixes), and relationships (e.g., &quot;Jr.&quot;, &quot;III&quot;, &quot;fils&quot;), the rules across cultures become even more complicated.
<br/>

<br/>
Sakai needs to be able to properly display common-names and sorting-names for its users. Specifically, this requirement was entered to support Dutch names.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* A Dutch name such as &quot;Victor van Dijk&quot; needs to be alphabetized as &quot;Dijk, Victor van&quot;.
<br/>

<br/>
* A French name such as &quot;Aimee de L''Aigle&quot; needs to be alphabetized as &quot;L''Aigle, Aimee de&quot;.
<br/>

<br/>
* A Chinese name such as &quot;Wong Kar-Wai&quot; needs to be alphabetized as &quot;Wong Kar-Wai&quot;.
<br/>

<br/>
* A Welsh name such as &quot;John Fitz Gerald&quot; needs to be alphabetized as &quot;Fitz Gerald, John&quot;.
<br/>

<br/>
Technical notes:
<br/>

<br/>
The Dutch and French cases above could be taken care of by adding a field to the existing Sakai user tables and forms. (A less user-friendly workaround with the current DB might be to put prepositional prefixes such as &quot;van der&quot; and &quot;de&quot; in the existing &quot;first name&quot; field.)
<br/>

<br/>
If required, the Chinese case could be taken care of by adding system-wide properties to configure the ordering of given and family names. However, this assumes that all users at a site follow the same naming conventions, which may not be true for all installations.
<br/>

<br/>
The distinction between &quot;middle name&quot; and &quot;prepositional prefix&quot; becomes more important when an honorific combines with the family name. For a Dutch name, it should be &quot;Mr. Van Dijk&quot; rather than &quot;Mr. Dijk&quot;. In that case, it again becomes necessary to configure the orderings.
<br/>

<br/>
A simple approach used by some systems is to store &quot;common name&quot; and &quot;sorting name&quot; directly as separate fields.
<br/>
','Students|Instructors|Staff (administrative)|Sakai administrators|Sakai developers','Account|Global|Profile|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-103','103','Sites browsing needs performance improvements, sorting, and direct links to public content','The legacy tools which browse available sites (including &quot;Worksite Setup&quot; and the Gateway &quot;Sites&quot; tool which shows available sites to visitors) need several improvements.
<br/>

<br/>
1) Performance issues need to be taken care of. (Probably a redesign of some underlying services will be needed to achieve this, since the necessary data is currently spread among different tables.)
<br/>

<br/>
2) Sorting by &quot;Term&quot; must be supported for course sites. (Making this efficient may also require some service redesign, since the term is not currently exposed as a column in the database.)
<br/>

<br/>
3) Visitors should be given a direct link to the public content of a site, if such a page exists.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* An instructor logs in, goes to Worksite Setup, and sorts sites by term in order to find course sites from last fall.
<br/>

<br/>
* A new student visits the institution''s LMS to see what sort of Sociology classes are being offered. Without logging in, she''s able to quickly see a list of this term''s sites. She clicks on the &quot;Public Page&quot; link for one and gets an idea of what''s being done there.
<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Sites (Gateway)|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-104','104','Selected course site sections should be automatically created and maintained based on external roster feeds','Use Cases:
<br/>

<br/>
* An instructor creates a course site whose student membership comes from 3 Lecture sections of Psych 100. She chooses to automatically create and populate corresponding visible user groups in her site. Section aware tools then let her see which Lecture section a student is part of, and let her filter and assign students by Lecture section. As students are dropped from or added to the external feeds, they appear in or disappear from the appropriate site sections. The instructor can use Section Info to add internally managed students and TAs to the site sections.
<br/>
','Students|Instructors|Researchers','Providers|Section Info|Site Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-107','107','Undockable sites','Each site, represented through its tab, should be able to be &quot;undocked&quot; into its own browser window and ?re-docked&quot; back into the window it was launched from','Instructors|Students|Researchers|Staff (administrative)','Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-108','108','Calendar subscription capability','Add to the Schedule tool the ability to subscribe to iCal feeds. This would allow easy addition of academic and school calendars to a Sakai worksite, or any other calendar that supports iCal.  This could also be used to add class meeting times to class sites, and student schedules to My Workspace schedules.','Students|Instructors|Researchers|Staff (administrative)','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-109','109','Search across site and sites','A Search capability is needed that allows searching through all content in a site, or through all content in all sites in which the user is a member.','Researchers|Instructors|Staff (administrative)|Students',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-111','111','Resource Viewer Tool','The resources tool is cluttered because it has everything needed to create new resources and edit existing resources as well as giving hierarchical access to large resource collections. Lots of people want different views of resources.  One common request is the ability to create a list of resources (and possibly other types of entities) related to a particular part of a course or subproject.  If we make the resources tool more like that, we break the hierarchical view.  Instead, we should make a new tool that is intended as a resource viewer.  This tool would focus on making it easier for a site maintainer to create a simple list of resources and format it as they see fit.  The list itself would be read-only.    ','Students|Instructors|Researchers',' New Tool|Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-113','113','Accessibility--Title and Content Frames should be combined','Separate title and content frames create a situation where tool headings are often redundant and navigation is cumbersome. For example, if a screen reader user has his JAWS settings on default, he will hear the following description:
<br/>

<br/>
Beginning of announcements title frame
<br/>
Announcements title frame
<br/>
Help
<br/>
End of announcements title frame
<br/>
Beginning of announcements content frame
<br/>
Announcements content frame
<br/>
Add
<br/>
Merge
<br/>
Options
<br/>
Permissions
<br/>
Announcements heading one
<br/>

<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Portal ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-114','114','Anonymous poll tool','A simple but useful tool is one which can quickly survey opinion on a specific topic - a poll tool.<br/>
<br/>
The tool should provide a simple multiple-choice question, allowing respondents to choose one or possibly multiple options.<br/>
<br/>
Aggregate results are immediately available to participants.<br/>
<br/>
The poll tool should be optionally integrated with discussion (ideally targetted at Message Centre) so that it''s possible to follow a link to a topic / thread about the poll. There may also be other integration points and features, e.g. ability to send an email notification of a new poll, or automatically add an announcement about the poll (with a link to take the poll and/or view results).<br/>
<br/>
Some screenshots from an existing CMS illustrating the basic idea are attached.','Students|Instructors|Researchers','Sakai Application Framework|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-115','115','Online surveys and course evaluations','There are 2 use cases for a tool which can be used for surveys:
<br/>

<br/>
1. Research and collaboration groups using Sakai who wish to survey participants or a broader sample of people online
<br/>

<br/>
2. Course evaluations
<br/>

<br/>
This capability is similar to that currently provided by T&amp;Q, but with some important differences, e.g.:
<br/>
- No correct answer
<br/>
- No references to grading, assessment, etc.
<br/>
- Support for presenting and exporting results in various ways
<br/>

<br/>
It is expected that the easiest way of achieving this would be to extend T&amp;Q.
<br/>

<br/>
Expanded upon by Owen McGrath and edited slightly by Kristol Hancock:
<br/>
In terms of the survey-ish uses cases (e.g., group collaboration, formative or summative course evaluation) there would seem to be an opportunity right away to improve the use interface by optionally hiding references to scores and scoring, as Stephen mentioned. I have also been wondering for a while if it might make more sense to liberate &quot;survey&quot; from being just a question type. It would make more sense to have &quot;survey&quot; as a general assessment type that allows for a wide range of questions types such as Short Answer/Essay, Fill-in-the-blank, and the scale type questions currently offered by the survey question type.
<br/>
','Students|Instructors|Researchers','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-116','116','Users should be given a way to log in and reset lost passwords','When user accounts are explictly added to Sakai, the new user will receive an email with their password. However if a user loses his/her password, there is no way for the user to recover a password (e.g. by having a new one emailed to them).
<br/>

<br/>
This is an important capability which needs to be in core Sakai. Otherwise it creates significant support issues as the guest userbase grows.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* A visiting scholar will be contibuting content to a project site from her own institution. A Sakai user account is added for her based on her email address, and she''s added to the site.  A month later, she''s ready to contribute but no longer remembers her password. After failing to log on, she clicks on a &quot;Forgot Password?&quot; link. After verifying a password reset, she''s then emailed instructions for logging in, with the understanding that she must immediately change her password after logging in.
<br/>

<br/>
Solutions separately implemented by Rutgers and UNISA are described in the comments.
<br/>
','Instructors|Researchers','Account ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-117','117','SMS (text messaging) integration','In a number of countries, a very high percentage of students have cell phones (mobile phones) with text messaging capability (e.g. &gt; 95% of students at University of Cape Town).
<br/>

<br/>
There are many applications for using text messaging to communicate with Sakai users both with the existing &amp; future toolset, for example announcements and notifications, and for interactive learning applications such as submitting content or questions to possible tools such as a FAQ, Glossary tool, Forums or Wiki page by SMS.
<br/>

<br/>
Supporting SMS capability in Sakai requires:
<br/>
- Profile tool to allow students to enter a cellphone number
<br/>
- User preference settings to opt in or opt out of SMS notifications
<br/>
- Integration with (minimally) Announcements and notification service
<br/>
- Site option settings
<br/>
- A service for passing outgoing messages to a gateway
<br/>
- A service for accepting incoming messages from a gateway
<br/>
- Quota management capabilities for setting volume limits for sites and users
<br/>

<br/>
The service and options available need to be flexible enough to cater for inter alia different types of SMS gateways in use, and different business models applicable in different countries (e.g. sender pays, receiver pays, etc.).
<br/>
','Instructors|Students|Researchers|Staff (administrative)','Announcements|Global|Preferences|Profile|Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-119','119','Users should be able to upload a photo in Profile','Presently, if a user wishes to add her photo to her profile, she needs to do the following:
<br/>

<br/>
- Upload an image into Resources
<br/>
- Make the image public (share it)
<br/>
- Add the URL of the image in Profile
<br/>

<br/>
To make this simpler for users, Profile should allow users to upload a photo, rather than specifying a URL. The uploaded image should also be automatically resized for an appropriate display size. Optionally, the original image could be retained along with the resized image.
<br/>

<br/>
Use Case:
<br/>

<br/>
* A TA wants to make his photo available to students, instructors, and other TAs in a course site. He goes to &quot;Profile&quot;, clicks on &quot;Upload Picture&quot;, and selects a JPG file on his desktop. The graphics file is uploaded and displayed to users who have authorization to see his personal information.
<br/>
','Students|Instructors','Profile ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-120','120','Renaming Tools Should be Reflected in Help Documentation','The names of tools in help documentation needs to be configurable to match an institution''s desire to rename tools.
<br/>

<br/>
Use Case:
<br/>

<br/>
* An institution decides to rename &quot;Syllabus&quot; to &quot;Course Outline&quot;.
<br/>

<br/>

<br/>
----------------------------
<br/>
Original Description:
<br/>

<br/>
Two changes to the help tool:
<br/>

<br/>
- The current frames layout is clumsy. Specifically users have to resize the search / index frames when using either one. It would be preferable to have Index and Search as tabs, and a top banner which institutions can brand and customize. [This is more of a Featue Request for an alternate design that a new use case and is being dropped from this requirement.]
<br/>

<br/>
- When institutions rename tools (e.g. &quot;Syllabus&quot; to &quot;Course Outline&quot;), there is no easy way to have that name change reflected in the Help index and documents (or if this capacity exists, it is under-documented).
<br/>
','Students|Instructors|Researchers|Sakai administrators|Sakai developers','Help ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-121','121','Add Hierarchy Capability to the Framework','This will add a generic hierarchy backbone within Sakai and allow sites, and other objects to be associated with theis hierarchy.  The primary end-user visible aspect of this will be the ability to have sub-sites, or sites within sites.  Over time, tools may begin to use the hierarchy capability to organize their own objects.','Sakai developers','Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-122','122','Add IP Filtering to Web Services','Sakai''s web services needs to support the same configurable IP filtering capability as WSRP.
<br/>
','Sakai administrators|Sakai developers','Web Services ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-123','123','Support IMS Enterprise','Sakai should support IMS Enterprise.
<br/>
','Sakai administrators','Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-124','124','Add SCORM Player to Sakai','Sakai currently does not have SCORM support.  For some sites (especially commercial) this is a critical feature for a learning system.','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-125','125','Align Sakai CSS with WSRP/JSR-168 CSS','Currently Sakai has its own CSS - Increasingly as Sakai tools are integrated into portals through WSRP and JSR-168, it will need to inherit the CSS values from the enclosing portal.  ','Sakai developers','Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-126','126','Allow Sakai capabilities to be integrated into non-JSR-168 portals','Create new proxy tools and a virtual portal for WSRP.  This effectively replicates the Sakai JSR-168 portlet capability in a WSRP end point.  The idea is that one can place a WSRP endpoint in a portal and then configure the endpoint to be a proxy for any Sakai site, tool, or page, or even the whole Sakia portal.','Sakai administrators','Portal ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-127','127','Improve support for Hibernate - Move hibernate aspects out of shared/lib','Currently when a component uses Hibernate all of the Hibernate aspects of the component must move into shared/lib because of class loader issues.  This also causes some problems when hibernate based components call each other.
<br/>

<br/>
This will require some careful thought to come up with a solution and then may require all of the Sakai components which use Hibernate to make some modifications to make use of the new pattern of Hibernate usage.  Because of the need for release-wide coordination and the potentially large QA effort, this is something that the community should prioritize.
<br/>

<br/>
This may be combined with an update to Hibernate-3 and possibly a move to the latest Spring version.
<br/>
','Sakai developers','Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-128','128','Moodle Integration','Come up with a strategy, design, and development effort to provide some form of integration with Moodle.  A commonly discussed use case is to allow Moodle to be used from  within Sakai using a variant of the IMS Tool Interoperability approach.<br/>
<br/>
This would allow most of a Sakai site to be Sakai tools, but to be able to have buttons within a Sakai site be Moodle tools hosted on any Moodle server.<br/>
<br/>
The key will be autoprivisioning of identity and roles between Sakai and Moodle.','Sakai developers|Students|Instructors',' New Tool|Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-129','129','Support for Learning Design and other Work Flow Engines (such as LAMS)','Sakai should be able to integrate with learning design and workflow engines. We need to refine the Sakai Architecture (likely the Entity Model) in order to support the workflow needs of a learning design engine such as LAMS or Coppercore.  The requirements these engines have range from discovery of entities, the timed use of entities during Learning Design experiences, and the retrieval of information from entities.
<br/>

<br/>
Use Case:
<br/>
An instructor wants to be able to create a workflow in a Sakai site. Once this support was added they could use a learning design and workflow engine to create a workflow and make it part of their Sakai site.','Instructors|Sakai administrators|Sakai developers','Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-130','130','JSF Widget Cleanup','One of the original visions of Sakai was to delegate much of the implementation of the presentation abstraction to JSF components.  <br/>
<br/>
Many projects have used JSF and used a blend of Sakai widgets and their own widgets.<br/>
<br/>
We need to go through a carful effort of bringing these widgets back together so as to end up with a richer set of Sakai widgets so that we can use widgets across tools.<br/>
<br/>
This is often a daunting task because it is more difficultt to write a highly generic variant of a widget versus one which is used in a single place - so some careful architecting is needed to be done in this effort.<br/>
<br/>
','Sakai developers','JSF ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-131','131','Organize and display resources in topic hierarchies','Some sites may wish to categorise resources according to hierarchical topic categories. Significantly, a resource may belong to more than one topic.<br/>
<br/>
The Resources tool could be extended to support this capability given 2 changes:<br/>
<br/>
- Ability to create a link entry (analogous to a symbolic link on a filesystem) pointing to another resource entry<br/>
- An Resources UI (topic view)<br/>
<br/>
Two screenshots from an existing CMS illustrate this concept. Note in the resource display view (topics-1) that the Resource has been added to mutiple topics.<br/>
','Instructors|Students|Researchers','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-132','132','Link Resources to discussion about that Resource','Currently it is possible to attach a resource to a discussion entry, but not the other way around: when viewing a resource, there is no link to discussion entries about that resource.<br/>
<br/>
This requirement is to add this reverse-linking (preferably targetted at Message Forums).<br/>
<br/>
A typical use case for this would be a student who is reviewing course resources at the end of a course, views a resource (for example an image in Resources) and wishes to review the discussion about that resource which took place somewhere in the discussion forums (which now have a very large number of messages, such that it''s impractical to read through them all again).<br/>
','Students|Instructors','Discussion|Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-133','133','Thumbnails for gallery view of Resources folder','Equivalent functionality to Windows Explorer''s View|Thumbnails, i.e.:<br/>
<br/>
- It is possible to display a set of thumbnails of images in a Resources folder, for purposes of easy navigation and finding the appropriate image.<br/>
<br/>
- The thumbnails should be generated automatically (scaled to an appropriate display size), and then cached for future use (possibly stored with the Resource metadata)<br/>
','Students|Researchers|Instructors','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-134','134','Internationalize all the tools','All the tools in sakai must be localizable without code changes, only adding new resource boundles with localized messages.<br/>
<br/>
A development manual can be created to explain how to make intertionalizable tools.','Sakai developers','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-135','135','Bidirectional email gateway for Message Forums','In many cases, users wish to receive discussion items by email rather than logging in to a website daily or more often. Email Archive provides a way of using email discussion, but is too simple for many applications.<br/>
<br/>
Users should therefore have the ability to participate in Forum discussions as if they were email-based mailing lists, i.e. subscribe to a discussion at various levels (forum, topic or thread). Once subscribed, user''s are sent relevant forum postings. <br/>
<br/>
Each email has an appropriate reply address allowing the user to reply to the message by email (in which case the message is inserted into the forum), and also has links which take the user directly to that thread in the forums tool (subject to the usual authentication).<br/>
<br/>
Users can manage their email subscriptions with the forum tool, again either at a forum / topic / thread level, or by managing a list of all current subscriptions for the site.<br/>
','Instructors|Students','Discussion ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-136','136','Multiple choices of localization','It would be desirable that:<br/>
- A user could choose the localization of their workspace<br/>
- A site admin could choose the localization of the site<br/>
','Students|Instructors','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-137','137','Hierarchy and date ranges for Syllabus','Syllabus currently provides a reorderable flat view of items. In many cases, lecturers wish to group items according to:<br/>
<br/>
1. Theme<br/>
2. Timeslot (e.g. weeks)<br/>
<br/>
Syllabus should therefore be able to support hierarchies (either unlimited or to depth 3), and some relationship of items to dates, for example if an item is a Lecture, it would have a specific day associated with it. If an item is a week (Week 3), it may have a start and end date.<br/>
<br/>
Syllabus item dates could optionally be added to the Schedule (Calendar). The Syllabus display could also be optimized to show current or forthcoming (near future) items, e.g. Current Week, Forthcoming lectures.<br/>
','Students|Instructors','Schedule|Syllabus ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-138','138','Gradebook options to support moderating grades across sections','In large courses (e.g. 500+ students) with many groups/sections and many different people grading assignments (e.g. TAs), institutional assessment policy may require that grades are moderated across groups, i.e. the grading behaviour of different graders should be consistent, and if not, grades possibly adjusted.<br/>
<br/>
To facilitate this, the gradebook should provide a display and export option to produce a table for each assignment showing by group, the TA, and the highest, lowest and average grade given.<br/>
<br/>
This allows a course convenor or assessment moderator to determine if grading has been consistent across groups, and to apply moderation strategies if required.<br/>
<br/>
(The above is in US terminology; in South Africa, grades = marks, TAs = Tutors).<br/>
','Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-140','140','Audio/Video integration','Either through a new tool, or through integration with an existing product such as Horizon Wimba, users will be able to do the following:
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
','Students|Instructors|Researchers',' New Tool|Discussion|E-mail Archive|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-141','141','Electronic Lab Notebook','Either through a new tool or through integration with an existing product, such as Open Source Electronic Lab Notebook <a href="http://www.opensourceeln.org,">http://www.opensourceeln.org,</a> that would allow users (students, instructors, researchers) the ability to keep an electronic notebook of lab experiments:<br/>
<br/>
-users can submit info (kind of like a blog) except no previous info can be changed.  The goal is to create a legal record of lab progress.<br/>
<br/>
-all entries will be date &amp; time stamped and associated with a specific user<br/>
<br/>
-users can attach files to entries<br/>
<br/>
-','Researchers|Students|Instructors',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-143','143','Calendar with GroupDAV capabilities','Use cases:<br/>
- Create/Update/Delete entries inside sakai<br/>
- Create/Update/Delete entries with other tools (like Mozilla Calendar, Evolution ..) with iCalendar via WebDAV<br/>
','Researchers|Instructors|Students','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-144','144','Distributed/Remote tool/components support','Use cases examples:
<br/>

<br/>
- UserDirectory provider situated outside sakai in another computer
<br/>
- Chat tool situated in another computer','Sakai administrators|Sakai developers','Web Services ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-145','145','Ability to hide a folder','In some cases it may be desirable to hide a folder, while still making files inside it accessible.<br/>
<br/>
For example, a course site owner may wish to include various images in the Wiki, but doesn''t want a ''WikiImages'' folder visible to students browsing the site.<br/>
<br/>
Folders (optionally files) should therefore have an attribute which can be set by someone with appropriate permissions on the folder, viz. ''Hidden''. Hidden folders are displayed to users who have update permissions on the folder, but are not displayed to users who have read-only access.<br/>
','Instructors|Students','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-147','147','Add flexibility to Schedule tool configuration','Allow the site''s admin to set:<br/>
- The first day of the week<br/>
- The starting hour of the day','Sakai administrators|Instructors','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-148','148','Improved handling of attachments','Various tools allow attachments to be added (for example to Schedule items or Assignments). At present, these are stored in a separate attachments area, which has various drawbacks including not being subject to the same authentication context as the item to which they are attached, and the quota policies applied to the site in question.<br/>
<br/>
Attachment handling should be revised to address these issues. Storing attachments within the site folder structure within a protected/hidden folder may be a good starting point.<br/>
','Instructors|Sakai administrators|Students','Announcements|Assignments|Attachment Widget|Discussion|E-mail Archive|Resources|Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-149','149','RSS updates publishing','Each tool that generates updates as Resources, Announcements, Assingments ...<br/>
would inform publishing in RSS<br/>
','Instructors|Sakai administrators|Sakai developers|Students','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-151','151','Signup for a specific event within a course and assignment context','Certain courses require individuals or teams to complete tasks in (for example) lab settings, where there are is a limited number of lab spaces available (and/or any other constrained resource, e.g. items of equipment).<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-152','152','Server-wide Usage Statistics','Sakai administrators can use this tool to view statistics of access to the platform:
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-155','155','Administrators should be able to prevent users from unjoining a site','Currently, any user who is added to a site is able to remove themselves from a site via &quot;Unjoin&quot; in the Membership tool.
<br/>

<br/>
It should be possible for administrators to enforce centralized management of site membership by setting a site to be non-unjoinable.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* Membership of a course site is manually administered and should not be changed without notice. When creating the course site, the administrator leaves &quot;Can be joined by anyone&quot; unchecked and checks the &quot;Members cannot unjoin themselves&quot; option. If a student or TA wants to leave the site, they must submit a request.
<br/>
','Students|Instructors|Researchers','Membership ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-159','159','Graphical content in rich text editor','We would like the ability to embed graphical content (in a user friendly way) into a rich editor (HtmlArea) on any tool that uses it.','Sakai administrators|Sakai developers','WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-160','160','User activity information displayed with profile','When viewing a user profile in a site context, it is sometimes helpful to see that user''s contributions to the site, including:<br/>
<br/>
- Messages posted<br/>
- Resources added<br/>
- Assignments submitted<br/>
<br/>
etc. In some cases it may be desirable to have the information available to all site participants (e.g. messages posted) and in other cases only to site owners (e.g. assignments).<br/>
<br/>
The visibility of this information can help in establishing an online community, and in allowing site owners to track participation (esp. in course sites), which can be used for assessment purposes.','Students|Instructors','Assignments|Chat Room|Discussion|Drop box|E-mail Archive|Gradebook|Profile|Resources|Rwiki|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-161','161','TurnItIn integration','Our institution subscribes to TurnItIn''s plagiarism detection services (<a href="http://www.turnitin.com/static/plagiarism.html">http://www.turnitin.com/static/plagiarism.html</a>).<br/>
It can be accessed via a web browser but we''ve also integrated it with our home-grown CMS.  In other words when staff creates an assignment in our CMS it automatically create an assignment in TurnItIn with the same name.<br/>
When students submit to our CMS the papers are automatically also submitted to TurnItIn and when the submission reports from TurnItIn are made available, they are accessible from our CMS.<br/>
Some staff has become so used to this feature, since it is easier and far less work than using TurnItIn directly, which will make the decision to migrate to Sakai a difficult one.','Instructors|Staff (administrative)','Assignments ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-162','162','Calendar provider','We would generally like providers that will allow a hybrid of the following of the calendar in the schedule tool.
<br/>

<br/>
Currently, there is a provider that allows us to have both local users and external users.  We would like the same functionality for the calendar/scheduler, that will allow a hybrid of sakai database events, and externally generated events on the calendar (such as exam dates) even if these events are then read-only.
<br/>

<br/>
Use Case:
<br/>
An item related to a course is added to a campus wide calendaring system. When the students view the calendar for the related course, they see items entered within Sakai and also the campus wide items that are displayed through the provider.','Students|Instructors|Sakai administrators|Sakai developers','Providers|Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-163','163','Instructors should be able to assign site-specific aliases to users','Currently, a user has one ID, one email address, one name, and so on across all sites within a Sakai installation. There should be a way to set site-specific user data which will be displayed instead of the defaults in the context of a given site. In particular, course-site-specific aliases should be able to override a student''s user ID.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* In a Trade Bargaining course, students are assigned country names. For the duration of the course they represent that country in all activities within the course, including voting, chatting, and discussions. In the equivalent course site, students are identified by country name aliases in all tools.
<br/>

<br/>
===
<br/>

<br/>
Original description:
<br/>

<br/>
We have a Trade Bargaining course where students are assigned country names and for the duration of the course they represent that country in all activities within the course. 
<br/>
For the last few years they''ve been using an online environment to do their bargaining, voting, chatting and discussions. Having access to an online environment has become essential to the course and they won''t be able to use Sakai without this feature.
<br/>
The alias should be course specific.
<br/>
Also the students don''t choose their alias, it is assigned to them
<br/>
','Students|Instructors|Sakai administrators','Global|Providers|Sakai APIs|Site Info|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-165','165','Behavior Change for "Release Grades" function','In the current system, if an instructor saves a draft of an assignment he or she is in the process of grading, and then clicks &quot;Release Grades&quot;, the grade is still sent to the student. 
<br/>

<br/>
1. Instructor - create an assignment 
<br/>
2. Student - submit the assignment 
<br/>
3. Instructor - enter a grade and comments for assignment, click &quot;Preview&quot;, then click &quot;Save draft&quot; 
<br/>
4. Instructor - click &quot;Release Grades&quot; 
<br/>
5. Student - grade is displayed
<br/>

<br/>
The desired behavior from our perspective would be for ONLY grades that were RETURNED and not SAVED as a Draft.  It seems that the option to SAVE as a Draft implies that the grading is still in progress and should not be returned back to the student when &quot;Release Grades&quot; is chosen.
<br/>

<br/>
A work around that may give more flexibility to this problem would be to allow the instructor the ability to set preferences for the Release Grades option, such that they can choose to release all grades or only returned grades.
<br/>

<br/>
This was originally bug SAK-3719
<br/>

<br/>
','Instructors|Students','Assignments ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-166','166','Schedule should allow site owner to set view preference','Instructors can set the default view in the schedule tool to something other than ''Calendar by week''<br/>
<br/>
Some of our instructors would like the default view for the Schedule tool to be set to ''List of events'' instead of ''Calendar by week''.','Researchers|Instructors|Staff (administrative)|Students','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-167','167','Schedule should allow author to specify order of schedule items','Our users would like the ability to change the order of the schedule items.<br/>
<br/>
Goals:<br/>
Authors of schedule items can specify the order of schedule items<br/>
<br/>
','Researchers|Staff (administrative)|Students|Instructors','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-168','168','Announcements should allow the author to specify the order','Our users would like the ability to change the display order of the announcements.<br/>
<br/>
Goals:<br/>
Authors of an announcement can change the order of the announcements<br/>
<br/>
instructors want to customize the order of announcements: e.g., have one announcement permanently appear on top<br/>
','Researchers|Staff (administrative)|Students|Instructors','Announcements ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-171','171','Chat should allow multiple rooms per site','Our instructors would like the ability to create multiple chat rooms per site.  With multiple chat rooms, some students could be participating in the chat on Social Behaviors while others could participate in the chat on Famous Psychologists.  Currently, all students must participate in the same chat discussion.<br/>
<br/>
Goals:<br/>
Instructors can create multiple chat rooms in a site to address different topics','Researchers|Students|Staff (administrative)|Instructors','Chat Room ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-172','172','Chat should allow private discussions','I''d like to give a quick use case for this requirement.  At IU, there are several online classes, where the instructor conducts the class directly from the chat room.  In this situation, an instructor might need to speak privately with a student about a particular problem the student is experiencing in class while also conducting class.  This is an extremely common occurrence in these online classes.<br/>
<br/>
Goals:<br/>
Users can chat privately, without participating in the group discussion','Instructors|Students|Staff (administrative)|Researchers','Chat Room ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-173','173','Chat should allow users to search for messages from a particular user','Goal:<br/>
Users can search for messages by name or username','Staff (administrative)|Researchers|Students|Instructors','Chat Room ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-174','174','Allow administrator to view list of user''s sites','Provide administrators with a tool for viewing the list of sites to which a user belongs.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* Often users submit support requests that don''t contain quite enough information to figure out what site a problem was in, such as URL; however, by identifying the sites a user is in, the adminstrator or support staff may be able to identify the problem site.
<br/>

<br/>
* From IU - Often our campus and department admins will receive a trouble ticket for a particular user, that has the course number, but not the section number for the course.  At IU, a course number an be associated with many sections, so it would not be useful to know just the course number if searching by course.  However, if the administrator were searching by username, the course number would be more relevant because most likely the user would only be associated with one course (in the situation of a student).  The become user tool is useful to super administrators, but this tool cannot be given to campus and department admins due to the nature of the tool.
<br/>
','Sakai administrators',' New Tool|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-175','175','Administrator tools should allow administrators to import course materials from/to any site to which they have administrative rights','Goals:<br/>
Administrators can import materials from/to any site to which they have administrative rights without having to join the site(s)','Sakai administrators','Sites (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-176','176','Syllabus should allow user to display syllabus text in plain text','Our instructors are not happy with the way the WYSIWYG displays some of their text and would like the option of displaying the text in plain text, without any applied formatting by the WYSIWYG editor.<br/>
<br/>
Goals:<br/>
Instructors can copy and paste formatted text and choose to display the formatted text in plain text (no formatting)','Instructors|Staff (administrative)|Researchers','Syllabus ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-181','181','Ability to specify the order the assignments are listed ','Our instructors would like to be able to specify the order the assignments are listed ','Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-182','182','Offer option of displaying user''s photo where usernames are typically displayed','There are a variety of tools that display usernames in lists or when viewing single items.  It should be possible to display photos, along with the usernames.  This can help remind folks of who the person is, particularly for instructors who haven''t put names to faces yet early in the term; and, it also provides a nice visual short-hand throught the semester or life-time of the project, if you''re better at remembering who a person is by their face rather than by their name
<br/>

<br/>
Such functionality, however, probably needs to be optional, as some campus will need to disable it site-wide for privacy reasons, some implmentations may support individual user''s decisions to share a photo or not, some project sites might want to enable/disable this on a site-wide basis, etc.
<br/>

<br/>
User Case:
<br/>

<br/>
* Instructor wants to see photo id of student when grading that student''s assignment or assessment.
<br/>

<br/>
* Instructor wants to print out a photo roster of their course to take with them to class to help remind them of who is who
<br/>

<br/>
* Project site participants want to see photos of who created or last modified a Resource in the list, rather than usernames.
<br/>

<br/>
* Photos can be placed next to usernames in the Chat log display area.','Students|Instructors|Researchers|Staff (administrative)','Global|Sites (Admin Site Management)|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-183','183','Sakai should warn a user before the user''s session times out and data is inadvertently lost','Goals:<br/>
User can indicate he/she is still using Sakai before session times out','Researchers|Students|Instructors|Staff (administrative)',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-184','184','Enter all assignment grades for 1 user','The ability to enter in all the grades for a specific user.  This could possiblely be accoplished off the roster screen.  Clicking one of the user''s would take the site author to a screen allowing the ability to enter in grades for all assignments for 1 particular user.   ','Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-186','186','Allow comments for each assigned grade','Allow comments for each assigned grade (ie each assignment). <br/>
<br/>
- Comments would be optionally visable to students as this allows instructors the ability to make private or &quot;public&quot; (to individual students) comments<br/>
- Comments should be imported from applicable tools (Assignments/ Tests &amp; Quizzes) to allow student access to appropriate feedback','Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-187','187','Actions Column in Resources Tool','The Actions column in the Resources tool is problematic for the interface.  Its options are wordy, and it tends to take up a great deal of screen real estate in an area where people would most like to see a description of the item instead.<br/>
<br/>
It would be good to find a more compact (and perhaps graphically intuitive) way for actions to be carried out on items.','Researchers|Instructors|Students','Resources|UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-190','190','Gradebook should accept spreadsheet imports (csv)','The Gradebook currently has the functionality to export  and the next logical step is to accept spreadsheet imports (csv)<br/>
<br/>
Instructors can create new assignment columns in the gradebook by importing spreadsheet data<br/>
Instructors can keep a backup copy of gradebook data<br/>
Instructors that use a spreadsheet for tracking data can make it easily available to students<br/>
Instructors would be able to easily reuse a gradebook from a previous semester in a new one<br/>
','Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-192','192','Test & Quizzes should provide logs of dates/times assessments were accessed or submitted to Instructors','Goals:<br/>
Instructors can view logs of dates/times assessments were accessed or submitted for each student','Instructors|Staff (administrative)|Researchers|Students','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-193','193','Tests & Quizzes should allow instructors to export responses, questions, points earned, total score to CSV or XML file for advanced analysis','Goals:<br/>
Instructors can export responses, questions, points earned, total score to CSV or XML file for advanced analysis','Instructors|Staff (administrative)|Students|Researchers','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-194','194','Tests & Quizzes should provide a printer friendly view of an assessment for an instructor','Goals:<br/>
Instructors can print an assessment created in Tests &amp; Quizzes to give to a student who cannot take the assessment online','Instructors|Staff (administrative)|Researchers|Students','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-195','195','WYSIWYG should include emoticons','Goals:<br/>
Users can include emoticons in WYSIWYG-enabled text boxes','Students|Instructors|Staff (administrative)|Researchers','WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-196','196','Import should allow instructors to replace existing items with imported items','Goals:
<br/>
Instructors can choose to replace existing items with imported items rather than always adding imported items to the data that''s already there.
<br/>

<br/>
(Effectively, this combines cleaning out existing tool data with importing. It implies that tools which support &quot;import&quot; and &quot;export&quot; should also develop support for &quot;replace&quot;.)
<br/>

<br/>
Use cases:
<br/>

<br/>
* An instructor wants to refresh parts of their course site rather than creating a new site. She chooses to import from another site''s Announcements, Assignments, Discussion items, Resource items and Schedule. However, instead of having the relevant data be added to existing items, she selects the tool-by-tool option of overwriting the current data with the imported data.
<br/>
','Students|Instructors|Researchers|Staff (administrative)','Announcements|Assignments|Discussion|Global|Resources|Schedule|Site Info|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-197','197','Instructors should be able to re-use section/group definitions','Many different sites, with different memberships, may share an organizational hierarchy of sections and groups. There should be a way to re-use a set of section or site group names across sites without having to recreate the groups each time. This might be done by importing section/group definitions from an existing site, for example.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* An Instructor is teaching 5 sections of the same class (Speech R110) and he consistently uses the same names for groups in his classes (e.g., Informational Speech, Demonstration Speech, Impromptu Speaking, Persuasive Speech and Commemorative Speech). Each time he creates a site, he imports these group names. The instructor then assigns the new site''s students to the groups.
<br/>
','Students|Instructors|Researchers|Staff (administrative)','Section Info|Site Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-198','198','Gradebook Statistical Display','Provide statistics 
<br/>

<br/>
Provide meaningful statistics on data entered in the gradebook for instructor and student review. Instructors should be able to specify whether or not students have this ability.  This would be something that isn''t displayed initially, but could be displayed. 
<br/>

<br/>
At a glance, Instructors can see how the class is performing.  If students have access, they can compare their performance to that of the class. 
<br/>

<br/>
For students, the instructor should be able to see - at a glance - 
<br/>
1) Running grade as a letter (grade calculated based solely on assignments that have a grade entered -  0 vs null)
<br/>
2) Running grade as a percent
<br/>
3) Total points
<br/>
4) points possible (which could vary from student to student depending on what assignments have entered grades)
<br/>

<br/>
In addition, on an assignment basis the following should be calculated and displayed
<br/>
1) Average
<br/>
2) Highest grade
<br/>
3) Lowest grade
<br/>
4) Standard deviation
<br/>

<br/>
All viewable on the same screen - right now the average can be viewed, but none of the student specific data is there for easy comparison.  ','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-199','199','Sakai should allow instructors to define a parent site and associated child sites','Goals:<br/>
Administrators or Instructors can define a parent site and associated child sites<br/>
Instructors can create non-user related items (Syllabus, Schedule, Announcements, News, Web Content) and those items will automatically be visible in the parent and child sites','Researchers|Staff (administrative)|Instructors|Students','Global|Section Info|Sites (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-200','200','Gradebook Assignment Description Field','Assignment description
<br/>

<br/>
Allow an optional  description to be entered in for an assignment.  Instructors may want a 5 assignments entitled Exam 1, Exam2, ect . . but may want to provide more data on the actual assignment. For instance, Exam 1 covered readings in Chapters 1, 3, 7, ect . . . ','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-204','204','Utilize the home tool to describe what''s new the course or project in a dashboard view.','Allow users to quickly and easily get a snapshot of what has been happening in the site.<br/>
Create a default dashboard layout for site owner to start with and let them decide if they want to customize it.<br/>
Allow the site owner some flexibility in customizing the dashboard so that the most important information for that site is front and center (e.g. if they think recent announcements are most important, then they should be able to make them visually &quot;pop out&quot; at users when they arrive at the site).  <br/>
Help users customize the layout in meaningful way without forcing them to design the page free form.  In other words, ask site owners meaningful questions to determine the site layout  (e.g. what do you want users to notice first when they visit the site?)<br/>
Allow official course information (coming from the registrars office) to be displayed on this page as part of the customization.<br/>
<br/>
In course and project sites, show users relavant information for that site.  <br/>
In ''My Workspace'', by default give users a dashboard view of all the sites they belong to but allow them to &quot;opt out&quot; of sites displaying in the dashboard.  This will help allow them to decide what is most important to them.<br/>
<br/>
','Instructors|Researchers|Students|Staff (administrative)','Home ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-208','208','Consistently use global action action links as tool navigation between pages.  Currently, these buttons have different models in legacy tools and newer tools.','Conistently use global action links as tool navigation between pages.  This will allow users to build a consistent mental model about getting around in Sakai. <br/>
<br/>
Allow users to use the global action links to move around to different pages within a tool in a consistent manner.  Legacy and newer tools act differently.  In new tools, the global action links (at the top of the page) are persistently available and take users to each page within the tool.  In legacy tools there are a variety of results, sometimes they are used for navigation and others times they are used for actions.  The global action links change depending on what on page you are in within the tool.<br/>
<br/>
Analysis will need to be done to understand the models and behaviors in each of the legacy tools and a new design ','Instructors|Researchers|Staff (administrative)|Students','Global|Style Guide|UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-210','210','Add Support for JSR-170 (Java Content Repository)','Sakai should support JSR-170. This would allow Sakai to import content from repositories which are JSR-170 compliant and possibly allow content systems to display Sakai content as well.
<br/>

<br/>
JSR-170 or Content Repository API for Java (JCR) is a specification for a Java platform API for accessing content repositories in a uniform manner. The specification was developed under the Java Community Process. The objective of JSR-170 is to provide a standard content repository API facilitating vendor neutrality and interoperability. JSR-170 specifies a standard API to access content repositories in Java independently of implementation.
<br/>

<br/>
This is a long term effort and will need to be fit in within a sequence of significant framework changes.  The rough approach should be to first evaluate possible solutions/implementations looking at Jakarta JackRabbit or other open source alternatives.','Sakai developers','Sakai APIs ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-211','211','Sakai should support authoring of public web pages','Currently, the public face of a Sakai installation is the special &quot;Gateway&quot; site, and the public face of a Sakai site consists of a few pieces of data shown inside the &quot;Sites&quot; browser. Existing out-of-the-box Sakai tools aren''t well set up to provide the kind of flexibility needed for easy production of &quot;normal&quot; web pages.
<br/>

<br/>
Sakai needs some web content management capability that is nicely integrated into Sakai''s structure and organization.
<br/>

<br/>
Sakai should be able to produce an organization''s public pages in addition to private site-oriented and personal pages.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* The installation administrator creates a set of publicly accessible HTML pages describing their organization, including uploaded graphics. Visitors to that Sakai deployment see those pages before logging in.
<br/>

<br/>
* An instructor creates a course site and then adds a publicly accessible page, giving an overview of the course and providing links to interesting publicly accessible resources on the site. Non-site-members browsing the list of active sites see a link to that course site''s public page.
<br/>

<br/>
===
<br/>

<br/>
Original description:
<br/>

<br/>
The Gateway page is pretty lame in general.  This is one of the reasons that Sakai cannot be used to support <a href="http://www.sakaiproject.org">www.sakaiproject.org</a>.  Sakai needs a content management capability that is nicely integrated into Sakai''s structure and organization.
<br/>

<br/>
The basic use case is to use Sakai to produce an organization''s public pages in addition to the private site oriented and personal pages.
<br/>

<br/>
Some technologies to consider include <a href="http://incubator.apache.org/graffito/">http://incubator.apache.org/graffito/</a> and <a href="http://hypercontent.sourceforge.net/">http://hypercontent.sourceforge.net/</a>.','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators|Sakai developers',' New Tool|Gateway|Site Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-212','212','Search for users widget','Sakai should provide support for a consistent &quot;user search&quot; widget.  This widget would allow users to search for other users and user-related information, where such information needs to be input in a tool; for example, finding users in order to add them to a site.  The searchable content and results should be able to include any basic user information that is stored in Sakai or to which Sakai has access through an external provider; however, it may only be necessary to present a sub-set of that information in any given search context.  The sub-set may also need to be limited based on the searcher''s role and/or site type in order to satisfy privacy concerns.  The results of the search should also enable the seacher to easily choose a user or group of users(or the context-appropriate piece of user information, such as email address) and use it as input for the tool.
<br/>

<br/>
Use cases:
<br/>

<br/>
* When adding users to a site, you may know the user''s name or only part of their name, but not their username, and you need to search a directory of users to find the username.  Once you have it, you want it entered into &quot;add user&quot; field.
<br/>

<br/>
* Similarly in Section Info you may need to search for users for which you only have partial information to add them to a section.
<br/>

<br/>
','Researchers|Students|Instructors|Staff (administrative)|Sakai administrators|Sakai developers',' New Tool|Membership|Profile ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-213','213','Schedule should allow for creating new items in the context of the calendar.','Allow users to choose the date and time of an event in the context of the calendar (like most calendar systems).
<br/>

<br/>
Allow users to drag events around on the calendar to change the date and time of the event.
<br/>

<br/>
Allow users to change the duration of an event by directly manipulating the event on the calendar.
<br/>

<br/>

<br/>
Another requirement from UC Berkeley with Essential priority (within one year):
<br/>

<br/>
&quot;Currently the schedule tool requires users to navigate to a separate window to enter a new calendar event. The norm in many calendars is to click and drag to select the duration of a meeting, or double-clcik a timeframe in the calendar interface to begin adding or editing an entry.
<br/>

<br/>
The schedule tool should allow users to click the time the wish to schedule an event to bring up an editing window.
<br/>

<br/>
This is similar to functionality available in other calendar tools like iCal, Outlook, and Oracle.&quot;
<br/>

<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-214','214','Release widget that allows content created or posted in Sakai to be ''hidden'' until user specifies','Allow users specify a release date for material they post or create in Sakai.  The material is not available to site members until the release date. 
<br/>

<br/>
Allow users to set a date when site material (as they post or create it) is no longer available to site members.
<br/>

<br/>
This functionality is needed in any Sakai tool that that allows content to be posted or created,  like resources, assignments, announcements, discussion items, etc..  For efficiency, the functionality should be a widget that can be added to tools as needed.','Instructors|Researchers|Staff (administrative)|Sakai administrators|Students',' New Tool|Announcements|Assignments|Discussion|Global|Resources|Schedule|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-215','215','More detailed synoptic views in My Workspace','It would be helpful for individuals to be able to see more overviews of site activity and items in My Workspace, including:<br/>
<br/>
- Open/available assignments and assessments (T&amp;Q) across all sites<br/>
- Grades across all sites<br/>
- Participation info across all sites (e.g. messages posted by me in all sites)<br/>
','Students','My Workspace ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-216','216','Glossary tool','In some disciplines and courses, getting to grips with new terminology is difficult for students.
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
','Students|Instructors',' New Tool|Melete');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-217','217','Samigo Import Images Using IMS QTI','Ability to import questions in IMS QTI format that contains images
<br/>

<br/>
At the moment one is able to import questions into Samigoin QTI format. The problem is that if there are images associated with the question then there is way to import the images as well, or rather keep the link between questions and images.
<br/>

<br/>
There are quite a few issues logged in Sakai and Samigo which deals with importing questions into Sakai but I have not seen this listed as a requirement here.
<br/>
','Instructors','Samigo - Authoring ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-218','218','Integration with Respondus','Respondus  (<a href="http://www.respondus.com/">http://www.respondus.com/</a>)  is a program one uses in creating and managing exams that can be printed to paper or published directly to Blackboard, WebCT, eCollege, ANGEL and other eLearning systems.
<br/>

<br/>
i.e. you can create quizzes in Respondus, connect to your CMS from within Respondus and upload the questions to a particular course. You can also download questions and quizzes from the CMS.
<br/>

<br/>
It also has the ability to export quizzes in IMS QTI format. 
<br/>

<br/>
Our stats department are heavy users of Respondus and if it possible to have the same ability to upload questions/quizzes directly to Sakai it would make the migration easier.
<br/>

<br/>
Going the IMS QTI route is possible, but only if the questions do not contain images. This is filed under another requirement.  (REQ-217)
<br/>

<br/>
Also see <a href="http://bugs.sakaiproject.org/jira/browse/SAK-1891">http://bugs.sakaiproject.org/jira/browse/SAK-1891</a>','Instructors','Samigo - Authoring ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-220','220','Calculated questions','At the moment the calculated question type is missing in Samigo, i.e. the ability to have questions which contains variables,  a method of setting the range of those variables and the number of questions to be generated of that type.
<br/>
eg. what is {x} + {y} where  0 &lt; x &lt; 100 and 0 &lt; y &lt; 50 
<br/>

<br/>
i.e., integration with equation editors.','Instructors','Samigo - Authoring ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-221','221','Need easliy configurable grade scales and mechanism to present a given scale to instructor in a particular site','The gradebook supports a letter grade scale currently that is hardcoded. An institution will want to use scales appropriate to their institntuion which may be different. There may be many scales, each used for a different type of course site (e.g., each school may have a different scale, or there m ight be a scale used for freshman classes different from sophmore, or different scales between Lecture and discussion sections, etc.).   There needs to be an easy way to add scales to gradebook, perhaps via sakai.property settings. <br/>
<br/>
','Students|Sakai administrators|Instructors|Staff (administrative)','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-222','222','Administration of site roles and permissions needs UI and performance improvements','Currently, Sakai administration is divided between Users (for managing user accounts), Realms (for managing role-permission-user mappings in a site or template), and a set of overlapping site management tools including Site Info, Sites, and Worksite Setup (for browsing sites, creating a site, attaching roster feeds to a course site, setting up tools for a site, adding members to a site, managing ad hoc user groups, and importing content). (Course sites also have Section Info.)
<br/>

<br/>
Legacy user and site tools are addressed elsewhere. The administrative functions of Realms also need improvement.
<br/>

<br/>
1) Performance is slow when there are a large number of sites.
<br/>

<br/>
2) There''s no direct relationship between a site''s realm and the site. Instead, the site ID is buried in the realm name. There needs to be easier ways to locate the desired realm. For example, site metadata such as term, title, and created-by might be included as sortable or searchable columns in the listing.
<br/>

<br/>
3) There should be some direct UI link between the sort of administrative functions in the site management tools and the sort in Realms.
<br/>

<br/>
===
<br/>

<br/>
Original Description:
<br/>

<br/>
Improve admin tools:
<br/>

<br/>
* improve performance; response time is often slow when the system contains a large numbers of sites
<br/>

<br/>
* improve search capabilities
<br/>

<br/>
* improve sorting/filtering capabilities
<br/>

<br/>
The admin tools are often slow when the system contains large numbers of sites. It is hard to find a realm when only some part of the site name is known - site and realm tool each contain search functions that would be useful in the other or are missing useful search capabilities (search for a realm by knowing part of a site title for example, or search for sites a user has created). We need to be able to sort/filter by term in the admin in the admin tools as well.
<br/>
','Instructors|Sakai administrators|Staff (administrative)','Realms (Admin Site Management)|Sites (Admin Site Management)|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-224','224','Add feedback/rating capability to Help tool','A feature on each help page to rate the helpfulness of the content will help improve the quality of help documentation.
<br/>

<br/>
The current rating of each help item should be visible on each page (after it has been rated by that user, or if the user is an admin).
<br/>

<br/>
Use case:
<br/>
Admins want to know whether the help documents are arranged well (for user searching) and if the information in them is relevant and helpful. Users could rate the help and admins could view a summary of these ratings to find the help pages that need to be improved.','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators|Sakai developers','Help ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-225','225','Order tabs by site types, and for course sites, by term','Even with the ability for users to order and hide tabs, there still is the frequent request to put current course site tabs first.  As new term sites are created and a user becomes a participant, the new term sites should rise to the top of the user''s preference list. The preference list of all sites should be ordered by term to make it easy to hide a term''s course sites. Sites which are not associated with a term (e.g., project, or GradTools sites) can be in a separate group in that list.','Students|Instructors|Researchers|Staff (administrative)','My Workspace|Tab Management ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-228','228','Schedule tool export and syncing','Schedule tool needs to be enhanced to allow exporting to common formats. <br/>
It needs to allow syncing with other calendars as well, so that importing calendar from another tool a 2nd time doesn''t add duplicate events. ','Sakai administrators|Researchers|Staff (administrative)|Students|Instructors','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-229','229','Tool reset','It would be useful in tools like Chat, Discussions or others to erase all<br/>
messages, a kind of reset to the initial state.','Instructors|Researchers','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-230','230','Administrators need a better UI for user management','The legacy Users tool sorts user accounts only by their Sakai user ID. Paging is handled in the legacy CHEF way rather than according to the Style Guide.
<br/>

<br/>
The UI should be updated to support the following features:
<br/>

<br/>
- Order the list by name, email or type (acending or descending)
<br/>
- Search by name, email or type
<br/>
- Select the number of items per page
<br/>
','Instructors|Sakai administrators','Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-231','231','Search in resources','Include a search feature in resources tool<br/>
<br/>
Use cases:<br/>
<br/>
Searching by:<br/>
<br/>
- Author<br/>
- Last modified date<br/>
- Title<br/>
- File type','Students|Researchers|Instructors|Sakai administrators','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-232','232','Resources - greater granularity for permissions','Would like to be able to set permissions on folders to:
<br/>

<br/>
1. hide a folder from all students
<br/>

<br/>
','Students|Instructors|Researchers','Permission Widget|Realms (Admin Site Management)|Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-234','234','Paging description for List Navigator needs to better explain what to do at boundaries','This was implemented in Sakai in r5861 (post-2.1.1).  So this requirement is really just for the New Tools now; and, if we are going to use the Style Guide or something similar going forward, then it should include a description of this aspect of the paging process.<br/>
<br/>
<br/>
Original Description:<br/>
For the List Navigator a better description of what should happen as one pages through a list and hits a boundary is needed.  The current beahvior in most circumstances is that when you are viewing 20 items at a time from a 33 item list Next will move you from viewing 1-20 to viewing 14-33.  Preference has been expressed for it behaving otherwise and making the boundaries firm so you are not seeing items on multiple pages; view 1-20 and then view 21-33.  No preference has been expressed yet for keeping it the way it currently works.<br/>
<br/>
This requirement should apply to both paging JSF widget and the style guide definition.','Students|Researchers|Instructors|Sakai developers','Global|JSF|Style Guide ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-236','236','Assignment tool improvements','Feature enhancements on Assignment tool:
<br/>
- in addition to batch download of all submitted assignments, one prof. requested the ability to batch upload the graded assignments
<br/>
- students need a way of confirming that the assignment that they''ve submitted has been saved intact in the system
<br/>
','Students|Instructors','Assignments ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-237','237','Documentation:  Need to write an architecture document on the Sakai Event Mechanism','In the docs/architecture areas of Sakai there is a set of documents aimed at developers and deployers of Sakai.  We need a document which describes the Sakai event system.
<br/>

<br/>
This needs to cover how Events work and are distributed throughout the system.  Also this needs sample code showing how developers can make use of the event system.
<br/>

<br/>
Event applications which use the Courier also must be described as well as how to create a daemon to listen for events.
<br/>

<br/>
Use Case:
<br/>
A developer which is new to Sakai wants to write code which uses the event system. This documentation would explain how to get started with simple examples and would include details about all aspects of the event system.','Sakai developers','Documentation (other than Help)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-238','238','Documentation: Need to write an architecture describing how notifications operate','Need to document the Sakai notification system. This would be a document describing the Sakai Notification mechanisms and how to hook new applications into the Sakai Notification System.
<br/>

<br/>
Use Case:
<br/>
A developer wants to write some code that uses the sakai notification mechanisms. They would be able to check these documents for examples and detailed information about the notification system.
<br/>
','Sakai developers','Documentation (other than Help)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-239','239','WYSIWYG improvements','WYSIWYG editor could be improved by adding:<br/>
- browse function for locating images (currently requires input of a URL)<br/>
- ability to use style sheets, either locally on individual HTML pages saved in Resources or globally within a course site (WYSIWYG currently strips style definitions from HTML files saved within Resources)<br/>
- capability of parsing MS Word .doc styles when copying-and-pasting in WYSIWYG to create new HTML resources (esp. in the Syllabus tool)','Instructors','WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-240','240','Documentation: WSRP Architecture Document','We need an architecture document that describes how WSRP is architected and how it works in Sakai.
<br/>

<br/>
WSRP (Web Services for Remote Portlets) is dynamic plug-ins for portal pages. WSRP defines how to plug remote web services into the pages of online portals and other user-facing applications. This allows portal or application owners to easily embed a web service from a third party into a section of a portal page (a ''portlet''). The portlet then displays interactive content and services that are dynamically updated from the provider''s own servers.
<br/>

<br/>
The docs should be located in docs/architecture and included in the Sakai distribution. Developers would be able to reference these when working with WSRP in Sakai.','Sakai developers','Documentation (other than Help)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-243','243','Documentation: Need web services architecture document','This document needs to provide an overview of how web services work - their general model and patterns and how to creat new web services and modify existing web services.
<br/>
This should also have a section on web services security.
<br/>

<br/>
A Web service is a software system designed to support interoperable machine-to-machine interaction over a network. It has an interface described in a machine-processable format (specifically WSDL). Other systems interact with the Web service in a manner prescribed by its description using SOAP-messages, typically conveyed using HTTP with an XML serialization in conjunction with other Web-related standards.
<br/>

<br/>
Web services are a specific type of application built on an architecture that offers the promise of allowing any client to work with any server, anywhere in the world. Getting computers to speak with one another has been a goal of programmers ever since the second computer was built. RPCs. or Remote Procedures Calls, have been used for many years, but RPCs are mostly are &quot;tightly-coupled,&quot; built specifically for applications on specific platforms and in specific languages. Any changes made on either end may create havoc on the other end. &quot;Loose coupling&quot; refers to a relaxed dependency between two applications. Web services provide a loosely-coupled way of communicating between two programs.
<br/>

<br/>
These documents should be located in docs/architecture to allow easy access for developers.
<br/>
','Sakai developers','Documentation (other than Help)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-244','244','Adjust calendar display to show  ''More...'' indicator if there are schedule items beyond current timespan being viewed','When there is a schedule item that occurs later in the day than the default view for the Weekly view is present, there is no indicator to show the person that there is a scheduled event for later in the day. I can look at the schedule for today and see that I have nothing on my schedule, even if there is something scheduled for 7:00pm, there is nothing to indicate that I should scroll down to see that something is there. I do see it, however, when I do a monthly view.','Students|Researchers|Instructors|Staff (administrative)|Sakai administrators','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-245','245','Display modified date on DropBoxes to show when new content has been uploaded','Right now, the date on the drop box folder reflects the create date. Is there a way for it to show the last time something was uploaded to the folder so an instructor would know that a student put something in there?<br/>
','Staff (administrative)|Sakai administrators|Researchers|Instructors|Students','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-246','246','Format loss when saving post sent from Email Tool to Email Archive','Email sent from the Email Tool typically contains paragraph breaks.  This formatting is transmitted properly to individual email recipients, but is lost when saved automatically in the Email Archive.  As a result, archived messages are often impossible to read (one huge paragraph).  ','Students|Instructors','E-mail Archive');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-247','247','Need a way to delete dropboxes more easily when ''shoppers'' drop a course','Our students often ''shop'' many courses at the beginning of the semester, leaving behind their DropBoxes when they do not sign up for a course.  The mess left for the instructor to clean up is problematic.<br/>
<br/>
The instructor has to print a list of ''registered'' students for the course, then go to DropBoxes and delete any non-registered students.<br/>
<br/>
Is there a way to flag a certain ''role'' of site member that can then purge the dropboxes and leave the other dropboxes intact?','Instructors|Sakai administrators','Drop box ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-248','248','Need better way to control order of ''pages'' on a site','When new tools are added to a site, the site order changes from alphabetical to a seemingly random order.<br/>
<br/>
We are currently using siteorder.xml to force the order of tools in a site, but this leaves out the ability for our users to custom order the tools on the page.  Maybe an ordering column could be added to the sakai_site_page table to allow the site admin to specifiy the order in which something will appear on the page, so that sites could order items more logically.','Researchers|Sakai administrators|Instructors|Staff (administrative)','Presentation ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-249','249','Scheduling tool','This may be a new tool, but have a way to set up appointments between the student and the instructor via some sort of scheduling tool.<br/>
<br/>
The instructor would need to set ''office hours'' on the calendar and students could sign up for blocks of time.','Students|Instructors',' New Tool|Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-250','250','Synoptic view of gradebook in My Workspace','Some tools in My Workspace collate all submissions from specific sites (e.g., Schedule in My Workspace lists all site-specific schedule items), but there is no such version of Gradebook.  Students taking several classes may wish to scan all gradebooks at once to find new entries, rather than going site to site.','Students','Gradebook|My Workspace ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-252','252','Ability to set Web Content tool as pop-up when tool is added to site ','When adding a new web content tool to a site, add the ability to set it as a ''pop-up'' window instead of having to change the ''Options'' after the tool is created.','Instructors|Researchers|Staff (administrative)|Sakai administrators','Web Content ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-253','253','Assessment Tools should integrate with other Sakai Tools (i.e., Announcements, Schedule)','From REQ-235:
<br/>

<br/>
- simple way for instructors to announce a new assignment; provide a link to the assignment in the body of the announcement; and populate the assignment on the Schedule tool
<br/>

<br/>
Assignments does this mostly; it would be nice to have a direct link to the Assignment in the body of the Announcement.  Tests &amp; Quizzes (Samigo) should do this too, as should any new, appropriate assessment tool added to Sakai; in other words, this could be a requirement for provisional tools.
<br/>
','Instructors|Students|Researchers|Sakai developers','Announcements|Assignments|Schedule|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-254','254','Case sensitivity of answers','Most answers don''t need to be case sensitive.  However, I teach chemistry and when dealing with elements, case senstivity is important.  &quot;Ho&quot; is the element holmium and very heavy, &quot;HO&quot; is the hydroxide radical and a very different beast.  I need to be able to distinguish between these.','Instructors|Students|Sakai developers','Samigo - Authoring ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-255','255','appointment sign-up capability for Schedule tool','Several faculty have wanted to use the Schedule tool to:
<br/>
- allow students to sign up for slots during office hours
<br/>
- allow students to sign up as discussion leaders for certain weeks during a seminar.
<br/>

<br/>
In both cases, it would be nice to have permission granularity within the Schedule tool to allow the site owner to designate certain blocks of time for which students would have &quot;revise&quot; capability.  This way, students could modify only certain events in the schedule, rather than having global write or revise permissions in the tool.
<br/>

<br/>
Also it would be nice if this revise permission was in effect only for blank fields: once a student has signed up for a slot, others would not have the ability to revise that selection.  Only blank fields in the designated time blocks could be &quot;owned&quot; by students with revise or write permission.
<br/>

<br/>
Finally, for the office hour option, it would be nice if students'' displays of the Schedule list only their selected time slot, not every other student''s slot.  A lot to ask, I realize; perhaps this type of scheduling tool should be a new tool, which could then export information into the main class Schedule.    ','Students|Instructors','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-256','256','Terminology of the Email Notification Options in Announcements','The email notification options are a little confusing to the end user, &quot;all participants&quot; could mean of a particular space or bspace.  Change the terminology on the preferences.  Make it easier to customize this notification.  Make the preferences apply per site not for the entire user site.  ','Students|Instructors|Staff (administrative)','Announcements|Preferences ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-258','258','All tools should indicate new changes.','All of the tools should indicate what new changes have been made on the home page where all announcements are.  For example if 2 new resources have been added then the frontpage section for resources would indicate those resources have been added.','Instructors|Students','Assignments|Discussion|Resources|Syllabus|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-259','259','No notification if there have been new resources added.','Provide an indication of resources that user has viewed already.  There should also be a function that highlights new resources that have been added on the homepage of the site.<br/>
','Students|Instructors','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-260','260','Name changes for MyWorkspace collating tools (Schedule, Resources, etc.)','We''ve had a number of users mistakenly upload materials to their personal Resources area, in MyWorkspace, thinking that they were putting them in a course site Resources.  It could be nice to have the option of renaming the tools in MyWorkspace so that they''re not identical to the names of the tools in course sites -- this could help avoid some confusion.  ','Researchers|Instructors','My Workspace ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-262','262','Instructor puts everything in resources, not helpful','The resources section becomes too cluttered when there is a lot of material that has been added.  Need a way to better organize resources. ','Instructors|Researchers|Students','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-264','264','Copyright status - what if prof. is unsure, what goes in "copyright info" box?','Option on choosing copyright status is not clear for professors.  Change the default to be ''Material is subject to fair use'' there is a link to more information - maybe the choices in the drop down should be defined in that link.  <br/>
<br/>
This should be configurable per each institution.','Researchers|Instructors|Students','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-265','265','Include a print option for all tools.','It is important for students to have an option to print any assignments or resources because reading from a computer screen is not desirable for everyone.  Similarly, Instructors and Researchers may prefer to print out reading material.','Researchers|Staff (administrative)|Instructors|Students','Announcements|Assignments|Discussion|Drop box|Resources|Syllabus ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-268','268','Need for "Melete-like" Rich Content Authoring Tool for Fully Online Courses','Please excuse any ignorance as I''m still a bit of a &quot;newbie&quot; at this point in time...<br/>
<br/>
Marist College is currently in a production pilot with Sakai (called iLearn at Marist) with one of our many fully online programs.  From this experience, it is clear to us that having a &quot;Melete-like&quot; tool that allows our faculty to create &quot;rich media&quot; content for online delivery is critical.  <br/>
<br/>
My understanding is that most of the &quot;core institutions&quot; have historically not been heavily involved in offering fully online courses and have primarily used their CMS capabilities to supplement/enhance face-to-face courses.  I feel that this has driven the requirement process towards tools and functionality that is needed in this context of use.  Although there is a good deal of overlap between tools sets needed for fully online and &quot;web-facilitated&quot; courses, I feel that there are some difference as well.  This area is one of them.<br/>
<br/>
Although the capabilities of the Resource Tool is great, we need more than just a place to upload and download files.  Instead, we need a tool that allows faculty to place an &quot;instructional wrapper&quot; around those files and digital content that is upload so that the students have a full and rich learning experience in their online courses.<br/>
&nbsp;','Students|Instructors','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-274','274','Assignments should accept resubmissions.','Currently instructors can only change the option to accept resubmissions after they have already received a submission from a student.  This option should be moved so that when an instructor creates an assignment they can set whether or not they will accept resubmissions.','Students|Instructors','Assignments ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-277','277','K-12 Tools','So far, I have not heard too much discussion about using Sakai at the K-12 level but we, at Marist College, believe there is great potential in this area.  We have had some discussions with K-12 groups in our state and are hoping to collaborate with them on some pilot activities next school year.<br/>
<br/>
In talking with these initial contacts, it has become clear that there are additional functionality needs at the K-12 level that would be important to have before Sakai could penetrate too far into this &quot;market&quot;.  One that has surfaced in our discussions is a &quot;test and quiz&quot; tool that was adapted for K-12 needs (e.g. allowed school wide reporting, supported connections to state standards and school district curriculum benchmarks, etc.).','Students|Instructors','Samigo - Authoring|Samigo - Delivery|Samigo - Global|Samigo - Grading|Samigo - Question Pools ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-281','281','make calendar event frequency more flexible','Currently, the Schedule tool does not allow users to add events that occur every Monday/Wednesday or Tuesday/Thursday. Additionally, you cannot set an event to happen every third Thursday of the month.<br/>
<br/>
The system should allow the user to choose the frequency of an event with some flexibility. <br/>
','Researchers|Instructors|Students|Staff (administrative)','Schedule ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-282','282','Users should have more information and control over site import','The import functionality in Sakai site management tools is too opaque. The site administrator can pick a site and some tools, but there''s no indication of what the effect will actually be. The import service and interface should support finer granularity. Tool-specific code should give some indication of what sort or amount of data would be imported. In some cases, such as Resources, it may make sense to give the user control over which portions of data will be copied.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* An instructor creates a new course site for Chem 101 and wants to reuse material from the previous term''s site. She selects &quot;Import from Site&quot;, selects the old site, and sees that a Resources import will bring in 3 folders with 120 items, an Announcements import will bring in 0 announcements, and a Tests &amp; Quizzes import will bring in 50 assessments.
<br/>

<br/>
===
<br/>

<br/>
Original description:
<br/>

<br/>
From Site Info there is an option for &quot;Import from site.&quot; The system gives no indication that there are resources to import. Even if there is a resource to import it doesn''t tell you its been added nor does it give you a choice of resources you want. It just comes back to Site Info. Need a way to tell if there is something in there to add and then notification that something was added. Confirmation similar to the add/ remove tools. ''You have added 6 items.''
<br/>
','Students|Instructors|Researchers','Site Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-283','283','Student View should exist for all Instructor documents to be viewed by students','Instructors should have the ability to see the student view of all the items that will be viewed by students.  For example assignments, syllabus, resources, etc.<br/>
&nbsp;','Sakai developers|Sakai administrators|Instructors','Assignments|Gradebook|Resources|Syllabus ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-284','284','Gradebook should be able to show categories and weigh them accordingly','Letter grades in Gradebook do not reflect curves used by instructors.','Instructors|Students','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-285','285','Legacy tools should not save state.','When someone enters information into a form the state should not be saved when they go to another tool.  ','Staff (administrative)|Researchers|Instructors|Students','Announcements|Assignments|Discussion|Drop box|Resources|Syllabus ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-286','286','Gradebook should provide the ability to create categories of assignments','Goals:<br/>
Instructors can create categories of assignments (e.g., Exams, Homework, Attendance)<br/>
Instructors can assign a total number of points or a percentage (REQ-202) to a category <br/>
Sakai will equally distribute the points or percentages amongst the assignments associated with that category','Students|Instructors|Staff (administrative)','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-287','287','All tools included in the Sakai ''bundle'' should be fully integrated with one another','Our faculty have the expectation that tools should be fully integrated or &quot;aware&quot; of data entered within a course or project site.  While some of the tools in the Sakai bundle are integrated (like test &amp; quizzes is with gradebook) many of them are not.  For example, neither of the assignments tools can make an assignment automatically show up in the syllabus tool, or even in the test &amp; quizzes tool.  Another example is that items in the Test &amp; Quizzes tool do not show up in the schedule or the syllabus.','Students|Instructors','Assignments|Gradebook|Samigo - Authoring|Schedule|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-289','289','Student site tab names should be based on their section names rather than the course site name','When Sakai supports external feeds for course site sections, Sakai should identify the site to students by the name of their section rather than by the name of the site.
<br/>

<br/>
Use Cases:
<br/>

<br/>
* An instructor has created a course site &quot;Cognitive Science Frontiers&quot;. Two externally managed rosters are feeding site membership, one for &quot;Psych 212 LAB 01&quot; and the other for &quot;Phil 312 LEC 02&quot;. Both have site sections associated with them. When a student from Psych 212 logs onto Sakai, he sees a tab labeled &quot;Psych 212 LAB 01&quot; rather than a tab labeled &quot;Cognitive Science Frontiers&quot;.
<br/>

<br/>
(I''m not sure this captures the requirement. See comments.)
<br/>

<br/>
===
<br/>

<br/>
Original description:
<br/>

<br/>
Sakai should allow instructors to combine rosters of two or more sites
<br/>

<br/>
Goals:
<br/>
Instructors can combine the rosters for two or more sites
<br/>
Sakai will display combined rosters as separate sections in a site
<br/>
Students tab will indicate the course and section number of the site for which he or she signed up, not the site from which the instructor is delivering the combined content.
<br/>
','Students|Instructors|Staff (administrative)','Roster|Section Info|Sites (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-293','293','Have Syllabus option to either upload file, redirect, or fill out form','Professors need to have a clear indication of options for syllabus creation. Distinct options for either uploading a file, redirecting, or filling in the form. ','Staff (administrative)|Researchers|Instructors|Students','Syllabus ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-294','294','Need to be able to accept media files','Not able to link directly with the podcst rss feeds.  Instead, you are directed to webcast page and then have to choose link from there.','Students|Instructors','News (RSS)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-296','296','in year view, remove the dates from a previous month','In the Schedule tool, in the year view, the days from a previous month appear in gray. This is nice. The issue is that the numbers for the days in the previous month also appear. This makes it seem like there is an event on that day.<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-297','297','The HTML editor used across many Sakai tools needs to be improved and must work well across the most popular/used browsers','The HTML editor that is used across many Sakai tools must be improved, offer more capabilities than it currently does, and work consistently across the most popular browsers in use today.  Faculty on our campus would like to be able to cut and paste complex html code (that they have previously developed) into Sakai assignments and have them render appropriately.  There is no way to tell what part of the cut and pasted code, is causing the problem, therefore an additional capability needed is some sort of html &quot;debugger&quot;.  As for being compatible with other browsers, the html editor in Sakai does not work well on Internet Explorer.','Instructors|Researchers|Staff (administrative)|Students','WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-298','298','Apply style guide to worksite setup','The style guide should be applied to Worksite Setup<br/>
<br/>
This was initially reported at UC Berkeley with regard to the Worksite Setup. Instructors and staff were confused about the checkboxes in Worksite Setup because they are so far away from the action buttons. If the style guide were applied, the page would have the following changes -- <br/>
<br/>
(1) checkboxes would move to the right side of the page in a Remove column<br/>
(2) a revise link would appear under each item (this could be changed in the style guide so clicking the item automatically brings up an editable window)<br/>
(3) the add button would remain at the top of the page. ','Researchers|Instructors|Staff (administrative)','Site Info|Style Guide|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-299','299','clicking the name of a site in Worksite Setup should direct user to Site Info ','In Worksite Setup, users can click the title of any course or project site in their account. The expectation is that this will bring up the Site Info window for that course or project site. Instead, it navigates the user to the Home page of the site. This is confusing.<br/>
<br/>
Change the link in Worksite Setup so clicking the name of a site leads a user to the Site Info page for that site.','Students|Staff (administrative)|Instructors|Researchers','Site Info|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-300','300','All content authoring tools need to be able to be integrated with digital repositories that are login protected as well as those that are open','All content authoring tools need to be able to be integrated with digital repositories that are login protected (Twin peaks only works with DR''s that are open).   Content authoring tools in Sakai include:  announcements, assignments, assignments with grades, Modules, syllabus, test &amp; quizzes and discussion board.  Much of the content used in courses has copyrights associated with it , so Sakai needs a digital repository tool that can be integrated with an institution''s library repository that requries a login.','Students|Instructors|Staff (administrative)|Researchers','Announcements|Assignments|Discussion|Resources|Samigo - Authoring|Samigo - Delivery|Syllabus|Twin Peaks ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-301','301','Worksite Info on Home page should accept images and text','Instructors should be able to add images and text to the Worksite Information section of the Home page. <br/>
<br/>
Instructors should be able to upload an image, not just point to one that already exists on a website.<br/>
<br/>
This allows them to customize their site a bit.','Instructors|Staff (administrative)|Students|Researchers','Home ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-302','302','The User Management Tool (In Admin Workspace) needs additional functionality','The User Tool ( In the Admin Workspace ) needs additional functionality:<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-303','303','instructors should see timestamp in drop box to distinguish which folders have new content','The drop box currently displays a Modified date for each folder. This would be more useful if it also displayed a time stamp. <br/>
<br/>
This would allow instructors to see which folders have new content.','Instructors|Researchers|Students|Staff (administrative)','Drop box ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-305','305','Site Info should explain what file types are accepted for import','The Site Info &gt; Import from File option does not indicate what type of file can be imported. The browse mechanism is used throughout Sakai to allow users to upload a file, and there is nothing on this page to indicate that there is a restriction on the type of file accepted here. The system only prompts users for a zip file once you try to upload something that is not  a zip.
<br/>

<br/>
Instructions would be helpful.','Instructors|Researchers|Staff (administrative)','Site Info|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-306','306','allow users to order materials in tools','Instructors and site owners want to be able to determine the order of items in a tool. For example, they may want to have serveral folders in the Resources area -- Homework, Assignment Solutions, Images, Maps, Research Resources, etc. Currently, Sakai puts these items in alphabetical order. The site owner should be able to determine the order in which items appear.<br/>
<br/>
This is true for <br/>
Assignments<br/>
Drop Box<br/>
Resources<br/>
Samigo<br/>
Gradebook<br/>
','Staff (administrative)|Instructors|Researchers|Students','Assignments|Discussion|Drop box|Resources|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-307','307','create visual hierarchy in Resources','It is difficult to distinguish items in a folder from items outside of a folder in the current implementation (2.1) of Resources. This makes it difficult for students to navigate and find course materials.<br/>
<br/>
One solution would be to increase the indent so the hierarchy is more prounounced. ','Instructors|Researchers|Staff (administrative)|Students','UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-308','308','Ability to set instructor-only access to course site after term (quarter, semester) ends','This feature will prevent students from accessing course sites from previous terms and download assignments/course materials to share with other students who have not yet taken the course.<br/>
<br/>
Instructors can set this option but Sakai administrators and administrative staff can also set this option for the instructor.<br/>
','Students|Instructors|Staff (administrative)|Sakai administrators','My Workspace ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-309','309','allow customization of Home page ','Instructors should be able to decide which recent items show up on the Home page. Some instructors are interested in having the default tools show up (Announcements, Discussion, Chat), while others are more interested in having Resources, Email Archive or other tools displayed. <br/>
<br/>
Most of the available tools should have the option to display in the Home page.','Students|Instructors|Researchers|Staff (administrative)','Home ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-310','310','Site maintainers can select an option to make a file or folder visible, or not visible, to site participants.','Use case:  When copying files/folders to another site, instructors can specify whether they wish to hide (make invisible)  the content from students or other site participants. Admin staff (e.g., support staff and sakai admins should be able to do this as well).
<br/>

<br/>
Use case: instructors may upload files/folders for their own use, but not for view by students or other site participants.
<br/>

<br/>
This requirement relates to REQ-145, which concerns the ability to make a folder invisible, while making items within it visible.','Instructors|Staff (administrative)|Sakai administrators','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-312','312','limit internal scroll bars','The scroll bars within the iFrames cause much confusion. There should only be a single set of scroll bars.','Researchers|Instructors|Staff (administrative)|Students','Global|UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-313','313','Gradebook integration with other Sakai tools','Complete integration of gradebook with assignment and quiz tools.','Sakai administrators|Students|Instructors','Assignments|Gradebook|Samigo - Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-315','315','Tests & Quizzes should allow instructor to email student comments about test','In the Tests &amp; Quizzes tool, instructors need to be able to email individual students comments about the submitted test. Currently, there is a &quot;Comment&quot; field, but that is only viewable by instructors.<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-316','316','Ability to weight answers within samigo','Ability to assign points on quiz responses that make up the total grade for a quiz item.  For example, on a multiple choice with multiple correct answers, an instructor may select that choosing one of the answers is worth (weighted) more heavily than another.  Conversely, that one answer is so offbase that the student actually receives a negative score for choosing that answer (e.g., -2).','Instructors|Students|Sakai administrators','Samigo - Grading ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-318','318','Creation of Local Administrator role','Provide administrative staff in individual departments (e.g., chemistry, engineering) and professional schools (e.g., law, medical, business) the ability to locally administer Sakai.  <br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-320','320','Ability to display current term courses','Provide ability for instructors and students to view course sites by term (e.g., by Fall 2005, Winter 2006, Spring 2006, Summer 2006) in the portal when they login. They should also be able to filter the site listing so that it only shows courses from a chosen term.
<br/>
Current view of courses is not user-friendly and difficult to navigate through.
<br/>

<br/>
Portal example:
<br/>
Spring 2005 course:
<br/>
Taking/Participating:
<br/>
course 1 link
<br/>
course 2 link
<br/>

<br/>
Teaching/Maintaining:
<br/>
course 3 link
<br/>
course 4 link','Sakai administrators|Students|Instructors','Portal|Sites (Admin Site Management)|Sites (Gateway)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-321','321','Tests & Quizzes - support cross-listed classes by allowing instructor to view grades by class','In the Tests &amp; Quizzes tool, instructors can currently view scores on a specific assessment by section.  We also need to be able to support cross-listed classes, and allowing instructors to view scores by a specific cross-listed class.  Two examples of cross-listing:  <br/>
<br/>
1. A class is offered under two codes, one for undergraduates, one for graduates.  Example:  ECON 101 / 201.<br/>
<br/>
2. A class is offered by different departments, e.g.  ECON 101 / PoliSci 101 <br/>
<br/>
The instructors will need to be able to view the scores of all students who enrolled in Econ 101, then of all students in Econ 201 or PoliSci 101. Similar to View by &quot;All Sections / Section xxx / Group&quot;','Instructors|Students','Samigo - Delivery|Samigo - Grading|Section Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-322','322','Tests & Quizzes - support audio recording','The Tests &amp; Quizzes tool needs to support Audio Recording as a method for &quot;answering&quot; a question.  This is the current method used by all the language classes at Stanford University. <br/>
<br/>
The current method with our CourseWork tool is that an instructor creates a question that can be text-based (that the student reads on screen), or where a video or audio clip is played.  When taking the test, the student will read / listen to / watch the &quot;question&quot; and then click a button to begin recording their audio response.  For example, a student might read a text prompt, &quot;Say the days of the week&quot; and then click the Record button, speak into a microphone, and speak the days of the week in the given language.  The student then clicks Stop, and has the option to listen to the recorded audio, and can re-record it, before submitting it.','Students|Instructors','Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-323','323','Ability to customize site ID','Site ID should follow the format of term-department-number.  For example, 1064-CHEM-101-01.<br/>
<br/>
Currently, site ID follows an unintuitive format to target audience.  For example,  52be78bb-2fd4-482d-8071-19ea7a86b5cd.<br/>
<br/>
<br/>
<br/>
','Sakai developers|Instructors|Staff (administrative)|Sakai administrators','Sites (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-325','325','Use same WYSIWYG editor throughout both Sakai and Melete Course Builder.','Use same WYSIWYG editor throughout both Sakai and Melete Course Builder.
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
2.  An editor that can easily incorporate math symbols (i.e., Math ML or similar).  The largest classes (and thus a big user of online learning) and the largest amount of testing on campus is done by science departments--math, chemistry, engineering, physics.  They all need the capability for easy input of equations both in content creation and in testing.','Instructors|Sakai administrators','Melete|WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-326','326','Add Math/Equation functionality to WYSIWYG editor','Add Math/Equation functionality to WYSIWYG editor throughout both Sakai and Melete Course Builder.','Sakai administrators|Instructors','WYSIWYG Widget ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-330','330','generate usage reports from within Sakai','Sakai administrators and support staff should be able to easily generate reports from within the system. Reports might include things like:<br/>
<br/>
a) the number of sites created, broken down by project and course (this is currently displayed in the admin view, but requires an extra step of sorting or copying/pasting in another program)<br/>
b) the number of sites per instructor<br/>
c) the number of instructors with active accounts<br/>
d) the number of students with active accounts<br/>
e) the frequency of use for any of the tools (e.g., how many sites use a gradeboo or Assignments or Section Info, etc.)<br/>
','Sakai administrators',' New Tool');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-331','331','Resources tool should allow access control at the document level and the user level','The Resources tool lets you make a particular resource publicly accessible or accessible only by site members. Its &quot;Permissions&quot; panel lets you set permissions across all resources for all site members in a given role.
<br/>

<br/>
Some users need finer-grained control of authorization. 
<br/>

<br/>
Use cases:
<br/>

<br/>
* An instructor makes a folder accessible to students only if they''re in a certain section.
<br/>
* An instructor makes a particular document editable by two TAs but no one else.
<br/>

<br/>
===
<br/>
Original description:
<br/>

<br/>
Resources tool should allow for different access to documents for different users
<br/>

<br/>
Allow users to identify who is allowed to access information within Resources based on a drop-down class list. (particularly useful for sharing/collaboration on papers/projects).
<br/>
','Students|Instructors|Sakai administrators','Permission Widget|Realms (Admin Site Management)|Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-332','332','Drop box should be configurable by users to allow access to users other than instructor','Within drop box, allow users to identify other course members for access in addition to the instructor.','Students','Drop box ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-333','333','Profiles should be able to be displayed within other tools, like the discussion tool','Allow User Profile to be selected in conjunction with other tools. For example, an option in the Discussion tool would be to show user profile including a photo. ','Students|Instructors','Account|Discussion|Global|Gradebook|Profile|Section Info|Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-335','335','Chat tool should allow for archiving and should provide URL for archive','Chat should allow for easy archiving of sessions with archives then given a URL for easy linking.','Instructors|Sakai administrators|Researchers|Students','Chat Room ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-336','336','Announcement tool should allow instructor to specify the order in which announcements are displayed','Allow the instructor to specify the order in which announcements are displayed.','Instructors|Researchers|Sakai administrators|Students','Announcements ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-337','337','Sakai should recognize SCORM content packages to allowing populating Resources/Melete','Add SCORM recognition to Sakai, so that SCORM content packages could populate a course (integration to Resources and Melete Course Builder)
<br/>
&nbsp;','Instructors|Sakai administrators','Global|Melete|Resources|Sites (Admin Site Management) ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-338','338','Sakai should allow users to order tabs across top of frame','User may select order of tabs to display on top navigation (not require alphabetical)','Sakai administrators|Instructors|Students|Staff (administrative)|Researchers','Tab Management ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-339','339','Site Info enabling/disabling tools should be section aware','Instructors should be able to enable/disable access to any function within sections within a site.  ','Sakai administrators|Instructors','Section Info|Site Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-340','340','Gradebook should allow grading basis diversity','&nbsp;Instructor should be able to select grading basis as points, percentage, or letter grade.','Sakai administrators|Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-342','342','Discussion tool should indicate clearly whether message has been read and should allow message flagging','Indicate read/unread messages and implement flagging of messages within discussion tool','Students|Sakai administrators|Staff (administrative)|Instructors|Researchers','Discussion ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-344','344','Sakai should allow for aggregate uploading of multiple files at once into Resource through some method other than WebDAV','Ability to collect/aggregate files into a zip and download them OR upload them to another resource area.  Files could be selectively included.  This would replace WebDAV which doesn''t work half of the time.','Instructors|Sakai administrators|Researchers','Resources|WebDAV ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-345','345','Sakai should allow for tool access within Modules ','I would like to be able to &quot;modularizing the various tools&quot; into folders and/or sub-folders in the &quot;Modules&quot; area.  For example, a faculty member should be able to create a weekly folder in the modules area and insert direct links to discussion forums, specific assignments (Assignments Tool), quizzes, drop boxes, and/or any type of content.   Sakai could be both organized by tool and by time.','Instructors|Students|Sakai administrators|Researchers','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-346','346','Assignments tool should create assignments that are stored in Resources, not just within assignments tool.','Assignments tool should create assignments that are stored in Resources, not just within assignments tool.','Instructors|Students|Sakai administrators','Assignments|Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-347','347','Cross tool integration should be improved','Tools should be be able to be better integrated with one another and linking between tools should be handled in a standard way by the framework.
<br/>
eg:  
<br/>
1) gradebook/assignments, 
<br/>
2) resources/assignments, 
<br/>
3) gradebook/discussion, 
<br/>

<br/>
To expand on this requiremnet:
<br/>
There needs to be a way to link tools to each other within the sakai framework. In other words, something like &quot;Tool A depends on Tool B version 1.5 and cannot function without it&quot; should be specified in the tool xml file.
<br/>
Also, there should be ways for Tool A to pull data from Tool B or send data to Tool B that are standardized and confidured via an XML file contained within the structure of Tool A.
<br/>

<br/>
Use-Case:
<br/>
I have an attendance tool (AT tool) that I have written. My attendance tool works by interfacing with a system at my university which records attendance using &quot;clickers&quot; that students operate to indicate their presence in class. This data is stored in an external database which is part of the attendance system. The instructor accesses this database through the AT tool. The instructor can use the tool to calculate grades based on the attendance data from the external system and send a grade item and set of grades to the gradebook tool being used in his course site. The grades are calculated based on a set of rules in the AT tool. The instructor may create multiple grade items or choose to update an existing grade item.
<br/>
The key is that the AT tool has to be able to get a list of grade items, or send a list of grades and a grade item definition to the gradebook tool. It also needs to be able to send a grade item ID and a set of grades and probably needs to get the updated grades.
<br/>

<br/>
This is obviously very complicated and this requirement only talks about it on a fairly non-technical level. The key here is some standardized way of linking tools together and defining input and output of data.','Students|Instructors|Sakai administrators|Sakai developers','OSIDs|Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-348','348','Samigo Alternate Numerical Forms','Samigo should automatically allow for alternate numerical forms in grading questions
<br/>

<br/>
The Assessment creation tool should allow for alternate valid representations of a numerical answer without requiring the answer to be an exact textual match.  For example it would be useful to the sciences for the system to recognize that 0.00357 and 3.57E-3 are equivalent.','Students|Instructors','Samigo - Authoring|Samigo - Delivery|Samigo - Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-349','349','WebCT import filter for multiple versions of WebCT','While the future belongs to content standards, many of us will need support in moving courses off of legacy CMS''s at our institutions.  The sakai project needs to be able to import content from both Bb and WebCT''s earlier versions.  There is already a project for blackboard integration.  It would be good to have a similar project for WebCT integration.   Rutgers is running an older version of WebCT (4.0).  It would be useful to partner with other institutions running different versions of WebCT to create a tool that can handle differences across standard verrsions of WebCT. <br/>
<br/>
Ideally, these tools will merge in to a common import tool that will recognize IMS packacged content, the current versions of WebCT and Blackboard, and older versions of that software as well.','Sakai administrators|Instructors','Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-350','350','Assignments should allow instructors to grade assignments that were not submitted','Goals:
<br/>
Instructor should be able to assign a grade to a student who did not turn in an assignment through the assignments tool','Students|Instructors|Researchers|Staff (administrative)','Assignments ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-351','351','Assignments Without On-Line Submissions (or Due Dates)','Assignments should allow instructors to create assignments that do not require a submission
<br/>

<br/>
Goals:
<br/>
Instructors can create an assignment that does not require an online submission by the student (e.g., reading assignment, hand in hard copy)','Students|Instructors|Researchers|Staff (administrative)','Assignments ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-352','352','Usernames should be active links to information','Whever a username or user ID appears in Sakai, it should provide a context menu for access to the user profile, send them an email, IM with them if they are on-line, etc.','Students|Instructors|Researchers','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-353','353','Class Session/Workflow Tool','Class Workflow<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-354','354','Accessibility: Addition of Accesskeys to common functions','This is a two-part process: 1) standardizing the names of common functions (such as Remove, Delete and Cancel; Edit and Revise; Reply and Respond; View and Preview), and 2) identifying which occur often enough to warrant accesskeys.','Instructors|Students|Sakai administrators|Researchers|Staff (administrative)','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-355','355','Roles and permissions should be optimized for the most common use cases','Our experience during the Sakai pilot suggests that the current design of authorization is not optimized for the most institutional common use cases (centralized mapping of roles to permissions; occasional override of permissions for individual users), but instead for a relatively rare use case (site-specific mapping of roles to permissions). This introduces administrative and data storage overhead, and contributes to relatively slow execution of a frequently performed query.<br/>
<br/>
See SAK-2660 for detailed scenarios.','Staff (administrative)|Sakai developers|Sakai administrators','Realms (Admin Site Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-356','356','Database storage of web sessions should be eliminated or redesigned','Sakai currently permanently stores volatile transient information about a user''s web session in the enterprise database. This adds appreciably to the cost and response time of enterprise installations.<br/>
<br/>
For details, see SAK-3794.','Sakai administrators|Staff (administrative)','Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-357','357','Resource service should use relational database approach rather than XML strings','The central resource service (used by such tools as Resources, OSP, Announcements, and the Drop Box) continues to use CHEF''s XML-encoded approach to metadata storage. This is unmanageable over the long run in a enterprise system.<br/>
<br/>
For details, see SAK-3799.','Staff (administrative)|Sakai developers|Sakai administrators','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-358','358','Accessibility: Enhanced title tags to include tool names','This is to add the name of the tool to title tags describing page functions, for example:<br/>
<br/>
Instead of &quot;Permissions&quot;, use &quot;Permissions for Announcement Tool&quot;<br/>
Instead of Options, use &quot;Options for Resource Tool&quot;<br/>
<br/>
etc.','Researchers|Staff (administrative)|Students|Instructors|Sakai administrators','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-359','359','Framework needs to support institutional human-readable user IDs','There''s a pressing cross-institutional need for a configurable institution-specific unique person identifier which is neither the Sakai user account name nor the programmatic UID used in authentication systems. This was discussed during Core Architecture meetings last year, and is a central aspect of course site management and roster views.<br/>
<br/>
For details, see SAK-2924.','Staff (administrative)|Sakai developers|Sakai administrators|Instructors','Users (Admin User Management)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-360','360','Accessibility: Addition of accessibility elements to JSF widgets','This will require 1) identification of accessibility elements that are missing in JSF (such as &quot;onkeydown&quot;) and 2) customization of Sakai widgets.<br/>
<br/>
The ability of persons with disabilities to use Sakai will be compromised if JSF widgets are not made fully accessible.','Instructors|Staff (administrative)|Researchers|Students|Sakai administrators','JSF ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-362','362','Accessibility: Extension of heading tags to include form labels and table cells; caption tags to data tables','This will enable persons using assistive technology to better scan tool content. ','Sakai administrators|Instructors|Students|Researchers|Staff (administrative)','Global ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-363','363','The Sakai portal should not force the use of iframes','The Sakai portal should not force the use of iframes. There should either be a way to run Sakai without them or they should be taken out altogether.
<br/>

<br/>
On occasion, if input focus is carefully managed, iframes can be useful for embedding simple widget-like tools or views, or to provide independent scrolling handles for different aspects of the same data. They are not suitable for embedding complex interactive web applications. Indiscriminate use of iframes is a massive usability and accessibility problem.
<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai developers','Portal|UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-364','364','Applications and services need easier access to richer institutional data','Required LMS functionality is missing from Sakai, including but not restricted to the following:
<br/>

<br/>
Student data such as IDs, enrollment status, and number of credits sometimes need to be shown. Accurate data for official enrollment status and officially assigned instructors are needed for submitting final grades and for some security decisions. Course catalog information such as department, course title, and course description should be automatically available when creating a course site. Some authorization decisions might need to be made based on institutional roles (e.g., &quot;departmental admin&quot;).
<br/>

<br/>
Despite its functional limitations, Sakai''s legacy &quot;provider&quot;-based approach to enterprise integration is complex and has proven difficult for inexperienced developers to handle.
<br/>

<br/>
Some way to easily reach richer institutional data is needed. Services should be tailored to optimize common large-scale operations.','Researchers|Students|Instructors|Staff (administrative)|Sakai administrators|Sakai developers','Providers|Realms (Admin Site Management)|Roster|Sakai Application Framework|Section Info|Worksite Information|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-365','365','Instructors and administrators need easier and more powerful management of site memberships and roles','Course site user groups and roles should be able to be automatically defined and populated from institutional feeds. These feeds need to be displayed and controlled in ways that are meaningful to end users (e.g., titled sections organized by course numbers and titles). Some services or applications may need to update local data when enrollment data changes. Sakai must support easy reconciliation of manually managed site memberships and roles (e.g., new TAs, visiting scholars, or not-yet-officially-enrolled students) with externally managed memberships and roles.
<br/>

<br/>
Over time, both Sakai''s legacy site management UI and Sakai''s legacy membership services have grown complex and inefficient. The new functionality can only be supported by logically separating membership management from other aspects of site setup.
<br/>
','Researchers|Instructors|Staff (administrative)|Sakai administrators|Sakai developers','Realms (Admin Site Management)|Roster|Sakai Application Framework|Section Info|Worksite Information|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-367','367','Bonus questions','Allow instructors to specify a question as &quot;bonus.&quot;  A bonus question''s weight would not be added to the total amount of score points possible although it would be added to a student''s raw score.  With  bonus question a student could score 100% on an exam even without answering the bonus question correctly.  Instructors should be able to set a question to bonus after a test run is complete (or ongoing) and recalculate scores based on the fact that the question has been turned into a bonus question.  Among other use cases, bonus questions are useful when an instructor creates a question pool but realizes after the test run has started that one of his/her questions is testing knowledge that wasn''t adequately disseminated in the class.  <br/>
<br/>
Just for clarification purposes, a bonus question is not a survey question.','Students|Instructors','Samigo - Question Pools ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-368','368','Kuder Richardson and Discrimination Analysis reporting','Incorporate discrimination analysis reporting and Kuder-Richardson reporting.   Both of these statistical tools can help instructors design and improve the quality of their tests.','Students|Instructors','Samigo - Grading|Samigo - Question Pools ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-369','369','Gradebook - Due date on gradebook columns','A due date feature on a column would assign a 0 grade to the student if a score hasn''t been submitted by the due date.  This feature is particularly useful when the column is referenced by a running grade column.   When calculating the running grade, after the due date, any missing scores in this column will be counted as zeros. Prior to that date, if a score is missing this column will not be used to calculate the running grade.','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-370','370','Gradebook -- Running grades column','Include a running grade column in the gradebook.  A running grade column is like a formula column but it is date sensitive and will exclude particular columns from a formula if the due date of the column in question has yet to pass.  The running grade calculates a grade based on the columns that are currently due or those that have been turned in and scored. If an assignment is not yet due it will not be counted against the student, but will be counted if a score is present. This feature is useful so that students can extrapolate final grades even when not all of the assignments have been turned in.','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-371','371','Gradebook -- Dropping scores option in a formula column.','A formula or calculated column should have options that allow the lowest score from a group of selected columns to be dropped from the formula''s calculation.  For example, lets say an instructor delivers five quizzes to her students over the course of the semester.  She should be able to specify in the final grade calculation, that the calculation take the four highest quiz scores but drop the lowest.  
<br/>

<br/>
','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-372','372','Gradebook - Formula Column','Include a formula column that can calculate a grade based on scores in other columns.  
<br/>

<br/>
The formula GUI should allow an instructor to type standard operators (+-*/) into the formula, use parenthesis ( ) to control what gets calculated first, and allow the instructor to type in other columns as variables into the formula.  
<br/>

<br/>
An advanced formula column should also allow an instructor to group other columns together and specify that the lowest score from that group be dropped.   
<br/>

<br/>
A really advanced formula column should be able to extrapolate a final grade based on the work that a student has done up until a particular point in the semester.  These formula columns are sometimes called &quot;running grade columns.&quot;  A good running grade column won''t include columns in a calculation if the column in question is associated with an assignment that isn''t due yet.','Students|Instructors','Gradebook ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-374','374','Resources tool should have the ability to store multiple versions of files in Sakai.','Reporter - Charles Severance: Add Versioning Capabilities to Content Hosting, Resources Tool, and WebDav.  Add the ability to store multiple versions of files in Sakai. This will require a GUI design that allows users to manage their multiple versions and possibly technical support tools as well to manage the stored versions of files. This may require modifications to existing user interfaces and the addition of wholenew user interfaces to properly support these features.<br/>
<br/>
Reporter - Clay Fenlason: Document Versioning. Many of our courses involve team projects that involve several people working on the same document. This is awkward to manage without some versioning capability in the Resources tool. I would project that the same thing would be valuable for research collaboration. <br/>
<br/>
Use cases: <br/>
- a collaborator uploads a new file into a location with a file already bearing that name. The new file is stored with a new version number visible through the interface. <br/>
- other collaborators are able to access previous versions of the same document <br/>
- at least one collaborator or manager has the ability to revert the document''s version to a previous version. <br/>
- this versioning capability happens consistently through both WebDAV and the web interface<br/>
','Instructors|Researchers|Students','Resources|Sakai APIs|WebDAV ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-375','375',' Timed Release of documents/files in Resources tool','Faculty want finer grained control over when resources are visible to students. They want to be able to upload resources, yet constrain the dates/times at which they are available and dates/times at which they are no longer available to students. They would like to be able to manually release document(s) that are in the Resources tool but currently hidden<br/>
<br/>
Use cases: <br/>
- An instructor wants to pre-load all her resources at the beginning of the term, but organized into one folder for each week of class, and each folder is automatically &quot;turned on&quot; at the beginning of each week. <br/>
- An instructor wants to upload exam solutions to the site, but set them to be visible only at midnight following the exam day. <br/>
- An instructor wants &quot;stale&quot; content to disappear from the student''s view after two weeks, yet still wants to keep the content visible to teaching assistants and instructors of the site.<br/>
-  An instructor wants to upload lecture notes in one go, but set them to be revealed to students only after the scheduled lecture. <br/>
- An instructor may want to post answer sets to homework assignments, but only make them available after the due date of the homework and would like to post them all at the beginning of the semester.<br/>
','Staff (administrative)|Sakai administrators|Researchers|Instructors|Students|Sakai developers','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-376','376','viewing /using student email addresses','Instructors want to see / expect to see student email addresses. They also expect that they will be able to send messages to students in the following ways:
<br/>

<br/>
(1) messages to the whole class (currently accomplished at UC Berkeleythrough Announcements)
<br/>
(2) messages to select groups (currently accomplished at UC Berkeley through Assignments + Section/Group Info definitions)
<br/>
(3) messages to individual students (currently not possible &gt; the workaround is to  use another system at UC Berkeley) ','Instructors|Researchers|Staff (administrative)','Global|Site Info ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-377','377','Configurable Workflow','The ability to configure workflow in tools, which involve the handing off of items between users would be useful, such as Assessment tools like Assignments or Samigo.  These tools already have some notion of this, such as their ability to had an assignment back for a student to do it over.  It would be nice to make this workflow more configurable, however, inorder to support other use cases.  For instance, you might just one grade (or Assignment) to reflect work on a paper where first the student submits an outline, you review it and return it, they then submit a rough draft, you review and return it, then they finally submit a paper.  Maybe it goes even further and you allow multiple drafts to be submitted before you finally grade one.  
<br/>

<br/>
Another example comes for sharing grading responsibilities on complex submissions, such as exams, where different instructors are responsible for grading specific questions; the old split up the stack of exams and pass them from office to office, which we can avoid hopefully in the electronic world of Sakai.  An individual instructor would like to be able to tell which exams they''ve left to work on, or have already worked on.  It would also be useful to know when the exams are all done; when the instructors have all completed their pieces then whomever is responsible can be notified or see an indication in interface that thing are now ready for their step, such as releasing the grades at the appropriate time.','Students|Instructors','Assignments|Tests & Quizzes (Samigo)');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-378','378','Resources tool should allow instructor to set documents/files within and outside a folder, and folders, in a desired order','Instructors should be able to set documents/files within and outside of folders, as well as folders in resources in whatever order they choose, rather than having documents appear in alphabetical order. An instructor may have several folders, and files outside of folders, in the Resources area -- Homework, Assignments, Images, Maps, Research Resources List.  Currently, Sakai puts these items in alphabetical order. <br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-379','379','Configurable Display fields for resources, including description field','Faculty often complain that the resources tool does not display the information they most care about. They don''t care about the modified date so much as the description, for example. Faculty would also like to be able to enter instructions related to the document or file, or to display copyright status of a document.<br/>
<br/>
A Description field is now provided when a user uploads a document, but the description is not visible to those accessing the site. Similarly,  the copyright field, which currently exists, is not visible to those accessing the site.  <br/>
<br/>
A solution would be to let users select  &quot;Options&quot;  to decide what columns of data would be displayed, toggling them on and off as appropriate. <br/>
<br/>
<br/>
<br/>
<br/>
','Staff (administrative)|Sakai administrators|Students|Researchers|Instructors','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-380','380','Accessibility: Alternative Content Presentation for Persons with Disabilities','Persons with disabilities should be provided with alternative renderings upon entering Sakai. Ideally, Sakai should remember their preferences, so they are presented as the default for subsequent visits. The choices, at a minimum, should include:<br/>
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-383','383','Hierarchical Site Navigation Built on Typologies','The ability to type sites and expose those types to the primary navigation as a hierarchy would greatly improve the most fundamental navigational structure in Sakai. This need will become even greater as time goes on and multiple years and semesters pass. We can easily imagine a user wanting to drill down through:<br/>
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
Right now Sakai''s site navigation organizes sites alphabetically. While this might scale tolerably well for 10 or 15 sites, it does not scale for 30 or 40, and over the course of, say, an intstructor''s career, she might have many more than that.   ','Sakai developers|Students|Staff (administrative)|Instructors|Sakai administrators|Researchers','UI|Worksite Information|Worksite Setup ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-384','384','Dynamically targetted notification tool','There should be a way to communicate something to a subset of all Sakai users, for example:
<br/>
- Send a message about training opportunities to users who have the role of Site owner, Lecturer or Tutor in one or more course sites
<br/>
- Send a message about a feature change to users who are site owners of project sites.
<br/>

<br/>
It should be possible to specify and combine search constraints for one or more of:
<br/>
- Role (within a site type)
<br/>
- Site type
<br/>
- Account type
<br/>
- Sites (select multiple sites)
<br/>
- Course codes (i.e. provider IDs)
<br/>

<br/>
This requires an admin message tool which can dynamically construct a list of recipients, and then deliver a message in one or more chosen formats (e.g. IM, email, SMS, popup).
<br/>

<br/>
It should also be possible to save a ''recipient profile'', essentially a saved query string, so that instead of reconstructing the recipient query each time, one can simply select a predefined target such as ''Course site managers'', etc.
<br/>

<br/>
Use Cases: 
<br/>
* Send an email to all users informing them of an upcoming system-upgrade, the new features that will be available, and associated down-time.
<br/>
* Send an email to all Instructors highlighting resources available to them for help with creating their course sites for their next semester classes.
<br/>
* Send an email to all project site members announcing an increase in their Resource quotas.
<br/>
* Send a message to all users with the &quot;maintain&quot; role in at least 1 site.','Sakai administrators',' New Tool|Announcements ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-385','385','Move Non-tools Out of Tools Menu','Right now the metaphor ''tool'' does not apply well to ''Home'', ''Section Info'', ''Site Info'', ''Help'', and others. I think it''s worth debating whether the ''Web Tool'' that puts external sites in an iFrame belongs in the Tools Menu as well. We should move the  functions that aren''t properly tools out of the Tools Menu and into another menu - possibly above the title bar and across the top of the site. ','Staff (administrative)|Instructors|Students|Researchers|Sakai administrators|Sakai developers','UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-386','386','Crumb Trails','We should use crumb trails to indicate the state a tool is in. ','Sakai administrators|Students|Sakai developers|Instructors|Researchers|Staff (administrative)','UI');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-387','387','Chat Function should be Cross-site and Cross-tool','Right now chat is ''located'', like other tools, within a site. As Chat begins to support person-to-person messaging, as others have proposed the functions of chat need to transcend any particular tool or site. The ''contacts'' or ''buddy list'' needs to be available across sites, and the chat windows themselves could site on layers above any other functionality, as Gtalk now functions inside of Gmail.','Sakai developers|Students|Staff (administrative)|Researchers|Sakai administrators|Instructors','Chat Room ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-388','388','Drag-and-drop ability to reorder resources','Quote from the original (and now split) requirement:<br/>
&quot;the ability to re-order items that have been uploaded and some equivalent of a drag-and-drop ability to move items in and out of folders&quot;<br/>
<br/>
This ability already exists within WebDAV, but it would appear that this requirement also calls for the drag-and-drop ordering to be reflected in the web interface.  So it may fundamentally be a web interface issue that WebDAV does not address.','Researchers|Students|Instructors','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-390','390','Instructors can set specific group/section permissions in resources to allow for file-sharing and collaborative work.','Resources should be group and section aware
<br/>
Each group or section should/could have its own resources area.
<br/>
Instructors should be able to set permissions to allow particular individuals/groups/sections access to specific folders or items in resources
<br/>
Instructors should be able to set permissions to allow particular individuals/groups/sections the ability to create/edit/delete items in specific folders in resourceslaborative work
<br/>
- private file space for a group or section within a course or project
<br/>

<br/>
This requirement incorporates the following: REQ-18,  REQ-219, REQ-271
<br/>
It also includes group and section awareness for resources tool,  which is covered in REQ-40
<br/>
','Students|Instructors|Researchers|Staff (administrative)|Sakai administrators','Resources ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-393','393','Indication on DropBox page that new files have been added since last visit.','Indication on DropBox page that new files have been added since last visit.
<br/>

<br/>
Original (split) requirement is REQ-233.','Instructors','Drop box ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-395','395','Ability to select multiple DropBoxes and delete.','Ability to select multiple DropBoxes and delete.','Instructors','Drop box ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-396','396',' Resources should allow user to define permissions at folder level  ','Assumes that Resources is group/section aware
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
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-397','397','Instant Messaging','Instant Messaging support in Sakai is an oft requested feature. There are a variety of uses caches, approaches and technologies suggested.
<br/>

<br/>
(1) Enhanced presence and chat while online: Convert the Users Present List into a Buddy List for the site; or for the system, with users in the site you are currently in differentiated somehow from users in other sites in which you are a member. Clicking on a name starts a chat with that person; or enters the default chat room for the site.
<br/>

<br/>
(2) Integrate with existing desktop IM clients
<br/>
a. use IM as a notification channel (similar to email)
<br/>
b. allow users to be invited into and join a Sakai chat from a desktop IM client
<br/>
c. ''import'' presence into Sakai from a desktop IM client
<br/>

<br/>
(3) For sites not using &quot;user presence&quot; build an IM tool; very similar in that case to existing chat, but supporting private conversations too.
<br/>

<br/>
(4) When messages are sent in Chat display some sort of notification to other site participants who are logged in.
<br/>

<br/>
(5) Using IM as an underlying messaging system for collaborative tools (such as whiteboard)
<br/>

<br/>
Technologies suggested include Jabber/XMPP, and for clients AJAX, Java or Flash.
<br/>

<br/>
Implementation would need to take into account privacy concerns and options, and visibility of participants outside the scope of the site.
<br/>

<br/>
For instance, policy may require that certain types of users or users within specific sites (such as underaged children) may not be seen or converse with other types of users (such as college students).
<br/>
','Students|Instructors|Researchers',' New Tool|Announcements|Chat Room|Preferences|Presence|Profile|Sakai Application Framework ');
insert into requirements_data (jirakey,jiranum,summary,description,audience,component) values ('REQ-398','398','Resources provider','We would a provider that allows for hybrid content hosting.
<br/>
Currently, there is a provider that allows us to have both local users and external users.  We would like the same functionality for Sakai resources, that will allow a hybrid of sakai database resources, and externally generated resources (even if these resources are then read-only).
<br/>

<br/>
We have content on other systems, that we currently generate links for and post those links as resources in sakai.  We would like to automate the process by adding a provider between the dbcontenthostingservice and spring, which will allow automatically generated resources in anything that uses the resources tool.
<br/>

<br/>
Use Case:
<br/>
Content is added to an external system. When the user looks at their resources in sakai, the resource provider goes out and checks the external system for content related to that course. The external content is then displayed for the user along with any resources located inside that Sakai site.','Researchers|Sakai administrators|Students|Instructors|Sakai developers','Providers|Resources ');
