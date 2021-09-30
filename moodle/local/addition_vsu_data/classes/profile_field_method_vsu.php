<?php

/*
 * Устаревший класс используется для заполнения таблиц начальными данными
 */
class profile_field_method_vsu
{

    public $ids = array();

    function __construct()
    {
        /*
         * fac - Факультет //Физический факультет
         * year - Курс //4
         * stform - Форма обучения //Очная
         * level - Ступень //Бакалавр
         * naprspec - Код и наименование направления (специальности) //09.03.01 Информатика и вычислительная техника
         * naprspec2 - Наименование направления (специальности) //Информатика и вычислительная техника
         * specialityCode - Код направления (специальности) //09.03.01
         * profile - Профиль (специализация) //Вычислительные машины, комплексы, системы и сети (ФГОС3+)
         * streamyear - Год потока //2017
         * groupname - Номер группы //4
        */

        global $DB;

        $sql = "SELECT id, shortname 
            FROM mdl_user_info_field
            WHERE (shortname = 'fac') OR
                  (shortname = 'year') OR
                  (shortname = 'stform') OR
                  (shortname = 'level') OR
                  (shortname = 'naprspec') OR
                  (shortname = 'specialityCode') OR
                  (shortname = 'profile') OR
                  (shortname = 'naprspec2') OR
                  (shortname = 'streamyear') OR
                  (shortname = 'groupname');";
        $results = $DB->get_records_sql($sql);

        foreach ($results as $result) {
            $name = $result->shortname;
            $this->ids[$name] = $result->id;
        }
    }

    function get_facultet_names()
    {
        //Getting facultet names from DB
        global $DB;
        $field_id = $this->ids['fac'];

        $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '" . $field_id . "';";
        $results = $DB->get_records_sql($sql);
        $i = 0;
        $facultets = array();
        foreach ($results as $result) {
            if (($result->data != '') && ($result->data != null)) {
                $facultets[$i] = $result->data;
                $i++;
            }
        }
        $facultets = $this->reformat_array($facultets);

        return $facultets;
    }

    function get_num_course_name($ids)
    {
        global $DB;
        $field_id = $this->ids['year'];

        $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '" . $field_id . "';";
        $results = $DB->get_records_sql($sql);

        $i = 0;
        $nums_course = array();
        foreach ($results as $result) {
            if (($result->data != '') && ($result->data != null)) {
                $nums_course[$i] = $result->data;
                $i++;
            }
        }

        $nums_course = $this->reformat_array($nums_course);

        return $nums_course;
    }

    function get_edu_forms_name($ids)
    {
        global $DB;
        $field_id = $this->ids['stform'];

        $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '" . $field_id . "';";
        $results = $DB->get_records_sql($sql);

        $i = 0;
        $edu_forms = array();
        foreach ($results as $result) {
            if (($result->data != '') && ($result->data != null)) {
                $edu_forms[$i] = $result->data;
                $i++;
            }
        }

        $edu_forms = $this->reformat_array($edu_forms);

        return $edu_forms;
    }

    function get_edu_level_name($ids)
    {
        global $DB;
        $field_id = $this->ids['level'];

        $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '" . $field_id . "';";
        $results = $DB->get_records_sql($sql);

        $i = 0;
        $edu_levels = array();
        foreach ($results as $result) {
            if (($result->data != '') && ($result->data != null)) {
                $edu_levels[$i] = $result->data;
                $i++;
            }
        }

        $edu_levels = $this->reformat_array($edu_levels);

        return $edu_levels;
    }

    function get_edu_specialites_name($ids)
    {
        global $DB;
        $field_id = $this->ids['naprspec'];

        $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '" . $field_id . "';";
        $results = $DB->get_records_sql($sql);

        $i = 0;
        $edu_specialites = array();
        foreach ($results as $result) {
            if (($result->data != '') && ($result->data != null)) {
                $edu_specialites[$i] = $result->data;
                $i++;
            }
        }

        $edu_specialites = $this->reformat_array($edu_specialites);

        return $edu_specialites;
    }

    function get_edu_specialites_fac($ids)
    {
        global $DB;
        $field_id = $this->ids['fac'];

        $sql = "SELECT DISTINCT data
            FROM mdl_user_info_data
            WHERE fieldid = '" . $field_id . "';";
        $results = $DB->get_records_sql($sql);

        $i = 0;
        $edu_specialites = array();
        foreach ($results as $result) {
            if ($result->data != '' and $result->data != null) {
                $edu_specialites[$i] = $result->data;
            }
            $i++;
        }

        $edu_specialites = $this->reformat_array($edu_specialites);

        return $edu_specialites;
    }


    function reformat_array($array)
    {
        for ($i = 0; $i < count($array); $i++) {
            $sortkey[$i] = $array[$i]['price'];
        }

        asort($sortkey); //по возрастанию,
        //arsort($sortkey); //по убыванию

        foreach ($sortkey as $key => $key) {
            $sorted[] = $array[$key];
        }

        return $sorted;
    }

}