<?php

namespace App\DataFixtures;

use App\Entity\UserCountry;
use App\Entity\Users;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE = [self::ROLE_SUPERADMIN];
    public function load(ObjectManager $manager)
    {

      $country = new UserCountry();
        $country->setCountryCode('IN');
        $country->setCountryName('INDIA');
        $manager->persist($country);

        $user = new Users();
        $user->setUsername("samurai");
        $user->setEmail("suyog15122@gmail.com");
        $user->setRoles(self::ROLE);
        $user->setEnabled(true);
        $user->setFirstName("Suyog");
        $user->setLastName("Mishal");
        $user->setPassword($this->encoder->encodePassword($user,'suyog@100'));
        $user->setCountries($country);
        $manager->persist($user);

        $manager->flush();
    }
}
