var thisI = 0;

var KaElement = {
	init : function()
	{
		//Добавляем возможность прокрутки элементов с файлами
		$('.file-area').bind('mousewheel', function(event,delta) {
			var pos = $(this).scrollLeft();
			
			if (delta > 0) pos -= 60;
			else           pos += 60; 
			
			$(this).scrollLeft(pos);
			
			event.preventDefault();
		});
		
		//Добавляем возможность перетаскивания для файлов
		$('.file-area-items').sortable({
			axis : 'x',
			items : 'td',
			grid: [ 20, 0 ],
			opacity : 0.5,
			stop : function(event,ui)
			{
				
			}
		}).disableSelection();
		
		$('.fancybox').fancybox({
			openEffect  : 'elastic',
			closeEffect : 'elastic'
		});
		
	},
	add : function(type,obj) {
		
	},
	newTextElement : function(options)
	{
		if (options['type'] == 'textarea')
		{
			thisI++;
			
			var elHtml = sprintf('<p><textarea name="%s[]" id="textarea_%u">%s</textarea>'
				,options['name']
				,thisI
				,(typeof options['value'] == 'undefined') ? '' : options['value']
			);
			
			if (typeof options['obj'] == 'undefined')
			{
				document.write(elHtml);
			}
			else
			{
				$(elHtml).insertBefore(options['obj'].find('p:last'));
			}
			
			CKEDITOR.replace( 'textarea_'+thisI, {
				toolbar : 'toolbarVerySimple',
				height : '100px'
			});
		}
		else if (options['type'] == 'text')
		{
			var elHtml = sprintf('<p><input type="text" name="%s[]" class="left-text" %s %s /><input data-tooltip="Убрать" type="button" value="-" class="simple-button del-one" />'
				,options['name']
				,(typeof options['autocomplete'] == 'undefined')
					? ''
					: sprintf('data-autocomplete="%s"',options['autocomplete'])
				,(typeof options['value'] == 'undefined')
					? ''
					: sprintf('value="%s"',options['value'])
			);
			
			if (typeof options['obj'] == 'undefined')
			{
				document.write(elHtml);
			}
			else
			{
				$(elHtml).insertBefore(options['obj'].find('p:last'));
			}
		}
		
		if (typeof options['success'] != 'undefined')
		{
			options['success']();
		}
	}
};

$(function(){
	var contextArea = $('.admin-panel .content-panel');
	
	var tmpl = [];
	
	tmpl['file-element'] = 
	'<td>'+
		'<div class="file">'+
			'<input type="hidden" name="%s" value="%s" />'+
			'<div class="remove"><a href="#" onclick="removePoster(this);return false;" title="Удалить постер"><img width="15" src="https://dl.dropbox.com/u/343077/2/1354041989_Remove.png" /></a></div>'+
			'<a href="%s" class="fancybox"><img src="%s" width="100" /></a>'+
		'</div>'+
	'</td>';
	
	$('.element div[data-element-type=files]',contextArea).each(function(){
		thisI++;
		
		var filesHtml = '<div class="file-area"><table class="file-area-items"><tr></tr></table></div>';
		var localContext = $(this).find('div[data-type=image]');
		var fileContext = $(this);
		
		var boxName = $(this).data('elementName')+'[]';
		
		//Уже загруженные файлы
		if (localContext.length > 0)
		{
			$(this).prepend(filesHtml);
			
			var rowContainer = $(this).find('div.file-area tr');
			
			localContext.each(function(){
				rowContainer
				.prepend(sprintf(tmpl['file-element']
					,boxName
					,$(this).data('fileBig')
					,$(this).attr('data-file-big')
					,$(this).attr('data-file-thumb')
				))
				
				$(this).remove();
			});
		}
		
		KaElement.init();
		
		//Добавляем возможность загрузки файлов
		if (!$(this).find('div.file-area').length)
		{
			$(this).append(filesHtml);
		}
		
		$(this).append('<input type="file" multiple="true" id="file_upload_'+thisI+'">');
		
		$('#file_upload_'+thisI).uploadify({
			'queueID'  : 'file-queue',
			'buttonText'   : 'Добавить&nbsp;файлы',
			'buttonClass' : 'upload-button',
			'height' : '20',
			'formData'     : {
				'timestamp' : uploadifyTimestamp,
				'token'     : uploadifyToken
			},
			'swf'      : '/swf/uploadify.swf',
			'uploader' : '/uploadify.php',
			'onUploadSuccess' : function(file,dataJSON,response)
			{
				var json = $.parseJSON(dataJSON);
				
				$('div.file-area tr',fileContext)
				.append(sprintf(tmpl['file-element']
					,boxName
					,json['fileBig']
					,json['fileBig']
					,json['fileThumb']
				));
			},
			'onQueueComplete' : function(queueData)
			{
				KaElement.init();
			}
		});
	});
});



