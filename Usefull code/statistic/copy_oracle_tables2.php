<?php

require('config.php');

//Дублирование данных для подключения (переменная $conn)
require_once('blocks/usermanager/connect.php');

global $USER, $DB;

$table = 'vsu_subject_new';

//глобальная переменная содержащая данные для подключения к Oracle (объявлена в одном из плагинов)
global $conn;

//Часть отвечающая за выполнение запроса, после которого получается объект результата и парсится с помощью функций oci_fetch_*()
    $sql = 'SELECT * FROM moodle_study_work_view SW JOIN (SELECT * FROM moodle_subject_view WHERE study_year='2021') SU ON SW.subj_id=SU.subj_id;
    $stid = oci_parse($conn, $sql);
    $r = oci_execute($stid);

//Парсинг результата запроса
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {

        $record = new stdClass();

//$record->field - поля в таблице moodle
//$row['FIELD'] - поля из oracle (могут называться без префикса (SU.)

        $record->subj_id = $row['SU.SUBJ_ID'];

        $record->study_year = $row['SU.STUDY_YEAR'];

        $record->semester = $row['SW.SEMESTER'];

        $record->work_id = $row['SW.WORK_ID'];

        $record->faculty = $row['SU.FACULTY'];

        $record->step = $row['SU.STEP'];

        $record->speciality_code = $row['SU.SPECIALITY_CODE'];

        $record->speciality = $row['SU.SPECIALITY'];

        $record->st_form = $row['SU.ST_FORM'];

        $record->specialisation = $row['SU.SPECIALISATION'];

        $record->chair = $row['SU.CHAIR'];

        $record->subj_code = $row['SU.SUBJ_CODE'];

        $record->subj_name = iconv('', '', substr($row['SU.SUBJ_NAME'], 0, 99));

        $record->time_add = time();

        if($DB->insert_record($table, $record)) echo 'Запись добавлена' : 'Ошибка';
}
