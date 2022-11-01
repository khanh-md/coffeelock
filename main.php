<?php
    include('config.php');

    $sql = 'SELECT coffee_name, ingredients, price, id FROM coffee ORDER BY created_at';
    $result = mysqli_query($conn, $sql);

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);
    mysqli_close($conn);



?>

<!DOCTYPE html>
<html lang="en">

  
<?php include('header.php'); ?>
<section class="pad-top">
    <div class="p-4"><p class="h3 text-center" style="font-family: 'Dancing Script', cursive;">Menu</p></div>

    <div class="container">
        <div class="row align-items-center">
            <?php foreach($data as $smol_data) { ?>
                <div class="col col-sm-4 p-3">
                    <div class="card">
                        <div class="card-body text-center" style="height: 200px;">
                            <h6 class="card-title"><?php echo htmlspecialchars($smol_data['coffee_name']); ?> </h6>
                            <ul><?php foreach(explode(',', $smol_data['ingredients']) as $ingred) { ?>
                                    <li><?php echo htmlspecialchars($ingred); ?></li>
                                <?php } ?>
                            </ul>
                            <div><?php echo 'Price: $'.htmlspecialchars($smol_data['price']); ?> </div>
                        </div>
                        <div class="card-footer text-end text-decoration-none"><a href="fetch.php?id=<?php echo $smol_data['id']; ?>" class="btn btn-light">More info</a></div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>