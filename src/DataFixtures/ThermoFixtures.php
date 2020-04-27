<?php

namespace App\DataFixtures;

use App\Entity\Salle;
use App\Entity\Thermo;
use App\Entity\User;
use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\DBAL\Types\DateType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class ThermoFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {

      $user = new User();
      $user
          ->setEmail('ideesculture.thermoh.com')
          ->setNom('ideesculture')
          ->setAdmin(true)
          ->setRoles([])
          ->setPassword($this->encoder->encodePassword($user, 'Bonjour1'));


        $manager->persist($user);

        $user2 = new User();
        $user2
            ->setEmail('legrandjeu.thermoh.com')
            ->setNom('le grand jeu')
            ->setAdmin(false)
            ->setRoles([])
            ->setPassword($this->encoder->encodePassword($user2,'Bonjour1'));


        $manager->persist($user2);

        $manager->flush();

        /*fixtures de thermo h*/

        $thermo2 = new Thermo();
        $thermo2
            ->setDate(new \DateTime('2020/04/03'))
            ->setTemperature('21')
            ->setHygrometrie('49');
        $manager->persist($thermo2);
        $manager->flush();

        $thermo1 = new Thermo();
        $thermo1
            ->setDate(new \DateTime('2020/04/02'))
            ->setTemperature('18')
            ->setHygrometrie('51');
        $manager->persist($thermo1);
        $manager->flush();

        $salle =new Salle();
        $salle
            ->setNom('salle des temps modernes');
        $manager->persist($salle);
        $manager->flush();

        $salle2 =new Salle();
        $salle2
            ->setNom('salle perdue');
        $manager->persist($salle2);
        $manager->flush();

        $salle3 =new Salle();
        $salle3
            ->setNom('salle du grand roi');
        $manager->persist($salle3);
        $manager->flush();
    }




}
