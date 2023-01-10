<?php
namespace BlueCore;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class HelperTwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('is_active', [$this, 'isActive']),
        ];
    }

    public function isActive($url)
    {
        $action = (isset($_GET['action']) ? $_GET['action'] : 'default');
        return ($url == $action) ? 'active' : '';
    }
}
