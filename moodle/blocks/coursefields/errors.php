<?php
function get_error($error_code) {
    switch ($error_code) {
        case 200:
            return 'Ok';
            break;
        case 201:
            return 'Студент зарегестрирован (Created)';
            break;
        case 424:
            return 'courseId не существует (Failed Dependency)';
            break;
    }
}