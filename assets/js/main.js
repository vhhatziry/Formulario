// assets/js/main.js
document.addEventListener('DOMContentLoaded', () => {
  // 1) Lógica del formulario: habilita/deshabilita campos según Sí/No
  document.querySelectorAll('select[name^="completo"]').forEach(sel => {
    sel.addEventListener('change', e => {
      const code    = e.target.dataset.func;
      const enabled = e.target.value !== '';
      document.querySelectorAll(`[data-row="${code}"]`)
        .forEach(inp => inp.disabled = !enabled);
    });
  });

  // 2) Inicialización de Chart.js en el dashboard (si existen las variables)
  if (window.labels && window.dataSuccess && window.dataTime) {
    // Gráfica de tasa de éxito
    new Chart(
      document.getElementById('chartSuccess'),
      {
        type: 'bar',
        data: {
          labels: window.labels,
          datasets: [{
            label: 'Tasa de Éxito (%)',
            data: window.dataSuccess,
            backgroundColor: 'rgba(34,197,94,0.6)'
          }]
        },
        options: {
          indexAxis: 'y',
          scales: { x: { beginAtZero: true, max: 100 } }
        }
      }
    );

    // Gráfica de tiempo promedio
    new Chart(
      document.getElementById('chartTime'),
      {
        type: 'bar',
        data: {
          labels: window.labels,
          datasets: [{
            label: 'Tiempo Promedio (min)',
            data: window.dataTime,
            backgroundColor: 'rgba(234,179,8,0.6)'
          }]
        },
        options: {
          indexAxis: 'y',
          scales: { x: { beginAtZero: true } }
        }
      }
    );
  }
});
