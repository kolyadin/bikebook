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
				
			$('input[name=release_date]').datepicker({
				changeYear : true
			});
			
			$('input.new-one').each(function(){
				$(this).click(function(){
					var elButton = $(this);
					var elType = $(this).attr('data-type');
					
					if (elType == 'textarea')
					{
						KaElement.newTextElement({
							name : $(this).attr('data-new-name'),
							type : 'textarea',
							obj : $(this).parents('fieldset'),
							success : function()
							{
								
							}
						});
					}
					else if (elType == 'text')
					{
						var lastEl = elButton.parent().parent().find('input[type=text]:last');
						
						if (lastEl.val() == '')
						{
							$('#dialog-confirm')
							.html('<p>Понимаешь, нельзя создать новое поле, раз это еще пустое :)')
							.dialog({
								resizable: false,
								draggable: false,
								height:270,
								width:450,
								modal: true,
								buttons: {
									'Нет, не понимаю' : function() {
										document.location.href = 'http://youtu.be/Yf2TG0eshvY';
									},
									'Оке, понимаю :)': function() {
										$(this).dialog( "close" );
										lastEl.focus();
									}
								}
							});
						}
						else
						{
							KaElement.newTextElement({
								name : $(this).attr('data-new-name'),
								autocomplete : $(this).attr('data-new-autocomplete'),
								obj : $(this).parents('fieldset'),
								type : 'text',
								success : function()
								{
									doBind();
									
									elButton.parent().parent().find('input[type=text]:last').focus();
								}
							});
						}
					}
				});
			});
			
			/*
			$('input[data-label]').each(function(){
				if (!$(this).val().length)
				{
					$(this)
					.css('color','#ccc')
					.val($(this).data('label'))
					.on('click',function(){
						if ($(this).val() == $(this).data('label'))
						{
							$(this).css('color','#000').val('');
						}
					})
					.focusout(function(){
						if (!$(this).val().length)
						{
							$(this).css('color','#ccc').val($(this).data('label'));
						}
						else if ($(this).val() != $(this).data('label'))
						{
							$(this).css('color','#000');
						}
					})
				}
			});
			*/
			
			$('#content-form').submit(function(){
				//alert(123);
				//return false;
			});
			
			doBind();
		});
		
		function doBind()
		{
			$('input.del-one').click(function(){
				
				$(this).parent().remove();
			});
			
			$(document).tooltip({
				track : true,
				tooltipClass : 'admin-tooltip',
				content : function(){ return $(this).attr('data-tooltip'); },
				items : '*[data-tooltip]'
			});
			
			$('input[type=button]').button();
			//$('input[type=checkbox]').button();
			$('input[type=submit]').button();
			
			$('fieldset p').sortable();
			
			$('input[data-autocomplete]').each(function(){
				$(this)
				.autocomplete({
					source : '/admin/remote/?filter='+$(this).attr('data-autocomplete'),
					select : function(event,ui)
					{
						$('<input type="hidden" name="'+$(this).attr('name')+'" value="'+ui.item.id+'" />').insertBefore($(this));
						$(this).attr('disabled',true);
						
					},
					focus : function(event,ui)
					{
						//alert(ui.item.pic);
					}
				})
				.data('autocomplete')._renderItem = function( ul, item ) {
					return $('<li>')
					.data('item.autocomplete',item)
					.append(sprintf('<a style="cursor:pointer;" title="%s"><div style="vertical-align:top;"><img src="%s" class="fl" /><div style="padding:5px 0 0 7px;" class="fl">%s</div></div><div class="clear"></div></a>'
						,item.value
						,item.pic
						,item.value
					))
					.appendTo(ul);
				};
			});
		}
		</script>
	</head>
	<body>
		
		<div id="file-queue"></div>
		
		<div id="dialog-confirm" style="display:none;" title="Подтверждение">
			<p>Точно удалить?
		</div>
		
		<p>Привет, %admin-name%</p>
        <p>Вы вошли через небезопасную зону.</p>
		
		<div class="admin-panel">
		
			<?php $_view->loadAndRender('/admin/nav-menu.php'); ?>
			
			<div class="content-panel" id="content-tabs">
				<ul>
					<li><a href="#tabs-1">Основная информация</a></li>
					<li><a href="#tabs-2">Расписание</a></li>
					<li><a href="#tabs-3">Опции</a></li>
				</ul>
				
				<div id="tabs-1">
					<h2>Добавление нового фильма</h2>
					
					<form method="post" enctype="multipart/form-data" action="/admin/movies/edit/" id="content-form">
						<div class="element">
							<p class="title">Название фильма:</p>
							<p><input name="title" class="simple-text" />
						</div>
						
						<div class="element">
							<p class="title">Оригинальное название фильма:</p>
							<p><input name="original_title" class="simple-text" />
						</div>
						
						<div class="element">
							<p class="title">Страна производитель:</p>
							<p><input name="production_country" class="simple-text" data-autocomplete="{ka_goods|title|cat_id=123}" />
						</div>
						
						<div class="element">
							<div class="fl w1_4">
								<p class="title">Год выпуска:</p>
								<p><input name="production_year" class="small-int" />
							</div>
							<div class="fl w1_4">
								<p class="title">Продолжительность:</p>
								<p><input name="duration" class="small-int" data-tooltip="Продолжительность необходимо указывать в минутах" />
							</div>
							<div class="fl w1_4">
								<p class="title">Ограничение возраста:</p>
								
								<p><select name="age_limit">
									<option value="">-</option>
									<option value="0+">0+</option>
									<option value="6+">6+</option>
									<option value="12+">12+</option>
									<option value="14+">14+</option>
									<option value="16+">16+</option>
									<option value="18+" selected="true">18+</option>
								</select>
							</div>
							<div class="fl w1_4">
								<p class="title">Дата премьеры РФ:</p>
								<p><input name="release_date" class="simple-text" />
							</div>
							<div class="clear"></div>
						</div>
						
						<div class="element">
							<fieldset class="element"><legend>Опции:</legend>
								<div class="fl">
									<p data-tooltip="Получал ли фильм &quot;Оскара&quot;?"><input type="checkbox" name="oskar" id="field-oskar" /><label for="field-oskar">Оскар</label>
									<p data-tooltip="Если выберите, этот фильм появится на детской киноафиши"><input type="checkbox" name="kids" id="field-kids" /><label for="field-kids">Детское кино</label>
									<p data-tooltip="Запретить обсуждение фильма"><input type="checkbox" name="deny_talk" id="field-deny_talk" /><label for="field-deny_talk">Запретить обсуждение</label>
								</div>
								<div class="clear"></div>
							</fieldset>
						</div>
						
						<fieldset class="element"><legend>Постеры:</legend>
							<p class="hint" title="Подсказка">Первый постер и будет основным на сайте
							<p class="hint" title="Подсказка">Постеры можно "перетягивать" для установки приоритета
							<p class="hint" title="Подсказка">Постеры можно листать колесиком мыши
							<div class="file-area-bg" data-element-type="files" data-element-name="poster">
								<!--
								<div data-id="1" data-type="image" data-file-big="/upload/1354563470.7888.jpg" data-file-thumb="/k/r/100x100/upload/1354563470.7888.jpg"></div>
								<div data-id="1" data-type="image" data-file-big="/upload/1354563470.7888.jpg" data-file-thumb="/k/r/100x100/upload/1354563470.7888.jpg"></div>
								<div data-id="1" data-type="image" data-file-big="/upload/1354563470.7888.jpg" data-file-thumb="/k/r/100x100/upload/1354563470.7888.jpg"></div>
								-->
							</div>
						</fieldset>
						
						<fieldset class="element"><legend>Кадры:</legend>
							<p class="hint" title="Подсказка">Если фильм популярный, первый кадр будет на главной странице
							<p class="hint" title="Подсказка">Кадры можно "перетягивать" для установки приоритета
							<p class="hint" title="Подсказка">Кадры можно листать колесиком мыши
							<div class="file-area-bg" data-element-type="files" data-element-name="shot">
							</div>
						</fieldset>
						
						<fieldset class="element"><legend>Жанр:</legend>
							<script>
							//KaElement.newTextElement({name:'genre',autocomplete:'{ka_person|title}',value:'Привет',success : function(){ doBind(); }});
							</script>
							<p><input type="button" value="+" class="simple-button new-one" data-type="text" data-new-name="genre" data-new-autocomplete="{ka_person|title}" data-tooltip="Нажмите, чтобы добавить еще один жанр" />
						</fieldset>
						
						<fieldset class="element"><legend>Режиссер:</legend>
							<p><input type="button" value="+" class="simple-button new-one" data-type="text" data-tooltip="Нажмите, чтобы добавить еще одного режиссера" />
						</fieldset>
						
						<fieldset class="element"><legend><label>Актеры <input type="radio" name="actor_type" value="actor" checked="true" /></label>&nbsp;/&nbsp;<label>Озвучка <input type="radio" name="actor_type" value="voice" /></label></legend>
							<p><input type="button" value="+" class="simple-button new-one" data-type="text" data-new-name="actor" data-new-autocomplete="{ka_person|title}" data-tooltip="Нажмите, чтобы добавить еще одного актера" />
						</fieldset>
						
						<div class="element">
							<p class="title">Описание:</p>
							<p><textarea name="description" class="simple-textarea" id="editor1"></textarea>
						</div>
						
						<fieldset class="element"><legend>Интересные факты:</legend>
							<p><input type="button" value="+" class="simple-button new-one" data-type="textarea" data-new-name="fact" data-tooltip="Нажмите, чтобы добавить еще один факт" />
						</fieldset>
						
						
						<input type="submit" value="Сохранить" />
					</form>
				</div>
				<div id="tabs-2"></div>
				<div id="tabs-3"></div>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php $_view->loadAndRender('/common/footer.php'); ?>
	</body>
</html>