# AYU Moodle plugin

this project is a plugin for moodle system.
Our goal is to create a plug-in that will enable to connect between the moodle system and "Badkan" website which is an automatic code tester.
The plugin will enable Moodle academic users to submit an assignments with an automatic interface testers, designed by the academic stuff.

## installation guide

## prerquisites
- first make sure that you have the Moodle system (a stable version) installed on your divice (either on your system or as local host).
  you can find instructions here: https://docs.moodle.org/311/en/Installing_Moodle
- make sure that you have python installed on your divice.
- chrome browser.
- chrome driver , you can download it here https://chromedriver.chromium.org/downloads
- clone or download this repository to your divice
- compress the "assign" folder to a zip file (it will be in the folder you downloaded from this repository).

## instructions
now,once you have all that ready do the following:
 
 - on the moodle home page go to "Site administration" -> "Plugins" -> "Install plugins"
   and drag the "assing" zip folder ( the one you compress in the previous step) to the file picker or click "Choose a file".
   Continue according to the instructions given there.
   
 - you may ran into a problem in that procces because of a version conflict.
   if that the case go to "Site administration" -> "Plugins" -> "Plugins overview"
   and uninstall the "Assingnment" plugin,then try the previous step again.
   
now,you need to make a litte changes on the code
 - on the moodle installed on your device go to \server\moodle\mod\assign\edit_badkan.php 
   - on line 53 change and fill the right fields:
    > $python_path = '*path_to_your_python*/python.exe     *the_path_to_the_server_folder*\server\moodle\mod\assign\submit.py ';
     
 -  on the moodle installed on your device go to \server\moodle\mod\assign\submit.py
   - on line 18 change and fill the right fields:
   > PATH = "*the_path_to_your_chorme_driver*\chromedriver.exe"
   
## usage
  when editing(creating) a new assignmet on some course there are two fields need to be filled for 
  the plugin to work with the "bad-kan":
   - badkan course name
   - badkan assignment name
  those fields are coresponding to the course and assignment names as they called on the "bad-kan".
  
  when submiting an assignment there are four fields need to be filled for 
  the plugin to work with the "bad-kan":
   - Github url - the github url where the submiting code is at.
   - Email - the email that the user registerd to the "bad-kan" with.
   - Password - the Password that the user registerd to the "bad-kan" with.
   -  Assignment name -the name of the current moodle assignment (as its called on moodle *not* as it called on the "bad-kan") 


   
   
 
   

    


 
 

