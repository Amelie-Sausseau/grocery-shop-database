<?php
session_start();
class Article {
    public $name;
    public $image;
    public $price;
    public $category;
    public $description;
    
    
    public function __construct($name='',$image='',$price='',$category='',$description=''){
        $this->name = $name;
        $this->image = $image;
        $this->price = $price;
        $this->category = $category;
        $this->description = $description;
    }
}

$home_products = [
    'apples'=> new Article (
        "Pommes",
        "images/apples.jpg",
        "2.30",
        "fruit",
        ""
    ),
    'pineapples'=> new Article (
        "Ananas",
        "images/pineapples.jpg",
        "3",
        "fruit",
        ""
    ),
    'strawberries'=> new Article (
        "Fraises",
        "images/strawberry.jpg",
        "2.50",
        "fruit",
        ""
    ),
];

