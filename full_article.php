<?php
    require('connect.php');
    
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM articles WHERE id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    $statement->execute();
    $entries = $statement->fetch();   

    if(!$entries)
    {
        header("Location: index.php");
    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $entries['title'] ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://kit.fontawesome.com/d4de3d3a72.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php include('nav.php') ?>
    <div id="full_article">
        <p><i class="fa-regular fa-pen-to-square"></i><a href="update_article.php?id=<?= $entries['id'] ?>"> Edit Article</a></p>
        <form method="post" action="index.php">
            <button id= "full_article_category" class="btn btn-outline-primary" role="button"><?= $entries['category_name'] ?></button>
        </form>
        <p id="full_article_date">Published: <?= date('F j, Y, g:i a', strtotime($entries['created_date'])) ?></p>
        <h2><?= $entries['title'] ?></h2>
        <p><?= $entries['caption'] ?></p>   
        <p><?= $entries['content'] ?></p>       
    </div>
    <?php include('footer.php'); ?>
</body>
</html>