Introduction

 Databased is a self-hosted database application, allowing access to MySQL databases for non-technical people and technical people alike. With Databased we are trying to make working with MySQL databases easier and available for everyone.

Databased is not (yet) a replacement for phpMyAdmin or other MySQL administration tools as it offers only limited functionality mostly required by "regular" users. By "regular" users we mean sales staff, customer service reps, accountants etc.

Databased is built using CodeIgniter 2.1.4 and Flat UI Pro.

Upgrading

Below you'll find information on how to upgrade.

v1 to v1.1.1
Check your database to see if the table “dbapp_columnrestrictions” exists. If not, execute the following SQL statement:
"CREATE TABLE IF NOT EXISTS `dbapp_columnrestrictions` ( `dbapp_columnrestrictions_id` int(11) NOT NULL AUTO_INCREMENT, `dbapp_columnrestrictions_database` varchar(255) NOT NULL, `dbapp_columnrestrictions_table` varchar(255) NOT NULL, `dbapp_columnrestrictions_column` varchar(255) NOT NULL, `dbapp_columnrestrictions_restrictions` text NOT NULL, PRIMARY KEY (`dbapp_columnrestrictions_id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;"
Update the following folders:
– /application (every subfolder except for the /application/config folder) 
– /css 
– /js
v1.1.1 to v1.2.1
Locate the file "v1.1.1-to-v1.2.1.sql" in the /db_upgrade folder and execute the SQL statements in this file to update your main Databased database.
Update (overwrite) the following folders:
- /application (every subfolder except for /application/config/)
- /assets
- /css
- /custom
- /js
v1.2.1 to v1.2.2
Update (overwrite) the following folders:
- /application (every subfolder except for /application/config/)
v1.2.2 to v1.3.1
Update (overwrite) the following folders:
- /application (every subfolder except for /application/config/)
- /css
- /js
Create a folder named "tmp" in the root folder of your application (as a sibling of the application folder) and make sure it's writable by the web server (to be sure, you can set the permissions to 777).
v1.3.1 to v1.3.2
Update (overwrite) the following folders:
- /application (in the folder /application/config/ only replace the file "autoload.php")
- /css
- /js
v1.3.1 to v1.4.1
Update (overwrite) the following folders and files:
- .htaccess
- /application (every subfolder except for /application/config/)
- /assets
- /css
- /images
- /js
Create a new folder named "/uploads" and make sure it's writable. This folder has to be a sibling of /application (meaning it should be on the same level).
v1.4.1 to v1.4.2
Update (overwrite) the following folders and files:
- /application/views/admin/db.php
v1.4.2 to v1.4.3
Update (overwrite) the following folders and files:
- /application/views/table/table.php

Before Installing

Requirements

To be able to install Databased, you must have the following:

PHP 5.1.6 (older versions might work)
Apache webserver
MySQL with support for InnoDB tables and foreign keys
Root access to your MySQL server
phpMyAdmin access to setup the initial database
An FTP tool to upload the files
Structure

Like mentioned before, Databased is built using CodeIgniter and Flat UI Pro. To learn more about CodeIgniter, please visit the CodeIgniter website or read the online documentation here. To learn more about Flat UI Pro, please have a look here.

In addition to the default CodeIgniter files, Databased uses the following custom files:

Controllers (/application/controllers/):
account.php
admin.php
columnnotes.php
columns.php
dashboard.php
db.php
recordnotes.php
revisions.php
roles.php
table_datasource.php
tablenotes.php
users.php
Models (/application/models/):
columnnote_model.php
db_model.php
issue_model.php
recordnote_model.php
relation_model.php
revision_model.php
role_model.php
table_model.php
tablenote_model.php
user_model.php
Views (/application/views/)
All files and folders are custom, except for the folder "/application/views/auth".

Flat UI Pro files
The following folders are part of the Flat UI Pro kit:

/bootstrap (contains basic bootstrap items)
/css (contains custom css)
/custom (contains less+css)
/fonts (contains the fonts used in Databased)
/images (contains images used in Databased)
/js (contains the Flat UI Pro javascript files)
/less (contains the original Flat UI Pro less files)
Additional files/folders
/assets (contains some additional jQuery plugins + support files)
/swf (contains files used by the jQuery DataTables plugin)
CodeIgniter

Before continuing with the installation of Databased, please make sure your hosting is capable of hosting CodeIgniter 2.1.4. In 99% of the cases, this won't be a be a problem :)


Installation

Step 1: Upload Files

You'll need to start with uploading the Databased files. You can either upload "Databased.zip" and unpack it on your hosting or unpack "Databased.zip" locally first and then upload the files. Unpacking the file "Databased.zip" will create a folder named "Databased" which contains all the application files.

Databased can run either in the root folder of your hosting, or in a sub folder. After unpacking/uploading, please double check and make sure a file named ".htaccess" can be found in the folder to which you have uploaded the Databased files.

Step 2: Setup MySQL Database

Databased requires it's own MySQL database to function properly. Use phpMyAdmin or any other MySQL administration tool to create a new MySQL database. You can name this database whatever you like, but make sure you remember (or write it down) the name, as you'll need to put this into the configuration file later.

Once you have created the MySQL database, import the SQL file named "Databased.sql". You can find this file in the "Databased" folder after unpacking the "Databased.zip" file. Importing the SQL file will create all the required tables in your new MySQL database. Please make sure you don't change anything in this database.

Step 3: Configuration

The final step of the installation process is the configuration of Databased. Use your FTP tool to edit the following files as per the following instructions:

/application/config/config.php
Find the line $config['support_email'] = 'support@somedomain