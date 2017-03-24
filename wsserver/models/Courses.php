<?php
class Courses {
    private $_courses = [
        [
            'id' => 1,
            'code' => '01418101',
            'name' => 'Computer 101'
        ],
        [
            'id' => 2,
            'code' => '01418102',
            'name' => 'Computer 102'
        ],
        [
            'id' => 3,
            'code' => '01418103',
            'name' => 'Computer 103'
        ],
        [
            'id' => 4,
            'code' => '01418104',
            'name' => 'Computer 103'
        ],
    ];

    public function getCourses($id = false) {
        if (!$id) {
            return $this->_courses;
        } else {
            $key = array_search($id, array_column($this->_courses, 'id'));
            return ($key !== false) ? $this->_courses[$key]: null;
        }
    }

    public function getCourseByCode($code = false) {
        if (!$code) {
            return null;
        } else {
            $key = array_search($code, array_column($this->_courses, 'code'));
            return ($key !== false) ? $this->_courses[$key]: null;
        }
    }
}
