<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\FavoriteCategories;
use App\Entity\FavoriteSources;
use App\Entity\Source;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $categories = [];
        $categorieNames = ['business', 'entertainment', 'general', 'health', 'science', 'sports', 'technology'];

        for ($i = 0; $i < count($categorieNames); $i++) {
            $category = new Category();
            $category->setName($categorieNames[$i]);

            $manager->persist($category);
        }


        
        
        for ($i= 0; $i < 5; $i++) {
            $user = new User();
            $user->setName($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setEmail($faker->email)
                ->setLogin($faker->userName)
                ->setPassword($faker->password);

            $manager->persist($user);
        }



        $sources = [];
        $sourceNames = ['huffington-post', 'bfm', 'lci'];

        for ($i = 0; $i < (count($sourceNames) - 1); $i++) {
            $source = new Source();
            $source->setName($sourceNames[$i]);

            $manager->persist($source);
        }


        

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();
            $article->setUrl($faker->url)
                    ->setImageUrl($faker->url)
                    ->setDescription($faker->paragraph($faker->numberBetween(1,10)))
                    ->setTitle($faker->words($faker->numberBetween(1,5), true))
                    ->setDate($faker->dateTime)
                    ->setCategory($category)
                    ->setSource($source);
            
            $manager->persist($article);

        }


        for ($i =0; $i < 5; $i++) {
            $favoriteCategory = new FavoriteCategories();
            $favoriteCategory->setCategory($category);

            $manager->persist($favoriteCategory);
        }


        for ($i = 0; $i < 5; $i++) {
            $favoriteSource = new FavoriteSources();
            $favoriteSource->setSource($source);

            $manager->persist($favoriteSource);
        }

        $manager->flush();
    }
}
