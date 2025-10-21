<?php
include "connexion.php";

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function ajouterEtudiant($code, $nom, $prenom, $email, $sexe, $filiere) {
    try {
        if (!validateEmail($email)) {
            throw new Exception("Format d'email invalide");
        }
        
        $conn = Connect();
        $sql = "INSERT INTO etudiant (code, nom, prenom, email, sexe, filiere) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $code, $nom, $prenom, $email, $sexe, $filiere);
        
        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de l'insertion: " . $stmt->error);
        }
        
        $newId = $stmt->insert_id;
        $stmt->close();
        $conn->close();
        return $newId;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

function logAction($action, $data) {
    $logFile = __DIR__ . '/crud.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "$timestamp - $action: " . json_encode($data) . "\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

function getAllEtudiants() {
    try {
        $conn = Connect();
        if (!$conn) {
            throw new Exception("Erreur de connexion à la base de données");
        }
        
        $sql = "SELECT * FROM etudiant ORDER BY nom, prenom";
        $result = $conn->query($sql);
        
        if ($result === false) {
            throw new Exception("Erreur SQL: " . $conn->error);
        }
        
        logAction("SELECT_ALL", ["count" => $result->num_rows]);
        return $result;
    } catch (Exception $e) {
        logAction("ERROR", ["message" => $e->getMessage()]);
        error_log($e->getMessage());
        return null;
    }
}

function getEtudiantById($id) {
    try {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new Exception("ID étudiant invalide");
        }
        
        $conn = Connect();
        $sql = "SELECT * FROM etudiant WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de la récupération: " . $stmt->error);
        }
        
        $result = $stmt->get_result();
        $etudiant = $result->fetch_assoc();
        
        $stmt->close();
        $conn->close();
        
        if (!$etudiant) {
            throw new Exception("Étudiant non trouvé");
        }
        
        return $etudiant;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return null;
    }
}

function modifierEtudiant($id, $code, $nom, $prenom, $email, $sexe, $filiere) {
    try {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new Exception("ID étudiant invalide");
        }
        
        if (!validateEmail($email)) {
            throw new Exception("Format d'email invalide");
        }
        
        $conn = Connect();
        $sql = "UPDATE etudiant SET code=?, nom=?, prenom=?, email=?, sexe=?, filiere=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $code, $nom, $prenom, $email, $sexe, $filiere, $id);
        
        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de la modification: " . $stmt->error);
        }
        
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        $conn->close();
        return $success;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}

function supprimerEtudiant($id) {
    try {
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new Exception("ID étudiant invalide");
        }
        
        $conn = Connect();
        $sql = "DELETE FROM etudiant WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute()) {
            throw new Exception("Erreur lors de la suppression: " . $stmt->error);
        }
        
        $success = $stmt->affected_rows > 0;
        $stmt->close();
        $conn->close();
        return $success;
    } catch (Exception $e) {
        error_log($e->getMessage());
        return false;
    }
}