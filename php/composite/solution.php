<?php

namespace DesignPatterns\Composite\Solution;

abstract class SomethingWithPrice
{
    abstract public function getPrice(): int;
}

class Product extends SomethingWithPrice
{
    protected int $price; 

    public function __construct(int $price)
    {  
        $this->price = $price;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}

abstract class CollectionOfSomethingWithPrice extends SomethingWithPrice
{
    public array $somethings = [];

    public function add(SomethingWithPrice $something): void
    {
        $this->somethings[] = $something;
    }

    public function getPrice(): int
    {
        $price = 0;

        foreach ($this->somethings as $key => $something) {
            $price += $something->getPrice();
        }

        return $price;
    }
}

class BoxOfSomethingWithPrice extends CollectionOfSomethingWithPrice
{

}

// client code
$box01 = new BoxOfSomethingWithPrice;
$box01->add(new Product(100));
$box01->add(new Product(200));

$box02 = new BoxOfSomethingWithPrice;
$box02->add($box01);
$box02->add(new Product(100));
$box02->add(new Product(200));

$box12 = new BoxOfSomethingWithPrice;
$box12->add(new Product(100));
$box12->add(new Product(200));

$box03 = new BoxOfSomethingWithPrice;
$box03->add($box02);
$box03->add($box12);
$box03->add(new Product(100));
$box03->add(new Product(200));

var_dump($box03->getPrice());