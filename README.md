# FLoRA LMS Setup


[Moodle]: https://moodle.org
[Surveypro]: https://docs.moodle.org/310/en/Surveypro_module
[Generico]: https://moodle.org/plugins/filter_generico
[Langauge Packs]: https://docs.moodle.org/23/en/Language_packs
[Boost navigation fumbling]: https://moodle.org/plugins/local_boostnavigation
[Installation_Quick_Guide]: https://docs.moodle.org/311/en/Installation_quick_guide
[Multi-Language Content (v2)]: https://moodle.org/plugins/filter_multilang2
[Course Enrolment]: https://docs.moodle.org/311/en/Course_enrolment
[Sample Courses]: https://drive.google.com/drive/folders/1SrPEC-_bQPm0OZs4PeMhOthkXUhZiibS?usp=sharing
[flora-addons]: https://github.com/ssin122/flora-addon 
[sample-csv]: https://drive.google.com/file/d/1Qxyi5LWJCmKp1_XcEC4-eU0K_gvPVZEX/view?usp=sharing

This learning management system is an adapted version of [Moodle] 3.9 that already includes several plugins to support the various interfaces and the logging of trace data needed to support the project. 

These addtional plugins include:
* [Surveypro] - to administer surveys (MESH)
* [Generico] - templating filter to setup code snippets in Moodle text areas.
* [Langauge Packs] - installed in Moodle site via Settings > Site administration > Language > Language packs
* [Boost navigation fumbling] - theme to support the customised navigation bar.
* [Multi-Language Content (v2)] - simplified multi-language filte

[Moodle] is a learning platform designed to provide educators, administrators and learners with a single robust, secure and integrated system to create personalised learning environments.

# Server requirements

These are just the minimum supported versions. 

* Web Server : Preferred   Nginx Webserver - v1.17.0+ ( or Apache/2.4.46+)
* Database Server version: 10.2.36-MariaDB MariaDB Server +
* PHP:  Version 7.3+

Download and unzip the lms folder in the document root. For example: DocumentRoot "/var/www/lms".

Visit http(s)://yourdoman.com/lms/ to start the installation process.

You may be required to specify the following which will eventually be saved in the config.php file in the lms directory:

* Database Type - Choose MariaDB or mySQL.
* Database Name - (manually create if it done not exist)
* DB Username & Password - (credentials for your database)
* Port Number - (usually 3306)

Moodle installation guide : Refer to [Installation_Quick_Guide].

Note: Ensure that you force your site to load securely by:
* Using .htaccess (or other methods) to redirect non-www to www and HTTP to HTTPS, and ensure that they resolve to a single address. This is important to the setup - particularily for the Annotations & the Traceparcer features as they rely on unique URL mapping.

# Client requirements

## Browser support
The setup is compatible with any standards compliant web browser. We have tested the setup with the following browsers:

Desktop:
* Chrome
* Firefox
* Safari

However, we highly recommend that the clients use Google Chrome.

# Customisation Steps

### 1. Enabling Plugins & Langauge Packs

1. Install Appropriate Language Packs (eg. en, nl, de, zh_cn) by visiting (Site administration > Language > Language packs)
2. Enable Plugins (Use: Site administration > Plugins > Filters > Manage filters):
    1. Generico (Enable)
    2. Multi-Language Content (v2) (Enable & Apply to: Content & Headings)
3. Enable Theme:
    1. Ensure Boost theme is selected under (Use: Site administration > Appearance > Themes > Theme selector)
  
### 2. Importing the Courses
1. The typical setup for FLoRA contains the following modules:
    * Pre Test Module
    * Training Module
    * Essay Task Module
    * Post Test Module
2. These sample courses (backup) can be downloaded from the following link: [Sample Courses]
3. From (Use: Site administration > Courses > Manage courses and categories), first create a new course category (eg. FLoRa Courses).
4. Next, proceed to restoring the four (4) backup courses via (Use: Site administration > Courses > Restore course) under your newly created course category.
5. Enroll a few users (Manager & Student roles) to the course so that you can verify if the courses have restored correctly. Guide: [Course Enrolment]
6. Finally, you may want to simplify the Dashboard page of the LMS, so that it only lists the enrolled courses for the participants (Use: Site administration > Appearance > Default Dashboard page) and apply these new settings to all users.

### 3. Enabling Flora-addons
1. The first step is to download and unzip the contents of [flora-addons] repo directly in the root folder: eg. DocumentRoot "/var/www/". The structure of the root folder should be as follows:
   * /var/www/ 
   * |-- admin (folder)
   * |-- flora (folder)
   * |-- functions.php
   * |-- lms (folder)
   * |-- log_to_db.php
   * |-- logs (folder)
   * |-- traceParser.php
2. Launch http(s)://yourdoman.com/admin/installDB.php to setup the FLoRA Log-Database with your appropriate DB credentials.
3. At this stage you may need to purge the cache for your new settings to take effect. To do this, go to (http(s)://yourdoman.com/lms) Site administration > Development > Purge caches > Purge selected caches (custom option at the bottom and the select all the options). Finally, Click (Purge selected caches). This task may take 2 minutes to complete.

### 4. Configuring FLoRA Add-on 
1. Currently this process is manual and thus the admin has to enter the following parameters for the task
    * Main Essay Writing Task Duration (in minutes)
    * Training Task Duration (in minutes)
    * Essay Length (in words)
    * Main Task Course Page (eg. course-4) 'Extract this information from your moodle site
    * Training Task Course Page (eg. course-3) 'Extract this information from your moodle site
    * task_landing_page - landing page (General Instruction Page) for Main Task
    * This information can be configured via the Moodle interface (http(s)://yourdoman.com/lms) Site administration > Appearance > Additional HTML > (Within HEAD) textarea :
   ```javascript
   // Locate this section within the textarea
   // You may need the 'content author' to assist in making some of these decisions.
   /* ==========  Beginning of Configurations  ========== */
   var task_course_id = "course-4"; // Primary or Main essay writing course ID (ensure that you don't leave out "course-") 
   var training_task_id = "course-3";  // Training Course ID (ensure that you dont leave out "course-") 
   var scaffold_option = "IMPROVED" ; // IMPROVED OR STANDARD
   var task_landing_page = "/lms/mod/lesson/view.php?id=8&pageid=1";  // landing page (General Instruction Page) for Main Task

   localStorage.setItem("mainTask", 45);
   localStorage.setItem("trainingTask", 20);
   localStorage.setItem("essayLen", 400);
   /* ==========  End of Configurations  ========== */

   ```
2. Similarily, the Action Labeller and the Scaffolding engine on the server needs to recognise the courses it is getting data from to either correctly label and store the logs OR ignore the logs. (We hope to sync this feature in the near future.). The configuration info has to be entered on the webserver by editing the config.php file in the lms folder: DocumentRoot "/var/www/lms/config.php".
    * Add the following two line of code at the bottom of DocumentRoot "/var/www/lms/config.php" with the appropriate course-ids:
   ```php
   /* FLoRA Custom code added to config.php to correctly support scaffolding engine and pattern labelling */

   $CFG->TrainingCourse_ID = 3;  // course number only (no text).  To correctly identify the Training Course. Extract this information from your moodle site
   $CFG->MainCourse_ID = 4;      //  course number only (no text). To correctly identify theMain Course. Extract this information from your moodle site
   
   /* End of Custom code */

   ``` 
   
### 5. Verifying Page/Resource URLS
 1. Our annotation tool, the custom navigation menu, and action labeller is fully dependent on the page URL to accurately attach annotations, to redirect users and to label their log actions in the database. Thus, it is important to ensure that the moodle page urls are correctly coded and none of the links are broken. 
 2. The following table shows the resource information for our sample course:
 
   |   Resource Page on LMS    |   URL  (Example only) |   Resource Classification |
   |   -------------   |   -------------   |   -------------   |
   |   General Instructions    |   https://yourdoman.com/lms/mod/lesson/view.php?id=1&pageid=1 |    GENERAL_INSTRUCTION    |
   |   Rubric Page |   https://yourdoman.com/lms/mod/lesson/view.php?id=1&pageid=2 |    RUBRIC |
   |   1.1 Definition of Artificial Intelligence |   https://yourdoman.com/lms/mod/page/view.php?id=2    |    RELEVANT   |
   |   1.2 History of Artificial Intelligence |   https://yourdoman.com/lms/mod/page/view.php?id=3    |    IRRELEVANT |
   |   1.3 How does AI work?  |   https://yourdoman.com/lms/mod/page/view.php?id=4    |    RELEVANT   |
   |   1.4 Ethics and risks of developing AI  |   https://yourdoman.com/lms/mod/page/view.php?id=5    |    IRRELEVANT |
   |   1.5 Supervised machine learning|   https://yourdoman.com/lms/mod/page/view.php?id=6    |    RELEVANT   |
   |   1.6 Unsupervised machine learning|   https://yourdoman.com/lms/mod/page/view.php?id=7    |    RELEVANT   |
   |   1.7 Reinforcement learning |   https://yourdoman.com/lms/mod/page/view.php?id=8    |    RELEVANT   |
   |   1.8 Deep Learning  |   https://yourdoman.com/lms/mod/page/view.php?id=9    |    RELEVANT   |
   |   2.1 What is Differentiation?  |   https://yourdoman.com/lms/mod/page/view.php?id=10   |    RELEVANT   |
   |   2.2 Using differentiation to adapt education   |   https://yourdoman.com/lms/mod/page/view.php?id=11   |    RELEVANT   |
   |   2.3 Standards for teaching  |   https://yourdoman.com/lms/mod/page/view.php?id=12   |    IRRELEVANT |
   |   3.1 The development of scaffolding  |   https://yourdoman.com/lms/mod/page/view.php?id=13   |    RELEVANT   |
   |   3.2 What is cognitive apprenticeship?   |   https://yourdoman.com/lms/mod/page/view.php?id=14   |    IRRELEVANT |
   |   3.3 What is scaffolding |   https://yourdoman.com/lms/mod/page/view.php?id=15   |    RELEVANT   |
   |   3.4 Applications of scaffolding |   https://yourdoman.com/lms/mod/page/view.php?id=16   |    RELEVANT   |
   |   3.5 Applications of cognitive apprenticeship   |   https://yourdoman.com/lms/mod/page/view.php?id=17   |    IRRELEVANT |

 4. It may be useful for you to come with a similar table yourself. Then change the code for the relevant sections in the website by following the steps below:
      * For creating or fixing issues with your Navigation Menu: visit (http(s)://yourdoman.com/lms) Site administration > Appearance > Boost navigation fumbling > Custom course nodes, and correct the custom template loaded for you.
        ```html
            This is just example code on how custom menu items are created on moodle (more information is provided in the LMS itself):
            Moodle.org website|http://www.moodle.org|en,de
            Our university|http://www.our-university.edu
            Faculty of mathematics|http://www.our-university.edu/math||math
            Teachers' handbook|http://www.our-university.edu/teacher-handbook|||editingteacher,teacher
            Student information course|/course/view.php?id=1234||||||fa-graduation-cap
         ```
            
       * Ensure that all the relative URLs (last field for each line) is pointing to the correct page resource.
  2. Similarily, on the WebServer, locate the file "/var/www/traceParser.php" (and in get_ActionLabel() ) and ensure that the page_info resources are pointing to the correct pages on your website (as per the resource table above) and that the links are not broken:
  
     ```php 
        $page_info = array(
            "https://yourdoman.com/lms/mod/lesson/view.php?id=1&pageid=1" => "GENERAL_INSTRUCTION",
            "https://yourdoman.com/lms/mod/lesson/view.php?id=1&pageid=2" => "RUBRIC",
            "https://yourdoman.com/lms/mod/page/view.php?id=2" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=3" => "IRRELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=4" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=5" => "IRRELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=6" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=7" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=8" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=9" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=10" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=11" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=12" => "IRRELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=13" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=14" => "IRRELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=15" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=16" => "RELEVANT",
            "https://yourdoman.com/lms/mod/page/view.php?id=17" => "IRRELEVANT"
          );

      ``` 
### 6. Last Steps
1. Finally, you may need to purge the cache for your new settings to take effect. To do this, go to (http(s)://yourdoman.com/lms) Site administration > Development > Purge caches > Purge selected caches (Select all the options) and then Click (Purge selected caches).
2. Visit your LMS site (http(s)://yourdoman.com/lms) to check that all tools (Annotation, Planner, Essay, Timer and Scaffolds) are correctly loading. You can open the console window in the Web browser temporarily to note any possible errors.
3. To check if the log system is working correctly, visit (http(s)://yourdoman.com/logs). The temporary credentials for this website is:
   * Username: flora
   * Password: fl#r@Proje8t

### Creating Participants/Users and adding to your experiment
1. You can use the Admin Settings to add a new participants to you course. However, this is done one user at a time. We have simplified this step, so that you can create bulk user accounts using a csv file (sample upload file - [sample-csv]). During the user account creation process, some of the key attributes you have to consider (and as included in the sample file) are:
* username - (e.g. fsp4_501). This field should be unique. Please try to avoid any spaces or special characters, except an underscore "_".
* password - (e.g. Fsp4_501pass). This field should be atleast 6 characters long.
* firstname - (e.g. fsp4501). Please try to avoid any spaces or  special characters.
* lastname - (e.g. PL). Since the name fields are used across module and activities (eg. quizzes & surveys), we have used this surname field to help quickly identify usergroups and for filtering purpose (as the setup doesnot capture the real names of participants. Also, Addiing a separate userfield in moodle had its limitations). The user-groups supported in this setup are:
    * CN - Control Group (particpants don't receive any prompts during their task)
    * GE - Generalised Group (these particpants receive generic prompts during their task)
    * PL - Personalised Group (these particpants receive personalised prompts during their task)
    * AD - Admin Accounts used for testing purpose (whereby user can choose the prompt types and reset past sessions).
    * and are reflected accordingly in the surname column of the csv file for easy reference.
* email - (e.g. fsp4501@localhost.com) . This field should be unique. Currrently Moodle does not send notifications using their addresses.
* lang - (e.g. nl) Language. The learning content currently supports the following languages:
    * en - English
    * nl - Dutch
    * de -  German
    * zh_cn - Chinese
* city - (e.g. Nijmegen). Useful to display localised timezone and deadlines to partipants.
* country - (e.g. Netherlands). . Useful to display localised timezone and deadlines to partipants.
2. To create the particpants, you need to populuate the sample file ([sample-csv]) with the appropriate user attributes and upload it via the Amdin Panel: Site Adminitration > Users > Upload users > Add the csv file and Proceed with the default steps.
3. Finally, using the course Enrol option, add these users as students to your courses.

Note: Duplicates or repeated user credentials will throw an exception. 

### Final Notes
* Please note that this project is continuously maintained. However, some minor bugs may persist as the project is still evolving. If you encounter any issues or have any questions, please email: shaveen.singh@gmail.com

