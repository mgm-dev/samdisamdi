<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

setcookie("user_email", "", time() -3600);

if(isset($email) || isset($password)) {

    $conn = mysqli_connect("localhost", "mysql", "EnterPasswordHere", "user_info");
    $conn->set_charset('utf8');
    $sql = "SELECT * FROM user WHERE  email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($row['active']) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['is_login'] = true;
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['email'] = $row['email']
                ?>
                <script>
                    parent.postMessage("success", "*");
                </script>
                <?php
            }
            else {
                ?>
                <script>
                    parent.postMessage("openAlert", "*");
                </script>
                <?php
            }
        }
        else {
            ?>
            <script>
                parent.postMessage("openAlert", "*");
            </script>
            <?php
        }
    }
    else {
        ?>
        <script>
            parent.postMessage("openAlert", "*");
        </script>
        <?php
    }

}
?>

