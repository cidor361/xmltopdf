<?php
require_once('../../config.php');
require_once('list_form.php');

global $PAGE, $OUTPUT, $CFG;

$PAGE->set_url('/blocks/xmltopdf/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('XMLtoPDF');
$PAGE->set_heading(get_string('comeon', 'block_xmltopdf'));
$listPortfForm = new listPortfForm();
$listPortfForm->add_filepicker();
$listPortfForm->add_act_button();

if($listPortfForm->is_cancelled()) {

} else if ($listPortfForm->get_data()) {
    $filename = $listPortfForm->get_new_filename('userfile');
    $XMLString = $listPortfForm->get_file_content('userfile');
    $_SESSION["XMLString"] = $XMLString;
    $url = new moodle_url('/blocks/xmltopdf/list2.php');
    redirect($url);
} else {

}
echo $OUTPUT->header();
$listPortfForm->display();
echo $OUTPUT->footer();