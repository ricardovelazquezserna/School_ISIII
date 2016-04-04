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
?>
