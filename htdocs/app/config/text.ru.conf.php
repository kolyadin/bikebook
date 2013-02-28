<?php
$text = array();

$text['emailMessageAfterRegister'] = <<<'EOL'
<p>Спасибо, что зарегистрировались у нас, вы не пожелаете.
<p>Пожалуйста, перейдите по ссылке ниже, чтобы мы подтвердили ваши регистрационные данные:

<p>http://bikebook.loc/new-biker/email-confirm/%s
EOL;

return $text;
