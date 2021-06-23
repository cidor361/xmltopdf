<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add('localplugins', new admin_category('local_addition_vsu_data_settings', new lang_string('pluginname', 'local_addition_vsu_data')));
    $settingspage = new admin_settingpage('managelocalhelloworld', new lang_string('manage', 'local_addition_vsu_data'));

    if ($ADMIN->fulltree) {
        $settingspage->add(new admin_setting_configcheckbox(
            'local_addition_vsu_data/showinnavigation',
            new lang_string('showinnavigation', 'local_addition_vsu_data'),
            new lang_string('showinnavigation_desc', 'local_addition_vsu_data'),
            1
        ));
    }

    $ADMIN->add('local_addition_vsu_data', $settingspage);
}
