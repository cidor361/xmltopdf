<?php

//Информация по курсам
$query_course_info = "SELECT id AS courseid, shortname, fullname FROM mdl_course ;";

// Факультет и Кафедра - категории курсов
$cafedra_info = $DB->get_record('course_categories', array('id' => $course->category), 'name,parent');
$cafedra = $cafedra_info->name;
$parent = $cafedra_info->parent;
$faculty = $DB->get_record('course_categories', array('id' => $parent), 'name');
$faculty = $faculty->name;

//TODO: Узнать про код дисциплин семестр и форму обучения

