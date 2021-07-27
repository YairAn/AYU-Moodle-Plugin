# AYU Moodle plugin

This project is a plugin for moodle system.
Our goal is to create a plug-in that will enable to connect between the moodle system and "Badkan" website which is an automatic code tester.
The plugin will enable Moodle academic users to submit an assignments with an automatic interface testers, designed by the academic stuff.

## Installation guide

## Prerquisites
- First make sure that you have the Moodle system (a stable version) 3.11.1 or higher installed on your divice (either on your system or as local host).
  You can find instructions here: https://docs.moodle.org/311/en/Installing_Moodle
- Make sure that you have python(3.8) installed on your divice.
- Chrome browser.
- Chrome driver ,(a stable version 9.0 and higher) you can download it here https://chromedriver.chromium.org/downloads
- Clone or download this repository to your divice.
- Compress the "assign" folder to a zip file (it will be in the folder you downloaded from this repository).

## Instructions
Once you have all that ready do the following:
 
 - On the moodle home page go to : "Site administration" -> "Plugins" -> "Install plugins"
   and drag the "assing" zip folder ( the one you compress in the previous step) to the file picker or click "Choose a file".
   Continue according to the instructions given there.
   
 - You may ran into a problem in that procces because of a version conflict.
   In this case go to "Site administration" -> "Plugins" -> "Plugins overview"
   and uninstall the "Assingnment" plugin,then try the previous step again.
   
Afterwards , change the code as follows
 - In the installed moodle on your device go to : \server\moodle\mod\assign\edit_badkan.php 
   - In line 53 change and fill the right fields:
    > $python_path = '*path_to_your_python*/python.exe     *the_path_to_the_server_folder*\server\moodle\mod\assign\submit.py ';
     
 - In the installed moodle on your device go to : \server\moodle\mod\assign\submit.py

- In line 17 change and fill the right fields:
   > weburl  = "*The current link to the Badkan"


- In line 18 change and fill the right fields:
   > PATH = "*the_path_to_your_chorme_driver*\chromedriver.exe"

 - In the installed moodle on your device go to : \server\moodle\course\modedit.php
   - replace the existing modedit.php file with the modedit.php file that in this repository.
   

## Usage
  ### When editing(creating) a new assignmet on some course there are two fields need to be filled for the plugin to work with the "Badkan":
   - badkan course name.
   - badkan assignment name.
  <img width="500" height="300" src="https://github.com/YairAn/AYU-Moodle-Plugin/blob/main/images/s1.png"> 
  Those fields are coresponding to the course and assignment names as they called on the "Badkan".
  
  ### when submiting an assignment there are four fields need to be filled for the plugin to work with the "bad-kan":
   - Github url - The github url where the submiting code is at.
   - Email - The email that the user registerd to the "bad-kan" with.
   - Password - The Password that the user registerd to the "bad-kan" with.
   -  Assignment name -The name of the current moodle assignment (as its called on moodle *not* as it called on the "bad-kan") 
<img width="500" height="300" src="https://github.com/YairAn/AYU-Moodle-Plugin/blob/main/images/s2.png">
<img width="500" height="300" src="https://github.com/YairAn/AYU-Moodle-Plugin/blob/main/images/s3.png">

   
   
 
   

    


 
 

