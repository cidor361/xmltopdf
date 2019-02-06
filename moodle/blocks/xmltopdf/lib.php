<?php

function file_get_unused_draft_itemid($id) {
    global $DB, $USER;

    if (isguestuser() or !isloggedin()) {
        // guests and not-logged-in users can not be allowed to upload anything!!!!!!
        print_error('noguest');
    }

    $context=get_context_instance(CONTEXT_COURSE,$id);

    $fs = get_file_storage();
    $draftitemid = rand(1, 999999999);
    while ($files = $fs->get_area_files($context->id, 'block_groupreg', 'excel', $draftitemid)) {
        $draftitemid = rand(1, 999999999);
    }

    return $draftitemid;
}