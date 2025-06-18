<?php

// --- Database Connection Parameters ---
// IMPORTANT: Replace with your actual database credentials if needed.
// These are common defaults for a local development environment.
$servername = "localhost"; // أو "127.0.0.1"
$username = "encuesta_user";        // Common default username
$password = "encuesta_pass";            // Common default password (often empty for local XAMPP/WAMP)
$dbname = "encuesta_app";

echo "<h1>Configuración de la Base de Datos</h1>";

// --- 1. Connect to MySQL Server (without selecting a database initially) ---
echo "<p>Paso 1: Conectando al servidor MySQL en '$servername'...</p>";
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("<p style='color: red;'>Error de conexión al servidor MySQL: " . $conn->connect_error . "</p><p>Por favor, verifica los parámetros de conexión (\$servername, \$username, \$password) en este script y asegúrate de que el servidor MySQL esté en ejecución.</p></body></html>");
}
echo "<p style='color: green;'>Conexión al servidor MySQL exitosa.</p>";

// --- 2. Create Database if it doesn't exist ---
echo "<p>Paso 2: Creando la base de datos '$dbname' si no existe...</p>";
$sql_create_db = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql_create_db) === TRUE) {
    echo "<p style='color: green;'>Base de datos '$dbname' creada exitosamente o ya existía.</p>";
} else {
    echo "<p style='color: red;'>Error al crear la base de datos '$dbname': " . $conn->error . "</p>";
    $conn->close();
    die("</body></html>");
}

// --- 3. Select the Database ---
echo "<p>Paso 3: Seleccionando la base de datos '$dbname'...</p>";
if ($conn->select_db($dbname) === TRUE) {
    echo "<p style='color: green;'>Base de datos '$dbname' seleccionada exitosamente.</p>";
} else {
    echo "<p style='color: red;'>Error al seleccionar la base de datos '$dbname': " . $conn->error . "</p>";
    $conn->close();
    die("</body></html>");
}

// --- 4. Create 'pruebas' Table ---
echo "<p>Paso 4: Creando la tabla 'pruebas' si no existe...</p>";
$sql_create_table = "
CREATE TABLE IF NOT EXISTS `pruebas` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `nombre` VARCHAR(255) NOT NULL,
  `descripcion` TEXT,
  `fecha_creacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `activo` BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

if ($conn->query($sql_create_table) === TRUE) {
    echo "<p style='color: green;'>Tabla 'pruebas' creada exitosamente o ya existía.</p>";
} else {
    echo "<p style='color: red;'>Error al crear la tabla 'pruebas': " . $conn->error . "</p>";
}

// --- Close Connection ---
echo "<p>Cerrando conexión a la base de datos.</p>";
$conn->close();

echo "<hr><p><strong>Configuración completada.</strong> Si no hubo errores rojos arriba, la base de datos '$dbname' y la tabla 'pruebas' deberían estar listas.</p>";
echo "<p><a href='index.php'>Volver al inicio</a></p>";

?>
</body>
</html>
