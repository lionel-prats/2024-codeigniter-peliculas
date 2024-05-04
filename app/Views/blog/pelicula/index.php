<?php echo $this->extend("Layouts/blog"); ?>
<?php echo $this->section("contenido"); ?>
    <h1><?php echo $titulo_vista; ?></h1>
    <hr>
    <div class="card my-3 text-bg-primary">
        <div class="card-body">
            <form method="GET">
                <div class="d-flex gap-2 mb-2">
                    <select name="categoria_id" class="form-control flex-grow-1">
                        <option value="">Todas las categorías</option>
                        <?php foreach($categorias as $categoria): ?>
                            <option 
                                value="<?php echo $categoria->id; ?>"
                                <?php echo $old_categoria_id == $categoria->id ? "selected" : ""; ?> 
                            ><?php echo $categoria->titulo; ?></option>
                        <?php endforeach ?>
                    </select>
                    <select name="etiqueta_id" class="form-control">
                        <option value="">Todas las etiquetas</option>
                        <?php foreach($etiquetas as $etiqueta): ?>
                            <option 
                                value="<?php echo $etiqueta->id; ?>"
                                <?php echo $old_etiqueta_id == $etiqueta->id ? "selected" : ""; ?> 
                            ><?php echo $etiqueta->titulo; ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="d-flex gap-2">
                    <input 
                        type="text" name="buscar" class="form-control w-75 flex-grow-1" placeholder="Buscar..."
                        value="<?php echo $old_buscar ? $old_buscar : ""; ?>"
                    >
                    <div>
                        <input type="submit" value="Enviar" class="btn btn-secondary" id="send">
                        <a 
                            class="btn btn-success"
                            href="<?php echo base_url("blog"); ?>"
                        >Limpiar Filtro</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php echo view(
                    "partials/_peliculas", 
                    ["desde" => "\"/Views/blog/pelicula/index.php\" (v162)"]
                ); 
    ?>
    
    <script>
        function disableEnableButton() {
            if(!select_categoria && !select_etiqueta && !input_buscar) {
                document.getElementById("send").setAttribute("disabled", "disabled")
            } else {
                document.getElementById("send").removeAttribute("disabled")
            }
        }
        function cargarEtiquetas(){
            fetch(`/blog/etiquetas_por_categoria/${document.querySelector("[name=categoria_id]").value}`)
                .then(res => res.json())  
                .then(res => { 
                    let html = "<option value=\"\">Etiqueta</option>"
                    res.forEach(etiqueta => {
                        html += `<option value=${etiqueta.id}>${etiqueta.titulo}</option>`
                    });
                    document.querySelector("[name=etiqueta_id]").innerHTML = html
                })
        }
        let select_categoria = document.querySelector("[name=categoria_id]").value
        let select_etiqueta = document.querySelector("[name=etiqueta_id]").value
        let input_buscar = document.querySelector("[name=buscar]").value
        disableEnableButton()
        document.querySelector("[name=buscar]").addEventListener("input", () => {
            input_buscar = document.querySelector("[name=buscar]").value
            disableEnableButton()
        })
        // forma #1 de escuchar por un change en un <select> para peticion fetch
        document.querySelector("[name=categoria_id]").addEventListener("change", () => {
            select_categoria = document.querySelector("[name=categoria_id]").value
            disableEnableButton()
            if(select_categoria != "") cargarEtiquetas()
            // select_categoria != "" ? cargarEtiquetas() : ""
        })
        
        // forma #2 de escuchar por un change en un <select> para peticion fetch
        // document.querySelector("[name=categoria_id]").addEventListener("change", cargarEtiquetas)

        // forma #3 de escuchar por un change en un <select> para peticion fetch 
        /* document.querySelector("[name=categoria_id]").onchange = function(event) {
            fetch(`/blog/etiquetas_por_categoria/${document.querySelector("[name=categoria_id]").value}`)
                .then(res => res.json())  
                .then(res => { console.log(res); })
        } */

        // forma #4 de escuchar por un change en un <select> para peticion fetch
        /* document.querySelector("[name=categoria_id]").addEventListener("change", () => {
            fetch(`/blog/etiquetas_por_categoria/${document.querySelector("[name=categoria_id]").value}`)
                .then(res => res.json())  
                .then(res => { console.log(res); })
        }) */
    </script>
<?php echo $this->endSection(); ?>