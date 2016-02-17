<html>
<head>
    <title>Formulario</title>
    <meta charset="utf-8">
    <link type="text/css" href="./../css/style.css" rel="stylesheet" />
</head>
 
<body>
    <div style="color:red;"><b><?=$error?></b></div>
<form style="border:solid 2px; " action="VerificaLogin" method="post" >
                <div style="margin-left:30px; padding:3px,3px,3px,3px;">
                    
                    <label for="user">Nombre de usuario:</label>
                    <input name="user" type="text" id="user" class="list-group-item" >
                    
                    <p><label for="cont">Contraseña:</label></p>
                        <input name="cont" type="password" id="cont" class="list-group-item"/></p>
                <p id="bot">
                    <input name="submit" type="submit" id="boton" value="Aceptar" class="list-group-item"/></p>
                 </div>
</form>
</body>