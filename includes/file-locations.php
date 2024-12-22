<?php
$hosted = ($_SERVER['HTTP_HOST'] !== 'localhost' && $_SERVER['HTTP_HOST'] !== '127.0.0.1');
$SMARTWAGE_LOCATION = "";

if($hosted){
    $SMARTWAGE_LOCATION .= "/smartWage";
}else{
    $SMARTWAGE_LOCATION .= "/case-study";
}




?>
<script>
const SMARTWAGE_LOCATION = "<?php echo $SMARTWAGE_LOCATION; ?>";
</script>