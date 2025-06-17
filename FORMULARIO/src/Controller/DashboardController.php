<?php

namespace App\Controller;

use App\Storage;
use App\Config;

class DashboardController {
    private Storage $storage;

    public function __construct() {
        $this->storage = new Storage(Config::DATA_FILE);
    }

    public function getMetrics(): array {
        $submissions = $this->storage->readAll();
        $totalSubmissions = count($submissions);

        $overallSuccessCount = 0;
        $overallTimeSum = 0;
        $overallCompletedCount = 0; // Count of CUs marked as 'si' for averaging time
        $totalErrors = 0;

        $labels = [];
        $dataRate = [];
        $dataAvgTime = [];

        $cuStats = []; // To hold stats for each CU

        // Initialize stats for each CU from Config::FUNCS
        foreach (Config::FUNCS as $cuCode => $cuLabel) {
            $cuStats[$cuCode] = [
                'label' => $cuLabel,
                'successCount' => 0,
                'totalAttempts' => 0, // Submissions that included this CU
                'timeSum' => 0,
                'completedCount' => 0, // How many times this CU was marked 'si'
                'errorCount' => 0,
            ];
            $labels[] = $cuLabel; // For Chart.js labels
        }

        if ($totalSubmissions === 0) {
            // Prepare empty data for Chart.js if no submissions
            foreach (Config::FUNCS as $cuLabel) {
                $dataRate[] = 0;
                $dataAvgTime[] = 0;
            }
            return [
                'overallRate' => 0,
                'avgTime' => 0,
                'cntErrors' => 0,
                'labels' => $labels,
                'dataRate' => $dataRate,
                'dataAvgTime' => $dataAvgTime,
                'totalSubmissions' => 0,
                'cuStats' => $cuStats // Return initialized stats
            ];
        }

        foreach ($submissions as $submission) {
            if (isset($submission['functional_units']) && is_array($submission['functional_units'])) {
                foreach ($submission['functional_units'] as $cuCode => $details) {
                    if (!isset($cuStats[$cuCode])) continue; // Skip if CU code from data isn't in Config

                    $cuStats[$cuCode]['totalAttempts']++; // This CU was part of a submission

                    if (isset($details['completo']) && $details['completo'] === 'si') {
                        $cuStats[$cuCode]['successCount']++;
                        $overallSuccessCount++;

                        if (isset($details['tiempo']) && is_numeric($details['tiempo'])) {
                            $cuStats[$cuCode]['timeSum'] += (int)$details['tiempo'];
                            $overallTimeSum += (int)$details['tiempo'];
                            $cuStats[$cuCode]['completedCount']++;
                            $overallCompletedCount++;
                        }
                        if (isset($details['errores']) && is_numeric($details['errores'])) {
                            $cuErrorCount = (int)$details['errores'];
                            $cuStats[$cuCode]['errorCount'] += $cuErrorCount;
                            $totalErrors += $cuErrorCount;
                        }
                    }
                }
            }
        }

        $overallRate = ($overallCompletedCount > 0) ? ($overallSuccessCount / $overallCompletedCount) * 100 : 0;
        // Calculate overall average time based on CUs marked 'si' and having time
        $avgTime = ($overallCompletedCount > 0) ? $overallTimeSum / $overallCompletedCount : 0;


        foreach (Config::FUNCS as $cuCode => $cuLabel) {
            $stat = $cuStats[$cuCode];
            // Success rate for a CU is based on how many times it was marked 'si' successfully
            // out of the times it was attempted (i.e., part of a submission and marked 'si')
            $dataRate[] = ($stat['completedCount'] > 0) ? ($stat['successCount'] / $stat['completedCount']) * 100 : 0;
            $dataAvgTime[] = ($stat['completedCount'] > 0) ? $stat['timeSum'] / $stat['completedCount'] : 0;
        }

        return [
            'overallRate' => round($overallRate, 2),
            'avgTime' => round($avgTime, 2),
            'cntErrors' => $totalErrors,
            'labels' => $labels,
            'dataRate' => $dataRate,
            'dataAvgTime' => $dataAvgTime,
            'totalSubmissions' => $totalSubmissions,
            'cuStats' => $cuStats // Return detailed stats
        ];
    }
}
