<?php
/*
 * !!НЕ ТЕСТИРОВАЛСЯ!!
 * Позволяет получить информацию по выборке курсов (количество студентов, количество элементов в курсе,
 * кафедра и факультет)
 * Данные возвращаются в виде .csv файла
 */

define('CLI_SCRIPT', true);
require('../../config.php');

list($options, $unrecognised) = cli_get_params([
    'help' => false,
    'from_course' => null,
    'to_course' =>null,
    'force' => false,
], [
    'h' => 'help',
    's' => 'from',
    't' => 'to',
    'f' => 'force'
]);

global $DB;

$course_from = $unrecognised[0];
$course_to = $unrecognised[1];

//course_info
$sql = "SELECT id, fullname, timecreated, category 
        FROM mdl_course 
        WHERE id BETWEEN ".$course_from." AND ".$course_to.";";
$course_info = $DB->get_records_sql($sql);

$csv_file = fopen('mini-erport '.date("H:m").'.csv', "w");

foreach($course_info as $course) {
    //num_of_student
    $sql = "SELECT COUNT(DISTINCT userid) AS enter_once 
            FROM mdl_logstore_standard_log 
            WHERE userid > 1 AND target='course' AND action='viewed' AND courseid=".$course->id.";";
    $num_of_student = $DB->get_record_sql($sql)->enter_once;

    //num_of_elements
    $modules = $DB->get_records('course_modules', array("course"=>$course->id), $sort = '', 'id,module,added');
    $num_of_modules = count($modules);

    //num_of_students
    $sql = "SELECT COUNT(userid) AS enter_once 
            FROM mdl_logstore_standard_log 
            WHERE userid > 1 AND target='course' AND action='viewed' AND courseid=".$course->id.";";
    $num_of_users_at_all = $DB->get_record_sql($sql);
    $num_of_users_at_all = $num_of_users_at_all->enter_once;

    //get_cafedra_and_faculty
    $cafedra_info = $DB->get_record('course_categories', array('id' => $course->category), 'name,parent');
    $cafedra = $cafedra_info->name;
    $parent = $cafedra_info->parent;
    $faculty = $DB->get_record('course_categories', array('id' => $parent), 'name');
    $faculty = $faculty->name;

    //put_strings_in_file
    fputcsv($csv_file, array($course->id, $course->fullname, date('Y-m-d', $course->timecreated),
        $faculty, $cafedra, $num_of_student,
        $num_of_modules, $num_of_users_at_all));
}
fclose($csv_file);
