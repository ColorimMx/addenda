<?php

$idoc = ($_POST["inputOcompra"]);
$xml_src = ($_FILES['xml']['tmp_name']);

// El fichero test.xml contiene un documento XML con un elemento raíz y, al
// menos, un elemento /[raiz]/titulo.

//(file_exists('test.xml'))
if (empty($idoc && $xml_src))  {

    exit('<script language="javascript">alert(\'Ingrese los datos requeridos\');</script>
<script>
      window.location.href = "home.php";
    </script>');

} else {



    // XPath-Querys
    $parent_path = "//cfdi:Comprobante";



    // Create a new DOM document
    $dom = new DOMDocument('1.0','UTF-8');
    $dom->load($xml_src);

    // Find the parent node
    $xpath = new DomXPath($dom);

    // Find parent node
    $parent = $xpath->query($parent_path);


    // Create the new element
    $addenda = $dom->createElement('cfdi:Addenda');

    //Nodos segundo nivel

    $refid = $addenda->appendChild($dom->createElement('cfdi:InfoAdicional'));
    $refid->setAttribute('OrdenCompra', $idoc);

    // Insert the new element
    $parent->item(0)->insertBefore($addenda);

    header('Content-Type: text/xml');

    ob_clean();

    print $dom->saveXML();

}
?>
