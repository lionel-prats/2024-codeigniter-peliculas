<?php echo $this->extend("Layouts/dashboard"); ?>

<?php echo $this->section("contenido"); ?>
    <form method="POST">
        <label for="">Categorías</label>
        <select name="categoria_id" id="categoria_id">
            <option value="">Seleccione una categoría</option>
            <?php foreach($categorias as $categoria): ?>
                <option 
                    value="<?php echo $categoria->id; ?>"
                    <?php echo $categoria_id == $categoria->id ? "selected" : ""; ?> 
                >
                    <?php echo $categoria->titulo; ?>
                </option>
            <?php endforeach ?>
        </select>
        <br>
        <br>
        <label for="">Etiquetas</label>
        <select name="etiqueta_id" id="etiqueta_id">
            <option value="">Seleccione una etiqueta</option>
            <?php foreach($etiquetas as $etiqueta): ?>
                <option value="<?php echo $etiqueta->id; ?>">
                    <?php echo $etiqueta->titulo; ?>
                </option>
            <?php endforeach ?>
        </select>
        <br>
        <br>
        <input type="submit" id="send" value="Enviar">
    </form>
    <br>
    <a href="/dashboard/pelicula">Volver</a>
    <script>
        function disableEnableButton() {
            if(document.querySelector("[name=etiqueta_id]").value == ""){
                document.getElementById("send").setAttribute("disabled", "disabled")
            } else {
                document.getElementById("send").removeAttribute("disabled")
            }
        }
        disableEnableButton()
        document.querySelector("[name=etiqueta_id]").onchange = function(event) {
            disableEnableButton()
        }
        // peticion GET a /dashboard/pelicula/etiquetas/3?categoria_id=$id_categoria_seleccionada desde JavaScript (v111)
        document.querySelector("[name=categoria_id]").onchange = function(event) {
            window.location.href = "<?php echo route_to("pelicula.etiquetas", $pelicula->id); ?>?categoria_id="+this.value
        }
    </script>
<?php echo $this->endSection(); ?>