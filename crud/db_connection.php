<?php
function getDbConnection() {
    $dbname = 'oficina_mecanica.db';
    try {
        $conn = new PDO("sqlite:" . $dbname);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return null;
    }
}
?>
