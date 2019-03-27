<?php
require_once('../../config.php');
require_once('list_form.php');
require_once($CFG->libdir.'/pdflib.php');
require_once('lib.php');

global $PAGE, $OUTPUT, $CFG;

$PAGE->set_url('/blocks/xmltopdf/list2.php');
$PAGE->set_pagelayout('standart');
$PAGE->set_title('XMLtoPDF');
$PAGE->set_heading(get_string('comeon', 'block_xmltopdf'));
$listform = new listform();
$XMLString = $_SESSION["XMLString"];
$xmlCVObject = simplexml_load_string($XMLString);
$editstring = '';
$editstring = $editstring . TagH1(get_name($xmlCVObject));
$editstring = $editstring . get_contacts($xmlCVObject);
//    $editstring = $editstring . get_web_sites($xmlCVObject);
$editstring = TagP(get_messagers($xmlCVObject));
//    $editstring = get_personal_info($xmlCVObject);
//    $editstring = $editstring . get_work_experiance($xmlCVObject);
//    $editstring = $editstring . get_education($xmlCVObject);
$editstring = $editstring . get_skills($xmlCVObject);
$editstring = $editstring . get_achivment($xmlCVObject);
$editstring = $editstring . get_cover_letter($xmlCVObject);
$listform->add_text_editor('Резюме', $editstring, 'resume');
$listform->add_act_button();

if($listform->is_cancelled()) {

} else if ($listform->get_data()) {
    $data = $listform->get_data()->resume;
    $string = $data['text'];
    $filename = 'Portfolio.pdf';
    $pdf = new pdf;
    $pdf->AddPage();
    $pdf->writeHTML($string, true, false, false, false, $filename);
    $pdf->Output($filename, 'D');
} else {

}
echo $OUTPUT->header();
$listform->display();
echo $OUTPUT->footer();