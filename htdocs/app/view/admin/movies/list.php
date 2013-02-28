<!DOCTYPE html>
<html>
	<head>
		<?php $_view->loadAndRender('/common/head.twig'); ?>
		
		<link rel="stylesheet" href="/css/base.css" type="text/css" />
		
		<link rel="stylesheet" href="/css/jquery-ui-themes/cupertino/jquery-ui.css" type="text/css" />
		
		<script type="text/javascript" src="http://yandex.st/jquery/1.8.3/jquery.min.js"></script>
		<script type="text/javascript" src="http://yandex.st/jquery-ui/1.9.2/jquery-ui.min.js"></script>
		<script type="text/javascript" src="/js/jquery.ui.datepicker-ru.js"></script>
		
		
		<script type="text/javascript" src="/js/jquery.fancybox.js"></script>
		<script type="text/javascript" src="/js/jquery.mousewheel.js"></script>
		<script type="text/javascript" src="/js/jquery.uploadify.min.js"></script>
		
		<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
		
		<script type="text/javascript">
		<?php $timestamp = microtime(1);?>
		
		var uploadifyTimestamp = '<?php print $timestamp; ?>';
		var uploadifyToken = '<?php print md5($timestamp); ?>';
		
		</script>
		<script type="text/javascript" src="/js/sprintf.js"></script>
		<script type="text/javascript" src="/js/admin.js"></script>
		<script type="text/javascript" src="/js/kaelement.js"></script>
		
		<script type="text/javascript">
		$(function(){
			$('#content-tabs').tabs();
			$('.nav-panel').accordion({heightStyle: "content"});
		});
		</script>
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
					<li><a href="#tabs-1">По алфавиту</a></li>
					<li><a href="#tabs-2">Поиск</a></li>
					<li><a href="#tabs-3">Опции</a></li>
				</ul>
				
				<div id="tabs-1">
					<h2>Список фильмов</h2>
					
					<table>
						<tr>
							<td>ID</td>
							<td>Фильм</td>
							<td>Оригинальное название</td>
							<td>Год выпуска</td>
							<td>Страна-производитель</td>
						</tr>
					<?php
					$tmpl = <<<EOL
					<tr>
						<td>%u</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
						<td>%s</td>
					</tr>
EOL;
					foreach ($list as $row)
					{
						printf($tmpl
							,$row['id']
							,$row['title']
							,$row['original_title']
							,$row['production_year']
							,$row['production_country']
						);
					}
					?>
					</table>
				</div>
				<div id="tabs-2"></div>
				<div id="tabs-3"></div>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php $_view->loadAndRender('/common/footer.php'); ?>
	</body>
</html>
