<?php
/*
 * !!НЕ ТЕСТИРОВАЛСЯ!!
 * This script allows you to get a report on all instances
 * of anti-plagiarism from a certain date.
 * Script create csv file with "antiplagiasm_report current time .csv
*/

require('../../config.php');
require_once($CFG->libdir . '/clilib.php');

define('CLI_SCRIPT', true);

list($options, $unrecognised) = cli_get_params([
    'help' => false,
    'time' => null,
    'force' => false,
], [
    'h' => 'help',
    't' => 'time',
    'f' => 'force'
]);

//if (!$unrecognised) {
//    cli_error(get_string('cliunknowoption', 'core_admin', $unrecognised));
//}

$time_from = $unrecognised[0];
$time_from = strtotime($time_from);

//get all instance of antiplagiasm from date
$sql = 'SELECT id, cm, userid, similarityscore, lastmodified, reporturl 
        FROM mdl_plagiarism_apru_files 
        WHERE lastmodified>'. $time_from .';';
$modules = $DB->get_records_sql($sql);

$csv_file = fopen('antiplagiasm_report ' . date('H:m') . '.csv', 'w');

foreach ($modules as $module) {
    //get courseid from courseelement info
    $sql = 'SELECT * FROM mdl_course_modules WHERE id='.$module->cm;
    $module_info = $DB->get_record_sql($sql);
    $course = $DB->get_record('course', array('id' => $module_info->course));

    //get user info
    $user = $DB->get_record('user', array('id'=>$module->userid));

    //get cafedra and faculty info
    $cafedra_info = $DB->get_record('course_categories', array('id' => $course->category), 'name,parent');
    $cafedra = $cafedra_info->name;
    $parent = $cafedra_info->parent;
    $faculty = $DB->get_record('course_categories', array('id' => $parent), 'name');
    $faculty = $faculty->name;

    fputcsv($csv_file, array($module->id, $user->firstname, $user->lastname,
                             date('Y-m-d', $module->lastmodified), 'цk',
                             $course->fullname, $faculty, $cafedra, $module->reporturl));
}

fclose($csv_file);
