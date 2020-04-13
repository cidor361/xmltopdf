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
 * Plugin version and other meta-data are defined here.
 *
 * @package     block_userlist
 * @copyright   2020 Igor <cidor361@gmail.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once($CFG->dirroot.'/user/profile/lib.php');
$context = get_context_instance(CONTEXT_COURSE, $SESSION->courseid);

if (!has_capability('block/userlist:view', $context)) {

header('Content-Description: File Transfer');
header('Content-Type: application/csv');
header("Content-Disposition: attachment; filename=page-data-export.csv");
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

$handle = fopen('php://output', 'w');
ob_clean();
$users = get_role_users(5, $context);
$i = 1;
foreach($users as $user) {
	$myuser = new stdClass();
	$myuser->id = $user->id;
	profile_load_data($myuser);
	$reportuser = $myuser->profile_field_naprspec.','.
		$myuser->profile_field_idgroup.','.
		$user->lastname.','.$user->firstname.','.
		$user->middlename.','.$user->email;
	$data = str_getcsv($reportuser);
	fputcsv($handle, $data);
	$i = $i + 1;
}
ob_flush();
fclose($handle);
}
