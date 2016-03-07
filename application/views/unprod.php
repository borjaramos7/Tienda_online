<!-- Vista en detalle de un producto -->
    
<?php  
/**
 * Recibe el precio,descuento e iva de un producto y devuelve su precio definitivo
 * @param type $precio
 * @param type $desc
 * @param type $iva
 * @return type
 */
function PrecioFinal($precio,$desc,$iva){
            $preciofi=$precio-($precio/100*$desc)+($precio/100*$iva);
    return $preciofi;
    } 
?>
<html>
<head>
</head>
<body>
        <img style="" src="<?= base_url()."asset/img/".$producto->imagenpro?>" alt="">
        <div class="col-sm-6 col-lg-6 col-md-8">
            <div class="thumbnail">
                <div class="caption">
                    <p class="pull-right">Stock: <?=$producto->stock?></p>
                    
                    <h4 class="pull-left">Especificaciones</h4><br><br>
                    <p><?=$producto->descripcion?></p>
                </div>
            </div>
            <form method="post" action="<?= site_url('Cont_Carrito/MeteCarrito')?>">
            <input type="hidden" name="idpro" value="<?= $producto->id ?>">
            <h4 class="pull">Precio Final</h4><br>
            <p class="pull">Precio base: <?=$producto->precio?> €</p>
             <p class="pull"> - <?=$producto->descuento?> % de descuento</p>
              <p class="pull">+ <?=$producto->iva?> % de IVA</p><br>
                 <p class="pull">Total: 
                     <input type="text" readonly="" name="prefi"
                value="<?= PrecioFinal($producto->precio,$producto->descuento,$producto->iva);?>"></p>
                 <?php if ($producto->stock!=0) :?>
                 <h4 class="pull-left">Cantidad: </h4>
                 <input class="input-sm" name="cantidad" type="number" value="1" 
                     max="<?=$producto->stock?>"   min="1" max size="2">
                 <input type="submit" value="Añadir al carrito">
                 <form>
                 <?php else: echo "Este producto esta agotado en estos momentos";
                 endif;?>
        </div>
    
</body>
</html>

