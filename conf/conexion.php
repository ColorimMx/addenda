<?php
function conectarSQL() {
    $serverName = "srv-edger550-09";
    $connectionOptions = [
        "Database" => "ADDENDAS_COLORIM_App",
        "Uid" => "sa",
        "PWD" => 'S$colorim%2022',
        "Encrypt" => "yes",
        "TrustServerCertificate" => "yes",
        "CharacterSet" => "UTF-8"
    ];

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if (!$conn) {
        die(print_r(sqlsrv_errors(), true));
    }

    return $conn;
}
?>