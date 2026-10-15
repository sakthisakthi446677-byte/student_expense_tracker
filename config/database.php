<?php
if (!defined('BASE_URL')) {
    $h = $_SERVER['HTTP_HOST'] ?? '';
    define('BASE_URL', str_contains($h, '5300.') ? '/proxy/' . ($_SERVER['SERVER_PORT'] ?? '8080') : '');
}
$DB_HOST = 'db01.dbhost.dev'; $DB_PORT = '5051'; $DB_NAME = 'db_45686cjt5';
$DB_USER = 'user_45686cjt5'; $DB_PASS = 'p45686cjt5';
$pdo = null;
try {
    $pdo = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 2
    ]);
} catch(Exception $e) { error_log("DB fail: ".$e->getMessage()); }
function getUserByEmail($e){ global $pdo; if(!$pdo) return false; $s=$pdo->prepare("SELECT * FROM expense_users WHERE email=?"); $s->execute([$e]); return $s->fetch(); }
function getTxns($uid=1){ global $pdo; if(!$pdo) return []; $s=$pdo->prepare("SELECT * FROM transactions WHERE user_id=? ORDER BY id DESC"); $s->execute([$uid]); return $s->fetchAll(); }
function addTxn($uid,$t,$c,$a,$d,$n){ global $pdo; if(!$pdo) return false; $s=$pdo->prepare("INSERT INTO transactions (user_id,type,category,amount,date,note) VALUES (?,?,?,?,?,?)"); return $s->execute([$uid,$t,$c,$a,$d,$n]); }
?>
