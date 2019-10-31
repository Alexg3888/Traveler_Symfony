<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Pays;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
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
        //Création d'un User Admin de test dans la DB:
        $user = new User();

        $user->setLogin("AdminTest");

        $password = $this->encoder->encodePassword($user, 'AdminTest');
        $user->setPassword($password);

        $user->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();

        //Création d'un User Utilisateur de test dans la DB:
        $user = new User();

        $user->setLogin("UtilisateurTest");

        $password = $this->encoder->encodePassword($user, 'UtilisateurTest');
        $user->setPassword($password);

        // Pas obligatoire car il ramene par défaut le ROLE_USER
        // $user->setRoles(['ROLE_USER']);

        $manager->persist($user);
        $manager->flush();

        //Récupération d'une liste de pays en csv et upload dans la DB dans l'entité Pays

        if (($paysFile = fopen(__DIR__ . "/../../data/ListeDePays.csv", "r")) !== FALSE){

            while (($data = fgetcsv($paysFile)) !== FALSE) {

                $pays = new Pays();
                $pays->setNom($data[0]);
                $manager->persist($pays);
            }

            fclose($paysFile);
        }

        $manager->flush();
    }
}
