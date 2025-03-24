<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../Setting.php'                    ;
require_once __DIR__ . '/../SettingService.php'             ;

require_once __DIR__ . '/../../includes/Helper.php'         ;
require_once __DIR__ . '/../../database/database.php'       ;


try {
    $settingDao     = new SettingDao($pdo)                  ;
    $settingRepo    = new SettingRepository($settingDao)    ;
    $settingService = new SettingService($settingRepo)      ;

    $action = $_POST['action'] ?? '';
    if ($action === 'fetchAll') {
        $result = $settingService->fetchAllSettings();
        $settings;
        if ($result !== ActionResult::FAILURE) {
            $settings = $result['result_set'];
        }
        include __DIR__ . '/company-settings-table.php';
        return;
    }

    if ($action === 'update'){

        $settings = $_POST['settings'] ?? null;
        if(!$settings){
            return;
        }
        
        $result = $settingService->updateSetting($settings);
        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showUpdateSuccess();
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'error') {
            die("
            <script>
                showError(" . json_encode($result) . ");
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'invalid_input'){
            die("
            <script>
                showValidationError(" . json_encode($result['errors']) . ");
            </script>
            ");
        }
        return;
    }


    $message = "Invalid action specified.";
    die('
    <script>
        showFatalError(' . json_encode($message) 
    . ');
    </script>');
} catch (Exception $e) {
    $message = "Fatal error: " . $e->getMessage();
    die('
    <script>
        showFatalError(' . json_encode($message) 
    . ');
    </script>');
}