<?php
namespace local_addition_vsu_data;

class general_data_vsu {
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

    function get_data_vsu($data_type) {
        global $DB;

        $fields = 'name';
        $sort = 'name';
        $table = '';

        if ($data_type == 'facultets') {
            $table = 'local_vsu_data_facultets';
        } elseif ($data_type == 'year') {
            $table = 'local_vsu_data_years';
        } elseif ($data_type == 'level') {
            $table = 'local_vsu_data_edustep';
        } elseif ($data_type == 'naprspec') {
            $table = 'local_vsu_data_specs';
        } elseif ($data_type == 'stform') {
            $table = 'local_vsu_data_eduforms';
        } elseif ($data_type == 'streamyear') {
            $table = 'local_vsu_data_streamyear';
        }

        $data = array();
        $result_fields = $DB->get_records($table, array(), $sort, $fields);
        foreach ($result_fields as $result_field) {
            if ($result_field->name != '' and $result_field->name != null) {
                $data[$result_field->name] = $result_field->name;
            }
        }
        return $data;
    }

    function get_all_vsu_data() {
        $data = array();
        $data['facultets'] = $this->get_data_vsu('facultets');
        $data['num_course'] = $this->get_data_vsu('year');
        $data['edu_forms'] = $this->get_data_vsu('stform');
        $data['edu_levels'] = $this->get_data_vsu('level');
        $data['edu_specialites'] = $this->get_data_vsu('naprspec');
        $data['streamyears'] = $this->get_data_vsu('streamyear');
        return $data;

    }

//    function get_edu_specialites_fac($ids)
//    {
//        global $DB;
//        $field_id = $this->ids['fac'];
//
//        $sql = "SELECT DISTINCT data
//            FROM mdl_user_info_data
//            WHERE fieldid = '" . $field_id . "';";
//        $results = $DB->get_records_sql($sql);
//
//        $i = 0;
//        $edu_specialites = array();
//        foreach ($results as $result) {
//            if ($result->data != '' and $result->data != null) {
//                $edu_specialites[$i] = $result->data;
//            }
//            $i++;
//        }
//
//        $edu_specialites = $this->reformat_array($edu_specialites);
//
//        return $edu_specialites;
//    }

}