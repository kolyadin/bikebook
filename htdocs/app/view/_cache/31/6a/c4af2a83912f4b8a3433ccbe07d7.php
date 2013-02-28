<?php

/* auth.twig */
class __TwigTemplate_316ac4af2a83912f4b8a3433ccbe07d7 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("/common/content.twig");

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'head' => array($this, 'block_head'),
            'content' => array($this, 'block_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "/common/content.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_title($context, array $blocks = array())
    {
        // line 4
        echo "    ";
        $this->displayParentBlock("title", $context, $blocks);
        echo " | Авторизация на сайте
";
    }

    // line 7
    public function block_head($context, array $blocks = array())
    {
        // line 8
        echo "    ";
        $this->displayParentBlock("head", $context, $blocks);
        echo "
";
    }

    // line 11
    public function block_content($context, array $blocks = array())
    {
        // line 12
        echo "
    ";
        // line 13
        if (((isset($context["cat"]) ? $context["cat"] : null) == "forgotPwd")) {
            // line 14
            echo "
        <script>
            \$(function(){

                \$('body').append('<span id=\"_countWidth\" style=\"position:absolute;top:-9999px;display:none;font-size:20px;\"></span>');

                var textWidth = '0px';

                \$('#input-email')
                .focus()
                .keyup(function(){
                    textWidth = \$('#_countWidth').text(\$(this).val()).width();

                    \$(this).animate({
                        width:\$(this).val().length < 8 ? '120px' : (80+Math.round(\$(this).val().length*8))+'px'
                    },100);
                })
                .focus(function(){
                    \$(this).css({'background-color':'#fff'});
                })
                .focusout(function(){
                    \$(this).css('width',parseInt(\$(this).css('width')) > 120 ? textWidth+'px' : '120px');
                    //\$(this).css({/*'text-align':'center',*/'background-color':'#b0dead'});
                });

                \$('#goButton').click(function(){

                    \$(this).attr('disabled',true).css('color','gray');

                    \$('#progressBar-pwd').show();
                    \$('#progressSummary-pwd').hide();

                    \$.getJSON('/verification/forgot-password/ajax',{'email':\$('#input-email').val()},function(data){
                        if (data.status == 'no_email')
                        {
                            \$('#progressSummary-pwd').show('fast').html('Укаказан неверный адрес, попробуйте снова.').css('color','red');
                            \$('#goButton').css('color','#000').attr('disabled',false);

                            \$('#input-email').css('background-color','#d29c9c');

                            \$('#progressBar-pwd').hide();
                        }
                        else if (data.status == 'success')
                        {
                            \$('#progressSummary-pwd').show('fast').html('... теперь проверь свой почтовый ящик!').css('color','#000');
                            \$('#progressBar-pwd').hide();
                            \$('#input-email').css('background-color','#b8dbb2');
                        }
                    });
                });
            });
        </script>

        <h1>Напомним пароль</h1>

        <p>Как же так получилось? :) Ладно, просто введи адрес своей электронной почты:
        <p><input type=\"email\" id=\"input-email\" class=\"text-middle\" style=\"width:120px;padding:3px;\" /><span id=\"progressBar-pwd\"><img src=\"/i/loader1.gif\" /></span>
        <p id=\"progressSummary-pwd\"></p>
        <p><input type=\"button\" id=\"goButton\" style=\"font-weight:bold;padding:3px 10px 3px 10px;\" value=\"отправить письмо с инструкцией\" /></p>

    ";
        } else {
            // line 75
            echo "
        <h1>Привет! Заходи!</h1>

        <p>Если ты забыл(а) пароль, <a href=\"/verification/forgot-password\">перейди по этой ссылке, поможем!</a>

        <form method=\"post\" action=\"/verification/check\">
            <p>Мыло&nbsp;<input type=\"text\" name=\"email\" class=\"text-middle\">
            <p>Пароль&nbsp;<input type=\"password\" name=\"pwd\" class=\"text-middle\">

            <p><label><input type=\"checkbox\" name=\"quickExit\" value=\"yes\" />&nbsp;Не запоминать</label>

            <p><input type=\"submit\" value=\"ok\" />
        </form>

    ";
        }
        // line 90
        echo "
";
    }

    public function getTemplateName()
    {
        return "auth.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  138 => 90,  121 => 75,  58 => 14,  56 => 13,  53 => 12,  50 => 11,  43 => 8,  40 => 7,  33 => 4,  30 => 3,);
    }
}
