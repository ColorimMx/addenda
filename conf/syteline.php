<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
include '../conf/functions.php';
verificar_sesion();

$idfac = $_POST["inputFactura"];

class SytelineCon {
    private $pdo;

    public function __construct() {
        try {
            $this->pdo = new PDO(
                "sqlsrv:Server=srv-edger550-09;Database=SLCOLORIM_Productivo_App;Encrypt=yes;TrustServerCertificate=yes",
                "addenda",
                "A.colorim%24"
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            echo "Error de conexión: " . $ex->getMessage();
            exit;
        }
    }

    public function getInvoiceData($invNum) {
        $sql = "SELECT inv_num, SUBSTRING(inv_num,2,11) AS folio, inv_seq, cust_num, name, cust_seq, co_num, order_date, cust_po, inv_date, terms_code, 
                       co_line, item, description, qty_invoiced, u_m, addenda, reference_id, reference_id_type, 
                       gln_buyer, gln_seller, alt_party_id, alt_party_id_type, gln_ship_to
                FROM JPAS_addenda_garces_view
                WHERE inv_num = :inv_num";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':inv_num', $invNum, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$db = new SytelineCon();
$facturaData = $db->getInvoiceData($idfac);

?>