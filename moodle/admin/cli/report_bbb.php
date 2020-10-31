<?php
define('CLI_SCRIPT', true);
require('/var/www/moodle-3.9.1+/config.php');

$time_from = 1593561600; // 1 august 2020

//get all instance of bbb from date
$sql = 'SELECT id, name, timecreated, course 
        FROM mdl_bigbluebuttonbn 
        WHERE timecreated>"'.$time_from.'" LIMIT 20;';
$modules = $DB->get_records_sql($sql);

$csv_file = fopen('report_bbb '.date("H:m").'.csv', "w");

foreach($modules as $module) {
    //get course info
    $course =  $DB->get_record('course', array('id'=>$course->id));

    fputcsv($csv_file, array($module->id, $module->name,
        date('Y-m-d', $module->timecreated), $course->fullname));
}
fclose($csv_file);