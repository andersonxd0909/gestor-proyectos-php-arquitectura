<?php
session_start();
include 'db.php';

$pass_maestra =  "Cambiame123.";

if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); exit; }

if (!isset($_SESSION['auth'])) {
    if (isset($_POST['clave']) && $_POST['clave'] === $pass_maestra) {
        $_SESSION['auth'] = true;
    } else {
        die('
        <link rel="stylesheet" href="style.css">
        <div class="admin-container">
            <div class="admin-box" style="margin-top:100px; text-align:center;">
                <h2>🔒 Acceso Privado</h2>
                <form method="POST">
                    <input type="password" name="clave" placeholder="Contraseña" required>
                    <button type="submit">ENTRAR AL PANEL</button>
                </form>
            </div>
        </div>');
    }
}

if (isset($_GET['borrar'])) {
    $id = $_GET['borrar'];
    $db->query("DELETE FROM proyectos WHERE id = $id");
    header("Location: admin.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $titulo = $db->real_escape_string($_POST['titulo']);
    $cat = $db->real_escape_string($_POST['cat']);
    $url = $db->real_escape_string($_POST['url_ext']); // Captura la URL
    $img = time() . "_" . $_FILES['foto']['name'];
    
    if (move_uploaded_file($_FILES['foto']['tmp_name'], "uploads/".$img)) {
        // Insertamos también la URL
        $db->query("INSERT INTO proyectos (titulo, categoria, imagen_url, url_externa) VALUES ('$titulo', '$cat', '$img', '$url')");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Admin - ARCHIVO.ARCH</title>
</head>
<body>
    <div class="admin-container">
        <div class="admin-box">
            <div style="display:flex; justify-content:space-between;">
                <span style="font-weight:bold;">Panel de Gestión</span>
                <a href="admin.php?logout=1" style="color:red; font-size:12px;">Cerrar Sesión</a>
            </div>
            <a href="index.php" style="font-size:12px;">← Volver a la web</a>
            <hr style="margin:20px 0; border:0; border-top:1px solid #eee;">

            <form method="POST" enctype="multipart/form-data">
                <label>Nombre del proyecto:</label>
                <input type="text" name="titulo" placeholder="Ej: Casa de Vidrio" required>
                
                <label>Categoría:</label>
                <input type="text" name="cat" placeholder="Ej: Vivienda" required>
                
                <label>Link externo (Opcional):</label>
                <input type="url" name="url_ext" placeholder="https://ejemplo.com">
                
                <label>Imagen:</label>
                <input type="file" name="foto" required>
                
                <button type="submit">PUBLICAR PROYECTO</button>
            </form>

            <h3 style="margin-top:30px;">Proyectos actuales</h3>
            <table>
                <?php
                $res = $db->query("SELECT * FROM proyectos ORDER BY id DESC");
                while($r = $res->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $r['titulo']; ?></td>
                    <td style="text-align:right;">
                        <a href="admin.php?borrar=<?php echo $r['id']; ?>" class="btn-borrar" onclick="return confirm('¿Borrar?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>