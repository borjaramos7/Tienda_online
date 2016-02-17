<html>

<head>
</head>
<body>
    <?php foreach ($productos as $producto) : ?>
    <!--h1 class="lead">$titulo</h1-->
        <div class="col-sm-3 col-lg-3 col-md-3">
            <div class="thumbnail">
                <img src="<?= base_url()."asset/img/".$producto['imagenpro']?>" alt="">
                <div class="caption">
                    <h4 class="pull-right"><?=$producto['precio']?> €</h4>
                     <?php echo anchor("Cont_Carrito/VerProducto/{$producto['id']}",$producto['nombrepro']);?></a>
                    </h4>
                    <p><?=$producto['anuncio']?></p>
                    <p class="pull-right">Stock: <?=$producto['stock']?></p>
                    <!--a href="" class="btn btn-default" aria-label="Left Align">
                            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                    </a-->
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>

