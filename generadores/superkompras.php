<?php
// 🔒 Opcional: puedes comentar si necesitas debug
//error_reporting(0); ini_set('display_errors', 0);

session_start(); // iniciar sesión para usar variables de sesión

require_once '../conf/functions.php';
require_once '../conf/conversor.php';
require_once '../conf/syteline.php';

verificar_sesion();

$idfac = $_POST["inputFactura"] ?? null;
$idrec = ($_POST["inputRecibo"]) ?? null;
$xml_src = $_FILES['xml']['tmp_name'] ?? null;

if (empty($idfac) || empty($idrec) || empty($xml_src)) {
    $_SESSION['mensaje_error'] = 'Ingrese los datos requeridos';
    header("Location: ../home.php");
    exit;
}


// Obtener datos de la factura
$db = new SytelineCon();
$datos = $db->getInvoiceData($idfac);

if (empty($datos)) {
    echo "<script>alert('Factura no encontrada'); window.location.href = '../home.php';</script>";
    exit;
}

$facturaData = $datos[0];

// Cargar el XML
$dom = new DOMDocument('1.0', 'UTF-8');
$dom->preserveWhiteSpace = false;
$dom->formatOutput = true;
if (!$dom->load($xml_src)) {
    echo "<script>alert('Error al cargar el XML'); window.location.href = '../home.php';</script>";
    exit;
}

$xpath = new DOMXPath($dom);
$xpath->registerNamespace('cfdi', 'http://www.sat.gob.mx/cfd/4');

$parent = $xpath->query('//cfdi:Comprobante');
if ($parent->length === 0) {
    echo "<script>alert('No se encontró el nodo Comprobante'); window.location.href = '../home.php';</script>";
    exit;
}

// Crear Addenda
$addenda = $dom->createElement('cfdi:Addenda');
// <-- 1.6.1-->
$payment = $addenda->appendChild($dom->createElement('requestForPayment'));
//<--a.1-->
$paymentid = $payment->appendChild($dom->createElement('requestForPaymentIdentification'));
//<--a.2-->
$specialins = $payment->appendChild($dom->createElement('specialInstruction'));
//<--a.3-->
$orderid = $payment->appendChild($dom->createElement('orderIdentification'));
//<--a.4-->
$adiid = $payment->appendChild($dom->createElement('AdditionalInformation'));
//<--a.5-->
$delnot = $payment->appendChild($dom->createElement('DeliveryNote'));
//<--a.6-->
$buyer = $payment->appendChild($dom->createElement('buyer'));
//<--a.7-->
$seller = $payment->appendChild($dom->createElement('seller'));
//<--a.8-->
$shipto = $payment->appendChild($dom->createElement('shipTo'));
//<--a.9-->
//$invoice = $payment->appendChild($dom->createElement('InvoiceCreator'));
//<--a.10-->
//$custom = $payment->appendChild($dom->createElement('Customs'));
//<--a.11-->
//$currency = $payment->appendChild($dom->createElement('currency'));
//<--a.12-->
//$payterms = $payment->appendChild($dom->createElement('paymentTerms'));
//<--a.13-->
//$shipment = $payment->appendChild($dom->createElement('shipmentDetail'));
//<--a.14-->
//$allowance = $payment->appendChild($dom->createElement('allowanceCharge'));
//<--a.15-->
$item = $payment->appendChild($dom->createElement('lineItem'));
//<--a.16-->
//$amount = $payment->appendChild($dom->createElement('totalAmount'));
//<--a.17-->
//$charge = $payment->appendChild($dom->createElement('TotalAllowanceCharge'));
//<--a.18-->
//$base = $payment->appendChild($dom->createElement('baseAmount'));
//<--a.19-->
//$tax = $payment->appendChild($dom->createElement('tax'));
//<--a.20-->
//$payable = $payment->appendChild($dom->createElement('payableAmount'));

// Atributos principales <--1.6.1-->
$payment->setAttribute('type', 'SimpleInvoiceType');
$payment->setAttribute('contentVersion', '1.3.1');
$payment->setAttribute('documentStructureVersion', $facturaData['addenda']);
$payment->setAttribute('documentStatus', 'ORIGINAL');
$payment->setAttribute('DeliveryDate', date("Y-m-d", strtotime($facturaData['order_date'])));

// requestForPaymentIdentification <--a.1.1-->
$paymentid->appendChild($dom->createElement('entityType', 'INVOICE'));
//<--a.1.2-->
$paymentid->appendChild($dom->createElement('uniqueCreatorIdentification', $facturaData['inv_num']));

// specialInstruction <--a.2.1-->
//$specialins->setAttribute('code', 'ZZZ');
//$numero = number_format($facturaData['folio'], 2, ".", "");
//$specialins->appendChild($dom->createElement('text', convertir($numero)));

// orderIdentification <--a.3.1 NUMERO DE ORDEN DE COMPRA-->
$ref = $dom->createElement('referenceIdentification', $facturaData['cust_po']);
$ref->setAttribute('type', 'ON');
$orderid->appendChild($ref);
$orderid->appendChild($dom->createElement('ReferenceDate', date("Y-m-d", strtotime($facturaData['order_date']))));

// AdditionalInformation <--a.4.1 TIPO Y NUMERO DE REFERENCIA A NIVEL GLOBAL ADICIONAL-->
$ref = $dom->createElement('referenceIdentification', $facturaData['reference_id']);
$ref->setAttribute('type', $facturaData['reference_id_type']);
$adiid->appendChild($ref);

//<--a.5.1-->
$delnot->appendChild($dom->createElement('referenceIdentification', $idrec));

// Buyer <--    a.6-->
$buyer->appendChild($dom->createElement('gln', $facturaData['gln_buyer']));
//$contact = $buyer->appendChild($dom->createElement('contactInformation'));
//$person = $contact->appendChild($dom->createElement('personOrDepartmentName'));
//$person->appendChild($dom->createElement('text', '0'));

// Seller
$seller->appendChild($dom->createElement('gln', $facturaData['gln_seller']));
$altpart = $seller->appendChild($dom->createElement('alternatePartyIdentification', $facturaData['alt_party_id']));
$altpart->setAttribute('type', $facturaData['alt_party_id_type']);

// ShipTo
$shipto->appendChild($dom->createElement('gln', $facturaData['gln_ship_to']));
//$addr = $shipto->appendChild($dom->createElement('nameAndAddress'));
//$addr->appendChild($dom->createElement('name', 'CENTRO DE DISTRIBUCIÓN TULTITLÁN'));
//$addr->appendChild($dom->createElement('streetAddressOne', 'CALZ VALLEJO 980 COL IND VALLEJO'));
//$addr->appendChild($dom->createElement('city', 'MEXICO D.F'));
//$addr->appendChild($dom->createElement('postalCode', '54730'));

// Currency
//$currency->setAttribute('currencyISOCode', 'MXN');
//$currency->appendChild($dom->createElement('currencyFunction', 'BILLING_CURRENCY'));
//$currency->appendChild($dom->createElement('rateOfChange', '1.00'));

// PaymentTerms
//$payterms->setAttribute('paymentTermsEvent', 'DATE_OF_INVOICE');
//$payterms->setAttribute('PaymentTermsRelationTime', 'REFERENCE_AFTER');
//$netpay = $payterms->appendChild($dom->createElement('netPayment'));
//$netpay->setAttribute('netPaymentTermsType', 'BASIC_NET');
//$time = $netpay->appendChild($dom->createElement('paymentTimePeriod'));
//$tpd = $time->appendChild($dom->createElement('timePeriodDue'));
//$tpd->setAttribute('timePeriod', 'DAYS');
//$tpd->appendChild($dom->createElement('value', '90'));

foreach ($datos as $detalle) {
    $item = $payment->appendChild($dom->createElement('item'));
    $item->setAttribute('type', 'SimpleInvoiceLineItemType');
    $item->setAttribute('number', $detalle['co_line']);

    // tradeItemIdentification
    $tradeid = $item->appendChild($dom->createElement('tradeItemIdentification'));
    $gtin = $tradeid->appendChild($dom->createElement('gtin', $detalle['item']));

    // tradeItemDescriptionInformation
    $tradedesc = $item->appendChild($dom->createElement('tradeItemDescriptionInformation'));
    $tradedesc->setAttribute('language', 'ES-ESPAÑOL');
    $longtext = $tradedesc->appendChild($dom->createElement('longText', $detalle['description']));

    // invoicedQuantity
    $invqty = $dom->createElement('invoicedQuantity', number_format($detalle['qty_invoiced'], 2, ".", ""));
    $invqty->setAttribute('unitOfMeasure', $detalle['u_m']);
    $item->appendChild($invqty);

}

// Insertar addenda
$parent->item(0)->appendChild($addenda);

// Guardar archivo
$nombreArchivo = 'addenda_' . $facturaData['inv_num'] . '.xml';
$rutaArchivo = __DIR__ . '/../xml_generados/' . $nombreArchivo;

if (!is_dir(dirname($rutaArchivo))) {
    mkdir(dirname($rutaArchivo), 0777, true);
}

if ($dom->save($rutaArchivo)) {
    $_SESSION['mensaje_exito'] = 'El archivo "' . $nombreArchivo . '" se generó correctamente.';
    $_SESSION['archivo_generado'] = $nombreArchivo; // para el enlace de descarga
    header("Location: ../home.php");
    exit;
} else {
    $_SESSION['mensaje_error'] = 'Error al guardar el archivo XML. Verifique permisos o intente nuevamente.';
    header("Location: ../home.php");
    exit;
}
?>