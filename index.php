<?php
session_start();
require 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    $sql = "INSERT INTO books (title, author, year) VALUES ('$title', '$author', '$year')";
    if ($conn->query($sql) === true) {
        $message = "New book added successfully";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];

    $sql = "UPDATE books SET title='$title', author='$author', year='$year' WHERE id='$id'";
    if ($conn->query($sql) === true) {
        $message = "Book updated successfully";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM books WHERE id='$id'";
    if ($conn->query($sql) === true) {
        $message = "Book deleted successfully";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Libreria</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Bienvenid@, <?php echo $_SESSION['username']; ?></h1>

                <form method="post" action="index.php" class="text-right">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>

                <?php
                if (!empty($message)) {
                    echo '<div class="alert alert-success">' . $message . '</div>';
                }
                if (!empty($error_message)) {
                    echo '<div class="alert alert-danger">' . $error_message . '</div>';
                }
                ?>

                <h2>Agregar Libro</h2>
                <form method="post" action="index.php" class="mb-4">
                    <div class="form-group">
                        <label for="title">Titulo:</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="author">Autor:</label>
                        <input type="text" class="form-control" id="author" name="author" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Año:</label>
                        <input type="number" class="form-control" id="year" name="year" required>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary">Agregar</button>
                </form>

                <h2>Lista de Libros</h2>
                <?php
                $sql = "SELECT * FROM books";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<div class="list-group">';
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="list-group-item">';
                        echo '<form method="post" action="index.php">';
                        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                        echo '<div class="form-group">';
                        echo '<label>Title:</label>';
                        echo '<input type="text" class="form-control" name="title" value="' . $row['title'] . '" required>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label>Author:</label>';
                        echo '<input type="text" class="form-control" name="author" value="' . $row['author'] . '" required>';
                        echo '</div>';
                        echo '<div class="form-group">';
                        echo '<label>Year:</label>';
                        echo '<input type="number" class="form-control" name="year" value="' . $row['year'] . '" required>';
                        echo '</div>';
                        echo '<button type="submit" name="update" class="btn btn-warning">Modificar</button> ';
                        echo '<button type="submit" name="delete" class="btn btn-danger">Borrar</button>';
                        echo '</form>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<div class="alert alert-info">No books found.</div>';
                }
                ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
