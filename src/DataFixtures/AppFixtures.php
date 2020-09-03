<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\FavoriteCategories;
use App\Entity\FavoriteSources;
use App\Entity\Source;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $categories=[];
        $categorieNames = ['business', 'entertainment', 'general', 'health', 'science', 'sports', 'technology'];

        for ($i = 0; $i < count($categorieNames); $i++) {
            $category = new Category();
            $category->setName($categorieNames[$i]);

            $manager->persist($category);

            $categories[] = $category;
        }


        $sources = [];
        $sourceNames = ['huffington-post', 'bfm', 'lci', 'le monde', 'l\'équipe', '20 minutes', 'les numériques', 'foot mercato', 'boursorama', 'le parisien', 'pure people', 'presse-citron', 'france.tv' ];

        for ($i = 0; $i < count($sourceNames); $i++) {
            $source = new Source();
            $source->setName($sourceNames[$i])
                    ->setCategory($categories[$faker->numberBetween(0, count($categories) - 1)]);

            $manager->persist($source);

            $sources[] = $source;
        }


        
        $articles = [];

        for ($i = 0; $i < 30; $i++) {
            $article = new Article();
            $article->setUrl($faker->url)
                    ->setImageUrl($faker->url)
                    ->setDescription($faker->paragraph($faker->numberBetween(1,10)))
                    ->setTitle($faker->words($faker->numberBetween(1,5), true))
                    ->setDate($faker->dateTime)
                    ->setSource($sources[$faker->numberBetween(0, count($sources) - 1)]);
            
            $manager->persist($article);
            $articles[]= $article;

        }

        $favoriteCategories = [];
        for ($i =0; $i < count($categories); $i++) {
            $favoriteCategory = new FavoriteCategories();
            $favoriteCategory->setCategory($categories[$i]);

            
            $manager->persist($favoriteCategory);
            $favoriteCategories[]= $favoriteCategory;
        }

        $favoriteSources = [];
        
        for ($i = 0; $i < count($sources); $i++) {
            $favoriteSource = new FavoriteSources();
            $favoriteSource->setSource($sources[$i]);

            
            $manager->persist($favoriteSource);
            $favoriteSources[] = $favoriteSource;
        }


        
        
        $users = [];
    
        $admin = new User();
        $admin->setName("First")
                ->setFirstname("Adam")
                ->setEmail("adam.first@gmail.com")
                ->setLogin("Adam1")
                ->setRoles(['ROLE_ADMIN'])
                ->setPassword('AdamFirst')
                ->addFavorite($favoriteSources[$faker->numberBetween(0, count($favoriteSources) - 1)])
                ->addFavorite($favoriteCategories[$faker->numberBetween(0, count($favoriteCategories) - 1)]);

                $manager->persist($admin);
                
        
        for ($i= 0; $i < 5; $i++) {
            $user = new User();
            $user->setName($faker->lastName)
                ->setFirstname($faker->firstName)
                ->setEmail($faker->email)
                ->setLogin($faker->userName)
                ->setPassword($faker->password)
                ->addFavorite($favoriteSources[$faker->numberBetween(0, count($favoriteSources) - 1)])
                ->addFavorite($favoriteCategories[$faker->numberBetween(0, count($favoriteCategories) - 1)]);
                
            

            $manager->persist($user);
            $users[]= $user;
        }

        for ($i = 0; $i < 15; $i++) {
            $comment = new Comment();
            $comment-> setContent($faker->paragraph($faker->numberBetween(1,10)))
                    ->setDate($faker ->dateTime)
                    ->setArticle($articles[$faker->numberBetween(0,count($articles)-1)])
                    ->setUser($users[$faker->numberBetween(0,count($users)-1)]);
            
            $manager->persist($comment);
        }
        
        
        $manager->flush();


        
    }
}
