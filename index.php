<?php

include("config/db_connect.php");

// write query for all film lists
$sql = "SELECT genre, films, author, id FROM film_lists ORDER BY created_at";

// make query & get result
$result = mysqli_query($conn, $sql);

// fetch resulting rows as an array
$filmLists = mysqli_fetch_all($result, MYSQLI_ASSOC);

mysqli_free_result($result);

// close connection
mysqli_close($conn);

?>


<!DOCTYPE html>
<html lang="en">
<?php include("templates/header.php"); ?>

<h4 class="center grey-text">Film Recommendations!</h4>

<div class="container">
    <div class="row">

        <?php foreach ($filmLists as $filmList) : ?>

            <div class="col s6 md3">
                <div class="card z-depth-0">
                    <img src="img/film.svg" class="film">
                    <div class="card-content center">
                        <h5><?php echo htmlspecialchars($filmList["genre"]); ?></h5>
                        <ul>
                            <?php foreach (explode(",", $filmList["films"]) as $ing) : ?>
                                <li>
                                    <?php echo htmlspecialchars($ing); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div><?php echo htmlspecialchars($filmList["author"]) ?></div>
                    </div>
                    <div class="card-action right-align">
                        <a class="brand-text" href="details.php?id=<?php echo $filmList["id"] ?>">More Info</a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>

<?php include("templates/footer.php"); ?>

</html>