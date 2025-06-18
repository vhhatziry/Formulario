<?php

// Definición de constantes para la conexión a la base de datos
define('DB_HOST', 'localhost'); // o 127.0.0.1
define('DB_USER', 'encuesta_user');
define('DB_PASS', 'encuesta_pass');
define('DB_NAME', 'encuesta_app'); // Nombre de la base de datos creada por setup_database.php

class DB {
    private $conn;

    public function __construct() {
        // Intentar conectar a la base de datos real
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($this->conn->connect_error) {
            // No imprimir directamente el error en producción, registrarlo o manejarlo de forma más segura.
            // Para este ejemplo, se muestra un mensaje genérico y se termina.
            error_log("Error de conexión a la BD: " . $this->conn->connect_error);
            die("Error al conectar con la base de datos. Por favor, inténtelo más tarde.");
            // En un entorno de desarrollo/prueba, podría ser útil:
            // echo "Error de conexión: " . $this->conn->connect_error . "\n";
            // $this->conn = null; // Asegurarse de que conn es null si falla
        } else {
            // echo "Conexión a la base de datos '" . DB_NAME . "' establecida.\n";
            $this->conn->set_charset("utf8mb4");
        }
    }

    // Método para obtener la conexión si es necesario fuera de la clase (aunque se prefiere encapsular)
    public function get_connection() {
        return $this->conn;
    }

    // Los métodos guardar_encuesta, obtener_encuesta, guardar_respuesta
    // necesitarían ser adaptados para usar $this->conn para interactuar con la BD real.
    // Por ahora, se dejan como simulación o se comentan si no se van a implementar aún.

    public function guardar_encuesta(Encuesta $encuesta) {
        if (!$this->conn || $this->conn->connect_error) {
             error_log("Error de BD: No hay conexión para guardar encuesta.");
             return false;
        }
        // Simulación de guardado de encuesta (a adaptar con SQL real)
        echo "Simulación: Guardando encuesta '" . $encuesta->get_nombre() . "' en la BD.\n";
        // Ejemplo de SQL (necesitaría la estructura de tabla 'encuestas'):
        // $stmt = $this->conn->prepare("INSERT INTO encuestas (nombre) VALUES (?)");
        // $nombre = $encuesta->get_nombre();
        // $stmt->bind_param("s", $nombre);
        // $success = $stmt->execute();
        // $stmt->close();
        // return $success;
        return true; // Mantener simulación por ahora
    }

    public function obtener_encuesta(string $nombre_encuesta): ?Encuesta {
        if (!$this->conn || $this->conn->connect_error) {
             error_log("Error de BD: No hay conexión para obtener encuesta.");
             return null;
        }
        // Simulación de obtención de encuesta (a adaptar con SQL real)
        echo "Simulación: Obteniendo encuesta '" . $nombre_encuesta . "' de la BD.\n";
        // Ejemplo de SQL (necesitaría la estructura de tabla 'encuestas' y 'preguntas'):
        // $stmt = $this->conn->prepare("SELECT id, nombre FROM encuestas WHERE nombre = ?");
        // $stmt->bind_param("s", $nombre_encuesta);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // if ($row = $result->fetch_assoc()) {
        //     $encuesta = new Encuesta($row['nombre']);
        //     // Aquí se cargarían también las preguntas asociadas a la encuesta
        //     return $encuesta;
        // }
        // $stmt->close();
        return null; // Mantener simulación por ahora
    }

    public function guardar_respuesta(Respuesta $respuesta) {
         if (!$this->conn || $this->conn->connect_error) {
             error_log("Error de BD: No hay conexión para guardar respuesta.");
             return false;
        }
        // Simulación de guardado de respuesta (a adaptar con SQL real)
        echo "Simulación: Guardando respuesta del usuario '" . $respuesta->get_usuario()->get_correo() . "' en la BD.\n";
        // Ejemplo de SQL (necesitaría la estructura de tabla 'respuestas', 'usuarios', 'preguntas'):
        // $stmt = $this->conn->prepare("INSERT INTO respuestas (id_usuario, id_pregunta, alternativa_seleccionada) VALUES (?, ?, ?)");
        // $id_usuario = $this->obtener_o_crear_id_usuario($respuesta->get_usuario()); // Método auxiliar
        // $id_pregunta = $this->obtener_id_pregunta($respuesta->get_pregunta()); // Método auxiliar
        // $alternativa = $respuesta->get_alternativa_seleccionada();
        // $stmt->bind_param("iii", $id_usuario, $id_pregunta, $alternativa);
        // $success = $stmt->execute();
        // $stmt->close();
        // return $success;
        return true; // Mantener simulación por ahora
    }

    public function __destruct() {
        if ($this->conn && !$this->conn->connect_error) {
            // echo "Cerrando conexión a la base de datos '" . DB_NAME . "'.\n";
            $this->conn->close();
        }
    }
}

// Clases dummy para que el archivo PHP sea autocontenido y no dé errores de "clase no encontrada"
// Estas clases deberían estar definidas en otros archivos si esto fuera un proyecto PHP real.
// Se mantienen aquí por compatibilidad con los scripts de prueba existentes (agregar_prueba.php, guardar_prueba.php)
// que dependen de que estas clases estén disponibles después de incluir db.php.

if (!class_exists('Encuesta')) {
    class Encuesta {
        private $nombre;
        private $preguntas = []; // Añadido para compatibilidad con agregar_prueba.php
        public function __construct($nombre) { $this->nombre = $nombre; }
        public function get_nombre() { return $this->nombre; }
        public function agregar_pregunta(Pregunta $pregunta) { $this->preguntas[] = $pregunta; } // Añadido
        public function get_preguntas() { return $this->preguntas; } // Añadido
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
        public function get_alternativas() { return $this->alternativas; } // Añadido
    }
}

if (!class_exists('Usuario')) {
    class Usuario {
        private $correo;
        // Añadidos edad y region para compatibilidad con guardar_prueba.php
        private $edad;
        private $region;
        public function __construct($correo, $edad = 0, $region = '') { // Valores por defecto si no se usan
            $this->correo = $correo;
            $this->edad = $edad;
            $this->region = $region;
        }
        public function get_correo() { return $this->correo; }
        public function get_edad() { return $this->edad; }
        public function get_region() { return $this->region; }
    }
}

if (!class_exists('Respuesta')) {
    class Respuesta {
        private $usuario;
        private $pregunta;
        private $alternativa_seleccionada;

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

?>
