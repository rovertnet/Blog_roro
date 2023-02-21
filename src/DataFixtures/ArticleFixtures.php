<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
       for($i = 1; $i<=10; $i++){
            $article   =  new Articles();
            $article->setTitle("Titre de l'article n° $i ")
                    ->setContent(" Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
				cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
				proident, sunt in culpa qui officia deserunt mollit anim id est laborum.")
                    ->setImage("http://placehold.it/350x150")
                    ->setCreatedAt(new \DatetimeImmutable());
            $manager->persist($article);
       }

        $manager->flush();
    }
}
