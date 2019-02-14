<?php
function XMLParsing($xmlCVObject) {

}

function TagB($string) {
    $string2 = '<b>'.$string.'</b>';
     return $string2;
}
function NewLine($string) {
    $string2 = '<br>'.$string.'</br>';
    return $string2;
}



function get_name($XMLObject) {
    $name = $XMLObject->LearnerInfo->Identification->PersonName->FirstName.' '.$XMLObject->LearnerInfo->Identification->PersonName->Surname;
    return $name;
}
function get_adress($XMLObject) {}
function get_contacts($XMLObject) {
    $contacts = NewLine('Email: '.$XMLObject->LearnerInfo->Identification->ContactInfo->Email->Contact);
    $contacts = $contacts.NewLine('Telephone: '.$XMLObject->LearnerInfo->Identification->ContactInfo->TelephoneList->{'0'}->Contact);
    return $contacts.'qq';
}
function get_web_sites($XMLObject) {
    return $XMLObject->LearnerInfo->Identification->ContactInfo->WebsiteList->Website->Contact;
}
function get_messagers($XMLObject){

    $skype = NewLine('Skype: '.$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'0'}->Use->Code);
    $icq = NewLine('icq: '.$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'1'}->Use->Code);
    $aim = NewLine('aim: '.$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'2'}->Use->Code);
    $msn = NewLine('msn: '.$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'3'}->Use->Code);
    $yahoo = NewLine('yahoo: '.$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'4'}->Use->Code);
    return $skype.$icq.$aim.$msn.$yahoo;
}
function get_personal_info($XMLObject) {
    $statement = NewLine('Personal info: '.$XMLObject->LearnerInfo->Headline->Type->Code->Label);
    return $statement;
}
function get_work_experiance($XMLObject) {
    $work = NewLine('Work: '.$XMLObject->LearnerInfo->WorkExperienceList);
    return $work;
}
function get_education($XMLObject) {
    $education = NewLine('Education: '.$XMLObject->LearnerInfo->Skills);
    return $education;
}
function get_skills($XMLObject) {
    $skills = NewLine('Skills: '.$XMLObject->LearnerInfo->EducationList);
    return $skills;
}
function get_achivment($XMLObject) {
    $achivment = NewLine('Achivment: '.$XMLObject->LearnerInfo->AchievementList);
    return $achivment;
}
function get_cover_letter($XMLObject) {         //html yet
    $letter = NewLine('Cover Letter: '.$XMLObject->CoverLetter->Letter->Body->MainBody);
    return $letter;}