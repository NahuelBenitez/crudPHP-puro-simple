<?php
// controller/UserController.php

require_once './config/database.php';
require_once './model/User.php';

class UserController {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function index() {
        // Lógica para mostrar todos los usuarios
        $users = $this->getAllUsers();
        require './view/index.php';
    }

    public function create() {
        // Lógica para mostrar formulario de creación de usuario
        require './view/create.php';
    }

    public function store() {
        // Lógica para guardar un nuevo usuario en la base de datos
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener datos del formulario
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];

            // Insertar usuario en la base de datos
            $stmt = $this->db->prepare("INSERT INTO users (nombre, apellido, email) VALUES (:nombre, :apellido, :email)");
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            // Redireccionar a la página de inicio
            header("Location: index.php?action=index");
        }
    }

    public function getUserById($id) {
        // Preparar la consulta para obtener un usuario por su ID
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        // Obtener el usuario
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }
    public function edit() {
        // Obtener el ID del usuario a editar
        $userId = $_GET['id'];
        
        // Obtener los datos del usuario desde la base de datos
        $user = $this->getUserById($userId);
    
        // Pasar los datos del usuario a la vista
        require './view/edit.php';
    }
    public function update() {
        // Verificar si el formulario de actualización ha sido enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtener los datos del formulario
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
    
            // Preparar la consulta para actualizar el usuario en la base de datos
            $stmt = $this->db->prepare("UPDATE users SET nombre = :nombre, apellido = :apellido, email = :email WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':email', $email);
            
            // Ejecutar la consulta
            $stmt->execute();
    
            // Redireccionar a la página de inicio después de la actualización
            header("Location: index.php?action=index");
        }
    }
    

    public function delete() {
        
        if(isset($_GET['id'])) {
            $userId = $_GET['id'];
    
            // Preparar la consulta para eliminar el usuario de la base de datos
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            
            // Ejecutar la consulta
            $stmt->execute();
    
            // Redireccionar a la página de inicio después de eliminar el usuario
            header("Location: index.php?action=index");
        } else {
            // Si no se proporciona un ID de usuario, redirigir a la página de inicio
            header("Location: index.php?action=index");
        }
    }
    

    private function getAllUsers() {
        // Obtener todos los usuarios de la base de datos
        $stmt = $this->db->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
}
