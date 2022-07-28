<?php

    session_start();
    include 'functions.php';
    verificar_sesion();

	$idfac = ($_POST["inputFactura"]);

class Fac{


}


class DetalleFac{


    }

try{

        $pdo = new PDO ("4D:host=100.48.0.7;charset=UTF-8","ODBC",
            "ODBC");

    } catch (PDOException $ex) {

        var_dump($ex->getMessage());
        var_dump($ex->getCode());

    }

    $qryFac=$pdo->prepare("SELECT SerieDocumento,NumeroSecuencialDocumento,ORDEN_COMPRA_CLIENTE,FECHA_FACTURA,
        SUBTOTAL_CON_IVA, TOTAL_IMPUESTOS, VALOR_FACTURA
        FROM CLNT_Factura_Principal
        WHERE NUMERO_FACTURA = $idfac and TIPO_DOCUMENTO = 'FACT' ");
    $qryFac->execute();


    $qryFD=$pdo->prepare("SELECT   INV.Posicion, INV.PRODUCT_ID, INV.PRODUCT_NAME, INV.UNIT_COST,
         INV.UNIT_COST,INV.QUANTITY  ,INV.LINE_TOTAL, INV.NET_LINE_TOTAL,
         INV1.CODE_PROV_O_ALT
         FROM INVT_Producto_Movimientos INV,
         INVT_Ficha_Principal INV1
         WHERE INV.PRODUCT_ID_CORP=INV1.PRODUCT_ID_CORP
         AND INV.ORIGIN_REF =  '$idfac' AND TIPO_DOCUMENTO = '5RF' ORDER BY INV.Posicion");
    $qryFD->execute();


    $facDetalle=$qryFD->fetchAll(PDO::FETCH_CLASS,"DetalleFac");
    $fac=$qryFac->fetchAll(PDO::FETCH_CLASS,"Fac");

    //var_dump($fac);
    //var_dump($facDetalle)


?>
