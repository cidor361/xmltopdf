<?php

$courseid = 2;
$time_from = 1577836800;
$time_to = 1594809145;

//Информация о курсе
$query_courseinfo = "SELECT id AS courseid, shortname, fullname FROM mdl_course 
WHERE courseid=$courseid AND timecreated BETWEEN $time_from AND $time_to;";

//Количество пользователей заходивших хотя бы раз в курс
$query_all_user_access = "SELECT DISTINCT(userid) from mdl_logstore_standard_log 
WHERE userid > 1 AND target='course' AND action='viewed' AND courseid='2';"; //Без target='course' больше!

//Количество всего заходов пользователей
$query_user_all_access = "SELECT COUNT(userid) from mdl_logstore_standard_log 
WHERE userid > 1 AND courseid='2' AND target='course_module';"; //Уточнить варианты доступа!
//+ Среднее количество заходов на студента

//Общее количество вопросов в бланке
//TODO: Найти таблицу с вопросами

//Количество вопросов, добавленный за период

