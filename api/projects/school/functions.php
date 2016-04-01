<?php

// Get database config
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

function getsubjects() {
    $request = \Slim\Slim::getInstance()->request();
    $payload = json_decode($request->getBody());
    $idc = $_GET['idc'];
    $ns = $_GET['ns'];


    $sql = "SELECT s.name,s.id FROM career c INNER JOIN career_subject cs ON c.id=cs.id_career INNER JOIN subject s ON cs.id_subject=s.id WHERE s.semester= ".$ns." AND c.id=".$idc."";
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
function search() {

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

    $query_insert = "
        INSERT INTO student_career (
            id_student,id_career
        ) VALUES (
            :id_student,
            :id_career);";



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

        $stmt = $db->prepare($query_insert);
        $stmt->bindParam("id_student", $newstudentid);
        $stmt->bindParam("id_career", $id_career_selected);
        $stmt->execute();

        $response = array(
            "id " => $newstudentid,
            "success" => "ok");
    } catch (PDOException $e) {
        $response = array(
            "error" => $e->getmessage()
        );
    }





    return json_encode($response);
}

/*
function ligarValores() {
    $request = \Slim\Slim::getInstance()->request();
    $payload = json_decode($request->getBody());
    $array_string = $payload->arreglo;
    $my_array = explode(',', $array_string);

    $sql = "
        INSERT INTO proced_depart(
            id_pdt,
            id_dpt
          ) VALUES (
            :id_procedimiento,
            :id_departamento
           );";
    try {
        $db = getConnection();
        foreach ($my_array as $value) {
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id_procedimiento", $payload->cookie);
            $stmt->bindParam("id_departamento", $value);
            $stmt->execute();
        }
        $response = array(
            "success" => "OK",

        );
    } catch (PDOException $e) {
        $response = array(
            "error" => $payload
        );
    }
    return json_encode($response);
}
function selectDpt() {

    $sql = "
            SELECT
                *
            FROM
                departamento

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
function selectPdt() {
    $sql = "
            SELECT
               *
            FROM
                procedimiento
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
}*/
