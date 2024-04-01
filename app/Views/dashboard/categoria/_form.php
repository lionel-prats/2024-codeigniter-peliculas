<?php 

    // bloque para que no rompa el form de edicion por errores de validacion
    $titulo = "";
    if(isset($categoria) && isset($categoria->titulo)) {
        $titulo = $categoria->titulo;
    }    
    // fin bloque
?>
<label for="titulo">Título</label>
<input 
    type="text" name="titulo" id="titulo" 
    value="<?php echo old("titulo", $titulo); ?>"
>
<br>
<br>
<input type="submit" value="<?php echo $op; ?>" 