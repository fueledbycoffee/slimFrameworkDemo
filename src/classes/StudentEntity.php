<?php

  class StudentEntity {
    protected $id;
    protected $firstName;
    protected $lastName;
    
    public function __construct(array $data) {
      // pas d'id si on est entrain de créer
      if(isset($data['id'])) {
        $this->id = $data['id'];
      }
      $this->firstName = $data['firstName'];
      $this->lastName = $data['lastName'];
    }
    public function getId() {
      return $this->id;
    }
    public function getFirstName() {
      return $this->firstName;
    }
    public function getLastName() {
      return $this->lastName;
    }
    public function getFullName() {
      return $this->firstName . " " . $this->lastName;
    }
  }

  ?>