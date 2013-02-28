<?php

/* register.twig */
class __TwigTemplate_fef543fa97116080464c455c273d3867 extends Twig_Template
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
        echo " | Регистрация на сайте
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
    <form method=\"post\" action=\"/new-biker/check\">

        <p>Мыло&nbsp;<input type=\"text\" name=\"reg-email\">
        <p>Пароль&nbsp;<input type=\"password\" name=\"reg-pwd\">

        <p>Пол<br/>
            Мужской&nbsp;<input type=\"radio\" name=\"reg-sex\" value=\"man\" checked />
            Женский&nbsp;<input type=\"radio\" name=\"reg-sex\" value=\"woman\" />

        <p><input type=\"submit\" value=\"ok\" />
    </form>

";
    }

    public function getTemplateName()
    {
        return "register.twig";
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
