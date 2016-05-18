<?php
require_once "../model/persist/DBConnect.php";
require_once "../model/persist/EntityInterfaceADO.php";
require_once "../model/Menus/CourseClass.php";

class CourseADO implements EntityInterfaceADO {
    //Queries
    const SELECT_ALL_COURSES= "SELECT * FROM course ORDER BY priority";
    const INSERT_COURSE = "INSERT INTO `course`(`course_id`, `course_name`, `priority`) VALUES (?, ?, ?)";
    const DELETE_COURSE = "DELETE FROM `course` WHERE `course_id` = ?";
    const UPDATE_COURSE = "UPDATE `course` SET `course_name` = ?, `priority` = ? WHERE `course_id` = ?";
    
    private $dataSource;

    public function __construct() {
        $this->dataSource = DBConnect::getInstance();
    }

    public function create($course) {
        $array=[$course->getName(),$course->getPriority()];
        
        return $this->dataSource->executionInsert(self::INSERT_COURSE, $array);
    }

    public function delete($courseId) {
        return $this->dataSource->execution(self::DELETE_COURSE, $array=[$courseId]);
    }

    public function findAll() {
        return $this->dataSource->execution(self::SELECT_ALL_COURSES,$array=[]);
    }

    public function update($course) {
        $array = [
                $course->getName(),
                $course->getPriority(),
                $course->getId()
                ];
        
        return $this->dataSource->execution(self::UPDATE_COURSE,$array);
    }

}

