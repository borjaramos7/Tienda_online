<!-- Vista para registrarse o loguearse para realizar un pedido -->
<html lang="en">

    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h1 class="lead">No se encuentra logueado en el sistema, 
            por favor entre con su usuario o registrese si no tiene una cuenta con nosotros</h1>
        <a class="btn btn-info" style="height:5%;"
           <?php echo anchor("Cont_user/Login", "Login"); ?></a>
        <a class="btn btn-info"
           <?php echo anchor("Cont_user/Registro", "Registrarse"); ?></a>
    </body>
</html>