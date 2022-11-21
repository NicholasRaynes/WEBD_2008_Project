<?php
	require('authenticate.php');
    require('connect.php');

    $flag = true;

    $categories_query = "SELECT * FROM categories";
    $categories_statement = $db->prepare($categories_query);
    $categories_statement->execute();

    if($_POST && !empty(trim($_POST['new_category_name'])))
    {        
        $new_category_name = filter_input(INPUT_POST, 'new_category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $query = "UPDATE categories SET category_name = :new_category_name WHERE category_name = :category_name";

        $statement = $db->prepare($query);

        $statement->bindValue(':new_category_name', $new_category_name);
        $statement->bindValue(':category_name', $category_name);

        $statement->execute();

        header("Location: index.php"); 
    } 
    elseif($_POST && (empty(trim($_POST['new_category_name'])))) 
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
    <title>Update Categories</title>
</head>
<body>
    <?php include('nav.php'); ?>
    <?php if($flag): ?>
        <div class="container-md">
            <h2 class="create_edit_header">Update Categories</h2>
            <form method="post" action="update_categories.php">
                <label for="category_name">Select Category:</label>
                <select name="category_name" id="category_name">
                    <?php while($entries = $categories_statement->fetch()): ?>
                        <option><?= $entries['category_name'] ?></option>
                    <?php endwhile ?>
                </select>
                <label for="new_category_name" id="new_category_label">New Category Name:</label>
                <input id="new_category_name" name="new_category_name">
                <input type="submit" id="create_category" value="Update Category">   
            </form>   
            </form>
        </div>
    <?php elseif(!$flag): ?>
        <h2 id="details">Please enter valid values for all fields on the page.<a href="index.php"></a></h2>
    <?php endif ?>
    <?php include('footer.php'); ?>
</body>
</html>

