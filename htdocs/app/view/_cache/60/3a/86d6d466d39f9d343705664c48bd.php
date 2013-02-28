<?php

/* auth.twig */
class __TwigTemplate_603a86d6d466d39f9d343705664c48bd extends Twig_Template
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
    <form method=\"post\" action=\"/auth/check\">
        <p>Мыло&nbsp;<input type=\"text\" name=\"email\">
        <p>Пароль&nbsp;<input type=\"password\" name=\"pwd\">

        <p><label><input type=\"checkbox\" name=\"quickExit\" value=\"yes\" />&nbsp;Не запоминать</label>

        <p><input type=\"submit\" value=\"ok\" />
    </form>

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
        return array (  53 => 12,  50 => 11,  43 => 8,  40 => 7,  33 => 4,  30 => 3,);
    }
}
