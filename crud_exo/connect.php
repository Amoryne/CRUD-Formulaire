<!-- CONNECT TO DB -->

<?php
try{
    $db = new PDO('mysql:host=localhost;dbname=crud','amoryne','becode');
    $db->exec('SET NAMES "UTF8"');
} catch (PDOException $e){
    echo 'error:' . $e->getMessage();
    die();
}
?>