<?php

require_once("$CFG->libdir/formslib.php");

class edit extends moodleform {

    public function definition() {
        $mform = $this->_form; //
        global $CFG ,$DB ,$USER , $OUTPUT;
        $mform->addElement('text', 'git_url', ' Github url'); // Add elements to your form
        $mform->setType('git_url', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('git_url', 'enter-the-Github-url');        //Default value
        //$mform->addHelpButton('git_url', 'badkanassignname', 'assign');
        $mform->addRule('git_url', null, 'required', null, 'client');


        $mform->addElement('text', 'user_email', 'Email'); // Add elements to your form
        $mform->setType('user_email', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('user_email', ' enter-your-email');        //Default value
        // $mform->addHelpButton('user_email', 'badkanassignname', 'assign');
        $mform->addRule('user_email', null, 'required', null, 'client');


        $mform->addElement('password', 'user_password', ' Password'); // Add elements to your form
        $mform->setType('user_password', PARAM_INT);                   //Set type of element
        $mform->setDefault('user_password', '123456');        //Default value
        //$mform->addHelpButton('user_password', 'badkanassignname', 'assign');
        $mform->addRule('user_password', null, 'required', null, 'client');


        $mform->addElement('text', 'assign_name', ' Assignment name'); // Add elements to your form
        $mform->setType('assign_name', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('assign_name', 'like-named-on-moodle');        //Default value
        //$mform->addHelpButton('assign_name', 'badkanassignname', 'assign');
        $mform->addRule('assign_name', null, 'required', null, 'client');


        $this->add_action_buttons();
        $mform->addElement('html', '<h4 style="font-size:40px;"><b>Feedback</b></h4>');
        $mform->addElement('html', '<pre>   </pre>');

        $feed =  $DB->get_record('badkan_feedback',array('userid'=>$USER->id));
        $feedString  = $feed->feedback;
        $mform->addElement('textarea', 'introduction',
            'feedback', 'wrap="virtual" rows="10" cols="100"');
        $mform->setDefault(introduction,$feedString);

        $mform->addElement('html', '<pre>   </pre>');

        $grString  = $feed->grade;

        $mform->addElement('text', 'grade', 'Your grade'); // Add elements to your form
        $mform->setType('grade', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('grade', $grString);        //Default value

        $DB->delete_records('badkan_feedback',array('userid'=>$USER->id));

    }

    function validation($data, $files) {
        return array();
    }
}