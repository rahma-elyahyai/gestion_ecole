<?php
include "connexion.php";

/**
 * Logging simple pour les opérations CRUD des professeurs
 */
function logActionProf($action, $data) {
    $logFile = __DIR__ . '/crud_prof.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "$timestamp - $action: " . json_encode($data) . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
}

// Table utilisée
$table = 'prof';

// AJOUTER PROFESSEUR
function ajouterProfesseur($code, $nom, $prenom, $email, $langues = null, $specialite = null) {
    global $table;
    try {
        logActionProf('INSERT_ATTEMPT', compact('code','nom','prenom','email','langues','specialite'));
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Email invalide");
        $conn = Connect();
        $sql = "INSERT INTO {$table} (code, nom, prenom, email, langues, specialite) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param("ssssss", $code, $nom, $prenom, $email, $langues, $specialite);
        $ok = $stmt->execute();
        $newId = $stmt->insert_id;
        logActionProf('INSERT_RESULT', ['success' => $ok, 'insert_id' => $newId, 'error' => $stmt->error]);
        $stmt->close();
        $conn->close();
        return $ok ? $newId : false;
    } catch (Exception $e) {
        error_log($e->getMessage());
        logActionProf('ERROR_INSERT', ['message' => $e->getMessage(), 'code' => $code ?? null]);
        return false;
    }
}

// RECUPERER TOUS LES PROFESSEURS
function getAllProfesseurs() {
    global $table;
    try {
        $conn = Connect();
        $sql = "SELECT * FROM {$table} ORDER BY nom, prenom";
        $result = $conn->query($sql);
        logActionProf('SELECT_ALL', ['count' => $result ? $result->num_rows : 0]);
        $conn->close();
        return $result;
    } catch (Exception $e) {
        error_log($e->getMessage());
        logActionProf('ERROR_SELECT', ['message' => $e->getMessage()]);
        return null;
    }
}

// RECUPERER UN PROFESSEUR PAR ID
function getProfesseurById($id) {
    global $table;
    try {
        $conn = Connect();
        $sql = "SELECT * FROM {$table} WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res ? $res->fetch_assoc() : null;
        $stmt->close();
        $conn->close();
        logActionProf('GET', ['id' => $id]);
        return $row;
    } catch (Exception $e) {
        error_log($e->getMessage());
        logActionProf('ERROR_GET', ['id' => $id, 'message' => $e->getMessage()]);
        return null;
    }
}

// MODIFIER PROFESSEUR
function modifierProfesseur($id, $code, $nom, $prenom, $email, $langues = null, $specialite = null) {
    global $table;
    try {
        $conn = Connect();
        $sql = "UPDATE {$table} SET code = ?, nom = ?, prenom = ?, email = ?, langues = ?, specialite = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param("ssssssi", $code, $nom, $prenom, $email, $langues, $specialite, $id);
        $ok = $stmt->execute();
        $affected = $stmt->affected_rows;
        logActionProf('UPDATE', ['id' => $id, 'affected_rows' => $affected, 'error' => $stmt->error]);
        $stmt->close();
        $conn->close();
        return $ok;
    } catch (Exception $e) {
        error_log($e->getMessage());
        logActionProf('ERROR_UPDATE', ['id' => $id, 'message' => $e->getMessage()]);
        return false;
    }
}

// SUPPRIMER PROFESSEUR
function supprimerProfesseur($id) {
    global $table;
    try {
        $conn = Connect();
        $sql = "DELETE FROM {$table} WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if (!$stmt) throw new Exception("Prepare failed: " . $conn->error);
        $stmt->bind_param("i", $id);
        $ok = $stmt->execute();
        $affected = $stmt->affected_rows;
        logActionProf('DELETE', ['id' => $id, 'affected_rows' => $affected, 'error' => $stmt->error]);
        $stmt->close();
        $conn->close();
        return $ok;
    } catch (Exception $e) {
        error_log($e->getMessage());
        logActionProf('ERROR_DELETE', ['id' => $id, 'message' => $e->getMessage()]);
        return false;
    }
}
?>
