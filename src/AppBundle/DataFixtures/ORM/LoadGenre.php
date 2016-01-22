<?php
/**
 * Created by PhpStorm.
 * User: Maximilien
 * Date: 22/01/2016
 * Time: 12:13
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Genre;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGenre extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {

        $vars = ['Action', 'Fantastique', 'Horreur', 'Science-Fiction'];

        foreach ($vars as $var){
            $genre = new Genre();
            $genre->setGenre($var);

            $manager->persist($genre);
        }

        $manager->flush();
    }
}