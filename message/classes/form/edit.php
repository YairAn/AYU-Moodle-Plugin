<?php

require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {
    public function definition() {
        $mform = $this->_form; //
        global $CFG;

        $mform->addElement('text', 'git_url', ' קישור לבדקן'); // Add elements to your form
        $mform->setType('git_url', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('git_url', 'Please enter the Github url');        //Default value
        

        $mform->addElement('text', 'user_email', ' דואר אלקטרוני'); // Add elements to your form
        $mform->setType('user_email', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('user_email', ' enter yout email');        //Default value

        $mform->addElement('password', 'user_password', ' סיסמא'); // Add elements to your form
        $mform->setType('user_password', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('user_password', ' password');        //Default value
        
       
        $this->add_action_buttons();
    }


    function validation($data, $files) {
        return array();
    }
}