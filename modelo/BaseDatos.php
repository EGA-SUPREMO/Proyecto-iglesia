<?php

class BaseDatos
{
    private static ?PDO $pdoInstance = null;
    private static $host = null;
    private static $dbname = null;
    private static $user = null;
    private static $pass = null;
    private static $charset = 'utf8';

    private function __construct()
    {
    }

    public static function obtenerConexion(
        $host = null,
        $dbname = null,
        $user = null,
        $pass = null,
        $charset = null
    ) {
        if (self::$pdoInstance !== null) {
            return self::$pdoInstance;
        }
        $h = $host ?? self::$host;
        $d = $dbname ?? self::$dbname;
        $u = $user ?? self::$user;
        $p = $pass ?? self::$pass;
        $c = $charset ?? self::$charset;

        if ($h === null || $d === null || $u === null || $p === null) {
            throw new PDOException("Faltan credenciales. Deben proporcionarse en la primera llamada.");
        }

        try {
            $dsn = "mysql:host={$h};dbname={$d};charset={$c}";

            self::$pdoInstance = new PDO($dsn, $u, $p);
            self::$pdoInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$host = $h;
            self::$dbname = $d;
            self::$user = $u;
            self::$pass = $p;
            self::$charset = $c;

        } catch (PDOException $e) {
            self::$pdoInstance = null;
            error_log("Error de conexión a la base de datos: " . $e->getMessage());
            throw new PDOException("No se pudo conectar a la base de datos.");
        }

        return self::$pdoInstance;
    }

    public static function hacerRespaldo($pdo, $backupDir)
    {
        $backupDir = rtrim($backupDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        if (!is_dir($backupDir)) {
            if (!mkdir($backupDir, 0755, true)) {
                error_log("Error: No se pudo crear el directorio de copias de seguridad: " . $backupDir);
                return;
            }
        }

        $currentDate = date("Y-m-d");
        $todayFilePath = $backupDir . 'respaldo_base_de_datos_' . $currentDate . '.sql';

        if (file_exists($todayFilePath)) {
            error_log("Omitiendo la creación: " . $todayFilePath);
            self::limpiarBackupsAntiguos($backupDir, 30);
            return;
        }
        $handle = fopen($todayFilePath, 'w+');
        if (!$handle) {
            error_log("Error: No se pudo abrir el archivo para escribir.");
            return;
        }

        fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
        fwrite($handle, "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n");
        fwrite($handle, "START TRANSACTION;\n");
        fwrite($handle, "SET time_zone = \"+00:00\";\n\n");

        $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
        foreach ($tables as $table) {
            $createTable = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);

            fwrite($handle, "\n-- Estructura para la tabla `$table`\n");
            fwrite($handle, "DROP TABLE IF EXISTS `$table`;\n");
            fwrite($handle, $createTable['Create Table'] . ";\n");

            fwrite($handle, "\n-- Datos de la tabla `$table`\n");
            $statement = $pdo->query("SELECT * FROM `$table`");
            $rows = $statement->fetchAll(PDO::FETCH_NUM);

            foreach ($rows as $row) {
                $data = array_map(function ($value) use ($pdo) {
                    if (isset($value)) {
                        return $pdo->quote($value);
                    }
                    return 'NULL';
                }, $row);

                $line = "INSERT INTO `$table` VALUES (" . implode(", ", $data) . ");\n";
                fwrite($handle, $line);
            }
        }

        fwrite($handle, "\nSET FOREIGN_KEY_CHECKS=1;\n");
        fwrite($handle, "COMMIT;\n");

        fclose($handle);

        error_log("Copia de seguridad creada con éxito en: " . $todayFilePath);
        self::limpiarBackupsAntiguos($backupDir, 30);
    }

    private static function limpiarBackupsAntiguos($backupDir, $keepLimit)
    {
        // Obtener todos los archivos que coincidan con el patrón 'respaldo_base_de_datos_YYYY-MM-DD.sql'
        // Utilizamos GLOB_BRACE por si el nombre del archivo cambia, aunque el actual no lo usa.
        $files = glob($backupDir . 'respaldo_base_de_datos_*.sql');
        if (count($files) <= $keepLimit) {
            return;
        }

        // Ordenar los archivos por fecha de modificación (la más antigua primero)
        // filemtime() devuelve el timestamp de la última modificación
        $sortedFiles = [];
        foreach ($files as $file) {
            $sortedFiles[filemtime($file)] = $file;
        }
        ksort($sortedFiles); // Ordenar por la clave (timestamp) ascendente

        $filesToDeleteCount = count($sortedFiles) - $keepLimit;
        // Tomar los N archivos más antiguos (los primeros N del array ordenado)
        $filesToDelete = array_slice($sortedFiles, 0, $filesToDeleteCount);

        foreach ($filesToDelete as $timestamp => $file) {
            error_log(print_r($file, true));
            if (unlink($file)) {
                error_log("Copia de seguridad antigua eliminada con éxito: " . basename($file) . " (Fecha: " . date("Y-m-d H:i:s", $timestamp) . ")");
            } else {
                error_log("Error al eliminar la copia de seguridad antigua: " . $file);
            }
        }
    }
}
