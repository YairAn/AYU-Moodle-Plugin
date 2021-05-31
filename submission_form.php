<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This file contains the submission form used by the assign module.
 *
 * @package   mod_assign
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die('Direct access to this script is forbidden.');


require_once($CFG->libdir . '/formslib.php');
require_once($CFG->dirroot . '/mod/assign/locallib.php');

/**
 * Assign submission form
 *
 * @package   mod_assign
 * @copyright 2012 NetSpot {@link http://www.netspot.com.au}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class mod_assign_submission_form extends moodleform {

    /**
     * Define this form - called by the parent constructor
     */
    public function definition() {
        global $USER;
        $mform = $this->_form;
        list($assign, $data) = $this->_customdata;
        $instance = $assign->get_instance();
        if ($instance->teamsubmission) {
            $submission = $assign->get_group_submission($data->userid, 0, true);
        } else {
            $submission = $assign->get_user_submission($data->userid, true);
        }
        if ($submission) {
            $mform->addElement('hidden', 'lastmodified', $submission->timemodified);
            $mform->setType('lastmodified', PARAM_INT);
        }
        
    
        $mform->addElement('html', '<h4 style="font-size:40px;"><b>Badkan submissions</b></h4>');

        $mform->addElement('text', 'git_url', 'Github url'); // Add elements to your form
        $mform->setType('git_url', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('git_url', 'Please enter the Github url');        //Default value

        $mform->addElement('text', 'user_email', 'Email'); // Add elements to your form
        $mform->setType('user_email', PARAM_NOTAGS);                   //Set type of element
        $mform->setDefault('user_email', 'enter your email');        //Default value

        $mform->addElement('password', 'user_password', ' Password'); // Add elements to your form
        $mform->setType('user_password', PARAM_NOTAGS);                   //Set type of element

        $mform->addElement('html', '
             <a id="mybutton" href="/mod/assign/edit_badkan.php/" title="link to google.com">       
            <input type="button"
              name = "button1"
             style= "background-color:royalblue ; color:white;
               width:180px ;
               height:50px ;"
             value= "Submit to badkan >>"
            />
            </a>');


        $mform->addElement('html', '<pre>   </pre>');
        $mform->addElement('html', '<hr>');
        $mform->addElement('html', '<h4 style="font-size:40px;"><b>other submissions</b></h4>');
        $assign->add_submission_form_elements($mform, $data);
        $this->add_action_buttons(true, get_string('savechanges', 'assign'));
        if ($data) {
            $this->set_data($data);
        }
    }
}