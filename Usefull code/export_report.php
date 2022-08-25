    <?php
public function downloadall_csv_file()
    {
        global $USER;

        $delimiter = ';';
        $newline =  PHP_EOL;

        $contextid = \context_system::instance()->id;
        $component = 'local_report_constructor';
        $filearea = $this->table->id . '_report_csv';
        $itemid = 0;

        self::delete_old_files($filearea);

        $fs = get_file_storage();

        $fileinfo = array(
            'userid' => $USER->id,
            'contextid' => $contextid, // ID of context
            'component' => $component,     // usually = table name
            'filearea' => $filearea,     // usually = table name
            'itemid' => $itemid,               // usually = ID of row in table
            'filepath' => '/',           // any path beginning and ending in /
            'filename' => 'report.csv'); // any filename

        $data = self::get_all_data();
        $content = '';
        foreach ($data as $d) {
            foreach ($d as $string) {
                $content .= $string . $delimiter;
            }
            $content = substr($content, 0, -1);
            $content .= $newline;
        }

        $fs->create_file_from_string($fileinfo, $content);

        $files = $fs->get_area_files($contextid, $component, $filearea, $itemid, '', false);

        foreach ($files as $file) {
            $url = moodle_url::make_pluginfile_url($file->get_contextid(),
                $file->get_component(), $file->get_filearea(), $file->get_itemid(),
                $file->get_filepath(), $file->get_filename(), true);
        }

        $br = html_writer::empty_tag('br');

        return $br . \html_writer::link($url, 'Скачать csv', ['class' => 'btn btn-primary float-sm-right float-right']);
    }

    //!!!НЕ ГОТОВА!!!
    public function downloadall_xlsx_file()
    {
        require_once("$CFG->libdir/excellib.class.php");
        global $USER;

        $workbook = new \MoodleExcelWorkbook("name");
        $myxls = $workbook->add_worksheet('name');
        $myxls->write_string(0,0,"Hello");
        $myxls->write_string(0,1,"Bye");
        $workbook->close();

        var_dump($workbook);


        $delimiter = ';';
        $newline =  PHP_EOL;

        $contextid = \context_system::instance()->id;
        $component = 'local_report_constructor';
        $filearea = $this->table->id . '_report_xlsx';
        $itemid = 0;

        self::delete_old_files($filearea);

        $fs = get_file_storage();

        $fileinfo = array(
            'userid' => $USER->id,
            'contextid' => $contextid, // ID of context
            'component' => $component,     // usually = table name
            'filearea' => $filearea,     // usually = table name
            'itemid' => $itemid,               // usually = ID of row in table
            'filepath' => '/',           // any path beginning and ending in /
            'filename' => 'report.xlsx'); // any filename

        $data = self::get_all_data();
        $content = '';
        foreach ($data as $d) {
            foreach ($d as $string) {
                $content .= $string . $delimiter;
            }
            $content = substr($content, 0, -1);
            $content .= $newline;
        }

        $fs->create_file_from_string($fileinfo, $content);

        $files = $fs->get_area_files($contextid, $component, $filearea, $itemid, '', false);

        foreach ($files as $file) {
            $url = moodle_url::make_pluginfile_url($file->get_contextid(),
                $file->get_component(), $file->get_filearea(), $file->get_itemid(),
                $file->get_filepath(), $file->get_filename(), true);
        }

        $br = html_writer::empty_tag('br');

        return $br . \html_writer::link($url, 'Скачать xlsx', ['class' => 'btn btn-primary float-sm-right float-right']);
    }


    private function delete_old_files($filearea)
    {
        global $USER;

        $contextid = \context_system::instance()->id;
        $component = 'local_report_constructor';
        $itemid = 0;
        $fs = get_file_storage();
        $files = $fs->get_area_files($contextid, $component, $filearea, $itemid, '', false);
        foreach ($files as $file) {
            if ($file->get_userid() == $USER->id) $file->delete();
        }

        return true;
    }
