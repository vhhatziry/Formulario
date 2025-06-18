from datetime import datetime

from entidades import Usuario, Pregunta, Encuesta, ListadoRespuestas
from excepciones import EdadInvalidaError, RegionInvalidaError, AlternativaInvalidaError, UsuarioNoEncontradoError

# Constantes
EDAD_MINIMA = 18
EDAD_MAXIMA = 120
REGIONES_VALIDAS = ["Latinoamérica", "Norteamérica", "Europa", "Asia", "África", "Oceanía"]

# Lista de encuestas (simulando una base de datos)
encuestas_disponibles = []

def crear_encuesta(nombre: str, preguntas_data: list[dict]) -> Encuesta:
    """Crea una nueva encuesta."""
    preguntas = []
    for p_data in preguntas_data:
        pregunta = Pregunta(p_data["enunciado"], p_data["alternativas"])
        preguntas.append(pregunta)

    encuesta = Encuesta(nombre, preguntas)
    encuestas_disponibles.append(encuesta)
    return encuesta

def registrar_usuario(correo: str, edad: int, region: str) -> Usuario:
    """Registra un nuevo usuario."""
    if not (EDAD_MINIMA <= edad <= EDAD_MAXIMA):
        raise EdadInvalidaError(f"La edad debe estar entre {EDAD_MINIMA} y {EDAD_MAXIMA} años.")
    if region not in REGIONES_VALIDAS:
        raise RegionInvalidaError(f"Región inválida. Las regiones válidas son: {', '.join(REGIONES_VALIDAS)}")

    return Usuario(correo, edad, region)

def responder_encuesta(encuesta: Encuesta, usuario: Usuario, respuestas: list[int]):
    """Registra las respuestas de un usuario a una encuesta."""
    if len(respuestas) != len(encuesta.preguntas):
        raise ValueError("El número de respuestas no coincide con el número de preguntas.")

    for i, respuesta_idx in enumerate(respuestas):
        pregunta = encuesta.preguntas[i]
        if not (0 <= respuesta_idx < len(pregunta.alternativas)):
            raise AlternativaInvalidaError(f"Alternativa inválida para la pregunta: {pregunta.enunciado}")

        # Aquí se podría guardar la respuesta en una base de datos
        # Por simplicidad, solo la agregamos a la encuesta
        # respuesta_obj = Respuesta(usuario, pregunta, respuesta_idx) # Descomentar si se usa la clase Respuesta
        # encuesta.agregar_respuesta(respuesta_obj) # Descomentar si se usa la clase Respuesta
        pass # Implementación pendiente para guardar respuestas

def obtener_listados_respuestas(encuesta: Encuesta, usuario_buscado: Usuario = None) -> list[ListadoRespuestas]:
    """Obtiene los listados de respuestas para una encuesta, opcionalmente filtrados por usuario."""
    # Implementación pendiente para recuperar y filtrar respuestas
    # Esta función debería devolver una lista de objetos ListadoRespuestas
    return []

# Ejemplo de uso (esto podría ir en un script separado o una interfaz de usuario)
if __name__ == "__main__":
    # 1. Crear una encuesta de prueba
    preguntas_ejemplo = [
        {"enunciado": "¿Cuál es tu lenguaje de programación favorito?", "alternativas": ["Python", "JavaScript", "Java", "C#"]},
        {"enunciado": "¿Qué tipo de proyectos te interesan más?", "alternativas": ["Desarrollo web", "Ciencia de datos", "Aplicaciones móviles", "Videojuegos"]}
    ]
    encuesta_tecnologia = crear_encuesta("Encuesta de Tecnología", preguntas_ejemplo)

    # 2. Registrar un usuario de prueba
    try:
        usuario_prueba = registrar_usuario("usuario@example.com", 25, "Latinoamérica")
    except (EdadInvalidaError, RegionInvalidaError) as e:
        print(f"Error al registrar usuario: {e}")
        exit()

    # 3. Simular respuestas del usuario (aquí se necesitaría una interfaz para obtenerlas)
    respuestas_usuario = [0, 1] # Python, Ciencia de datos

    # 4. Registrar las respuestas
    try:
        responder_encuesta(encuesta_tecnologia, usuario_prueba, respuestas_usuario)
        print("Encuesta respondida exitosamente.")
    except (ValueError, AlternativaInvalidaError) as e:
        print(f"Error al responder encuesta: {e}")

    # 5. Obtener y mostrar listados de respuestas (funcionalidad pendiente)
    # listados = obtener_listados_respuestas(encuesta_tecnologia)
    # for listado in listados:
    #     print(f"Pregunta: {listado.pregunta.enunciado}")
    #     # Aquí se mostrarían las respuestas y conteos por alternativa

    # print(f"\nEncuesta disponible: {encuestas_disponibles[0].nombre}")

    # Ejemplo de cómo se podrían usar las excepciones personalizadas
    try:
        usuario_invalido = registrar_usuario("test@test.com", 10, "Antártida") # Edad y región inválidas
    except EdadInvalidaError as e:
        print(f"Error de edad: {e}")
    except RegionInvalidaError as e:
        print(f"Error de región: {e}")

    try:
        # Suponiendo que la encuesta tiene 2 preguntas y cada una 4 alternativas
        responder_encuesta(encuesta_tecnologia, usuario_prueba, [0, 5]) # Alternativa 5 es inválida
    except AlternativaInvalidaError as e:
        print(f"Error de alternativa: {e}")

    # Simulación de búsqueda de usuario (funcionalidad pendiente en obtener_listados_respuestas)
    # try:
    #     listados_usuario = obtener_listados_respuestas(encuesta_tecnologia, Usuario("noexiste@example.com", 30, "Europa"))
    # except UsuarioNoEncontradoError as e: # Esta excepción no se lanza actualmente
    #     print(f"Error de usuario: {e}")
