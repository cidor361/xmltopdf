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
 * This is a one-line short description of the file.
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    block_userlist
 * @category   block
 * @copyright  2020 Igor Grebennikov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/user/profile/lib.php');

$courseid = required_param('courseid', PARAM_INT);

$coursecontext = context_course::instance($courseid);

if (!has_capability('block/userlist:view', $coursecontext)) {
  print_error('nopermissiontoviewforum');
} else {

    header('Content-Description: File Transfer');
    header('Content-Type: application/csv');
    header("Content-Disposition: attachment; filename=page-data-export.csv");
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

    $handle = fopen('php://output', 'w');
    ob_clean();
    $users = get_role_users(5, $coursecontext);
    $i = 1;
    foreach($users as $user) {
        $userdata = new stdClass();
        $userdata->id = $user->id;
        profile_load_data($userdata);
        $reportuser = $userdata->profile_field_naprspec.','.  //Направление
                      $userdata->profile_field_idgroup.','.   //Номер академической группы
                      $user->lastname.','.$user->firstname.','.    //ФИО
                      $user->middlename.','.$user->email;   //Почта
        $data = str_getcsv($reportuser);
        fputcsv($handle, $data);
        $i = $i++;
}
    ob_flush();
    fclose($handle);
}
