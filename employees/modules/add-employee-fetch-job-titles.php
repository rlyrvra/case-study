<?php
require_once __DIR__ . '/../../job-titles/JobTitleDao.php';
require_once __DIR__ . '/../../job-titles/JobTitle.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

function getJobTitles(){
    global $pdo;
    $jobTitleDao = new JobTitleDao($pdo);
    $selectedColumns = ["id", "title", "description"];
    $filterCriteria = [
        [
            "column"   => "job_title.status", 
            "operator" => "=", 
            "value"    => "Active"
        ]
    ];
    $data = $jobTitleDao->fetchAll($selectedColumns, $filterCriteria, []);
    $jobTitles = $data['result_set'];
    return $jobTitles;
}

?>

<script>
var jobTitles = getJobTitlesValues();

function clearJobTitleSelect(select){
    select.innerHTML = '';
}

function getJobTitlesValues(){
    const values = <?php 
        $jobTitles = getJobTitles();
        echo json_encode($jobTitles); 
        ?>;
    return values;
}

function populateJobTitleSelect(select){
    clearJobTitleSelect(select);
    const optionNone = document.createElement("option");
    optionNone.value = "";
    optionNone.text = "Select a job title";
    optionNone.disabled = true;
    optionNone.selected = true;
    select.add(optionNone);
    jobTitles.forEach(jobTitle => {
        const option = document.createElement("option");
        option.value = jobTitle.id;
        option.text = jobTitle.title;
        select.add(option);
    });
}

function selectJobTitle(id, select){
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === id) {
            select.selectedIndex = i;
            break;
        }
    }
}
</script>