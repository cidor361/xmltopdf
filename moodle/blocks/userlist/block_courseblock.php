<?php
class block_userlist extends block_base {

    public function init() {
        $this->title = get_string('userlist', 'block_userlist');
    }
    
    public function get_content() {
        
		global $COURSE, $SESSION;
		
		if ($this->content != null) {
				return $this->content;
			}
        
        $this->content = new stdClass;
 		$this->content->text = '<a href="'.'/blocks/userlist/index.php'.'">Скачать список студентов</a>';
		$SESSION->courseid = $COURSE->id;
            
        return $this->content;
    }
    
    function instance_allow_config() {
        return false;
    }
}
