<?php
	require('connect.php');
	
	$category = $entries['category_name'];

	$query = "SELECT * FROM articles ORDER BY {$order_by}";

    $statement = $db->prepare($query);

    $statement->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $category ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/d4de3d3a72.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <?php include('nav.php'); ?>
    <div class="container-md">
    	<?php while($entries = $statement->fetch()): ?>
        	<div id="articles">
            	<h2><a href="full_article.php?id=<?= $entries['id'] ?>"><?= $entries['title'] ?></a></h2>
                <p><?= substr($entries['caption'], 0, 100) . "..."?></p>
                <p>Published: <?= date('F j, Y, g:i a', strtotime($entries['created_date'])) ?></p>
                <a class="btn btn-primary" href="specific_category.php" role="button"><?= $entries['category_name'] ?></a>
            </div>
        <?php endwhile ?>
    <?php include('footer.php'); ?>
</body>
</html>