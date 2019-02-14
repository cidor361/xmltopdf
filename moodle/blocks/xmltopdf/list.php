<?php
require_once('../../config.php');
require_once('list_form.php');
require_once($CFG->libdir.'/pdflib.php');
require_once('lib.php');

global $PAGE, $OUTPUT, $CFG;

$PAGE->set_url('/blocks/xmltopdf/list.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('XMLtoPDF');
$PAGE->set_heading(get_string('comeon', 'block_xmltopdf'));
$listform = new listform();
$listform->add_filepicker();
$listform->add_act_button();

if($listform->is_cancelled()) {
//    print "qq";
    $site = get_site();
    echo $OUTPUT->header();
    $listform->display();
    echo $OUTPUT->footer();

} else if ($listform->get_data()) {
    $filename = $listform->get_new_filename('userfile');
    $XMLString = $listform->get_file_content('userfile');
    $xmlCVObject = simplexml_load_string($XMLString);
//    echo var_dump($xmlCVObject);
    echo get_name($xmlCVObject);
    echo NewLine(get_contacts($xmlCVObject));

//    $filename = 'Portfolio.pdf';
//    $pdf = new pdf;
//    $pdf->AddPage();
////    $pdf->Write(1, $XMLString);
//    $pdf->writeHTML($XMLString, true, false, false, false, 'qqqqq');
//    $pdf->Output($filename, 'D');
} else {
//    print 'q';
    echo $OUTPUT->header();
    $listform->display();
    echo $OUTPUT->footer();
}
