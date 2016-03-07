<!-- Vista con los pedidos de un usuario -->
<html>
    <head>
    </head>
    <body>
    <?php foreach ($pedidos as $pedido) :?>
        <div>
        <h1>Pedido</h1>
        <b>Pedido con fecha: <?= $pedido['fecha_pedido'] ?><br>
        Estado del pedido: <?= $pedido['estado_ped'] ?><br>
        ID del pedido: <?= $pedido['idpedido'] ?></b>
        
        <h1>Desglose del pedido</h1>
                <table class="table table-hover">
                    <tr class="active">
                        <td>Nombre producto</td>
                        <td>Cantidad</td>
                        <td>Precio</td>
                        <td>Precio Final(iva y desc incluidos)</td>
                    </tr>
                <?php foreach ($pedido["lineas"] as $lineapedido) :?>
                    <tr>
                        <td><?= $this->Modelo_tv->SacaNombrePro($lineapedido['producto_id'])?></td>
                        <td><?= $lineapedido['cantidad']?></td>
                        <td><?= $this->Modelo_tv->SacaPrecioPro($lineapedido['producto_id'])?></td>
                        <td><?= $lineapedido['precio_ped']?> €</td>
                    </tr>
                <?php endforeach; ?>
                   <tr class="success">
                        <td>Total a pagar</td>
                        <td></td>
                        <td></td>
                        <td><?= $pedido['total_ped'] ?> €</td>
                    </tr>
                </table>
        <?php if ($pedido['estado_ped']=='Pendiente de envio') :?>
        <div class="col-md-3 danger" style="text-align:center">
        <a  class="list-group-item danger" 
        <?php echo anchor("Cont_pedido/AnulaPedido/{$pedido['idpedido']}","Anular Pedido");?></a></div>
         <?php endif; ?>
        <div class="col-md-3 danger" style="text-align:center">
        <a  class="list-group-item danger" 
        <?php echo anchor("Cont_pedido/PdfPedido/{$pedido['idpedido']}","Pedido en PDF");?></a></div>
        </div>
        <br><br>
    <?php endforeach; ?>  
    </body>
</html>