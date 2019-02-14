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

    $skype = $XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'0'}->Use->Code;
    return $skype;
    $icq = $XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'1'}->Use->Code;
    return $icq;
    $aim = $XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'2'}->Use->Code;
    return $aim;
    $msn = $XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'3'}->Use->Code;
    return $msn;
    $yahoo = $XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'4'}->Use->Code;
    return $yahoo;
}
function get_personal_info($XMLObject) {
    $statement = $XMLObject->LearnerInfo->Headline->Type->Code->Label;
    return $statement;
}
function get_work_experiance($XMLObject) {
    $work = $XMLObject->LearnerInfo->WorkExperienceList;
    return $work;
}
function get_education($XMLObject) {
    $education = $XMLObject->LearnerInfo->Skills;
    return $education;
}
function get_skills($XMLObject) {
    $skills = $XMLObject->LearnerInfo->EducationList;
    return $skills;
}
function get_achivment($XMLObject) {
    $achivment = $XMLObject->LearnerInfo->AchievementList;
    return $achivment;
}
function get_cover_letter($XMLObject) {}