<?php
session_start();
include_once 'modelo/FuncionesComunes.php';
FuncionesComunes::requerirLogin();

// 1. FORZAR VISUALIZACIÓN DE ERRORES (Crítico para debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<style>
    body { font-family: sans-serif; background: #f4f4f4; padding: 20px; }
    .card { background: white; padding: 15px; margin-bottom: 15px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .ok { color: green; font-weight: bold; }
    .fail { color: red; font-weight: bold; border: 1px solid red; padding: 5px; background: #ffeeee; }
    .warn { color: orange; font-weight: bold; }
    h2 { border-bottom: 1px solid #ccc; padding-bottom: 10px; }
    .btn {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        border-radius: 8px; /* Membuat sudut lebih bulat/modern */
        transition: all 0.3s ease; /* Membuat efek halus saat ditekan */
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 123, 255, 0.2); /* Efek bayangan lembut */
    }

    .btn-primary:hover {
        background-color: #0056b3; /* Warna berubah sedikit gelap saat kursor di atasnya */
        transform: translateY(-2px); /* Efek melayang sedikit */
        box-shadow: 0 6px 12px rgba(0, 123, 255, 0.3);
    }
</style>";

echo '<a href="index.php" class="btn btn-primary">Volver</a>';

echo "<h1>🔍 Diagnóstico de Entorno Windows/PHP</h1>";

// --- BLOQUE 1: IDENTIDAD Y SISTEMA ---
echo "<div class='card'><h2>1. Identidad del Proceso</h2>";
$usuario_php = get_current_user();
$usuario_sistema = trim(shell_exec('whoami'));

echo "<ul>";
echo "<li><strong>Versión de PHP:</strong> " . phpversion() . "</li>";
echo "<li><strong>Usuario del Script (PHP):</strong> $usuario_php</li>";
echo "<li><strong>Usuario del Sistema (Exec):</strong> " . ($usuario_sistema ?: '<span class="fail">No se pudo determinar (shell_exec bloqueado?)</span>') . "</li>";

if (stripos($usuario_sistema, 'system') !== false) {
    echo "<li><span class='warn'>⚠️ Estás corriendo como SYSTEM (Servicio). Recuerda usar rutas absolutas y el flag -env para LibreOffice.</span></li>";
}
echo "</ul></div>";

// --- BLOQUE 2: EXTENSIONES CRÍTICAS ---
echo "<div class='card'><h2>2. Extensiones Requeridas</h2>";
$extensiones = ['zip', 'xml', 'gd', 'intl', 'fileinfo'];
echo "<ul>";
foreach ($extensiones as $ext) {
    if (extension_loaded($ext)) {
        echo "<li>Extensión <strong>$ext</strong>: <span class='ok'>INSTALADA (OK)</span></li>";
    } else {
        echo "<li>Extensión <strong>$ext</strong>: <span class='fail'>FALTA HABILITAR EN PHP.INI (CRÍTICO)</span></li>";
        echo "<small> -> Nota: Sin 'zip', PhpWord NO funcionará y no mostrará error.</small><br>";
    }
}
echo "</ul></div>";

// --- BLOQUE 3: PERMISOS DE ESCRITURA ---
echo "<div class='card'><h2>3. Permisos de Sistema de Archivos</h2>";
echo "<ul>";

// Chequeo carpeta actual
$dir_actual = __DIR__;
if (is_writable($dir_actual)) {
    echo "<li>Escritura en carpeta actual ($dir_actual): <span class='ok'>OK</span></li>";
} else {
    echo "<li>Escritura en carpeta actual: <span class='fail'>DENEGADO</span>. El usuario '$usuario_sistema' no puede guardar el PDF aquí.</li>";
}

// Chequeo carpeta temporal del sistema
$temp_dir = sys_get_temp_dir();
if (is_writable($temp_dir)) {
    echo "<li>Escritura en carpeta TEMP ($temp_dir): <span class='ok'>OK</span></li>";
} else {
    echo "<li>Escritura en carpeta TEMP: <span class='fail'>DENEGADO</span>. PhpWord fallará al crear archivos temporales.</li>";
}
echo "</ul></div>";

// --- BLOQUE 4: DETECCIÓN DE LIBREOFFICE ---
echo "<div class='card'><h2>4. Búsqueda de LibreOffice</h2>";
$candidatos = [
    'soffice' => 'Variable de entorno (PATH)',
    'C:\Program Files\LibreOffice\program\soffice.exe' => 'Ruta estándar 64-bit',
    'C:\Program Files (x86)\LibreOffice\program\soffice.exe' => 'Ruta estándar 32-bit',
    'C:\Program Files\OpenOffice\program\soffice.exe' => 'OpenOffice 64-bit',
];

$encontrado = false;
echo "<ul>";
foreach ($candidatos as $ruta => $desc) {
    $existe = false;
    if ($ruta === 'soffice') {
        $check = shell_exec('where soffice 2>NUL');
        if ($check) {
            $existe = true;
        }
    } else {
        if (file_exists($ruta)) {
            $existe = true;
        }
    }

    if ($existe) {
        echo "<li>$desc: <span class='ok'>ENCONTRADO ($ruta)</span></li>";
        $encontrado = true;
    } else {
        echo "<li>$desc: <span style='color:#ccc'>No encontrado</span></li>";
    }
}

if (!$encontrado) {
    echo "<br><span class='fail'>❌ CRÍTICO: No se encontró ningún ejecutable de LibreOffice/OpenOffice.</span>";
}
echo "</ul></div>";

// --- BLOQUE 5: PRUEBA DE EXEC() ---
echo "<div class='card'><h2>5. Prueba de funciones exec()</h2>";
$disabled = ini_get('disable_functions');
if ($disabled) {
    echo "Funciones deshabilitadas: $disabled <br>";
}

if (function_exists('exec')) {
    echo "Función exec(): <span class='ok'>HABILITADA</span><br>";
    // Prueba real de ejecución
    exec('dir 2>&1', $output, $return);
    if ($return === 0) {
        echo "Prueba de comando (dir): <span class='ok'>EJECUTADO CORRECTAMENTE</span>";
    } else {
        echo "Prueba de comando (dir): <span class='fail'>FALLÓ (Código $return)</span>. Puede ser permisos de cmd.exe";
    }
} else {
    echo "Función exec(): <span class='fail'>DESHABILITADA EN PHP.INI</span>";
}
echo "</div>";
?> 
