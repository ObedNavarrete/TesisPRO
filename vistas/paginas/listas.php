    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <style>
    button,
    input,
    optgroup,
    select,
    textarea {
        margin: 0;
        font-family: inherit;
        font-size: inherit;
        line-height: inherit;
        background-color: inherit;
        outline: none;
        color: white;
        text-align: center;
        border: none;
        width: 100%;
    }
    div.dataTables_wrapper div.dataTables_info {
        padding-top: 0.85em;
        color: white;
    }
    div.dataTables_wrapper div.dataTables_paginate {
    background-color: white;
    font-weight: bolder;
    padding: 10px;
    margin: 0;
    white-space: nowrap;
    text-align: right;
    width: 100% !important;
    }
    div.dt-buttons{
        margin-left: 10px !important;
        margin-top: 10px !important;
    }
    </style>


<?php
if (($usuarioIngreso['idRol'] != 4)) {
    echo "<script>
              window.location = 'inicio';
          </script>";
    return;
}

$listas = ControladorListas::ctrMostrarListas();

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 ml-2">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">SIGES</a></li>
                <li class="breadcrumb-item active">Listas de Ventas</li>
            </ol>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->

    <div class="card mx-1 mx-lg-2">
        <div class="card-header border-transparent">
            <h3 class="card-title mt-2 ml-0 text-center h2">Ventas</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table container-fluid tablaListas mx-0 display" width="100%">
                    <thead class="table-bordered">
                        <tr>
                            <th class="">Fecha</th>
                            <th class="text-center">Sorteo</th>
                            <th class="text-center">Vendedor</th>
                            <th class="text-center">Ventas</th>
                            <th class="text-center">Acciones</th>

                            <th class="text-center">Imprimir</th>
                        </tr>

                        <tr>
                            <th class="">Fecha</th>
                            <th>Sorteo</th>
                            <th>Vendedor</th>
                            <th>Ventas</th>
                            <th>Acciones</th>

                            <th>Imprimir</th>
                        </tr>
                    </thead>
                    <tbody class="table-bordered text-center">


                        <?php foreach ($listas as $key => $value) : ?>
                            <?php
                            $acciones = "<div class='btn-group'><button class='btn btn-success btn-sm btnVerLista' data-toggle='modal' data-target='#verLista' idvendidopor='" . $value["idVendidoPor"] . "' fecha='" . $value["fecha"] . "' idsorteo='" . $value["idSorteo"] . " '><i class='fas fa-eye text-white'></i></button></div>";
                            ?>
                            <tr class="text-center">
                                <td><?php echo $value["fechax"] ?></td>
                                <td><?php echo $value["sorteo"] ?></td>
                                <td><?php echo $value["nombre"] ?></td>
                                <td><?php echo $value["ventas"] ?></td>
                                <td><?php echo $acciones ?></td>

                                <td><button class="btn btn-sm  btn-primary"><a class="text-white" href="/fpdf/lista.php?idvendidopor=<?php echo $value["idVendidoPor"]?>&fecha=<?php echo $value["fecha"]?>&idsorteo=<?php echo $value["idSorteo"]?>"><i class="fas fa-print"></i></a></button></td>

                            </tr>
                        <?php endforeach ?>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- /.card -->
</div>


<div class="modal fade mt-5" id="verLista" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog container">

        <div class="card">
            <h2 class="text-center pt-5 text-success">RIFA DÍAZ</h2>
            <h5 class="text-center text-primary">LISTA CONSOLIDADA</h5>
            <div id="elvende"></div>
            <div class="texto-aqui"></div>
            <!-- <h5 class="pl-2 pt-2">Vendedor: <span class="text-success"><?php echo $usuarioIngreso["nombre"] ?></span> </h5>
      <h5 class="pl-2">Boleto no: <span class="text-success"><?php echo $recibo ?></span> </h5> -->
            <div class="card-body">

                <div class="row border-bottom">
                    <p class="text-center col-4 font-weight-bolder">Número</p>
                    <p class="text-center col-4 font-weight-bolder">Monto</p>
                    <p class="text-center col-4 font-weight-bolder">Premio</p>
                </div>

                <form method="post" class="encabezadoLista" id="">

                    <div class="row viendoLista" id="viendoLista">

                    </div>

                    <div class="d-flex modal-footer justify-content-end">
                        <button data-dismiss="modal" id="" class="btn btn-info">Cerrar</button>
                    </div>

                </form>

            </div>

        </div>
    </div>