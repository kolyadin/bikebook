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
            <li><a href="#tabs-1">Новый администратор</a></li>
        </ul>

        <div id="tabs-1">
            <h2>Добавление нового администратора</h2>

            <form method="post" enctype="multipart/form-data" action="/admin/administrator/new" id="content-form">
                <div class="element">
                    <p class="title">Имя пользователя:</p>
                    <p><input name="username" class="simple-text" value="<?php print @htmlspecialchars($_POST['username']); ?>" />
                </div>

                <div class="element">
                    <p class="title">Пароль:</p>
                    <p><input type="password" name="pwd" class="simple-text" value="<?php print @htmlspecialchars($_POST['pwd']); ?>" />
                </div>

                <div class="element">
                    <p class="title">Повторите пароль:</p>
                    <p><input type="password" name="pwd2" class="simple-text" value="<?php print @htmlspecialchars($_POST['pwd2']); ?>" />
                </div>

				<div class="element">
                    <p class="title">Номер мобильного телефона:</p>
                    <p class="hint" title="Подсказка">Пример (79111881250)
                    <p><input name="mobile_number" class="simple-text" value="<?php print @htmlspecialchars($_POST['mobile_number']); ?>" />
                </div>

				<?php if (isset($verifyMobile)) { ?>

                <div class="element">
                    <p class="title">На ваш номер отправлено смс с кодом. Введите его в это поле:</p>
                    <p><input name="verify_code" class="small-int" /></p>
                </div>

				<?php } ?>

                <input type="submit" value="Сохранить" />
            </form>
        </div>
    </div>
    <div class="clear"></div>
</div>

<?php $_view->loadAndRender('/common/footer.php'); ?>
</body>
</html>