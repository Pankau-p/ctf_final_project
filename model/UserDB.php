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
            die($e->getMessage());
            //$error_message = $e->getMessage();
            //include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/database_error.php');            
            //exit();
        }
    }

    // Get the list of countries from the DB
    public function get_countries() {
        try {
            $query = 'SELECT * FROM countries';
            $statement = $this->db->prepare($query);
            $statement->execute();
            $countries = $statement->fetchAll();
            $statement->closeCursor();
            return $countries;
        } catch (PDOException $e) {
            die($e->getMessage());
            //$error_message = $e->getMessage();
            //include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/database_error.php');   
            //exit();
        }
    }

    // Add a customer with firstName, lastName, 
    // countryCode, email and password
    public function register_user($username, $firstName, $lastName, 
                      $countryCode, $email, $password) {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $query = 'INSERT INTO users (username, firstName, lastName, 
                      countryCode, email, password)
                      VALUES
                      (:username, :firstName, :lastName, :countryCode,:email, :password_hash)';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':countryCode', $countryCode);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password_hash', $password_hash);
            $statement->execute();
            $statement->closeCursor();
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            die($e->getMessage());
            //$error_message = $e->getMessage();
            //include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/database_error.php');   
            //exit();
        }
    }

    public function get_user_by_id($user_id) {
        try {
            $query = 'SELECT * FROM users
                      WHERE users.userID = :user_id';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':user_id', $user_id);   
            $statement->execute();
            $user = $statement->fetch();
            $statement->closeCursor();
            return $user;     
        } catch (PDOException $e) {
            die($e->getMessage());
            //$error_message = $e->getMessage();
            //include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/database_error.php');   
            //exit();
        }
    }

    public function get_user_stats($user_id) {
        try {
            $query = 'SELECT 
                        SUM(CASE WHEN uc.solved = true THEN c.points ELSE 0 END) AS totalPoints,
                        SUM(CASE WHEN uc.solved = true THEN 1 ELSE 0 END) AS totalSolved,
                        SUM(uc.attempts) AS totalAttempts
                        FROM user_challenges uc
                        JOIN challenges c ON uc.challengeID = c.challengeID
                        WHERE uc.userID = :user_id';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':user_id', $user_id);   
            $statement->execute();
            $user_stats = $statement->fetch();
            $statement->closeCursor();
            return $user_stats;  
        } catch (PDOException $e) {
            die($e->getMessage());
            //$error_message = $e->getMessage();
            //include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/database_error.php');   
            //exit();
        }
    }

    public function get_progress($user_id) {
        try {
            $query = 'SELECT
                        SUM(CASE WHEN uc.solved = true THEN 1 ELSE 0 END) AS solved,
                        (SELECT COUNT(*) FROM challenges) AS total
                        FROM user_challenges uc
                        WHERE uc.userID = :user_id';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':user_id', $user_id);   
            $statement->execute();
            $user_progress = $statement->fetch();
            $statement->closeCursor();
            return $user_progress;  
        } catch (PDOException $e) {
            die($e->getMessage());
            //$error_message = $e->getMessage();
            //include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/database_error.php');   
            //exit();
        }
    }

    public function get_challenges_with_status($user_id) {
        try {
            $query = 'SELECT c.challengeID, c.title, c.difficulty, c.points,
                      COALESCE(uc.solved, 0) AS solved
                      FROM challenges c
                      LEFT JOIN user_challenges uc 
                      ON c.challengeID = uc.challengeID 
                      AND uc.userID = :user_id';
            $statement = $this->db->prepare($query);
            $statement->bindValue(':user_id', $user_id);   
            $statement->execute();
            $challenge_with_status = $statement->fetchAll();
            $statement->closeCursor();
            return $challenge_with_status; 
        } catch (PDOException $e) {
            die($e->getMessage());
            //$error_message = $e->getMessage();
            //include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/database_error.php');   
            //exit();
        }
    }

    public function  get_leaderboard() {
        try {
            $query = 'SELECT u.username, 
                       COALESCE(SUM(CASE WHEN uc.solved = true THEN c.points ELSE 0 END), 0) AS totalPoints
                       FROM users u
                       LEFT JOIN user_challenges uc ON u.userID = uc.userID
                       LEFT JOIN challenges c ON uc.challengeID = c.challengeID
                       GROUP BY u.userID, u.username
                       ORDER BY totalPoints DESC';
            $statement = $this->db->prepare($query);
            $statement->execute();
            $leaderboard = $statement->fetchAll();
            $statement->closeCursor();
            return $leaderboard; 
        } catch (PDOException $e) {
            die($e->getMessage());
            //$error_message = $e->getMessage();
            //include($_SERVER['DOCUMENT_ROOT'] . '/ctf/view/shared/database_error.php');   
            //exit();
        }
    }
}