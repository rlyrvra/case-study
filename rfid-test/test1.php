<?php

if (isset($_POST['rfid'])) {
    echo $_POST['rfid']; // ang pinagkaiba nito ay ibang user si nodeMCU at ibang user din tayo
    //so heto sa user (nodeMCU) lang ito lalabas which is 'di naman natin makikita kasi hardware yon
    // ah pag dinisplay di talaga makikita?
    // oo, unless may $_POST data na ilagay
    // gets, di madidisplay sa buong file nato, i mean pag nag echo ka sa file nato di talga madidisplay noh? kung saang file nagbigay ng data
    // magdidispaly siya kaso sa (client) ni nodeMCU lang mismo, sa iba wala talaga since walang $_POST nama
    // User 1: nodeMCU (client), User 2: tayo oo basta pagididisplay yung rfid sa nodemcu lang gets kona yun
}
