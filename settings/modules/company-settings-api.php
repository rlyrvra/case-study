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
        $token = $settings['token'] ?? null; if(!$token) return;
        $settingKey = strtolower(str_replace(' ', '_', $settings['setting_key'])) ?? null;
        $settingValue = $settings['setting_value'] ?? null;
        $groupName = strtolower(str_replace(' ', '_', $settings['group_name'])) ?? null;

        $updatedSetting = new Setting(
            id:           $token             ,
            settingKey:   $settingKey        ,
            settingValue: $settingValue      ,
            groupName:    $groupName          
        );
        $result = $settingService->updateSetting($updatedSetting);
        showUpdateResult($result);
        return;
    }


    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


function showUpdateResult($result){
    if(isset($result) && $result instanceof ActionResult){
        switch ($result) {
            case ActionResult::FAILURE:
                die("
                <script>
                    showError();
                </script>
                ");
                break;
            case ActionResult::SUCCESS:
                die("
                <script>
                    showUpdateSuccess();
                </script>
                ");
                break;
            default:
                die("
                <script>
                    showError();
                </script>
                ");
                break;
        }
    }else{
        die("An error occurred.");
    }
}