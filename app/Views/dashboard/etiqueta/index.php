<?php echo $this->extend("Layouts/dashboard"); ?>
<?php echo $this->section("contenido"); ?>
    <a href="<?php echo base_url("/dashboard/etiqueta/new"); ?>" 
        class="btn btn-success mb-3"
    >New</a>
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
                        <a 
                            href="/dashboard/etiqueta/show/<?php echo $etiqueta->id; ?>"
                            class="btn btn-warning btn-sm"
                        >Detail</a>                        
                        <a 
                            href="/dashboard/etiqueta/edit/<?php echo $etiqueta->id; ?>"
                            class="btn btn-primary btn-sm"    
                        >Edit</a>
                        <form action="/dashboard/etiqueta/delete/<?php echo $etiqueta->id; ?>" method="POST">
                            <input 
                                type="submit" value="Delete"
                                class="btn btn-danger btn-sm mt-1"    
                            >
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <?php echo $pager->links(); ?>
<?php echo $this->endSection(); ?>