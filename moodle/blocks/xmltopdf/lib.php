<?php
function TagH1($string) {
    $string = '<h1>'.$string.'</h1>';
    return $string;
}
//i - курсив
function TagI($string){
    $string = '<i>' . $string . '</i>';
    return $string;
}
//b - полужирный
function TagB($string){
    $string = '<b>' . $string . '</b>';
    return $string;
}
//ins - подчеркивание
function TagINS($string) {
    $string = '<ins>'.$string.'</ins>';
     return $string;
}
//p - отступ (абзац)
function TagP($string){
    $string = '<p>' . $string . '</p>';
    return $string;
}
//br - новая строка
function NewLine($string) {
    $string = '<br>'.$string;
    return $string;
}
//первый заголвок
function HeadLine($string) {
    $string = '<h1>'.$string.'</h1>';
    return $string;
}
//правый отступ
function RightSide($string) {
    $string = '<p align="right">'.$string.'</p>';
    return $string;
}



function get_name($XMLObject) {
    $personalName = $XMLObject->LearnerInfo->Identification->PersonName;
    $name = $personalName->FirstName.' '.$personalName->Surname;
    return $name;
}
function get_adress($XMLObject) {
    //TODO: adress
}
function get_contacts($XMLObject) {
    $contactInfo = $XMLObject->LearnerInfo->Identification->ContactInfo;
    $contacts = NewLine('Email: '.$contactInfo->Email->Contact);
    $num = count($contactInfo->TelephoneList) + 1;
    for ($i = 0; $i < $num; $i++) {
        if (!empty($contactInfo->TelephoneList->Telephone->{$i}->Contact)) {
            $contacts = $contacts . NewLine($contactInfo->TelephoneList->Telephone->{$i}->Use->Code . ': ');
            $contacts = $contacts . $contactInfo->TelephoneList->Telephone->{$i}->Contact;
        }
    }
    return $contacts;
}
function get_web_sites($XMLObject) {
    return $XMLObject->LearnerInfo->Identification->ContactInfo->WebsiteList->Website->Contact;
    //TODO: Цикл
}
function get_messagers($XMLObject) {
    $massageList = $XMLObject->LearnerInfo->Identification->ContactInfo->InstantMessagingList->InstantMessaging;
    $num = count($massageList) + 1;
    $massage = '';
    for ($i = 0; $i < $num; $i++) {
        if (!empty($massage.$massageList->{$i}->Contact)) {
            $massage = $massage . NewLine(TagI($massageList->{$i}->Use->Code) . ': ');
            $massage = $massage . $massageList->{$i}->Contact;
        }
    }
    return $massage;
}
function get_personal_info($XMLObject) {
    $personalInfo = $XMLObject->LearnerInfo->Headline;
    $statement = '';
    if (!empty($personalInfo->Description->Label)) {
        $statement = NewLine($personalInfo->Type->Label . ': ');
        $statement = $statement.NewLine($personalInfo->Description->Label);
    }
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
    $skillsInfo = $XMLObject->LearnerInfo->Skills;
    $skills = NewLine($skillsInfo->Other->Description);
    return $skills;
}
function get_achivment($XMLObject) {
    $achivmentList = $XMLObject->LearnerInfo->AchievementList->Achievement;
    $achivment = '';
    $num = count($achivmentList) + 1;
    for ($i = 0; $i < $num; $i++) {
        $achivment = $achivment.NewLine($achivmentList->{'$i'}->Title->Label.': ');
        $achivment = $achivment.$achivmentList->{'$i'}->Description;
    }
    return $achivment;
}
function get_cover_letter($XMLObject) {
    $letter = NewLine(TagB('Cover Letter: ').$XMLObject->CoverLetter->Letter->Body->MainBody);
    return $letter;
}