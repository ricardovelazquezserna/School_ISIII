<?php
require_once 'database.php';
function getcareers() {
  $request = \Slim\Slim::getInstance()->request();
  $payload = json_decode($request->getBody());
  $sql = "
  SELECT
  id,name
  FROM
  career
  ";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    if (count($result)) {
      $response = $result;
    } else {
      $response = array(
        "error" => 'No rows found'
      );
    }
  } catch (PDOException $e) {
    $response = array(
      "error" => $e->getMessage()
    );
  }
  return json_encode($response);
}

function getstudentnumber() {
  $request = \Slim\Slim::getInstance()->request();
  $payload = json_decode($request->getBody());
  $sql = "
  SELECT
  id,student_number
  FROM
  student
  ";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    if (count($result)) {
      $response = $result;
    } else {
      $response = array(
        "error" => 'No rows found'
      );
    }
  } catch (PDOException $e) {
    $response = array(
      "error" => $e->getMessage()
    );
  }
  return json_encode($response);
}

function getnamestudents() {
  $request = \Slim\Slim::getInstance()->request();
  $payload = json_decode($request->getBody());
  $sql = "
  SELECT
  id,CONCAT(name,' ',last_name) AS name
  FROM
  student
  ";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    if (count($result)) {
      $response = $result;
    } else {
      $response = array(
        "error" => 'Students not found'
      );
    }
  } catch (PDOException $e) {
    $response = array(
      "error" => $e->getMessage()
    );
  }
  return json_encode($response);
}


function getsubjects() {
  $request = \Slim\Slim::getInstance()->request();
  $payload = json_decode($request->getBody());
  $idc = $_GET['idc'];
  $ns = $_GET['ns'];
  $sql = "
  SELECT s.name,s.id
  FROM career c
  INNER JOIN career_subject cs
  ON c.id=cs.id_career
  INNER JOIN subject s
  ON cs.id_subject=s.id
  WHERE s.semester= ".$ns."
  AND c.id=".$idc."";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    if (count($result)) {
      $response = $result;
    } else {
      $response = array(
        "error" => 'Subjects not found'
      );
    }
  } catch (PDOException $e) {
    $response = array(
      "error" => $e->getMessage()
    );
  }
  return json_encode($response);
}

function newstudent() {
  $request = \Slim\Slim::getInstance()->request();
  $payload = json_decode($request->getBody());
  $sql = "
  INSERT INTO student (
  name,
  last_name,
  semester,
  campus,
  address,
  postal_code,
  email,
  cell_phone,
  student_number
  ) VALUES (
  :name,
  :last_name,
  :semester,
  :campus,
  :address,
  :postal_code,
  :email,
  :cell_phone,
  :student_number
);";

$query_insert_student_career = "
INSERT INTO student_career (
id_student,
id_career
) VALUES (
:id_student,
:id_career);";
$query_insert_student_subject = "
INSERT INTO student_subject (
id_student,
id_subject
) VALUES (
:id_student,
:id_subject
);";

try {
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("name", $payload->name);
  $stmt->bindParam("last_name", $payload->last_name);
  $stmt->bindParam("semester", $payload->semester);
  $stmt->bindParam("campus", $payload->campus);
  $stmt->bindParam("address", $payload->address);
  $stmt->bindParam("postal_code", $payload->postal_code);
  $stmt->bindParam("email", $payload->email);
  $stmt->bindParam("cell_phone", $payload->cell_phone);
  $stmt->bindParam("student_number", $payload->student_number);
  $stmt->execute();

  $newstudentid = $db->lastInsertId();
  $id_career_selected = intval($payload->career);
  $id_subjects = explode(",",  $payload->array);

  foreach ($id_subjects as $key ) {
    $stmt = $db->prepare($query_insert_student_subject);
    $stmt->bindParam("id_student", $newstudentid);
    $stmt->bindParam("id_subject", $key);
    $stmt->execute();
  }
  $response = array(
    "id " => $newstudentid,
    "id career" => $id_career_selected,
    "ids" => $id_subjects,
    "success" => "ok");
  } catch (PDOException $e) {
    $response = array(
      "error" => $e->getmessage()
    );
  }
  return json_encode($response);
}
function getsubjectsearch(){
  $request = \Slim\Slim::getInstance()->request();
  $payload = json_decode($request->getBody());
  $sql = "
  SELECT
  id,name
  FROM
  subject
  ";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    if (count($result)) {
      $response = $result;
    } else {
      $response = array(
        "error" => 'No rows found'
      );
    }
  } catch (PDOException $e) {
    $response = array(
      "error" => $e->getMessage()
    );
  }
  return json_encode($response);
}

function newuser() {
  $request = \Slim\Slim::getInstance()->request();
  $payload = json_decode($request->getBody());
  $sql = "
  INSERT INTO user (
  name,
  last_name,
  email,
  password
  ) VALUES (
  :name,
  :last_name,
  :email,
  :password
);";
try {
  $db = getConnection();
  $stmt = $db->prepare($sql);
  $stmt->bindParam("name", $payload->name);
  $stmt->bindParam("last_name", $payload->last_name);
  $stmt->bindParam("email", $payload->email);
  $stmt->bindParam("password", $payload->password);
  $stmt->execute();
  $response = array(
    "success" => "ok");
  } catch (PDOException $e) {
    $response = array(
      "error" => $e->getmessage()
    );
  }
  return json_encode($response);
}

function getuser(){
  $request = \Slim\Slim::getInstance()->request();
  $payload = json_decode($request->getBody());
  $email = $_GET['user'];
  $password = $_GET['password'];
  $sql = "
  SELECT
  email,password
  FROM
  user
  WHERE email= ".$email."
  AND password=".$password."
  ";
  try {
    $db = getConnection();
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_CLASS);
    if (count($result)) {

      $response = $result;
    } else {
      $response = array(
        "error" => 'No rows found'
      );
    }
  } catch (PDOException $e) {
    $response = array(
      "error" => $e->getMessage()
    );
  }
  return json_encode($response);
}
