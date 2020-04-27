<?php

namespace BlueCore;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

/**
 * Class for Render a page action
 */
class AppPage
{

    /**
     * Action in $_GET['action']
     */
    public $action;

    /**
     * List of TwigHelper Class
     */
    public $helpers;

    /**
     * Constructor 
     */
    public function __construct($configDir)
    {
        Configure::loadAll($configDir);
        $this->action = (isset($_GET['action']) ? $_GET['action'] : 'default');
    }

    /**
     * Get de name for CSS file
     */
    private function getStylePage()
    {
        $url = ROOT_DIR . 'src/scss/' . $this->action . '.scss';
        if (file_exists($url)) {
            return $this->action;
        } else {
            return 'app';
        }
    }

    /**
     * Get the name for JS file
     */
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
     * Render of the view
     * 
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render()
    {
        $loader = new FilesystemLoader(TWIG);
        $loader->addPath(TWIG . 'layouts' . DS, 'layouts');
        $loader->addPath(TWIG . 'components' . DS, 'components');
        $twig = new Environment($loader);
        $twig->addExtension(new HelperTwigExtension());
        if (!empty($this->helpers)) {
            foreach ($this->helpers as $helper) {
                $twig->addExtension(new $helper());
            }
        }
        echo $twig->render($this->getTemplate(), $this->getParams());
    }

    /**
     * Get parameters in the return action methode
     */
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

    /**
     * Get the twig template
     */
    public function getTemplate()
    {
        $template = $this->action . '.twig';
        if (!file_exists(TWIG . $template)) {
            $template = '404.twig';
        }
        return $template;
    }
}
