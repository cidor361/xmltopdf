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
 * @package    block_coursefields
 * @category   block
 * @copyright  2008 Kim Bloggs
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require(__DIR__.'../../config.php');
require_once(__DIR__.'constructor.php');
require_once(__DIR__.'info.php');
require_login($internal_courseid);

$internal_courseid = $SESSION->internal_courseid;
$id = $SESSION->id;

$context = get_context_instance(CONTEXT_COURSE, $internal_courseid);

$PAGE->set_url('/blocks/coursefields/sendlist.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title(get_string('course_fields', 'block_coursefields'));
$PAGE->set_heading(get_string('course_fields', 'block_coursefields'));
$PAGE->set_context(context_course::instance($internal_courseid));

if ($DB->record_exists('block_coursefields',array('internal_courseid' => $internal_courseid))) {
    $Object = $DB->get_record('block_coursefields', array('internal_courseid' => $internal_courseid), '*', MUST_EXIST);
        }
$Object = get_obj_from_json($Object);
$mform = create_simple_field($Object, $USER->id, $context);
$json = get_json_for_sending($Object, $info);

if ($mform->is_cancelled()) {
    $url = new moodle_url('/blocks/coursefields/list.php');
    redirect($url);
} else if ($data = $mform->get_data()) {
    $login_password = 'riapolov@vsu.ru:vsu_2019';
    $response = add_course($info['address'], $json, $login_password);
    $responseObj = json_decode($response);
    if ($responseObj->course_id != null) {
        $responseo = '<b>Отправка курса прошла успешно! Id курса: </b>'.$responseObj->course_id;
        $Object_for_db->external_courseid = $responseObj->course_id;
        $Object_for_db->id = $id;
        $DB->update_record('block_coursefields', $Object_for_db);
        }

} else {

}

echo $OUTPUT->header();
$mform->display();
if (!empty($responseo)){
    echo var_dump($response).'</br>';}
// if (file_put_contents("test.txt", $json)){echo "Sucsess write file!";}else{echo "Fail write file!";}
echo $OUTPUT->footer();
