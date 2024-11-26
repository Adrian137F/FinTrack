<?php
// Ruta al archivo de almacenamiento de usuarios
define('USERS_FILE', __DIR__ . '/users.txt');

// Función para cifrar contraseñas
function encryptPassword($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Función para validar contraseñas
function validatePassword($password, $hash) {
    return password_verify($password, $hash);
}

// Función para registrar usuarios
function registerUser($username, $password) {
    $users = loadUsers();

    if (isset($users[$username])) {
        return "El usuario ya existe.";
    }

    $users[$username] = encryptPassword($password);
    saveUsers($users);
    return "Usuario registrado exitosamente.";
}

// Función para iniciar sesión
function loginUser($username, $password) {
    $users = loadUsers();

    if (!isset($users[$username])) {
        return false;
    }

    return validatePassword($password, $users[$username]);
}

// Función para cargar usuarios
function loadUsers() {
    if (!file_exists(USERS_FILE)) {
        return [];
    }

    $data = file_get_contents(USERS_FILE);
    return json_decode($data, true) ?? [];
}

// Función para guardar usuarios
function saveUsers($users) {
    file_put_contents(USERS_FILE, json_encode($users));
}
