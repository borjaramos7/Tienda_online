<!-- Vista del registro de un usuario -->
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link type="text/css" href="./../css/style.css" rel="stylesheet" />
</head>
 
<body>
    <div id="envoltura">
        <div id="contenedor">
 
            <div id="lead">
                Datos de registro
            </div>
            <div style='color:blue; border:2px solid red;'><b>
            <?php echo validation_errors(); ?></b></div>
            <div id="cuerpo">
 
                <form style="border:solid 2px; " action="VerificaDatosUsuario" method="post" >
                <div style="margin-left:30px; padding:3px,3px,3px,3px;">
                    <label for="nombreuser">Nombre de usuario:</label>
                        <input name="nombreuser" type="text" id="nombreuser" class="list-group-item"
                               accept="" value="<?php echo set_value('nombreuser');?>" >
                    
                    <label for="nombre">Nombre:</label>
                    <input name="nombre" type="text" id="nombre" class="list-group-item" 
                           value="<?php echo set_value('nombre');?>">
                    
                    
                    <label for="apellidos">Apellidos:</label>
                        <input name="apellidos" type="text" id="apellidos" class="list-group-item"
                              value="<?php echo set_value('apellidos');?>" >
                    
                        <label for="dni">DNI:</label>
                    <input name="dni" type="text" id="dni" class="list-group-item" 
                           value="<?php echo set_value('dni');?>">
                
                    <label for="correo">Correo:</label>
                        <input name="correo" type="text" id="correo" class="list-group-item" 
                               value="<?php echo set_value('correo');?>">
                        
                    <label for="prov">Provincia:</label>
                    <input name="prov" type="text" id="prov" class="list-group-item"0
                           value="<?php echo set_value('prov');?>" >
                
                    <label for="dire">Direccion:</label>
                    <input name="dire" type="text" id="dire" class="list-group-item" 
                           value="<?php echo set_value('dire');?>">
                    
                    <label for="cp">Codigo Postal:</label>
                    <input name="cp" type="text" id="cp" class="list-group-item" 
                           value="<?php echo set_value('cp');?>">
                        
                    <p><label for="pass">Password:</label></p>
                        <input name="pass" type="password" id="pass" class="list-group-item" placeholder="Pon tu contraseña"></p>
 
                    <p><label for="repass">Repetir Password:</label></p>
                        <input name="repass" type="password" id="repass" class="list-group-item" placeholder="Repite contraseña"></p>
 
                    <p id="bot"><input name="submit" type="submit" id="boton" value="Registrar" class="list-group-item"/></p>
                 </div>
                </form>
           
        </div>
 
    </div>
 
</body>
 
</html>