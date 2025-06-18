<?php
// Este archivo es solo para propósitos de prueba y no debe considerarse
// como parte de una aplicación en producción sin la debida seguridad y validación.

// Simulación de inclusión de clases y conexión a BD
require_once 'db.php'; // Asume que db.php define la clase DB y las clases de entidades si son necesarias aquí

// Simulación de clases de entidades (si no están en db.php o en otro include)
if (!class_exists('Encuesta')) {
    class Encuesta {
        private $nombre;
        private $preguntas = [];
        public function __construct($nombre) { $this->nombre = $nombre; }
        public function get_nombre() { return $this->nombre; }
        public function agregar_pregunta(Pregunta $pregunta) { $this->preguntas[] = $pregunta; }
        public function get_preguntas() { return $this->preguntas; }
    }
}

if (!class_exists('Pregunta')) {
    class Pregunta {
        private $enunciado;
        private $alternativas = [];
        public function __construct($enunciado, $alternativas) {
            $this->enunciado = $enunciado;
            $this->alternativas = $alternativas;
        }
        public function get_enunciado() { return $this->enunciado; }
        public function get_alternativas() { return $this->alternativas; }
    }
}

echo "<h1>Script de Prueba para Agregar Encuesta</h1>";

// Crear instancia de la base de datos (simulada)
$db = new DB();

// Crear una nueva encuesta de ejemplo
$nombre_encuesta_prueba = "Encuesta de Satisfacción PHP " . date("Y-m-d H:i:s");
$encuesta_prueba = new Encuesta($nombre_encuesta_prueba);

// Agregar preguntas a la encuesta de ejemplo
$pregunta1_texto = "¿Qué tan satisfecho estás con nuestro servicio PHP?";
$alternativas1 = ["Muy satisfecho", "Satisfecho", "Neutral", "Insatisfecho", "Muy insatisfecho"];
$pregunta1 = new Pregunta($pregunta1_texto, $alternativas1);
$encuesta_prueba->agregar_pregunta($pregunta1);

$pregunta2_texto = "¿Recomendarías nuestro producto PHP a un amigo?";
$alternativas2 = ["Sí, definitivamente", "Probablemente sí", "No estoy seguro", "Probablemente no", "Definitivamente no"];
$pregunta2 = new Pregunta($pregunta2_texto, $alternativas2);
$encuesta_prueba->agregar_pregunta($pregunta2);

// Guardar la encuesta utilizando la clase DB (simulada)
if ($db->guardar_encuesta($encuesta_prueba)) {
    echo "<p style='color: green;'>Encuesta '" . htmlspecialchars($encuesta_prueba->get_nombre()) . "' agregada exitosamente (simulado).</p>";

    echo "<h2>Detalles de la Encuesta Agregada:</h2>";
    echo "<p><strong>Nombre:</strong> " . htmlspecialchars($encuesta_prueba->get_nombre()) . "</p>";
    echo "<h3>Preguntas:</h3>";
    echo "<ul>";
    foreach ($encuesta_prueba->get_preguntas() as $pregunta) {
        echo "<li><strong>" . htmlspecialchars($pregunta->get_enunciado()) . "</strong>";
        echo "<ul>";
        foreach ($pregunta->get_alternativas() as $alternativa) {
            echo "<li>" . htmlspecialchars($alternativa) . "</li>";
        }
        echo "</ul></li>";
    }
    echo "</ul>";

} else {
    echo "<p style='color: red;'>Error al agregar la encuesta (simulado).</p>";
}

// No es necesario cerrar la conexión explícitamente si __destruct se encarga de ello.
// unset($db);

echo "<p>Fin del script de prueba.</p>";

?>
