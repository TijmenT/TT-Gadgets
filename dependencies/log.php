<?php

session_start();
function logToFile()
{
    $logFile = ''.date('d-m-y').'.log';
    $logMessage = "[" . date('Y-m-d H:i:s') . "]"; 
    if(isset($_SESSION['id'])){
    $logMessage .= " | UserID: ". $_SESSION['id'] . " | ";
    }
    else
    {
        $logMessage .= " | ";
    }
    foreach ($_POST as $key => $value) {
        if($value !== null){
        if(str_contains($key, "pass")){
            $logMessage .= htmlspecialchars($key).": ******** | ";
        }
        else
        {
        $logMessage .= htmlspecialchars($key).": ".htmlspecialchars($value)." | ";
        }
        }
    }
    foreach ($_GET as $key => $value) {
        if($value !== null){
        $logMessage .= htmlspecialchars($key).": ".htmlspecialchars($value)." | ";
        }
    }
    $logMessage .= "\n";
    file_put_contents($logFile, $logMessage , FILE_APPEND); 
}

?>

