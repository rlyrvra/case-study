<?php
$hosted = false;
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