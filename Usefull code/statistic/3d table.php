<?php

$courseid = 2;
$time_from = 1577836800;
$time_to = 1594809145;

//Информация по элементам курса вцелом
$query_course_mods = "SELECT component, timecreated FROM mdl_logstore_standard_log 
WHERE courseid=$courseid AND target='course_module';";

//Количество заходов студентов в модуль курса за период
