class Usuario:
    def __init__(self, correo: str, edad: int, region: str):
        self.correo = correo
        self.edad = edad
        self.region = region

class Pregunta:
    def __init__(self, enunciado: str, alternativas: list):
        self.enunciado = enunciado
        self.alternativas = alternativas

class Respuesta:
    def __init__(self, usuario: Usuario, pregunta: Pregunta, alternativa_seleccionada: int):
        self.usuario = usuario
        self.pregunta = pregunta
        self.alternativa_seleccionada = alternativa_seleccionada

class Encuesta:
    def __init__(self, nombre: str, preguntas: list[Pregunta]):
        self.nombre = nombre
        self.preguntas = preguntas
        self.respuestas = []

    def agregar_respuesta(self, respuesta: Respuesta):
        self.respuestas.append(respuesta)

class ListadoRespuestas:
    def __init__(self, pregunta: Pregunta, respuestas: list[Respuesta]):
        self.pregunta = pregunta
        self.respuestas = respuestas
