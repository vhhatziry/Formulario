<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Encuesta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Bienvenido al Proyecto de Encuestas</h1>
        <p>Esta es la página principal de la aplicación de encuestas. Desde aquí puedes navegar a las diferentes secciones.</p>

        <h2>Opciones Disponibles:</h2>
        <ul>
            <li><a href="crear_encuesta.php">Crear Nueva Encuesta</a> (Funcionalidad PHP no implementada en este ejemplo)</li>
            <li><a href="responder_encuesta.php">Responder Encuesta</a> (Funcionalidad PHP no implementada en este ejemplo)</li>
            <li><a href="ver_resultados.php">Ver Resultados de Encuestas</a> (Funcionalidad PHP no implementada en este ejemplo)</li>
        </ul>

        <h2>Scripts de Prueba (Simulación):</h2>
        <p>Estos scripts simulan interacciones con una base de datos y la lógica de la aplicación, pero no implementan la interfaz de usuario completa ni la lógica de negocio avanzada.</p>
        <ul>
            <li>
                <p><strong>Agregar Encuesta de Prueba:</strong></p>
                <p>Este script simula la creación y guardado de una encuesta de ejemplo en la base de datos.</p>
                <form action="agregar_prueba.php" method="get" target="_blank">
                    <button type="submit">Ejecutar agregar_prueba.php</button>
                </form>
            </li>
            <li>
                <p><strong>Guardar Respuesta de Prueba:</strong></p>
                <p>Este script simula el guardado de una respuesta de un usuario a una pregunta específica.</p>
                <form action="guardar_prueba.php" method="get" target="_blank">
                    <button type="submit">Ejecutar guardar_prueba.php</button>
                </form>
            </li>
        </ul>

        <h2>Archivos del Proyecto:</h2>
        <p>A continuación se listan algunos de los archivos clave del proyecto (esta lista es solo informativa):</p>
        <ul>
            <li><code>index.php</code>: Esta página.</li>
            <li><code>style.css</code>: Hoja de estilos CSS.</li>
            <li><code>db.php</code>: Clase para simular la interacción con la base de datos.</li>
            <li><code>agregar_prueba.php</code>: Script para probar la adición de encuestas.</li>
            <li><code>guardar_prueba.php</code>: Script para probar el guardado de respuestas.</li>
            <li><code>entidades.py</code>: (Python) Clases de entidades del sistema (Usuario, Pregunta, Encuesta, etc.).</li>
            <li><code>main.py</code>: (Python) Lógica principal de la aplicación en Python.</li>
            <li><code>excepciones.py</code>: (Python) Excepciones personalizadas.</li>
        </ul>

        <footer>
            <p>Proyecto Encuesta &copy; <?php echo date("Y"); ?> - Versión de demostración</p>
        </footer>
    </div>
</body>
</html>
