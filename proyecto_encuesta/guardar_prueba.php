<?php
// Este archivo es solo para propósitos de prueba y no debe considerarse
// como parte de una aplicación en producción sin la debida seguridad y validación.

// Simulación de inclusión de clases y conexión a BD
require_once 'db.php'; // Asume que db.php define la clase DB y las clases de entidades

// Simulación de clases de entidades (si no están en db.php o en otro include)
// Es importante que estas definiciones coincidan con las usadas en otros archivos (como agregar_prueba.php)
if (!class_exists('Usuario')) {
    class Usuario {
        private $correo;
        private $edad;
        private $region;
        public function __construct($correo, $edad, $region) {
            $this->correo = $correo;
            $this->edad = $edad;
            $this->region = $region;
        }
        public function get_correo() { return $this->correo; }
        public function get_edad() { return $this->edad; }
        public function get_region() { return $this->region; }
    }
}

if (!class_exists('Pregunta')) { // Asegurarse que la clase Pregunta está definida
    class Pregunta {
        private $enunciado;
        private $alternativas;
        public function __construct($enunciado, $alternativas) {
            $this->enunciado = $enunciado;
            $this->alternativas = $alternativas;
        }
        public function get_enunciado() { return $this->enunciado; }
        // Podríamos necesitar un método para obtener una alternativa específica si el ID es solo un índice
    }
}


if (!class_exists('Respuesta')) {
    class Respuesta {
        private $usuario;
        private $pregunta; // Debería ser un objeto Pregunta
        private $alternativa_seleccionada; // Podría ser el índice o el texto de la alternativa

        // Se asume que $pregunta es un objeto Pregunta y $alternativa_seleccionada es un índice o valor.
        public function __construct(Usuario $usuario, Pregunta $pregunta, $alternativa_seleccionada) {
            $this->usuario = $usuario;
            $this->pregunta = $pregunta;
            $this->alternativa_seleccionada = $alternativa_seleccionada;
        }
        public function get_usuario() { return $this->usuario; }
        public function get_pregunta() { return $this->pregunta; }
        public function get_alternativa_seleccionada() { return $this->alternativa_seleccionada; }
    }
}

echo "<h1>Script de Prueba para Guardar Respuesta</h1>";

// Crear instancia de la base de datos (simulada)
$db = new DB();

// Simular datos que vendrían de un formulario POST o similar
$correo_usuario_prueba = "usuario_prueba_" . rand(1000, 9999) . "@example.com";
$edad_usuario_prueba = rand(18, 65);
$region_usuario_prueba = "Latinoamérica"; // Ejemplo

$nombre_encuesta_objetivo = "Encuesta de Satisfacción PHP"; // Nombre de una encuesta que se espera exista
$enunciado_pregunta_objetivo = "¿Qué tan satisfecho estás con nuestro servicio PHP?"; // Enunciado de una pregunta
$alternativa_seleccionada_prueba = 1; // Índice de la alternativa seleccionada (0-indexed)

// Crear un objeto Usuario de prueba
$usuario_prueba = new Usuario($correo_usuario_prueba, $edad_usuario_prueba, $region_usuario_prueba);
echo "<p>Usuario de prueba creado: " . htmlspecialchars($usuario_prueba->get_correo()) . "</p>";

// Simular la obtención de la encuesta y la pregunta específica
// En una aplicación real, obtendríamos la encuesta y su pregunta desde la BD
// Aquí, para la simulación, creamos un objeto Pregunta dummy.
$pregunta_simulada = new Pregunta($enunciado_pregunta_objetivo, ["Muy satisfecho", "Satisfecho", "Neutral", "Insatisfecho", "Muy insatisfecho"]);


// Crear un objeto Respuesta de prueba
$respuesta_prueba = new Respuesta($usuario_prueba, $pregunta_simulada, $alternativa_seleccionada_prueba);
echo "<p>Respuesta de prueba creada para la pregunta: '" . htmlspecialchars($respuesta_prueba->get_pregunta()->get_enunciado()) . "' con la alternativa índice: " . $respuesta_prueba->get_alternativa_seleccionada() . "</p>";

// Guardar la respuesta utilizando la clase DB (simulada)
if ($db->guardar_respuesta($respuesta_prueba)) {
    echo "<p style='color: green;'>Respuesta guardada exitosamente para el usuario " . htmlspecialchars($usuario_prueba->get_correo()) . " (simulado).</p>";
} else {
    echo "<p style='color: red;'>Error al guardar la respuesta (simulado).</p>";
}

echo "<p>Fin del script de prueba.</p>";

?>
