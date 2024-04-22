<?php echo $this->extend("Layouts/dashboard"); ?>
<?php echo $this->section("contenido"); ?>
    <div class="flex justify-content-between w-45">
        <a href="/dashboard/etiqueta/new">New</a>
        <!-- <div>
            <a href="/" class="pr-2">Home</a>
            <a href="/dashboard/categoria">Categorías</a>
        </div> -->
    </div>
    <br>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoría_id</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($etiquetas as $etiqueta): ?>
                <tr>
                    <td><?php echo $etiqueta->id; ?></td>
                    <td><?php echo $etiqueta->titulo; ?></td>
                    <td><?php echo $etiqueta->categoria_id; ?></td>
                    <td>
                        <a href="/dashboard/etiqueta/show/<?php echo $etiqueta->id; ?>">Detail</a>                        
                        <a href="/dashboard/etiqueta/edit/<?php echo $etiqueta->id; ?>">Edit</a>
                        <form action="/dashboard/etiqueta/delete/<?php echo $etiqueta->id; ?>" method="POST">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php echo $pager->links(); ?>
<?php echo $this->endSection(); ?>