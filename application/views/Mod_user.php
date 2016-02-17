<html>
<head>
    <title>Formulario</title>
    <meta charset="utf-8">
    <link type="text/css" href="./../css/style.css" rel="stylesheet" />
</head>
 
<body>
    <?php foreach ($usuarios as $user) : ?>
    <div id="envoltura">
        <div id="contenedor">
        
            <div id="lead">
                Datos de <?= $user->nombreus ;?>
            </div>
            <div style='color:blue; border:2px solid red;'><b>
            <?php echo validation_errors(); ?></b></div>
            <div id="cuerpo">
 
                <form style="border:solid 2px; " action="VerificaDatosUsuarioMod" method="post" >
                <div style="margin-left:30px; padding:3px,3px,3px,3px;">
                      
                    <label for="nombre">Nombre:</label>
                    <input name="nombre" type="text" id="nombre" class="list-group-item" 
                           value="<?= $user->nombre;?>">
                    
                    <label for="apellidos">Apellidos:</label>
                        <input name="apellidos" type="text" id="apellidos" class="list-group-item"
                              value="<?= $user->apellidos;?>" >
                    
                        <label for="dni">DNI:</label>
                    <input name="dni" type="text" id="dni" class="list-group-item" 
                           value="<?= $user->dni;?>">
                
                    <label for="correo">Correo:</label>
                        <input name="correo" type="text" id="correo" class="list-group-item" 
                               value="<?= $user->email;?>">
                        
                    <label for="prov">Provincia:</label>
                    <input name="prov" type="text" id="prov" class="list-group-item"
                           value="<?= $user->provincia;?>" >
                
                    <label for="dire">Direccion:</label>
                    <input name="dire" type="text" id="dire" class="list-group-item" 
                           value="<?= $user->direccion;?>">
                    
                    <label for="cp">Codigo Postal:</label>
                    <input name="cp" type="text" id="cp" class="list-group-item" 
                           value="<?= $user->cp;?>"><br>
                        
                    <!--p><label for="pass">Nuevo Password:</label></p>
                        <input name="pass" type="password" id="pass" class="list-group-item" placeholder="Pon tu contraseña"></p>
 
                    <p><label for="repass">Repetir nuevo Password:</label></p>
                        <input name="repass" type="password" id="repass" class="list-group-item" placeholder="Repite contraseña"></p-->
 
                    <p id="bot"><input name="submit" type="submit" id="boton" value="Guardar cambios" class="list-group-item"/></p>
                 </div>
                </form>
           
        </div>
            
    </div>
   <?php endforeach; ?>
</body>
 
</html>
