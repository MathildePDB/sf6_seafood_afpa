<?php

namespace App\DataFixtures;

use App\Entity\MenuCategories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class MenuCategoriesFixtures extends Fixture
{
    private $counter = 1;
    
    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
        $parent = $this->createMenuCategory('Main Course', null, $manager);
        $parent = $this->createMenuCategory('Soups & Salads', null, $manager);
        $parent = $this->createMenuCategory('Desserts', null, $manager);
        $parent = $this->createMenuCategory('Drinks', null, $manager);

        $manager->flush();
    }

    public function createMenuCategory(string $name, MenuCategories $parent = null, ObjectManager $manager)
    {
        $category = new MenuCategories();
        $category->setName($name);
        $category->setSlug($this->slugger->slug($category->getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this->addReference('cat-'.$this->counter, $category);
        $this->counter++;

        return $category;
    }
}
