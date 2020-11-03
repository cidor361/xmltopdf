<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This is a one-line short description of the file.
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    block_coursefields
 * @category   block
 * @copyright  2020 Igor Grebennikov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once('comment_form.php');
require('lib.php');
require_login();


$PAGE->set_url('/blocks/coursefields/comment.php');
//$PAGE->set_pagelayout('standart');
$PAGE->set_title('Поля курса');
//$PAGE->set_heading('Отзыв');
$courseid = $SESSION->courseid;

//Проверка существует ли отзыв уже
//Получение данных из БД, если запись существует (имя таблицы, array(имя_поля => значение_поля))
$data = $DB->get_record();

$mform = new comment_form();

if($mform->is_cancelled()) {
    // Cancelled forms redirect to the course main page.
    $courseurl = new moodle_url('/course/view.php', array('id' => $courseid));
    redirect($courseurl);
} else if ($simplehtml->get_data()) {

} else {
    //Если отзыв уже существует, то в форму нужно подставить данные - функция set_data($data)
    $mform->set_data($data);
    echo $OUTPUT->header();
    $mform->display();
    echo $OUTPUT->footer();
}
