<title><?php print $_view->title; ?></title>

<link rel="stylesheet" href="/css/base.css" type="text/css" />

<link rel="stylesheet" href="/css/jquery-ui-themes/cupertino/jquery-ui.css" type="text/css" />

<?php
$_view
->js()
->useStatic()
->compress()
->deploy(array(
	 array('/js/jquery-1.8.3.min.js')
	,array('/js/jquery-ui-1.9.2.min.js')
	,array('/js/jquery.ui.datepicker-ru.js')
	,array('/js/jquery.fancybox.js')
	,array('/js/jquery.mousewheel.js')
	,array('/js/jquery.uploadify.min.js')
	,array('/js/jquery.filter_input.js')
	,array('/js/ckeditor/ckeditor.js')
	,array('/js/sprintf.js')
	,array('/js/admin.js')
	,array('/js/kaelement.js')
));
?>

<script type="text/javascript">
	<?php $timestamp = microtime(1);?>

    var uploadifyTimestamp = '<?php print $timestamp; ?>';
    var uploadifyToken = '<?php print md5($timestamp); ?>';

    $(function(){
        $('input[type=submit]').button();
        $('#content-tabs').tabs();
        $('.nav-panel').accordion({heightStyle: "content",active:2});

        $('input[name=mobile_number]').filter_input({regex:'[0-9]'});
    });
</script>