<?php
    session_start();

    require('connect.php');

    $flag = true;

    if($_POST && !empty(trim($_POST['category_name'])))
    {        
        $category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "INSERT INTO categories (category_name) VALUES (:category_name)";

        $statement = $db->prepare($query);

        $statement->bindValue(':category_name', $category_name);

        $statement->execute();

        header("Location: index.php"); 
    } 
    elseif($_POST && (empty(trim($_POST['category_name'])))) 
    {
        $flag =  false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="https://kit.fontawesome.com/d4de3d3a72.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Admin Hub</title>
</head>
<body>
    <?php include('nav.php'); ?>
    <?php if($flag): ?>
        <div class="container-md">
            <h2 class="create_edit_header">Create Category</h2>
            <form method="post" action="admin_hub.php">
                <label for="category_name">Category Name:</label>
                <input id="category_name" name="category_name">
                <input type="submit" id="create_category" value="Create Category">   
            </form>
            <a href="update_categories.php" class="link-primary">Update Categories</a>
        </div>
    <?php elseif(!$flag): ?>
        <h2 id="details">Please enter valid values for all fields on the page.<a href="index.php"></a></h2>
    <?php endif ?>
    <?php include('footer.php'); ?>
</body>
</html>