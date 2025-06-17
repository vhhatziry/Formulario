<?php
// public/index.php

// 1. Lectura de datos
$dataFile = __DIR__ . '/../data/submissions.json';
$subs = file_exists($dataFile)
    ? json_decode(file_get_contents($dataFile), true)
    : [];

// 2. Definición de funciones
$funcs = [
  'CU01.1'   => 'Registrar cuenta',
  'CU01.2'   => 'Verificar cuenta',
  'CU03.2'   => 'Crear hábito',
  'CU03.3'   => 'Editar hábito',
  'CU06.1'   => 'Registrar emoción',
  'CU05.4.1' => 'Configurar notificación de hábito',
  'CU05.3'   => 'Conectar reloj inteligente',
  'CU07'     => 'Cerrar sesión'
];

// 3. Cálculo de métricas
$totalFields  = count($funcs) * count($subs);
$sumSuccess   = 0;
$sumTime      = 0.0;
$cntErrors    = 0;
$byFuncSucc   = array_fill_keys(array_keys($funcs), 0);
$byFuncTime   = array_fill_keys(array_keys($funcs), 0.0);

foreach ($subs as $entry) {
  foreach ($funcs as $code => $_) {
    $row = $entry[$code] ?? ['completo'=>'', 'tiempo'=>0, 'errores'=>''];
    if ($row['completo'] === 'si') {
      $sumSuccess++;
      $byFuncSucc[$code]++;
    }
    if (is_numeric($row['tiempo'])) {
      $sumTime += $row['tiempo'];
      $byFuncTime[$code] += $row['tiempo'];
    }
    if (trim($row['errores']) !== '') {
      $cntErrors++;
    }
  }
}

$overallRate = $totalFields ? round($sumSuccess / $totalFields * 100) : 0;
$avgTime     = $totalFields ? round($sumTime / $totalFields, 1)      : 0;
$subsCount   = max(count($subs), 1);

// 4. Datos para Chart.js
$labels      = array_values($funcs);
$dataRate    = array_map(fn($c)=> round($c / $subsCount * 100), $byFuncSucc);
$dataAvgTime = array_map(fn($t)=> round($t / $subsCount, 1), $byFuncTime);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard de Formularios</title>

  <!-- Tailwind CSS -->
  <link rel="stylesheet" href="/assets/css/tailwind.css">

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-4xl mx-auto space-y-8">
    <header class="text-center">
      <h1 class="text-3xl font-bold">Reporte de Pruebas de Usabilidad</h1>
      <p class="text-gray-600">Análisis interactivo de las funciones evaluadas en la aplicación.</p>
    </header>

    <!-- Resumen rápido -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="bg-white p-4 rounded shadow text-center">
        <p class="text-sm text-gray-500">Tasa de Éxito General</p>
        <p class="text-2xl font-semibold"><?= $overallRate ?>%</p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <p class="text-sm text-gray-500">Tiempo Promedio Total</p>
        <p class="text-2xl font-semibold"><?= $avgTime ?> min</p>
      </div>
      <div class="bg-white p-4 rounded shadow text-center">
        <p class="text-sm text-gray-500">Total de Errores Registrados</p>
        <p class="text-2xl font-semibold"><?= $cntErrors ?></p>
      </div>
    </div>

    <!-- Gráficas -->
    <section class="bg-white p-6 rounded shadow">
      <h2 class="text-xl mb-4">Análisis Visual del Rendimiento</h2>
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <canvas id="chartSuccess"></canvas>
        <canvas id="chartTime"></canvas>
      </div>
    </section>

    <!-- Botón de nuevo registro -->
    <div class="text-center">
      <a href="form.php"
         class="inline-block bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700 transition">
        Agregar registro
      </a>
    </div>
  </div>

  <!-- Pasa datos a JS -->
  <script>
    window.labels      = <?= json_encode($labels) ?>;
    window.dataSuccess = <?= json_encode($dataRate) ?>;
    window.dataTime    = <?= json_encode($dataAvgTime) ?>;
  </script>

  <!-- Tu JS común -->
  <script src="/assets/js/main.js"></script>
</body>
</html>
