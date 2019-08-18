<?php

namespace App\DataFixtures;

use App\Entity\Images;
use App\Entity\UserCountry;
use App\Entity\Users;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    const COUNTRIES = [
        ['id'=>'DZ','name' => 'Algeria'],
        ['id'=>'AO','name' => 'Angola'],
        ['id'=>'BJ','name' => 'Benin'],
        ['id'=>'BW','name' => 'Botswana'],
        ['id'=>'BF','name' => 'Burundi'],
        ['id'=>'CM','name' => 'Cameroon'],
        ['id'=>'CV','name' => 'Cape Verde'],
        ['id'=>'CF','name' => 'Central African Republic'],
        ['id'=>'KM','name' => 'Comoros'],
        ['id'=>'CD','name' => 'Democratic Republic of Congo'],
        ['id'=>'DJ','name' => 'Djibouti'],
        ['id'=>'DZ','name' => 'Algeria'],
        ['id'=>'EG','name' => 'Egypt'],
        ['id'=>'GQ','name' => 'Equatorial Guinea'],
        ['id'=>'ER','name' => 'Eritrea'],
        ['id'=>'ET','name' => 'Ethiopia'],
        ['id'=>'GA','name' => 'Gabon'],
        ['id'=>'GM','name' => 'Gambia'],
        ['id'=>'GH','name' => 'Ghana'],
        ['id'=>'GN','name' => 'Guinea'],
        ['id'=>'GW','name' => 'Guinea-Bissau'],
        ['id'=>'CI','name' => 'Ivory Coast'],
        ['id'=>'KE','name' => 'Kenya'],
        ['id'=>'LS','name' => 'Lesotho'],
        ['id'=>'LR','name' => 'Liberia'],
        ['id'=>'LY','name' => 'Libya'],
        ['id'=>'MG','name' => 'Madagascar'],
        ['id'=>'MW','name' => 'Malawi'],
        ['id'=>'ML','name' => 'Mali'],
        ['id'=>'MR','name' => 'Mauritania'],
        ['id'=>'MU','name' => 'Mauritius'],
        ['id'=>'MA','name' => 'Morocco'],
        ['id'=>'MZ','name' => 'Mozambique'],
        ['id'=>'NA','name' => 'Namibia'],
        ['id'=>'NE','name' => 'Niger'],
        ['id'=>'NG','name' => 'Nigeria'],
        ['id'=>'CG','name' => 'Republic of the Congo'],
        ['id'=>'RE','name' => 'Reunion'],
        ['id'=>'RW','name' => 'Rwanda'],
        ['id'=>'SH','name' => 'Saint Helena'],
        ['id'=>'ST','name' => 'Sao Tome and Principe'],
        ['id'=>'SN','name' => 'Senegal'],
        ['id'=>'SC','name' => 'Seychelles'],
        ['id'=>'SL','name' => 'Sierra Leone'],
        ['id'=>'SO','name' => 'Somalia'],
        ['id'=>'ZA','name' => 'South Africa'],
        ['id'=>'SS','name' => 'South Sudan'],
        ['id'=>'SD','name' => 'Sudan'],
        ['id'=>'SZ','name' => 'Swaziland'],
        ['id'=>'TZ','name' => 'Tanzania'],
        ['id'=>'TG','name' => 'Togo'],
        ['id'=>'TN','name' => 'Tunisia'],
        ['id'=>'UG','name' => 'Uganda'],
        ['id'=>'EH','name' => 'Western Sahara'],
        ['id'=>'ZM','name' => 'Zambia'],
        ['id'=>'ZW','name' => 'Zimbabwe']
    ];
    const ROLE = [self::ROLE_SUPERADMIN];
    public function load(ObjectManager $manager)
    {

        foreach (self::COUNTRIES as $cont){
            $cnt = new UserCountry();
            $cnt->setCountryCode($cont['id']);
            $cnt->setCountryName($cont['name']);
            $manager->persist($cnt);
        }

      $country = new UserCountry();
        $country->setCountryCode('IN');
        $country->setCountryName('INDIA');
        $manager->persist($country);
//        $image = new Images();
//        $src = 'D:\ClientsProject\ProfilePic.jpg';
//        $file = new UploadedFile($src,
//            'ProfilePic.jpg',
//            'image/jpg',
//            filesize($src),
//            null,
//            true);
//
//        $image->setFile($file);
//
//        $manager->persist($image);
//        $image->setFile(null);

        $user = new Users();
        $user->setUsername("samurai");
        $user->setEmail("suyog15122@gmail.com");
        $user->setRoles(self::ROLE);
        $user->setEnabled(true);
        $user->setFirstName("Suyog");
        $user->setLastName("Mishal");
        $user->setCreatedDate(new DateTime());
        $user->setPassword($this->encoder->encodePassword($user,'Suyog@100'));
        $user->setCountries($country);
        $manager->persist($user);

        $manager->flush();
    }
}
