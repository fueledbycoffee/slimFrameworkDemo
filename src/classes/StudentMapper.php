<?php

class StudentMapper extends BaseMapper {
  public function getStudents (bool $asArray = FALSE) {
    $sql = "SELECT * from students";
    $q = $this->db->query($sql);

    $results = [];

    while($row = $q->fetch()) {
      $results[] =  $asArray ? $row : new StudentEntity($row);
    }

    return $results;
  }

  public function getStudentById ($student_id, bool $asArray = FALSE) {
    $sql = "SELECT * FROM students s WHERE s.id = :student_id";
    $query = $this->db->prepare($sql);
    $result = $query->execute(["student_id" => $student_id]);

    if($result) {
      return $asArray ? $query->fetch() : new StudentEntity($query->fetch());
    }
  }

  public function create(StudentEntity $student, bool $asArray = FALSE ) {
    $sql = "INSERT INTO students
            (firstName, lastName) values (:firstName, :lastName)";
    $query = $this->db->prepare($sql);
    $result = $query->execute([
      "firstName" => $student->getFirstName(),
      "lastName" => $student->getLastName(),
    ]);
    

    if(!$result) {
      throw new Exception("Failed to create student");
    } else {
      return "ok";
    }
  }

  public function update(StudentEntity $student) {

  }

  public function remove($student_id) {

  }
}
