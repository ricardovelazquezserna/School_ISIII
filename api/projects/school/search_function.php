<?php
require_once 'database.php';
function getsearch() {
    $request = \Slim\Slim::getInstance()->request();
    $payload = json_decode($request->getBody());
    $student_id = $_GET['id'];
    $student_number = $_GET['number'];
    $semester = $_GET['semester'];
    $career = $_GET['career'];
    $subject = $_GET['subject'];
    $response = array ("id" => $student_id,
    "student_number" => $student_number,
    "semester" => $semester,
    "career" => $career,
    "subject" => $subject );
   if ($student_id!=null){
     $sql = "
          SELECT s.name as firstname,s.last_name,s.student_number,s.semester,s.campus,c.name
            FROM student s
          INNER JOIN student_career sc
            ON s.id=sc.id_student
          INNER JOIN career c
            ON sc.id_career=c.id
              WHERE s.id=".$student_id.";
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
             "ERROR" => "ERROR"
             );
         }
     } catch (PDOException $e) {
         $response = array(
             "error" => $e->getMessage()
         );
     }
    }

    return json_encode($response);
}
?>
