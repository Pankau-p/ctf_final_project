<?php
// File: model/auth_db.php
//
// Author: 
// Course: COMP 3541 - Web Programming
// Date: 2026-05-19
//
// Final
//
// Description: Model for authenticating an administrator user 
// in the database and app. 

class UserDB {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Returns an authenticated admin user
    public function get_user($email) {
        try {
            $query = 'SELECT * FROM users
                      WHERE users.email = :email';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->execute();
            $user = $statement->fetch();
            $statement->closeCursor();
            return $user;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            include($_SERVER['DOCUMENT_ROOT'] . 'view/shared/database_error.php');            
            exit();
        }
    }
}