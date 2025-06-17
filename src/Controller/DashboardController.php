<?php
namespace App\Controller;

use App\Config;
use App\Storage;

class DashboardController
{
    /**
     * Calcula todas las métricas necesarias para el dashboard.
     *
     * @return array{
     *   overallRate:int,
     *   avgTime:float,
     *   cntErrors:int,
     *   labels:string[],
     *   dataRate:int[],
     *   dataAvgTime:float[]
     * }
     */
    public function getMetrics(): array
    {
        $subs = Storage::readAll();
        $funcs = Config::FUNCS;

        $totalFields = count($funcs) * count($subs);
        $sumSuccess = 0;
        $sumTime    = 0.0;
        $cntErrors  = 0;
        $byFuncSucc = array_fill_keys(array_keys($funcs), 0);
        $byFuncTime = array_fill_keys(array_keys($funcs), 0.0);

        foreach ($subs as $entry) {
            foreach ($funcs as $code => $_lbl) {
                $row = $entry[$code] ?? ['completo'=>'','tiempo'=>0,'errores'=>'','notas'=>''];
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

        $subsCount   = max(count($subs), 1);
        $overallRate = $totalFields
            ? (int) round($sumSuccess / $totalFields * 100)
            : 0;
        $avgTime     = $totalFields
            ? round($sumTime / $totalFields, 1)
            : 0.0;

        // Datos para Chart.js
        $labels      = array_values($funcs);
        $dataRate    = array_map(fn($c) => (int) round($c / $subsCount * 100), $byFuncSucc);
        $dataAvgTime = array_map(fn($t) => round($t / $subsCount, 1), $byFuncTime);

        return [
            'overallRate' => $overallRate,
            'avgTime'     => $avgTime,
            'cntErrors'   => $cntErrors,
            'labels'      => $labels,
            'dataRate'    => $dataRate,
            'dataAvgTime' => $dataAvgTime,
        ];
    }
}
