<?php
require_once('../../config.php');
require_once('list_form.php');

global $PAGE, $OUTPUT, $CFG;

$PAGE->set_url('/blocks/xmltopdf/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('XMLtoPDF');
$PAGE->set_heading(get_string('comeon', 'block_xmltopdf'));
$listform = new listform();
$listform->add_filepicker();
$listform->add_act_button();

if($listform->is_cancelled()) {

} else if ($listform->get_data()) {
    $filename = $listform->get_new_filename('userfile');
    $XMLString = $listform->get_file_content('userfile');
    $_SESSION["XMLString"] = $XMLString;
    $url = new moodle_url('/blocks/xmltopdf/list2.php');
    redirect($url);
} else {

}
echo $OUTPUT->header();
$listform->display();
echo $OUTPUT->footer();