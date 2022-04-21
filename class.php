<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', '');
define('DB', 'ecommerceapp');

class DB
{
    function __construct()
    {
        $conn = mysqli_connect('HOST', 'USER', 'PASSWORD', 'DB') or die ('Connection Error! '. mysqli_error($conn));
    }
}

class User
{
    public
    function __construct()
    {
        $db = new DB;
    }

    public
    function register($created_at, $first_name, $last_name, $email, $password) {
        $password = md5($password);
        $checkuser = mysqli_query("SELECT user_id FROM user_info WHERE email='$email'");
        $result = mysqli_num_rows($checkuser);
        if ($result == 0){
            $register = mysqli_query("INSERT INTO user_info (created_at, first_name, last_name, email, password) VALUES ('$create_at','$first_name','$last_name','$email','$password')") or die (mysqli_error($register));

            return $register;
        }
        else {
            return false;
        }
    }
    
    public
    function login($email, $password){
        $password = md5($password);
        $check = mysqli_query("Select * from users where email='$email' and password='$password'");
        $data = mysqli_fetch_array($check);
        $result = mysqli_num_rows($check);
        if ($result == 1) {
            $_SESSION['login'] = true;
            $_SESSION['id'] = $data['id'];
            return true;
        }
        else {
            return false;
        }
    }

    public
    function fullname($id) {
        $result = mysqli_query("SELECT * FROM user_info WHERE user_id='id'");
        $row = mysqli_fetch_array($result);
        echo $row['name'];
    }

    public
    function session() {
        if (isset($_SESSION['login'])) {
            return $_SESSION['login'];
        }
    }

    public
    function logout() {
        $_SESSION['login'] = false;
        session_destroy();
    }
}
?>