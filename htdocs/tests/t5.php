<?php
xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);

print 123;

$xhprof_data = xhprof_disable();

echo '<pre>'.print_r($xhprof_data,1).'</pre>';
