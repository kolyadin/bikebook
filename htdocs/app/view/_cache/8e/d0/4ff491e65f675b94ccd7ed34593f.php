<?php

/* index_page.twig */
class __TwigTemplate_8ed04ff491e65f675b94ccd7ed34593f extends Twig_Template
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
        echo " | Новости
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
    <p>В данном варианте я хочу многое вам сказать

    <p>Блок меню</p>
    <ul>
        <li><a href=\"/man/";
        // line 17
        echo $this->getAttribute($this->getAttribute((isset($context["user"]) ? $context["user"] : null), "data"), "id");
        echo "/garage\">Гараж</a></li>
        <li><a href=\"/settings\">Настройки сайта</a></li>
    </ul>

    ";
        // line 21
        echo (isset($context["foto"]) ? $context["foto"] : null);
        echo "

    <p>Клиберн скончался в возрасте 78 лет, он страдал раком костей. По словам пресс-секретаря, пианист умер в окружении родных и друзей.
    <p>Международная карьера Клиберна началась в 1958 году, когда в возрасте 23 лет он победил на конкурсе имени П.И.Чайковского в Москве. Согласно некоторым источникам, отмечает АР, советский руководитель Никита Хрущев лично разрешил дать первую премию американцу, несмотря на напряженные отношения между СССР и США.
    <p>Клиберн прекратил гастролировать в 1978 году,. В 1987 году он сыграл на приеме в Белом доме в Вашингтоне по случаю исторического визита в США генерального секретаря ЦК КПСС Михаила Горбачева. После этого музыкант возобновил выступления.
    <p>В Форт-Ворте, напоминает агентство, с 1962 года проходит Международный музыкальный конкурс имени Вана Клиберна. Состязания профессиональных музыкантов и любителей проводятся раз в четыре года.



";
    }

    public function getTemplateName()
    {
        return "index_page.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 21,  60 => 17,  53 => 12,  50 => 11,  43 => 8,  40 => 7,  33 => 4,  30 => 3,);
    }
}
