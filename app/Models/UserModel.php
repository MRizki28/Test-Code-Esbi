<?php

namespace Models;

use Config\Database;
use Exception;

class UserModel
{
    protected $table = 'users';
    protected $pdo;
    protected $fillable = [
        'id', 'name', 'email', 'password'
    ];

    public function __construct()
    {
        try {
            $db = new Database();
            $this->pdo = $db->getPdo();
        } catch (Exception $e) {
            echo 'Terjadi kesalahan db: ' . $e->getMessage();
        }
    }

    public function getAllData()
    {
        try {
            $data = $this->pdo->query("SELECT * FROM users");
            return $data;
        } catch (Exception $e) {
            echo 'Terjadi kesalahan logic: ' . $e->getMessage();
        }
    }

    public function register($name, $email, $password)
    {
        try {
            if (empty($name) || empty($email) || empty($password)) {
                return json_encode(['success' => false, 'message' => 'Semua kolom harus diisi']);
            }
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $data = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $data->execute([$name, $email, $hashPassword]);

            return json_encode(['success' => true, 'message' => 'Registrasi berhasil']);
        } catch (\Throwable $th) {
            return json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }

    public function getDataById($id)
    {
        $data = $this->pdo->prepare("SELECT * FROM users WHERE id = ? ");
        $data->execute([$id]);
        return $data;
    }

    public function updateData($name, $email, $id)
    {
        try {
            if (empty($name) || empty($email)) {
                return json_encode(['success' => false, 'message' => 'Semua kolom harus diisi']);
            }
            $data = $this->pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $data->execute([$name, $email, $id]);
            return json_encode(['success' => true, 'message' => 'Update berhasil']);
        } catch (\Throwable $th) {
            return json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }

    public function resetPassword($id)
    {
        try {
            $defaultPassword = '12345678';
            $hashPassword = password_hash($defaultPassword, PASSWORD_DEFAULT);
            $data = $this->pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
            $data->execute([$hashPassword, $id]);
            return json_encode(['success' => true, 'message' => 'Reset password berhasil']);
        } catch (\Throwable $th) {
            return json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }

    public function deleteData($id)
    {
        try {
            $data = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            $data->execute([$id]);
            return json_encode(['success' => true, 'message' => 'Success delete data']);
        } catch (\Throwable $th) {
            return json_encode(['success' => false, 'message' => 'Terjadi kesalahan: ' . $th->getMessage()]);
        }
    }
}
