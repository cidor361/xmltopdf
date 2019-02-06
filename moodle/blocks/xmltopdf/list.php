<?php
require_once('../../config.php');
require_once('list_form.php');
require_once($CFG->libdir.'/pdflib.php');

global $PAGE, $OUTPUT, $USER, $CFG;

$PAGE->set_url('/blocks/xmltopdf/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('XMLtoPDF');
$PAGE->set_heading(get_string('comeon', 'block_xmltopdf'));
$PAGE->set_context(context_user::instance($USER->id, MUST_EXIST));
$listform = new listform();
$listform->add_filepicker();
$listform->add_act_button();

if($listform->is_cancelled()) {
    print "qq";
    $site = get_site();
    echo $OUTPUT->header();
    $listform->display();
    echo $OUTPUT->footer();

} else if ($listform->get_data()) {
    print "qqq\n";
    $filename = $listform->get_new_filename('userfile');
    $textXML = $listform->get_file_content('userfile');
    $xmlCVObject = simplexml_load_string($textXML);

    $file = $xmlCVObject;
    $itemid = file_get_unused_draft_itemid($USER->id);
    $filenamePDF = 'qqmbr.txt';
    $filepath = $CFG->dirroot.'/blocks/xmltopdf/temp/';

    $success = $listform->save_file($filenamePDF, $filepath, true);
    $listform->add_simple_text('Success', $success);
    $storedfile = $listform->save_temp_file($filenamePDF);
//    $storedfileqq = $listform->save_stored_file($filenamePDF, )

    $site = get_site();
    echo $OUTPUT->header();
    $listform->display();
    echo $OUTPUT->footer();

} else {
    print 'q';
    echo $OUTPUT->header();
    $listform->display();
    echo $OUTPUT->footer();
}