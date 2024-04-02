<?php

namespace Controllers;

use Models\UserModel;

class UserController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel;
    }

    public function getAllData()
    {
        $data = $this->userModel->getAllData();
        $data = $data->fetchAll(\PDO::FETCH_ASSOC);
        return json_encode($data);
    }

    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (empty($name) || empty($email) || empty($password)) {
            return json_encode(['success' => false, 'message' => 'Semua kolom harus diisi']);
        }
        $this->userModel->register($name, $email, $password);

        return json_encode([
            'message' => 'Registrasi berhasil'
        ]);
    }

    public function getDataById($id)
    {
        $data = $this->userModel->getDataById($id);
        $data = $data->fetchAll(\PDO::FETCH_ASSOC);
        return json_encode($data);
    }

    public function updateData($id)
    {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';

        if (empty($name) || empty($email)) {
            return json_encode(['success' => false, 'message' => 'Semua kolom harus diisi']);
        }
        $this->userModel->updateData($name, $email, $id);

        return json_encode([
            'message' => 'Update berhasil'
        ]);
    }

    public function resetPassword($id)
    {
        $this->userModel->resetPassword($id);
        return json_encode([
            'message' => 'Reset password berhasil'
        ]);
    }

    public function deleteData($id)
    {
        $this->userModel->deleteData($id);
        return json_encode([
            'message' => 'success delete'
        ]);
    }
}
