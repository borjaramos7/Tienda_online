<html>

<head>
</head>
<body>
    <?php foreach ($productos as $producto) : ?>
        <div style="width: 25%; height: 15%;" class="col-sm-2 col-lg-2 col-md-2">
            <div class="thumbnail">
                <img src="<?= base_url()."asset/img/".$producto['imagenpro']?>" alt="">
                <div class="caption">
                    <h4 class="pull-right"><?=$producto['precio']?> €</h4>
                     <?php echo anchor("Cont_Carrito/VerProducto/{$producto['id']}",$producto['nombrepro']);?></a><br>
                    </h4>
                    <p class="text-left"><?=$producto['anuncio']?></p><br>
                    <p class="text-left">Stock: <?=$producto['stock']?></p>
                    <!--a href="" class="btn btn-default" aria-label="Left Align">
                            <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
                    </a-->
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>

