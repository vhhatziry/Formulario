<?php
// public/form.php

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Procesa el POST y guarda
  $entry = [];
  foreach ($funcs as $code => $_) {
    $entry[$code] = [
      'completo' => $_POST['completo'][$code] ?? '',
      'tiempo'   => $_POST['tiempo'][$code]   ?? 0,
      'errores'  => $_POST['errores'][$code]  ?? '',
      'notas'    => $_POST['notas'][$code]    ?? '',
    ];
  }
  $file = __DIR__ . '/../data/submissions.json';
  $all  = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
  $all[] = $entry;
  file_put_contents($file, json_encode($all, JSON_PRETTY_PRINT, JSON_UNESCAPED_UNICODE));

  header('Location: index.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Formulario de Prueba</title>

  <!-- Tailwind CSS -->
  <link rel="stylesheet" href="/assets/css/tailwind.css">
</head>
<body class="bg-gray-50 p-6">
  <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Formulario de Prueba de Funciones</h1>
    <form method="post" id="testForm" class="space-y-4">
      <table class="w-full table-auto border-collapse">
        <thead>
          <tr class="bg-blue-200">
            <th class="p-2 border">Función evaluada</th>
            <th class="p-2 border">¿Se completó con éxito?</th>
            <th class="p-2 border">Tiempo (min)</th>
            <th class="p-2 border">Errores cometidos</th>
            <th class="p-2 border">Notas adicionales</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($funcs as $code => $lbl): ?>
          <tr>
            <td class="p-2 border"><?= $lbl ?> (<?= $code ?>)</td>
            <td class="p-2 border text-center">
              <select name="completo[<?= $code ?>]"
                      data-func="<?= $code ?>"
                      class="border rounded px-2 py-1">
                <option value="">--</option>
                <option value="si">Sí</option>
                <option value="no">No</option>
              </select>
            </td>
            <td class="p-2 border">
              <input type="number" step="0.1"
                     name="tiempo[<?= $code ?>]"
                     data-row="<?= $code ?>"
                     disabled
                     class="w-full border rounded px-2 py-1">
            </td>
            <td class="p-2 border">
              <input type="text"
                     name="errores[<?= $code ?>]"
                     data-row="<?= $code ?>"
                     disabled
                     class="w-full border rounded px-2 py-1">
            </td>
            <td class="p-2 border">
              <textarea name="notas[<?= $code ?>]"
                        rows="1"
                        data-row="<?= $code ?>"
                        disabled
                        class="w-full border rounded px-2 py-1"></textarea>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div class="text-right">
        <button type="submit"
                class="mt-4 bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
          Guardar Registro
        </button>
      </div>
    </form>
  </div>

  <!-- Tu JS común (habilita campos) -->
  <script src="/assets/js/main.js"></script>
</body>
</html>
