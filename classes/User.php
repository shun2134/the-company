<?php
require_once "Database.php";
// password = "12345678"

/* inheritance */
class User extends Database{
    public function store($request){
        $first_name = $request['first_name'];
        $last_name  = $request['last_name'];
        $username   = $request['username'];
        $password   = password_hash($request['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(`first_name`, `last_name`, `username`, `password`) VALUE ('$first_name', '$last_name', '$username', '$password')";

        if($this->conn->query($sql)){
            header('location: ../views');  // ../views/index.php
            exit;
        }else{
            die('Error creating new user' . $this->conn->error);
        }
    }

    public function login($request){
        $username = $request['username'];
        $password = $request['password'];

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->conn->query($sql);
        if($result->num_rows == 1){  // contains number of row
            $user = $result->fetch_assoc(); // fetch_assoc() retrives records from database table
            /* fetch_assoc shows below
            $user = {
                "id"         => 1,
                "first_name" => "Tony",
                "last_name"  => "Stark",
                "password"   => "12345678"
            }
            echo $user['password'];
            */
            if(password_verify($password, $user['password'])){
                session_start();
                $_SESSION['id']        = $user['id'];
                $_SESSION['username']  = $user['username'];
                $_SESSION['full_name'] = $user['first_name'] . " " . $user['last_name'];

                header("location: ../views/dashboard.php");
                exit;
            } else{
                die("Incorrect Password");
            }
        }else{
            die("Username not found");
        }
    }
    public function logout() {
        session_start();
        session_unset();
        session_destroy();

        header("location: ../views");
        exit;
    }

    public function getAllUsers(){
        $sql = "SELECT id, first_name, last_name, username, photo FROM users";

        if($result = $this->conn->query($sql)) {
            return $result;   
        } else {
            die("Error retrieving all users: " . $this->conn->error);
        }
    }

    public function getUser($id){
        $sql = "SELECT * FROM users WHERE id = $id";

        if($result = $this->conn->query($sql)) {
            return $result->fetch_assoc();
        }else{
            die("Error retrieving the user: " . $this->conn->error);
        }
    }

    public function update($request, $files){
        /* query */
        session_start();
        $id         = $_SESSION['id'];
        $first_name = $request['first_name'];
        $last_name  = $request['last_name'];
        $username   = $request['username'];
        $photo      = $files['photo']['name'];
        $tmp_photo  = $files['photo']['tmp_name'];

        $sql = "UPDATE users SET
            first_name = '$first_name',
            last_name = '$last_name',
            username = '$username'
            WHERE id = $id";
        
        if($this->conn->query($sql)) {
            $_SESSION['username'] = $username;
            $_SESSION['full_name'] = "$first_name $last_name";

            /* if there is a photo/image to upload, save the file to db and the file to assets/images folder. */
            if($photo) {
                $sql = "UPDATE users SET photo = '$photo' WHERE id = $id";
                $destination = "../assets/images/$photo";

                if($this->conn->query($sql)) {
                    /* save the image file to the images folder */
                    if(move_uploaded_file($tmp_photo, $destination)) {
                        header("location: ../views/dashboard.php");
                        exit;
                    } else {
                        die("Error moving the photo.");
                    }
                } else {
                    die("Error uploading photo: " . $this->conn->error);
                }
            }

            header("location: ../views/dashboard.php");
            exit;
        } else {
            dit("Error updating the user: " . $this->conn->error);
        }
    }

    public function delete() {
        session_start();
        $id = $_SESSION['id'];

        $sql = "DELETE FROM users WHERE id = $id";

        if($this->conn->query($sql)) {
            $this->logout();
        } else {
            die("Error deleting your account: " . $this->conn->error);
        }
    }
}
?>