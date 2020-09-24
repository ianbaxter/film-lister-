<?php

include("config/db_connect.php");

$author = $genre = $films = "";
$errors = array("author" => "", "genre" => "", "films" => "");

if (isset($_POST["submit"])) {
    // check author
    if (empty($_POST["author"])) {
        $errors["author"] = "An author is required <br />";
    } else {
        $author = $_POST["author"];
        if (!preg_match("/^[a-zA-Z\s]+$/", $author)) {
            $errors["author"] = "author must be letters and spaces";
        }
    }

    // check genre
    if (empty($_POST["genre"])) {
        $errors["genre"] = "A genre is required <br />";
    } else {
        $genre = $_POST["genre"];
        if (!preg_match("/^[a-zA-Z\s]+$/", $genre)) {
            $errors["genre"] = "genre must be letters and spaces";
        }
    }

    // check films
    if (empty($_POST["films"])) {
        $errors["films"] = "At least one films is required <br />";
    } else {
        $films = $_POST["films"];
        if (!preg_match("/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/", $films)) {
            $errors["films"] = "films must be comma separated letters";
        }
    }

    if (!array_filter($errors)) {
        $author = mysqli_real_escape_string($conn, $_POST["author"]);
        $genre = mysqli_real_escape_string($conn, $_POST["genre"]);
        $films = mysqli_real_escape_string($conn, $_POST["films"]);

        // create sql
        $sql = "INSERT INTO film_lists(genre,author,films) VALUES('$genre','$author','$films')";

        // save to db and check
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php");
        } else {
            echo "query error: " . mysqli_error($conn);
        }
    }
} // end of POST check

?>


<!DOCTYPE html>
<html lang="en">
<?php include("templates/header.php"); ?>

<section class="container grey-text">
    <h4 class="center">Add a Film List</h4>
    <form class="white" action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
        <label>Author</label>
        <input type="text" name="author" value="<?php echo htmlspecialchars($author) ?>">
        <div class="red-text"><?php echo $errors["author"]; ?></div>
        <label>Film List Genre</label>
        <input type="text" name="genre" value="<?php echo htmlspecialchars($genre) ?>">
        <div class="red-text"><?php echo $errors["genre"]; ?></div>
        <label>Films (comma separated)</label>
        <input type="text" name="films" value="<?php echo htmlspecialchars($films) ?>">
        <div class="red-text"><?php echo $errors["films"]; ?></div>
        <div class="center">
            <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include("templates/footer.php"); ?>

</html>