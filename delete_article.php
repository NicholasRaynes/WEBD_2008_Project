<?php
    require('connect.php');

    if(isset($_GET['id']))
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

        $query = "DELETE FROM articles WHERE id = :id";

        $statement = $db->prepare($query);

        $statement->bindValue(':id', $id, PDO::PARAM_INT);

        $statement->execute();
        
        $row = $statement->fetch(); 

        header("Location: index.php");
    }
?>