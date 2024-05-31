<?php
require('../config/database.php');


if (isset($_GET['delete_id'])) {
    $user_id = $_GET['delete_id'];

  
    $query_delete_user = "DELETE FROM users WHERE id = $1";
    
    $result = pg_query_params($conn, $query_delete_user, array($user_id));
    
    if ($result) {
        echo "<div class='alert alert-success' role='alert'>User deleted successfully</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error deleting user: " . pg_last_error($conn) . "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Pets | List users</title>
    <script>
        function confirmDeletion(userId) {
            if (confirm("¿DESEAS ELIMINAR ESTE DATO?")) {
                window.location.href = "?delete_id=" + userId;
            }
        }
    </script>
</head>
<body>
    <center>
        <h1>LIST USERS</h1>
        <table class="table table-striped">
            <tr>
                <th>fullname</th>
                <th>email</th>
                <th>status</th>
                <th>foto</th>
                <th>...</th>
            </tr>
            <?php
                $query_users = "
                    SELECT
                        id,
                        fullname,
                        email,
                        CASE WHEN status = true THEN 'Active' ELSE 'Inactive' END as status
                    FROM
                        users
                ";
                $result = pg_query($conn, $query_users);
                while ($row = pg_fetch_assoc($result)) {
                    echo "<tr>";
                        echo "<td>". htmlspecialchars($row['fullname']) ."</td>";
                        echo "<td>". htmlspecialchars($row['email']) ."</td>";
                        echo "<td>". htmlspecialchars($row['status']) ."</td>";
                        echo "<td><img src='photos/avatar.png' width='30'></td>";
                        echo "<td>
                            <a href='#' onclick='confirmDeletion(". htmlspecialchars($row['id']) .")'><img src='iconos/papelera.png' width='20'></a>
                            <a href='#'><img src='iconos/editar.png' width='20'></a>
                        </td>";
                    echo "</tr>";
                }
            ?>
    </table>     
</center>

</body>
</html>
        