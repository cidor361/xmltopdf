<?php
function XMLParsing($xmlCVObject) {

}

function TagB($string) {
    $string2 = '<b>'.$string.'</b>';
     return $string2;
}



function get_name($XMLObject) {
    $name = $XMLObject->LearnerInfo->Identification->PersonName->FirstName.' '.$XMLObject->LearnerInfo->Identification->PersonName->Surname;
    return $name;
}
function get_adress($XMLObject) {}
function get_contacts($XMLObject) {
    $contacts = '';
    return $XMLObject->LearnerInfo->Identification->ContactInfo->Email->Contact;
}
function get_web_sites($XMLObject) {
    return $XMLObject->LearnerInfo->Identification->ContactInfo->WebsiteList->Website->Contact;
}
function get_messagers($XMLObject){

    $contacts = $XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'0'}->Use->Code;
    return $contacts;
}
function get_personal_info($XMLObject) {}
function get_work_experiance($XMLObject) {}
function get_education($XMLObject) {}
function get_skills($XMLObject) {}
function get_achivment($XMLObject) {}
function get_cover_letter($XMLObject) {}