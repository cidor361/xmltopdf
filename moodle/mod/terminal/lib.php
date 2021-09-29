<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * This is a one-line short description of the file.
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_terminal
 * @category   mod
 * @copyright  2021 Igor Grebennikov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

function terminal_add_instance($terminal){
    global $DB;

    $terminal->timecreated = time();

    return $DB->insert_record('terminal', $terminal);
};
function terminal_update_instance($terminal){
    global $DB;

    $terminal->timemodified = time();
    $terminal->id = $terminal->instance;

    return $DB->update_record('terminal', $terminal);
};
function terminal_delete_instance($id){
    global $DB;

    if (! $terminal = $DB->get_record('terminal', array('id' => $id))) {
        return false;
    }

    $DB->delete_records('terminal', array('id' => $terminal->id));

    return true;
};

function create_main_VM($name) {

};

function create_clones($parent, $num_of) {

    return 1;
}
