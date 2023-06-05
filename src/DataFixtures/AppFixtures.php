<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // create " catégories
        $boissonsCategory = new Category();
        $boissonsCategory->setName("Boissons");
        $boissonsCategory->setDescription("Boissons");
        $manager->persist($boissonsCategory);

        $fruitsCategory = new Category();
        $fruitsCategory->setName("Fruits");
        $fruitsCategory->setDescription("Fruits");
        $manager->persist($fruitsCategory);

        $legumesCategory = new Category();
        $legumesCategory->setName("Légumes");
        $legumesCategory->setDescription("Légumes");
        $manager->persist($legumesCategory);

        //creates product for each category
        $eauProduct = new Product();
        $eauProduct->setCategory($boissonsCategory);
        $eauProduct->setName("Eau");
        $eauProduct->setDescription("Eau");
        $eauProduct->setPrice(mt_rand(10, 100));
        $manager->persist($eauProduct);

        $bananeProduct = new Product();
        $bananeProduct->setCategory($fruitsCategory);
        $bananeProduct->setName("Banane");
        $bananeProduct->setDescription("Banane");
        $bananeProduct->setPrice(mt_rand(10, 100));
        $manager->persist($bananeProduct);

        $haricotProduct = new Product();
        $haricotProduct->setCategory($legumesCategory);
        $haricotProduct->setName("Haricot");
        $haricotProduct->setDescription("Haricot");
        $haricotProduct->setPrice(mt_rand(10, 100));
        $manager->persist($haricotProduct);

        $manager->flush();
    }
}
