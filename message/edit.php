<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/message/classes/form/edit.php');
global $DB , $USER;
$PAGE->set_url(new moodle_url('/local/message/edit.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('submission');


// We want to display our form.
$mform = new edit();

if ($mform->is_cancelled()) {
    // Go back to manage.php page with error notification
    redirect($CFG->wwwroot . '/local/message/manage.php', 'העלאת הקישור לבדקן בוטלה',$type = \core\output\notification::NOTIFY_WARNING);
}

else if ($fromform = $mform->get_data()) {
    //insert to the data bases the information
    //and use python file to submit the assignment

     //The next data should be input from the server/~need to Complete ~
     $course_name = "C++ 5780" ;
     $assignment ="Solver - A" ;

     //use python file  to submit
     $python_data = array($course_name , $assignment , $fromform->user_emai , $fromform->user_password , $fromform->git_url ,  $USER->id );
     $python_path = 'python  /local/submit.py';
     $python_result;
     exec( $python_path.$python_data,$ $python_result);


    // Insert the  user  ans  submission data into our database table.
    $recordtoinsert = new stdClass();
    $recordtoinsert->git_url = $fromform->git_url;
    $recordtoinsert->user_id= $USER->id;
    $recordtoinsert->user_email = $fromform->user_email;
    $recordtoinsert->assignment = $assignment;
    $recordtoinsert->course_name = $course_name;
    $DB->insert_record('local_message', $recordtoinsert);

    // Insert the  user  ans  submission data into our database table.
    //$recordtoinsert2 = new stdClass();
    //$recordtoinsert2->feedback = $python_result;
    //$recordtoinsert2->user_id= $USER->id;
    //$recordtoinsert2->grade = grade;  //~~need to comlete~~
    //$DB->insert_record('badkan_feedback', $recordtoinsert2);
    
    //    // Go back to manage.php page 
    redirect($CFG->wwwroot . '/local/message/manage.php', 'send   :' . $fromform->github_url. '  to Badkan');
  
   
}
echo $OUTPUT->header();
echo'555 ';
echo 'u(:';

$mform->display();
echo $OUTPUT->footer();