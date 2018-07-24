<?php

require 'base.php';
require 'conversor.php';

$xml_src = ($_FILES['xml']['tmp_name']);

// El fichero test.xml contiene un documento XML con un elemento raíz y, al
// menos, un elemento /[raiz]/titulo.

//(file_exists('test.xml'))
if (empty($idfac && $xml_src))  {

    exit('<script language="javascript">alert(\'Ingrese los datos requeridos\');</script>
<script>
      window.location.href = "home.php";
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
    foreach ($fac as $factura ) {
//Nodo padre Addenda
        $addenda = $dom->appendChild($dom->createElement('cfdi:Addenda'));


        foreach ($facDetalle as $detalle) {

//Nodos segundo nivel
            $datnad = $addenda->appendChild($dom->createElement('DatosNadro'));

//Nodos tercer nivel
            $orden = $datnad->appendChild($dom->createElement('Orden'));
            $orden->appendChild($dom->createTextNode($factura->ORDEN_COMPRA_CLIENTE));
            $plazo = $datnad->appendChild($dom->createElement('Plazo'));
            $plazo->appendChild($dom->createTextNode(60));
            $entrega = $datnad->appendChild($dom->createElement('EntregaEntrante'));
            $entrega->appendChild($dom->createTextNode("SIN DATO"));
            $posicion = $datnad->appendChild($dom->createElement('PosicionOC'));
            $posicion->appendChild($dom->createTextNode(number_format
            ($detalle->POSICION,0,",","")));
            $total = $datnad->appendChild($dom->createElement('TotalOC'));
            $total->appendChild($dom->createTextNode(number_format
            ($detalle->NET_LINE_TOTAL,2,".","")));
            $codean = $datnad->appendChild($dom->createElement('CodEAN'));
            $codean->appendChild($dom->createTextNode($detalle->CODE_PROV_O_ALT));

        }
    }
// Insert the new element
    $parent->item(0)->insertBefore($addenda);

    header('Content-Type: text/xml');

    ob_clean();

    print $dom->saveXML();

}
?>
