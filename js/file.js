function formComer() {
    document.getElementById("form").innerHTML = '<form class="form-horizontal bounceInLeft animated" action="comergen.php" method="post"  enctype="multipart/form-data">'+
        '<div class="form-group">'+
        '<label for="inputFactura" class="col-sm-2 control-label">Factura</label>'+
        '<div class="col-sm-10">'+
        '<input type="text" class="form-control" id="inputFactura" name="inputFactura" placeholder="1000000001">'+
        '</div>'+
        '</div>'+
        '<div class="form-group">'+
        '<label for="inputRecibo" class="col-sm-2 control-label">Recibo</label>'+
        '<div class="col-sm-10">'+
        '<input type="text" class="form-control" id="inputRecibo" name="inputRecibo" placeholder="Recibo">'+
        '</div>'+
        '</div>'+
        '<div class="form-group">'+
        '<label for="inputXml" class="col-sm-2 control-label">Xml</label>'+
        '<div class="col-sm-10">'+
        '<input name="xml" id="xml" type="file" >'+
        '</div>'+
        '</div>'+
        '<div class="form-group">'+
        '<div class="col-sm-offset-2 col-sm-10">'+
        '<button type="submit" class="btn btn-lacomer">Addenda Lacomer</button>'+
        '</div>'+
        '</div>'+
        '</form>'
    $("#xml").change(function ()
    {
        var archivo = $("#xml").val();
        extensionesPermitidas = new Array(".xml");
        miError = "";
        if (!archivo){}
        else
        {
            extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
            permitida = false;
            for (var i = 0; i < extensionesPermitidas.length; i++)
            {
                if (extensionesPermitidas[i] == extension)
                {
                    permitida = true;
                    break;
                }
            }
            if (!permitida)
            {
                alert("Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extension: " + extensionesPermitidas.join());
                window.location.href = "index.html";
            }
        }
    });
    ;
}

function formNadro() {
    document.getElementById("form").innerHTML = '<form class="form-horizontal bounceInLeft animated" action="nadrogen.php" method="post"  enctype="multipart/form-data">'+
        '<div class="form-group">'+
        '<label for="inputFactura" class="col-sm-2 control-label">Factura</label>'+
        '<div class="col-sm-10">'+
        '<input type="text" class="form-control" id="inputFactura" name="inputFactura" placeholder="1000000001">'+
        '</div>'+
        '</div>'+
        '<div class="form-group">'+
        '<label for="inputXml" class="col-sm-2 control-label">Xml</label>'+
        '<div class="col-sm-10">'+
        '<input name="xml" id="xml" type="file">'+
        '</div>'+
        '</div>'+
        '<div class="form-group">'+
        '<div class="col-sm-offset-2 col-sm-10">'+
        '<button type="submit" class="btn btn-primary">Addenda Nadro</button>'+
        '</div>'+
        '</div>'+
        '</form>'
    $("#xml").change(function ()
    {
        var archivo = $("#xml").val();
        extensionesPermitidas = new Array(".xml");
        miError = "";
        if (!archivo){}
        else
        {
            extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
            permitida = false;
            for (var i = 0; i < extensionesPermitidas.length; i++)
            {
                if (extensionesPermitidas[i] == extension)
                {
                    permitida = true;
                    break;
                }
            }
            if (!permitida)
            {
                alert("Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extension: " + extensionesPermitidas.join());
                window.location.href = "index.html";
            }
        }
    });
    ;
}
