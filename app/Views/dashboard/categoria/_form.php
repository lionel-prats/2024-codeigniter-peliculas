<?php 
    // bloque para que no rompa el form de edicion por errores de validacion
    $titulo = "";
    if(isset($categoria) && isset($categoria->titulo)) {
        $titulo = $categoria->titulo;
    }    
    // fin bloque
?>
<div class="mb-3">
    <label for="titulo" class="form-label">Título</label>
    <input 
        type="text" name="titulo" id="titulo" 
        value="<?php echo old("titulo", $titulo); ?>"
        class="form-control"
    >
</div>
<input type="submit" value="<?php echo $op; ?>" class="btn btn-success"> 