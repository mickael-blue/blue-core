<?php

namespace BlueBase;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;
use Tools;

class AppPage
{

    public $action;

    public function __construct()
    {
        Tools::init();
        $this->action = (isset($_GET['action']) ? $_GET['action'] : 'default');
    }

    private function getStylePage()
    {
        $url = ROOT_DIR . 'src/scss/' . $this->action . '.scss';
        if (file_exists($url)) {
            return $this->action;
        } else {
            return 'app';
        }
    }

    private function getJsPage()
    {
        $url = ROOT_DIR . 'src/js/' . $this->action . '.js';
        if (file_exists($url)) {
            return $this->action;
        } else {
            return 'app';
        }
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render()
    {
        $loader = new FilesystemLoader(TWIG_DIR);
        $loader->addPath(TWIG_DIR . 'layouts' . DS, 'layouts');
        $loader->addPath(TWIG_DIR . 'components' . DS, 'components');
        $twig = new Environment($loader);
        $twig->addExtension(new HelperTwigExtension());
        echo $twig->render($this->getTemplate(), $this->getParams());
    }

    public function getParams()
    {
        $params = [];
        $methodAction = Tools::variable($this->action);
        if (method_exists($this, $methodAction)) {
            $params = $this->{$methodAction}();
        }
        $params['base_url'] = Tools::getBaseUrl();
        $params['style'] = $this->getStylePage();
        $params['script'] = $this->getJsPage();
        return $params;
    }

    public function getTemplate()
    {
        $template = $this->action . '.twig';
        if (!file_exists(TWIG_DIR . $template)) {
            $template = '404.twig';
        }
        return $template;
    }
}
