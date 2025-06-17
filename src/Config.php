<?php
namespace App;

class Config
{
    // Ruta al JSON donde guardamos los envíos
    public const DATA_FILE = __DIR__ . '/../data/submissions.json';

    // Lista de funciones evaluadas (código => etiqueta)
    public const FUNCS = [
        'CU01.1'   => 'Registrar cuenta',
        'CU01.2'   => 'Verificar cuenta',
        'CU03.2'   => 'Crear hábito',
        'CU03.3'   => 'Editar hábito',
        'CU06.1'   => 'Registrar emoción',
        'CU05.4.1' => 'Configurar notificación de hábito',
        'CU05.3'   => 'Conectar reloj inteligente',
        'CU07'     => 'Cerrar sesión',
    ];
}
