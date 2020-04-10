<?php
require_once('../../config.php');
require_once($CFG->libdir.'/pdflib.php');

$context = context_course::instance($SESSION-courseid);

$PAGE->set_url('/blocks/userlist/index.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('Скачать список студентов');
$PAGE->set_heading('Список дтудентов');
//$PAGE->set_context($context);

$users = get_enrolled_users($context);

$coursename = '<b>'.$COURSE->fullname.'</b></br>';
$i = 1;
$reportusers = array();
foreach($users as $user) {
	$reportusers[$i] = $user->lastname.','.$user->firstname.','.$user->middlename.','.$user->email;
	$i = $i + 1;	
}

echo $OUTPUT->header();
print(var_dump($USER));

