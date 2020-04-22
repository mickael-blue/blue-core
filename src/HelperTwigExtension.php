<?php
namespace App;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class HelperTwigExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('is_active', [$this, 'isActive']),
            new TwigFunction('three_skills', [$this, 'treeSkills']),
        ];
    }

    public function isActive($url)
    {
        $action = (isset($_GET['action']) ? $_GET['action'] : 'default');
        return ($url == $action) ? 'active' : '';
    }

    private function tree($tree, &$ranks, &$countChild, $idParent = null)
    {
        foreach ($tree as $skill) {
            if (!isset($countChild[$skill['rank']])) {
                $countChild[$skill['rank']] = 0;
            }
            $id = $skill['rank'] . $countChild[$skill['rank']];
            $ranks[$skill['rank']][] = [
                'id' => $id,
                'rank' => $skill['rank'],
                'level' => $skill['level'],
                'name' => $skill['name'],
                'parent' => $idParent,
                'class' => 'child-of-' . $idParent . ' parent-' . $id,
            ];
            $countChild[$skill['rank']] += 1;
            if (isset($skill['child']) && !empty($skill['child'])) {
                $this->tree($skill['child'], $ranks, $countChild, $id);
            }
        }
    }

    public function treeSkills($tree_skills)
    {
        $treeRanks = [];
        $countChild = [];
        $this->tree($tree_skills, $treeRanks, $countChild);
        return $treeRanks;
    }
}
