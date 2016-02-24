<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BuyPhone</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url().'asset/'?>plantilla/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?=base_url().'asset/'?>plantilla/css/shop-homepage.css" rel="stylesheet">

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand"
                    <?php echo anchor("Cont_user/Login","Login");?></a><span class="navbar-brand">||</span>
                <a class="navbar-brand"
                    <?php echo anchor("Cont_user/Registro","Registrarse");?></a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-1">
                
                    <span class="navbar-brand">
                        <?php echo $this->session->userdata('username');?>
                    </span>
                <?php if ($this->session->userdata('username')!=null) :?>
                <ul>
                    <li><?php echo anchor("Cont_user/LogOut","Logout");?></li>
                    <li><?php echo anchor("Cont_user/DarBajausuario","Dar de baja") ;?></li>
                    <li><?php echo anchor("Cont_user/CargaDatosUs","Modificar Datos") ;?></li>
                    <li><?php echo anchor("Cont_pedido/MuestraPedido","Mostrar pedidos") ;?></li>
                </ul>
                <?php endif; ?>
                    
                
                    </div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container" style="margin-top: 75px">

        <div class="row">

            <div class="col-md-3">
                <p class="lead">Buyphone</p>
                <br>
                <?php if (isset($_SESSION["carrito"])): ?>
                    <a  class="list-group-item" 
                        <?php echo anchor("Cont_Carrito/MuestraCarrito","Mostrar carrito");?></a>
                    <?php endif ;?>
                    
                <div class="list-group">
                    <a class="list-group-item"
                        <?php echo anchor("Principal/VerDestacado","Destacados");?></a><br><br>
                    <p class="lead">Marcas</p>
                    <?php foreach ($categorias as $categ) :?>
                    <a  class="list-group-item" 
                        <?php echo anchor("Principal/VerCategoria/{$categ['idcat']}",$categ['nombrecat']);?></a>
                    <?php endforeach; ?>
                    <br><br>
                    <p class="lead">Datos a exportar e importar</p>
                    <a  class="list-group-item"
                    <?php echo anchor("Exp_impXML/exporta_cat","Exporta Articulos");?></a>
                    <a  class="list-group-item"
                    <?php echo anchor("Exp_impXML/importar","Importar Articulos");?></a>
                </div>
            </div>

            <div class="col-md-9">

                <div class="row">
                    <?php if (isset($cuerpo)) {
                        echo " <div  id='underline'>
                            <h1 style='text-align:center; color:#0076DC'>
                            <b>".$encabezado."</b></h1>
                         </div>";
                        
                        //<p style='text-align:center; color:blue'><b>".$encabezado."</b></p>
                        echo $cuerpo;
                    } else {
                        $cuerpo=$this->load->view('destacados');
                    }
                    ?>
                    
                </div>
                
             <!--div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="http://placehold.it/800x300" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="http://placehold.it/800x300" alt="">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="http://placehold.it/800x300" alt="">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div-->
            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="<?=base_url().'asset/'?>plantilla/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="<?=base_url().'asset/'?>plantilla/js/bootstrap.min.js"></script>

</body>

</html>
