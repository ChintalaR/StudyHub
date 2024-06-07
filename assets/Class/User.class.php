<?php
namespace Users;
require_once("config.php");
require_once("JwtManager.class.php");
require_once("db.class.php");
//session_start();
use JwtManager;
use Db;
use PDO;
use PDOException;

class User
{
    public $conn;

    public function __construct()
    {
        $this->conn = new Db();
    }

    public function select()
    {
        try {
            $query = $this->conn->query("SELECT email, year.name AS year, course.name AS course FROM users JOIN year ON year.id = users.year JOIN course ON course.id = year.course");
            $query->execute();
            return json_encode(["status"=>1,"data"=>$query->fetchAll(PDO::FETCH_ASSOC)]);
        } catch (PDOException $e) {
            return json_encode(["status"=>0,"data"=>$e->getMessage()]);
        }
    }

    public function signup($email, $password,$year)
    {
        try {
            $query = $this->conn->prepare("SELECT email FROM users WHERE email=:email");
            $query->bindParam(":email", $email);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return json_encode(["status" => 0, "message" => "Email Already Exist", "error" => "User Already Exist"]);
            } else {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $query = $this->conn->prepare("INSERT INTO users (email, password,year) VALUES (:email,:password,:year)");
                $query->bindParam(':email', $email);
                $query->bindParam(':password', $password_hash);
                $query->bindParam(':year', $year);
                $result = $query->execute();
                if ($result) {
                    return json_encode(["status" => 1, "message" => "Sign up successful"]);
                } else {
                    return json_encode(["status" => 0, "message" => "Sign up unsuccessful", "error" => "Something went wrong"]);
                }
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => "Try again later", "error" => $e->getMessage()]);
        }
    }

    public function login($email, $password)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM users WHERE email=:email");
            $query->bindParam(":email", $email);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $verify_pass = password_verify($password, $result['password']);
                if ($verify_pass) {
                    $jwtManager = new JwtManager(JWT_SECRET);
                    $payload = [
                        "user_id" => $result["id"],
                        "email" => $email,
                        "exp" => time() + 3600 * 24, // Token expiration time (24 hours)
                    ];
                    $token = $jwtManager->createToken($payload);

                    return json_encode(["status" => 1, "message" => "login successfully", "token" => $token]);
                } else {
                    return json_encode(["status" => 0, "message" => "Invalid Password", "error" => "Password does not match"]);
                }
            } else {
                return json_encode(["status" => 0, "message" => "Email not exist", "error" => "Email not found"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => "Try again later", "error" => $e->getMessage()]);
        }
    }

    public function loginCheck($token)
    {
        try {
            $jwtManager = new JwtManager(JWT_SECRET);
            $validate = $jwtManager->decodeToken($token);
            if ($validate) {
                $id = $validate["user_id"];
                $email = $validate["email"];
                $query = $this->conn->prepare("SELECT id,email from users where id=:id and email=:email");
                $query->bindParam(":id", $id);
                $query->bindParam(":email", $email);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    return json_encode(["status" => 1]);
                } else {
                    return json_encode(["status" => 0]);
                }
            } else {
                return json_encode(["status" => 0]);
            }

        } catch (PDOException $e) {
            return json_encode(["status" => 0]);
        }
    }

    public function adminlogin($email, $password)
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM admin WHERE email=:email");
            $query->bindParam(":email", $email);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $verify_pass = password_verify($password, $result['password']);
                if ($verify_pass) {
                    $jwtManager = new JwtManager(JWT_SECRET);
                    $payload = [
                        "user_id" => $result["id"],
                        "email" => $email,
                        "exp" => time() + 3600 * 24,
                    ];
                    $token = $jwtManager->createToken($payload);
                    return json_encode(["status" => 1, "message" => "Logined successfully", "token" => $token]);
                } else {
                    return json_encode(["status" => 0, "message" => "Invalid Password", "error" => "Password Doesn't match"]);
                }
            } else {
                return json_encode(["status" => 0, "message" => "Invalid Email", "error" => "Email Not Found"]);
            }
        } catch (PDOException $e) {
            return json_encode(["status" => 0, "message" => "Try again later", "error" => $e->getMessage()]);
        }
    }
}