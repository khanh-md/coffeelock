<?php
    include('config.php');


    $ingredients = $coffee = $price = '';
    $error = ['coffee'=>'', 'ingredients'=>'', 'price'=>''];
    if(isset($_POST["submit"])) {
        if(empty($_POST['coffee_name'])) {
            $error['coffee'] = "Empty field";
        }
        else {
            $coffee = $_POST["coffee_name"];
            if (!preg_match('/^[a-zA-Z\s]+$/', $coffee)) {
                $error['coffee'] = "Not a valid name";
            }
        }

        if(empty($_POST['ingredients'])) {
            $error['ingredients'] = "Empty field";
        }
        else{
            $ingredients = $_POST["ingredients"];
            if (!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
                $error['ingredients'] = "Not a valid list";
            }
        }

        if(empty($_POST['price'])) {
            $error['price'] = "Empty field";
        }
        else{
            $price = $_POST["price"];
            if (!filter_var($price, FILTER_VALIDATE_INT)) {
                $error['price'] = "Not a valid number";
            }
        }

        if(!array_filter($error)) {
            $coffee = mysqli_real_escape_string($conn, $_POST['coffee_name']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
            $price = mysqli_real_escape_string($conn, $_POST['price']);

            $sql = "INSERT INTO coffee(coffee_name, ingredients, price) VALUES('$coffee', '$ingredients', '$price')";

            if (mysqli_query($conn, $sql)) {
                header('Location: main.php'); 
            }
            else {
                echo 'Error: '.mysqli_error($conn);
            }
        }
    }



?>

<!DOCTYPE html>
<html lang="en">
  
<?php include('header.php'); ?>

<section class="container pad-top d-flex flex-column align-items-center">
    <div class="p-4"><p class="h3" style="font-family: 'Dancing Script', cursive;">Make new entry</p></div>
    <form class="p-5"style="background-color: #fff; width: 600px;" action="add.php" method="POST">
        <div class="form-group p-2">
            <label for="coffee">Coffee Name</label>
            <input type="text" class="form-control" name="coffee_name" value = '<?php echo $coffee; ?>' placeholder="Enter name">
        </div>
        <div class="text-danger ps-2 small"><?php echo $error['coffee']; ?></div>
        <div class="form-group p-2">
            <label for="ingredients">Ingredients</label>
            <input type="text" class="form-control" name="ingredients" value = '<?php echo $ingredients; ?>' placeholder="Separated by comma">
        </div>
        <div class="text-danger ps-2 small"><?php echo $error['ingredients']; ?></div>
        <div class="form-group p-2">
            <label for="price">Price ($)</label>
            <input type="number" class="form-control" name="price" value = '<?php echo $price; ?>' placeholder="$">
        </div>
        <div class="text-danger ps-2 small"><?php echo $error['price']; ?></div>

        <input type="submit" name="submit" value="Submit" class="btn btn-light hover-change">
    </form>
</section>

<?php include('footer.php'); ?>

</html>