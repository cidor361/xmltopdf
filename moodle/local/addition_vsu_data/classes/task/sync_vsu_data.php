<?php
namespace addition_vsu_data\task;

defined('MOODLE_INTERNAL') || die();

use core\task\scheduled_task;
use stdClass;
use Exception;

class sync_vsu_data extends scheduled_task {

    public function  get_name() {
        return get_string('pluginname', 'sync_vsu_data');
    }

    public function execute() {

    }
}
