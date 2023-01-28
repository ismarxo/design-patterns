<?php

namespace DesignPatterns\Flyweight\Without;

class Tree
{
    public int $x;
    public int $y;
    public string $colorCode;
    public string $name;

    public function __construct($x, $y, $colorCode, $name)
    {
        $this->x = $x;
        $this->y = $y;
        $this->colorCode = $colorCode;
        $this->$name = $name;
    }
}

class Forest
{
    public array $trees = [];

    public function addTree(Tree $tree): void
    {
        $this->trees[] = $tree;
    }
}

class TreeFactory
{
    public array $colors = ['#FFFFFF', '#000000', '#3F3F3F'];
    public array $names = ['Teak', 'Apple', 'Elm'];


    public function plantTree(Forest $forest): void
    { 
        $tree = new Tree(
            rand(-100, 100), 
            rand(-100, 100), 
            $this->colors[rand(1, count($this->colors)) - 1], 
            $this->names[rand(1, count($this->names) - 1)]
        );
        $forest->addTree($tree);        
    }
}


// client code without 
echo memory_get_usage() . PHP_EOL; // 411744

$countOfTree = 1000;
$treeFactory = new TreeFactory();
$forest = new Forest();

echo memory_get_usage() . PHP_EOL; // 411912

for ($i = 0; $i < $countOfTree; $i++) { 
    $treeFactory->plantTree($forest);
}

echo memory_get_usage() . PHP_EOL; // 936832

/*
PHP 8.1.14 (cli) (built: Jan 13 2023 10:43:50) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.1.14, Copyright (c) Zend Technologies
    with Zend OPcache v8.1.14, Copyright (c), by Zend Technologies

*/