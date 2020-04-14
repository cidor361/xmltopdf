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
 * @package    block_userlist
 * @category   block
 * @copyright  2020 Igor Grebennikov
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

class block_userlist extends block_base {

    public function init() {
        $this->title = get_string('userlist', 'block_userlist');
    }
    
    public function get_content() {
        
		global $COURSE, $SESSION;
		
		if ($this->content != null) {
				return $this->content;
			}
			
        if (!has_capability('block/userlist:view', $this->context)) {
			return null;
		}
		
        $this->content = new stdClass;
 		$this->content->text = '<a href="'.'/blocks/userlist/index.php'.'">Скачать список студентов</a>';
		$SESSION->blockcontext = $this->page->context;
		$SESSION->courseid = $COURSE->id;
//		$context = get_context_instance(CONTEXT_COURSE, $COURSE->id);
				
    }
    
    function instance_allow_config() {
        return false;
    }
}
