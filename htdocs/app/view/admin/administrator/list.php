<!DOCTYPE html>
<html>
<head>
	<?php $_view->loadAndRender('/admin/common/head.twig'); ?>
</head>
<body>

<div id="file-queue"></div>

<div id="dialog-confirm" style="display:none;" title="Подтверждение">
    <p>Точно удалить?
</div>

<div class="admin-panel">

	<?php $_view->loadAndRender('/admin/nav-menu.php'); ?>

    <div class="content-panel" id="content-tabs">
        <ul>
            <li><a href="#tabs-1">Список</a></li>
        </ul>

        <div id="tabs-1">
            <h2>Список</h2>

			<table>
				<tr>
					<td>Имя пользователя</td>
					<td>Опции</td>
				</tr>
				<?php
				$tmpl = <<<EOL
				<tr>
					<td><a href="/admin/administrator/edit/%u">%s</a></td>
					<td><a href="#">Удалить</a></td>
				</tr>
EOL;
				foreach ($list as $row)
				{
					printf($tmpl
						,$row['id']
						,$row['username']
					);
				}
				?>
			</table>
        </div>
    </div>
    <div class="clear"></div>
</div>

<?php $_view->loadAndRender('/common/footer.php'); ?>
</body>
</html>