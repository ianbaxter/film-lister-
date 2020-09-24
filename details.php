<?php

include("config/db_connect.php");

if (isset($_POST["delete"])) {
    $id_to_delete = mysqli_real_escape_string($conn, $_POST["id_to_delete"]);

    $sql = "DELETE FROM film_lists WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "query error: " . mysqli_error($conn);
    }
}

// check GET request id param
if (isset($_GET["id"])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);

    // make sql
    $sql = "SELECT * FROM film_lists WHERE id = $id";

    // get query result
    $result = mysqli_query($conn, $sql);

    // fetch result in array format
    $filmList = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
    mysqli_close($conn);
}

?>


<!DOCTYPE html>
<html lang="en">
<?php include("templates/header.php"); ?>

<div class="container center grey-text">
    <?php if ($filmList) : ?>
        <h4><?php echo htmlspecialchars($filmList["genre"]); ?></h4>
        <p>Created by: <?php echo htmlspecialchars($filmList["author"]) ?></p>
        <p><?php echo date($filmList["created_at"]) ?></p>
        <h5>Films</h5>
        <p><?php echo htmlspecialchars($filmList["films"]) ?></p>

        <!-- DELETE FORM -->
        <form action="details.php" method="POST">
            <input type="hidden" name="id_to_delete" value="<?php echo $filmList["id"] ?>">
            <input class="btn brand z-depth-0" type="submit" name=delete value="Delete">
        </form>

    <?php else : ?>

        <h5>No such film list exists</h5>

    <?php endif; ?>
</div>

<?php include("templates/footer.php"); ?>

</html>