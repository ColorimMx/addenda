 <?php

require 'base.php';
require 'conversor.php';

$idrec = ($_POST["inputRecibo"]);
$xml_src = ($_FILES['xml']['tmp_name']);

// El fichero test.xml contiene un documento XML con un elemento raíz y, al
// menos, un elemento /[raiz]/titulo.

//(file_exists('test.xml'))
if (empty($idfac && $idrec && $xml_src))  {

    exit('<script language="javascript">alert(\'Ingrese los datos requeridos\');</script>
<script>
      window.location.href = "index.html";
    </script>');

} else {

    //$xml_src = $file;

    // XPath-Querys
    $parent_path = "//cfdi:Comprobante";
    //$next_path = "//cfdi:Comprobante/cfdi:Complemento";


    // Create a new DOM document
    $dom = new DOMDocument('1.0','UTF-8');
    $dom->load($xml_src);

    // Find the parent node
    $xpath = new DomXPath($dom);

    // Find parent node
    $parent = $xpath->query($parent_path);


// new node will be inserted before this node
    //$next = $xpath->query($parent);

// Create the new element
    $addenda = $dom->createElement('cfdi:Addenda');

    //Nodos segundo nivel
    $payment = $addenda->appendChild($dom->createElement('requestForPayment'));

    //Nodos tercer nivel
    $paymentid = $payment->appendChild($dom->createElement('requestForPaymentIdentification'));
    $specialins = $payment->appendChild($dom->createElement('specialInstruction'));
    $orderid = $payment->appendChild($dom->createElement('orderIdentification'));
    $adiid = $payment->appendChild($dom->createElement('AdditionalInformation'));
    $delnot = $payment->appendChild($dom->createElement('DeliveryNote'));
    $buyer = $payment->appendChild($dom->createElement('buyer'));
    $seller = $payment->appendChild($dom->createElement('seller'));
    $shipto = $payment->appendChild($dom->createElement('shipTo'));
    $curren = $payment->appendChild($dom->createElement('currency'));
    $payterms = $payment->appendChild($dom->createElement('paymentTerms'));
    //$lineitem = $payment->appendChild($dom->createElement('lineItem'));

    //Nodos Hijo de requestForPayment
    foreach ($fac as $factura ) {

        $numero = number_format ($factura->VALOR_FACTURA,2,".","");
        $payment->setAttribute('type', 'SimpleInvoiceType');
        $payment->setAttribute('contentVersion', '1.3.1');
        $payment->setAttribute('documentStructureVersion', 'AMC7.1');
        $payment->setAttribute('documentStatus', 'ORIGINAL');
        $payment->setAttribute('DeliveryDate', (date("Y-m-d",strtotime($factura->FECHA_FACTURA))));
        $entity = $paymentid->appendChild($dom->createElement('entityType'));
        $entity->appendChild($dom->createTextNode('INVOICE'));
        $creatorid = $paymentid->appendChild($dom->createElement('uniqueCreatorIdentification'));
        $creatorid->appendChild($dom->createTextNode($factura->SERIEDOCUMENTO.''.number_format($factura->NUMEROSECUENCIALDOCUMENTO,0,",","")
        ));

        //Nodos Hijo de specialInstruction
        $specialins->setAttribute('code', 'ZZZ');
        $textspe = $specialins->appendChild($dom->createElement('text'));
        $textspe->appendChild($dom->createTextNode($resultado = convertir($numero)));

        //Nodos Hijo de orderIdentification
        $refid = $orderid->appendChild($dom->createElement('referenceIdentification'));
        $refid->setAttribute('type', 'ON');
        $refid->appendChild($dom->createTextNode($idrec));
        $refdate = $orderid->appendChild($dom->createElement('ReferenceDate'));
        $refdate->appendChild($dom->createTextNode(date("Y-m-d",strtotime($factura->FECHA_FACTURA))));

        //Nodos Hijo de AdditionalInformation
        $refidad = $adiid->appendChild($dom->createElement('referenceIdentification'));
        $refidad->setAttribute('type', 'ATZ');
        $refidad->appendChild($dom->createTextNode('0'));

        //Nodos Hijo de DeliveryNote
        $refiddel = $delnot->appendChild($dom->createElement('referenceIdentification'));
        $refiddel->appendChild($dom->createTextNode($idrec));

        //Nodos Hijo de buyer
        $glnbuy = $buyer->appendChild($dom->createElement('gln'));
        $glnbuy->appendChild($dom->createTextNode('7505000099632'));
        $coninfo = $buyer->appendChild($dom->createElement('contactInformation'));
        $person = $coninfo->appendChild($dom->createElement('personOrDepartmentName'));
        $textper = $person->appendChild($dom->createElement('text'));
        $textper->appendChild($dom->createTextNode('0'));

        //Nodos Hijo de seller
        $glnsell = $seller->appendChild($dom->createElement('gln'));
        $glnsell->appendChild($dom->createTextNode('0000000872570'));
        $altpart = $seller->appendChild($dom->createElement('alternatePartyIdentification'));
        $altpart->setAttribute('type', 'SELLER_ASSIGNED_IDENTIFIER_FOR_A_PARTY');
        $altpart->appendChild($dom->createTextNode('872570'));

        //Nodos Hijo de shipto
        $glnship = $shipto->appendChild($dom->createElement('gln'));
        $glnship->appendChild($dom->createTextNode('7505000352805'));
        $nameddr = $shipto->appendChild($dom->createElement('nameAndAddress'));
        $name = $nameddr->appendChild($dom->createElement('name'));
        $name->appendChild($dom->createTextNode('CENTRO DE DISTRIBUCIÓN TULTITLÁN'));
        $street = $nameddr->appendChild($dom->createElement('streetAddressOne'));
        $street->appendChild($dom->createTextNode('CALZ VALLEJO 980 COL IND VALLEJO'));
        $city = $nameddr->appendChild($dom->createElement('city'));
        $city->appendChild($dom->createTextNode('MEXICO D.F'));
        $zip = $nameddr->appendChild($dom->createElement('postalCode'));
        $zip->appendChild($dom->createTextNode(54730));

        //Nodos Hijo de currency
        $curren->setAttribute('currencyISOCode', 'MXN');
        $currfun = $curren->appendChild($dom->createElement('currencyFunction'));
        $currfun->appendChild($dom->createTextNode('BILLING_CURRENCY'));
        $ratech = $curren->appendChild($dom->createElement('rateOfChange'));
        $ratech->appendChild($dom->createTextNode('1.00'));

        //Nodos Hijo de paymentTerms
        $payterms->setAttribute('paymentTermsEvent','DATE_OF_INVOICE');
        $payterms->setAttribute('PaymentTermsRelationTime', 'REFERENCE_AFTER');
        $netpay = $payterms->appendChild($dom->createElement('netPayment'));
        $netpay->setAttribute('netPaymentTermsType', 'BASIC_NET');
        $paytime = $netpay->appendChild($dom->createElement('paymentTimePeriod'));
        $timeper = $paytime->appendChild($dom->createElement('timePeriodDue'));
        $timeper->setAttribute('timePeriod', 'DAYS');
        $valuetime = $timeper->appendChild($dom->createElement('value'));
        $valuetime->appendChild($dom->createTextNode('90'));

    }

    foreach ($facDetalle as $detalle) {

        //Nodos detalle de productos
        //Nodos Hijo de lineItem
        $lineitem = $payment->appendChild($dom->createElement('lineItem'));
        $lineitem->setAttribute('type', 'SimpleInvoiceLineItemType');
        $lineitem->setAttribute('number', number_format($detalle->POSICION,0,",",""));
        $tradeid = $lineitem->appendChild($dom->createElement('tradeItemIdentification'));
        $gtin = $tradeid->appendChild($dom->createElement('gtin'));
        $gtin->appendChild($dom->createTextNode($detalle->CODE_PROV_O_ALT));
        $altid = $lineitem->appendChild($dom->createElement('alternateTradeItemIdentification'));
        $altid->setAttribute('type','BUYER_ASSIGNED');
        $altid->appendChild($dom->createTextNode($detalle->PRODUCT_ID));
        $tradescrip = $lineitem->appendChild($dom->createElement('tradeItemDescriptionInformation'));
        $longtext = $tradescrip->appendChild($dom->createElement('longText'));
        $longtext->appendChild($dom->createTextNode($detalle->PRODUCT_NAME));
        $invqty = $lineitem->appendChild($dom->createElement('invoicedQuantity'));
        $invqty->setAttribute('unitOfMeasure', 'PCE');
        $invqty->appendChild($dom->createTextNode(number_format($detalle->QUANTITY,2,".","")));
        $grprice = $lineitem->appendChild($dom->createElement('grossPrice'));
        $amtgrp = $grprice->appendChild($dom->createElement('Amount'));
        $amtgrp->appendChild($dom->createTextNode(number_format($detalle->UNIT_COST,2,".","")));
        $netprice = $lineitem->appendChild($dom->createElement('netPrice'));
        $amtnet = $netprice->appendChild($dom->createElement('Amount'));
        $amtnet->appendChild($dom->createTextNode(number_format($detalle->UNIT_COST,2,".","")));
        $adinfo = $lineitem->appendChild($dom->createElement('AdditionalInformation'));
        $refadinfo = $adinfo->appendChild($dom->createElement('referenceIdentification'));
        $refadinfo->setAttribute('type', 'ON');
        $refadinfo->appendChild($dom->createTextNode(0));
        $totamtln = $lineitem->appendChild($dom->createElement('totalLineAmount'));
        $grssamt = $totamtln->appendChild($dom->createElement('grossAmount'));
        $amtgross = $grssamt->appendChild($dom->createElement('Amount'));
        $amtgross->appendChild($dom->createTextNode(number_format($detalle->LINE_TOTAL,2,".","")));
        $netamt = $totamtln->appendChild($dom->createElement('netAmount'));
        $amtnet = $netamt->appendChild($dom->createElement('Amount'));
        $amtnet->appendChild($dom->createTextNode(number_format($detalle->NET_LINE_TOTAL,2,".","")));

    }

    $totamt = $payment->appendChild($dom->createElement('totalAmount'));
    $baseamt = $payment->appendChild($dom->createElement('baseAmount'));
    $tax = $payment->appendChild($dom->createElement('tax'));
    $payable = $payment->appendChild($dom->createElement('payableAmount'));

    //Nodos Hijo de totalAmount
    $amttot = $totamt->appendChild($dom->createElement('Amount'));
    $amttot->appendChild($dom->createTextNode((number_format($factura->SUBTOTAL_CON_IVA,2,".",""))));

    //Nodos Hijo de baseAmount
    $amtbase = $baseamt->appendChild($dom->createElement('Amount'));
    $amtbase->appendChild($dom->createTextNode((number_format($factura->SUBTOTAL_CON_IVA,2,".",""))));

    //Nodos Hijo de tax
    $tax->setAttribute('type', 'VAT');
    $prctax = $tax->appendChild($dom->createElement('taxPercentage'));
    $prctax->appendChild($dom->createTextNode('16.00'));
    $amtax = $tax->appendChild($dom->createElement('taxAmount'));
    $amtax->appendChild($dom->createTextNode((number_format($factura->TOTAL_IMPUESTOS,2,".",""))));
    $catax = $tax->appendChild($dom->createElement('taxCategory'));
    $catax->appendChild($dom->createTextNode('TRANSFERIDO'));

    //Nodos Hijo de payableAmount
    $amtpay = $payable->appendChild($dom->createElement('Amount'));
    $amtpay->appendChild($dom->createTextNode((number_format($factura->VALOR_FACTURA,2,".",""))));

// Insert the new element
    $parent->item(0)->insertBefore($addenda);

    header('Content-Type: text/xml');

    ob_clean();

    print $dom->saveXML();

}
?>
