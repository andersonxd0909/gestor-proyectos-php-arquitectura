<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ARCHIVO.ARCH</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div class="logo">ARCHIVO.ARCH</div>
        <div>
            <a href="index.php" style="text-decoration:none; color:black; margin-right:15px;">Todos</a>
            <a href="admin.php" style="text-decoration:none; color:gray; font-size:14px;">Admin</a>
        </div>
    </nav>

    <div class="grid">
        <?php
        $res = $db->query("SELECT * FROM proyectos ORDER BY id DESC");
        while($p = $res->fetch_assoc()): ?>
            <div class="project">
                <?php if(!empty($p['url_externa'])): ?>
                    <a href="<?php echo $p['url_externa']; ?>" target="_blank">
                <?php endif; ?>
                
                <div class="img-box"><img src="uploads/<?php echo $p['imagen_url']; ?>"></div>
                
                <?php if(!empty($p['url_externa'])): ?>
                    </a>
                <?php endif; ?>

                <h3><?php echo $p['titulo']; ?></h3>
                <p><?php echo $p['categoria']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>