<!-- Vista del carrito -->
<html>
    <head>
    </head>
    <body>
        
        <div  >
                <table class="table table-hover">
                    <tr class="active">
                        <td>Nombre producto</td>
                        <td>Cantidad</td>
                        <td>Precio</td>
                        <td>Total</td>
                        <td>Eliminar</td>
                    </tr>
                <?php foreach ($datos_car as $datos_carrito) :?>
                    <tr>
                        <td><?= $datos_carrito['nombrepro']?></td>
                        <td><?= $datos_carrito['cantidad']?></td>
                        <td><?= $datos_carrito['precio']?> €</td>
                        <td><?= $datos_carrito["total"]?> €</td>
                        <td><a title="Borrar Tarea"  
                            <?php echo anchor("Cont_Carrito/EliminaProd/{$datos_carrito['unique_id']}"," ","class='glyphicon glyphicon-remove'");?>
                            </a></td>
                    </tr>
                <?php endforeach; ?>
                    <tr class="success">
                        <td>Total a pagar</td>
                        <td></td>
                        <td></td>
                        <td><?= $precio_total ?> €</td>
                    </tr>
                </table>
            </div>
        <div class="col-md-3">
        <a  class="list-group-item danger" 
                        <?php echo anchor("Cont_Carrito/LimpiaCarrito","Vaciar todo el carrito");?></a></div>
        <div class="col-md-3">
        <a  class="list-group-item danger" 
                        <?php echo anchor("Cont_pedido/RealizaPedido","Realizar el pedido");?></a></div>
    </body>
</html>