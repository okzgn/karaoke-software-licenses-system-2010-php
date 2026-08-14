<?php

class MockMySQLResult {
    public $rows = [];
    public $currentIndex = 0;
    public $columnCount = 0;

    public function __construct($pdoStmt) {
        if ($pdoStmt) {
            $this->rows = $pdoStmt->fetchAll(PDO::FETCH_BOTH);
            $this->columnCount = $pdoStmt->columnCount();
        }
    }
}

class KLM_Mock_DB {
    public static $pdo = null;

    public static function getPDO() {
        if (self::$pdo === null) {
            $dbFile = __DIR__ . '/docs/klm.sqlite';
            $isNew = !file_exists($dbFile);

            self::$pdo = new PDO('sqlite:' . $dbFile);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

            if ($isNew) {
                self::initSchemaAndSeed();
            }
        }
        return self::$pdo;
    }

    private static function initSchemaAndSeed() {
        $db = self::$pdo;

        $db->exec("CREATE TABLE IF NOT EXISTS sellers (
            ref INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE,
            password TEXT,
            names TEXT,
            sign TEXT,
            lic_actived INTEGER DEFAULT 0,
            lic_used INTEGER DEFAULT 0,
            last TEXT DEFAULT '0000-00-00'
        );");

        $db->exec("CREATE TABLE IF NOT EXISTS generated (
            ord INTEGER PRIMARY KEY AUTOINCREMENT,
            ref INTEGER,
            client TEXT,
            firstCode TEXT,
            activationCode TEXT,
            creation TEXT
        );");

        $db->exec("CREATE TABLE IF NOT EXISTS money (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            ref INTEGER,
            names TEXT,
            licences INTEGER,
            price REAL,
            total REAL,
            date TEXT
        );");

        $db->exec("CREATE TABLE IF NOT EXISTS messages (
            ref INTEGER PRIMARY KEY AUTOINCREMENT,
            names TEXT,
            subject TEXT,
            message TEXT
        );");

        // Usuarios: password123
        $db->exec("INSERT INTO sellers VALUES (1, 'juanp', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 'Juan Pusuqui', 'JP Karaoke', 5, 2, '2010-02-15');");
        $db->exec("INSERT INTO sellers VALUES (2, 'carlosm', 'cbfdac6008f9cab4083784cbd1874f76618d2a97', 'Carlos Mayorca', 'Guayaquil Musik', 10, 0, '2009-06-10');");

        // Licencias
        $db->exec("INSERT INTO generated VALUES (1, 1, 'Bar La Rockola', 'A1B2C3D4', '94F2B', '2010-03-10');");
        $db->exec("INSERT INTO generated VALUES (2, 1, 'Discoteca El Faraon', 'E5F6A7B8', 'A8C3D', '2009-07-12');");

        // Mensajes
        $db->exec("INSERT INTO messages VALUES (1, 'juanp@gmail.com', 'Consulta de precio', 'Deseo adquirir 2 licencias.');");
        $db->exec("INSERT INTO messages VALUES (2, 'carlosm@hotmail.com', 'Requerimiento especial', 'Necesito tener facilidad de acceso en la app.');");
    }
}

// Emulación de funciones nativas mysql_*
if (!function_exists('mysql_connect')) {

    function mysql_connect($host = null, $user = null, $pass = null) {
        try {
            KLM_Mock_DB::getPDO();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function mysql_query($query, $link = null) {
        $pdo = KLM_Mock_DB::getPDO();
        $trimmed = trim($query);

        // Ignorar comandos 'USE db_name'
        if (preg_match('/^use\s+/i', $trimmed)) {
            return true;
        }

        // Adaptar TRUNCATE a DELETE
        $query = preg_replace('/^truncate\s+table\s+(\w+)/i', 'DELETE FROM $1', $query);

        // Adaptar 'INSERT INTO ... VALUES (0, ...)' para AUTOINCREMENT de SQLite
        $query = preg_replace('/values\s*\(\s*0\s*,/i', 'VALUES (NULL,', $query);

        // Adaptar 'DELETE ... LIMIT 1'
        $query = preg_replace('/\s+limit\s+1\s*;?$/i', '', $query);

        $stmt = $pdo->query($query);
        if ($stmt === false) {
            return false;
        }

        // Si es SELECT devuelve objeto con filas, si es UPDATE/INSERT devuelve true
        if (preg_match('/^(select|show|describe)/i', $trimmed)) {
            return new MockMySQLResult($stmt);
        }

        return true;
    }

    function mysql_fetch_object($result) {
        if ($result instanceof MockMySQLResult && isset($result->rows[$result->currentIndex])) {
            $row = $result->rows[$result->currentIndex];
            $result->currentIndex++;
            return (object)$row;
        }
        return false;
    }

    function mysql_num_rows($result) {
        return ($result instanceof MockMySQLResult) ? count($result->rows) : 0;
    }

    function mysql_num_fields($result) {
        return ($result instanceof MockMySQLResult) ? $result->columnCount : 0;
    }

    function mysql_free_result($result) {
        return true;
    }

    function mysql_result($result, $row, $field = 0) {
        if ($result instanceof MockMySQLResult && isset($result->rows[$row][$field])) {
            return $result->rows[$row][$field];
        }
        return false;
    }
}
