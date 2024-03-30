<?php echo $this->extend("Layouts/dashboard"); ?>

<?php echo $this->section("contenido"); ?>
    <div class="flex justify-content-between w-45">
        <a href="/dashboard/categoria/new">New</a>
        <div>
            <a href="/" class="pr-2">Home</a>
            <a href="/dashboard/pelicula">Películas</a>
        </div>
    </div>
    <br>
    <br>
    <table border="1" cellspacing="0" cellpadding="10">
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
                    <td><?php echo $categoria["id"]; ?></td>
                    <td><?php echo $categoria["titulo"]; ?></td>
                    <td>
                        <a href="/dashboard/categoria/show/<?php echo $categoria["id"]; ?>">Detail</a>
                        <br>
                        <a href="/dashboard/categoria/edit/<?php echo $categoria["id"]; ?>">Edit</a>
                        <form action="/dashboard/categoria/delete/<?php echo $categoria["id"]; ?>" method="POST">
                            <input type="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
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
<?php echo $this->endSection(); ?>