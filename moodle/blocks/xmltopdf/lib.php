<?php
function TagH1($string) {
    $string = '<h1>'.$string.'</h1>';
    return @$string;
}
//i - курсив
function TagI($string){
    $string = '<i>' . $string . '</i>';
    return @$string;
}
//b - полужирный
function TagB($string){
    $string = '<b>' . $string . '</b>';
    return @$string;
}
//ins - подчеркивание
function TagINS($string) {
    $string2 = '<ins>'.$string.'</ins>';
     return $string2;
}
//p - отступ
function TagP($string){
    $string = '<p>' . $string . '</p>';
    return @$string;
}
//br - новая строка
function NewLine($string) {
    $string2 = '<br>'.$string;
    return $string2;
}



function get_name($XMLObject) {
    $name = $XMLObject->LearnerInfo->Identification->PersonName->FirstName.' '.$XMLObject->LearnerInfo->Identification->PersonName->Surname;
    return $name;
}
function get_adress($XMLObject) {}
function get_contacts($XMLObject) {
    $contacts = NewLine('Email: ' . $XMLObject->LearnerInfo->Identification->ContactInfo->Email->Contact);
    $num = count($XMLObject->LearnerInfo->Identification->ContactInfo->TelephoneList) + 1;
    for ($i = 0; $i < $num; $i++) {
        $contacts = $contacts.NewLine($XMLObject->LearnerInfo->Identification->ContactInfo->TelephoneList->Telephone->{$i}->Use->Code.': ');
        $contacts = $contacts.$XMLObject->LearnerInfo->Identification->ContactInfo->TelephoneList->Telephone->{$i}->Contact;
    }
    return $contacts;
}
function get_web_sites($XMLObject) {
    return $XMLObject->LearnerInfo->Identification->ContactInfo->WebsiteList->Website->Contact;
}
function get_messagers($XMLObject){
    $skype = NewLine(TagI('Skype: ').$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'0'}->Use->Code);
    $icq = NewLine(TagI('icq: ').$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'1'}->Use->Code);
    $aim = NewLine(TagI('aim: ').$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'2'}->Use->Code);
    $msn = NewLine(TagI('msn: ').$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'3'}->Use->Code);
    $yahoo = NewLine(TagI('yahoo: ').$XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging->{'4'}->Use->Code);
    return $skype.$icq.$aim.$msn.$yahoo;
}
function get_personal_info($XMLObject) {
    $statement = NewLine(TagB('Personal info: ').$XMLObject->LearnerInfo->Headline->Type->Code->Label);
    return $statement;
}
function get_work_experiance($XMLObject) {
    $work = NewLine(TagB('Work: ').$XMLObject->LearnerInfo->WorkExperienceList);
    return $work;
}
function get_education($XMLObject) {
    $education = NewLine(TagB('Education: ').TagINS($XMLObject->LearnerInfo->EducationList));
    return $education;
}
function get_skills($XMLObject) {
    $skills = NewLine(TagB('Skills: ').$XMLObject->LearnerInfo->Skills);
    return $skills;
}
function get_achivment($XMLObject) {
    $achivment = NewLine(TagB('Achivment: ').$XMLObject->LearnerInfo->AchievementList);
    return $achivment;
}
function get_cover_letter($XMLObject) {         //html yet
    $letter = NewLine(TagB('Cover Letter: ').$XMLObject->CoverLetter->Letter->Body->MainBody);
    return $letter;
}
