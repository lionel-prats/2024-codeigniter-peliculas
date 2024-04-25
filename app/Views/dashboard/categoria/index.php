<?php echo $this->extend("Layouts/dashboard"); ?>

<?php echo $this->section("contenido"); ?>
    <a href="<?php echo base_url("/dashboard/categoria/new"); ?>" 
        class="btn btn-success mb-3"
    >New</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categorias as $categoria): ?>
                <tr>
                    <td><?php echo $categoria->id; ?></td>
                    <td><?php echo $categoria->titulo; ?></td>
                    <td>
                        <a 
                            href="/dashboard/categoria/show/<?php echo $categoria->id; ?>"
                            class="btn btn-warning btn-sm"    
                        >Show</a>
                        <a 
                            href="/dashboard/categoria/edit/<?php echo $categoria->id; ?>"
                            class="btn btn-primary btn-sm"    
                        >Edit</a>
                        <form action="/dashboard/categoria/delete/<?php echo $categoria->id; ?>" method="POST">
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
    <?php if(session("ip") && session("ip2") && session("session_key")): ?>
        <br>
        <code>Variable de sesion $ip == <?php echo session("ip"); ?></code>
        <br>
        <code>Variable de sesion $ip2 == <?php echo session()->get("ip2"); ?></code>
        <br>
        <code>Variable de sesion $session_key["origin"] == <?php echo session()->get("session_key")["origin"]; ?></code>
        <br>
        <code>Variable de sesion $session_key["owner"] == <?php echo session()->get("session_key")["owner"]; ?></code>
        <br>
        <code>Variable de sesion $session_key["shadow_pass"] == <?php echo session()->get("session_key")["shadow_pass"]; ?></code>
        <br>
        <a href="<?php echo route_to("pelicula.destruir-session", 15, 38); ?>">Destruir datos de sesión</a>
    <?php endif ?>
    <br>
    <form action="<?php echo route_to("usuario.logout"); ?>" method="POST">
        <input type="submit" value="Cerrar Sesión" class="btn btn-primary">    
    </form>
<?php echo $this->endSection(); ?>