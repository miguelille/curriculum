<?php

    $info = $datos[0];
   
    echo "<form action='index.php'>"
    . "Nombre: <input type='text' name='nombreal' value='".$info['nombreal']."'><br>"
            . "Apellidos: <input type='text' name='apellido' value='".$info['apellido']."'><br>"
            . "Telefono: <input type='text' name='telefono' value='".$info['telefono']."'><br>"
            . "Email: <input type='text' name='correo' value='".$info['correo']."'><br>"
            . "Direccion: <input type='text' name='direccion' value='".$info['direccion']."'><br>"
            . "Localidad: <input type='text' name='localidad' value='".$info['localidad']."'><br>"
            . "Provincia: <input type='text' name='provincia' value='".$info['provincia']."'><br>"
            . "DNI: <input type='text' name='dni' value='".$info['dni']."'><br>";
    
    if($info["activo"]==0){
        echo "Si <input type='radio' name='activo' value='1'>"
        . "No <input type='radio' name='activo' value='0' checked>";
    }else{
        echo "Si <input type='radio' name='activo' value='1' checked>"
        . "No <input type='radio' name='activo' value='0'>";
    }
    echo "<input type='hidden' name='accion' value='cambiarInfo'>"
        . "<input type='hidden' name='id' value='".$info['alumnoid']."'>"
        . "<input type='submit' value='Modificar'>"
        . "</form>";