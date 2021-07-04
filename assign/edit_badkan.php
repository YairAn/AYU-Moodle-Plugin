<?php
require_once(__DIR__ . '/../../config.php');
global $DB , $USER , $OUTPUT , $COURSE ,$PAGE ,$CFG , $C;
require_once($CFG->libdir.'/gradelib.php');

require_once($CFG->dirroot . '/mod/assign/classes/form/edit_badkan.php');
$PAGE->set_url(new moodle_url('/mod/assign/edit_badkan.php'));
$PAGE->set_context(\context_system::instance());
$PAGE->set_title('submission');


// We want to display our form.
$mform = new edit();

//get the course id from session
session_start();
$c_id = $_SESSION["course_id"];
session_unset();
session_abort();

if ($mform->is_cancelled()) {
    // Go back page with error notification
    redirect($CFG->wwwroot . '/mod/assign/edit_badkan.php/', 'submission canceled',$type = \core\output\notification::NOTIFY_ERROR);
}

else if ($fromform = $mform->get_data()) {
    //insert to the data bases the information
    //and use python file to submit the assignment
    $record = $DB->get_record('badkan_course',
         array('moodle_course_name' => $c_id , 'moodle_assignment' => $fromform->assign_name));
      $course_name = $record->badkan_course_name;
      $assignment = $record->badkan_assignment;

    // Insert the  user  ans  submission data into our database table.
    $recordtoinsert = new stdClass();
    $recordtoinsert->git_url = $fromform->git_url;
    $recordtoinsert->user_id = $USER->id;
    $recordtoinsert->user_password= $fromform->user_password;
    $recordtoinsert->user_email = $fromform->user_email;
    $recordtoinsert->assignment = $assignment;
    $recordtoinsert->course_name = $course_name;
    $DB->insert_record('details_to_badkan', $recordtoinsert);


    //use python file  to submit
    //we have a bug here - the details sent wrong becouse of the spases between words - need fix
    $course_name1 = str_replace(" " , "~" ,$course_name);
    $assignment1 = str_replace(" " , "~" ,$assignment);
    $python_data = "$course_name1 $assignment1 $fromform->user_email $fromform->user_password $fromform->git_url $USER->id" ;

    //important note for users - exchange this path with the path to your python interpreter
    // and your path to the submit.py file to where its exist/saved in your own compute/system.
    $python_path = 'C:/Users/Yair/anaconda3/python.exe C:\Users\Yair\moodle\server\moodle\mod\assign\submit.py ';


    $pid = exec( $python_path.$python_data ,$python_result);
    exec("kill -9 $pid") ;

    //extract the grade from the feedback
     $grade = 0;
     $result_text  = implode("\n",$python_result); //make a one string of the python result
     $str = substr($result_text ,strpos($result_text,'Your grade is')); //substring to find the grade int the text
     $found = preg_match('!\d+!', $str, $matches); //look for the value of the grade
     $grade = (double)(implode(" ",$matches));//extract the value
     if($found == 0){
         $str2 = substr($result_text ,strpos($result_text,'Grade')); //substring to find the grade int the text
         $found2 = preg_match('!\d+!', $str2, $matches2); //look for the value of the grade
         $grade = (double)(implode(" ",$matches2));//extract the value
     }


    // Insert the user ans submission data into our database table.

    $recordtoinsert2 = new stdClass();
    $recordtoinsert2->feedback = $result_text;
    $recordtoinsert2->userid = $USER->id;
    $recordtoinsert2->grade = $grade;
    $DB->insert_record('badkan_feedback', $recordtoinsert2);

    //save the grade to db.
    $item_id = $DB->get_record('grade_items',array('courseid' => $c_id , 'itemname' => $fromform->assign_name),'id');
    $item_instance = $DB->get_record('grade_items',array('courseid' => $c_id , 'itemname' => $fromform->assign_name),'iteminstance');

    $grades = array();
        $grades[$USER->id] = new stdClass();
        $grades[$USER->id]->userid = $USER->id;
        $grades[$USER->id]->rawgrade = $grade;
    grade_update('mod/assign', $c_id , 'mod', 'assign', $item_instance->iteminstance, 0, $grades);

    $assign_id = $DB->get_record('assign',array('course' => $c_id , 'name' => $fromform->assign_name),'id');
    $assign_grades_id = $DB->get_record('assign_grades',array('userid' => $USER->id , 'assignment' => $assign_id->id),'id');
    if(!($assign_grades_id)){
        $graderecord = new stdClass();
        $graderecord->assignment = $assign_id->id;
        $graderecord->userid = $USER->id;
        $graderecord->grade = $grade;
        $DB->insert_record('assign_grades', $graderecord);
    } else {
        $current = $DB->get_record('assign_grades',array('userid' => $USER->id , 'assignment' => $assign_id->id),'grade');
        $current_grade = $current->grade;
        // check if the current grade is lower than the existing one - if so then don't update
       // if($current_grade < $grade) {
            $graderecord = new stdClass();
            $graderecord->id = $assign_grades_id->id;
            $graderecord->grade = $grade;
            $DB->update_record('assign_grades', $graderecord);
      //  }
    }
   redirect($CFG->wwwroot . '/mod/assign/edit_badkan.php/', 'submited',$type = \core\output\notification::NOTIFY_SUCCESS);

}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
