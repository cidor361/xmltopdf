<?php
require '../../config.php';
require "$CFG->libdir/tablelib.php";

global $DB;

$PAGE->set_url('/blocks/course_statistic/statistic.php');
$PAGE->set_title('Статистика курса');
$PAGE->set_heading('Статистика курса');
echo $OUTPUT->header();

$courseid = 2;
$timefrom = -315619200;
$timeto = 1596635056;
$context = context_COURSE::instance($courseid);
$courses = $DB->get_records('course', array(), $sort = 'id', 'id');



$courseobject = $DB->get_record('course', array('id' => $courseid), '*');

//First table
$table = new html_table();

$table->head = array('ID курса', 'Краткое название курса', 'Полное название курса',
    'Количество пользователей заходивших в курс хотя бы раз', 'Количество заходов пользователей всего',
    'Среднее количество заходов в курс на одного студента', 'Общее количество вопросов в Банке тестовых заданий курса',
    'Количество вопросов в Банке тестовых заданий, добавленных течении периода');

$coursedata = $DB->get_record('course', array('id'=>$courseid), 'id,shortname,fullname');

$sql = "SELECT COUNT(DISTINCT userid) AS enter_once FROM mdl_logstore_standard_log 
WHERE userid > 1 AND target='course' AND action='viewed' AND courseid='$courseid';";
$coursedata->enter_once = $DB->get_record_sql($sql)->enter_once;

$sql = "SELECT COUNT(userid) AS enter_at_all FROM mdl_logstore_standard_log 
WHERE userid > 1 AND courseid='$courseid' AND (target='course' OR target='course_module');";
$coursedata->enter_at_all = $DB->get_record_sql($sql)->enter_at_all;
$enter_at_all = $coursedata->enter_at_all;

$num_of_user = count_enrolled_users($context,'block/course_statistic:countisers');
$coursedata->avg_enterance = $enter_at_all / $num_of_user;

$table->data[] = $coursedata;
echo html_writer::table($table);

//Second table
$table = new html_table();
$table->head = array('Номер курса', 'Краткое название курса', 'Полное название курса', 'Факультет', 'Кафедра',
    'Код и наименование направления', 'форма обучения', 'Код и наименование дисциплины', 'Семестр');
$data = $DB->get_record('course', array('id'=>$courseid), 'id,shortname,fullname');
$data->category = $DB->get_record('course_categories', array('id'=>$courseobject->category), 'name')->name;
$table->data[] = $data;
echo html_writer::table($table);

//Third table
$table = new html_table();
$table->head = array('№ эл-та в курсе', 'Тип элемента', 'Дата создания элемента',
    'Новизна элемента - создан после или до начала', 'Количество обращений студентов к элементу за период',
    'Для элементов Глоссарий, Форум, База данных указывается параметр «Метод расчета итога»');
$modules_info = $DB->get_records('course_modules', array("course"=>$courseid), $sort = '', 'id,module,added');
$num = count($modules_info);
for($i = 1; $i <= $num; ++$i){

    $id = $modules_info[$i]->id;
    $modules = new stdClass();
    $modules->num = $i;
    $modules->type = $DB->get_record('modules', array('id'=>$modules_info[$i]->module), 'name')->name;
    $modules->date = date('Y-m-d h:i', $modules_info[$i]->added);
    if ($modules_info[$i]->added > $timefrom) {
        $modules->new_element = 'Новый';
    } else {
        $modules->new_element = 'Старый';
    }
    $sql = "SELECT COUNT(userid) 
            FROM mdl_logstore_standard_log 
            WHERE objectid=$id AND courseid=$courseid;";
    $modules->access_at_all = $DB->get_record_sql($sql)->count;

    $table->data[] = $modules;
}

echo html_writer::table($table);

echo var_dump($num_of_user);

