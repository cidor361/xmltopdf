<?php

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}
require_once('lib.php');
require_once($CFG->libdir . '/formslib.php');

class group_autoenrol_form extends moodleform
{
    public $id;

    function definition()
    {
        global $SESSION;

        $mform =& $this->_form;

        $groups_of_users = $SESSION->groups_of_users;
        $students = array();
        if ($groups_of_users != null) {
            foreach ($groups_of_users as $key=>$group) {
                if ($group != null) {
                    $mform->addElement('header', $key, 'Группа №'.$key);
                    $mform->setExpanded($key, true);
                    foreach ($group as $user){
                        if ($user->enrolled) {
                            $enrolled = 'Зачислен';
                        } else {
                            $enrolled = '';
                        }
                        $mform->addElement('static', $user->id, $enrolled, $user->firstname .' '. $user->lastname);
                    }
                }
            }

            $this->add_action_buttons($cancel = true, $submitlabel = 'Подписать группы');
        }
    }

}


//TODO: уменьшить размер между галочками
