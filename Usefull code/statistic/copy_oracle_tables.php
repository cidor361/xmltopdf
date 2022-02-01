<?php
//Подключить файл с данными для подключения
require_once('config.php');
require_once('connect.php');

global $DB;

//Таблицы oracle
$oracle_study_work = 'moodle_study_work_view';
$oracle_subject = 'moodle_subject_view';

//Таблицы в moodle
$moodle_study_work = '';
$moodle_subject = '';

//Массив с таблицами
$tables = [{$oracle_study_work} => $moodle_study_work,
			{$oracle_subject} => $moodle_subject];

//Количественные характеристики
$number_of = 1000;

//Перебор таблиц
foreach ($tables as $oracle_table => $moodle_table) {
	$lastid = count_rows_moodle($moodle_table);
	$number_of_rows = count_oracle_rows($oracle_table);
	$iteration = 0;
	while ($number_of_rows != 0) {
		[$num_of_rows_iteration, $rows] = get_records($conn, $oracle_table, $number_of, $lastid + 1);
		foreach ($rows as $key->$row) {
			$row->{$key}->oci_id = $key;
			unset($row->{$key}->id);
			$lastid = $key;
		}
		$status = $DB->insert_records($moodle_table, $rows);
		echo 'Итерация: ' . $iteration . '; Количество записей: ' . $number_of . 'Статус: ' . $status . '</br>';
		$iteration += 1;
		$number_of_rows -= 1000;
		if (number_of_rows <= 0) breake;
		}
	}





function count_oracle_rows($table) {
	$sql = "SELECT count(*)
			FROM '" . $table . "';"
}

function get_records($conn, $table, $number_of, $first_id) {
	$first_id = $first_id - 1;
	$sql = "SELECT *
			FROM  '" . $table . "'
			WHERE id > $first_id
			ORDER BY id ASC
			LIMIT " . $number_of . ";"
	$stid = oci_parse($conn, $sql);
	oci_execute($stid);
	$nrows = oci_fetch_all($stid, $rows);
	return [$nrows, (object)$rows];
}

function get_last_id_moodle($table) {
	global $DB;
	
	if ($DB->record_exists($table)){
		$sql = "SELECT MAX(id) 
				FROM " . $table . ";";
		$result = $DB->get_record_sql($sql);
		foreach ($result as $value) {
			return $value;
		}
		
	} else {
		return 0;
	}
}
