<?php
  include('config.php');


  if (isset($_POST['delete'])) {
    $id_delete = mysqli_real_escape_string($conn, $_POST['id_delete']);
    $sql = "DELETE FROM coffee WHERE id = $id_delete";

    if (mysqli_query($conn,$sql)) {
        header('Location: main.php');
    }
    else {
        echo 'Error: '.mysqli_error($conn);
    }
  }

  if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM coffee WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);
  }
  
  $ingredients = $data['ingredients'];
  $coffee = $data['coffee_name'];
  $price = $data['price'];
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

          $sql = "UPDATE coffee SET coffee_name = '$coffee', ingredients = '$ingredients', price = '$price' WHERE id = $id";

          if (mysqli_query($conn, $sql)) {
              header('Location: main.php'); 
          }
          else {
              echo 'Error: '.mysqli_error($conn);
          }
      }
  }

  mysqli_free_result($result);
  mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">

<?php include('header.php'); ?>

<div class="container pad-top d-flex flex-column align-items-center">
    <div class="p4" style="height: 40px;"></div>
    <div class="card" style="width: 600px;">
        <div class="card-body text-center">
            <?php if($data) { ?>
                <h3 class="card-title"><?php echo htmlspecialchars($data['coffee_name']); ?></h3>
                <p> Created at: <?php echo htmlspecialchars($data['created_at']); ?> </p>
                <p> Ingredients: <?php echo htmlspecialchars($data['ingredients']); ?> </p>
                <p> Price: $<?php echo htmlspecialchars($data['price']); ?> </p>

            <form action="fetch.php" method="post">
                <input type="hidden" name="id_delete" value="<?php echo htmlspecialchars($data['id']);?>">
                <input type="submit" name="delete" value="Delete" class="btn btn-light hover-change">
            </form>
            <input type="button" name="edit" value="Edit" class="btn btn-light hover-change" onclick="showForm()">
            <?php } 
            
            else {?>
                <h5> Does not exist! </h5>
            <?php } ?>
        </div>
    </div>
    <form class="p-5" style="background-color: #fff; width: 600px; display: none;" action="" method="POST" id="formElement">
        <div class="form-group p-2">
            <label for="coffee">Coffee Name</label>
            <input type="text" class="form-control" name="coffee_name" value = '<?php echo $coffee; ?>'>
        </div>
        <div class="text-danger ps-2 small"><?php echo $error['coffee']; ?></div>
        <div class="form-group p-2">
            <label for="ingredients">Ingredients</label>
            <input type="text" class="form-control" name="ingredients" value = '<?php echo $ingredients; ?>'>
        </div>
        <div class="text-danger ps-2 small"><?php echo $error['ingredients']; ?></div>
        <div class="form-group p-2">
            <label for="price">Price ($)</label>
            <input type="number" class="form-control" name="price" value = '<?php echo $price; ?>'>
        </div>
        <div class="text-danger ps-2 small"><?php echo $error['price']; ?></div>

        <input type="submit" name="submit" value="Submit" class="btn btn-light hover-change">
    </form>
</div>

<?php include('footer.php'); ?>

</html>