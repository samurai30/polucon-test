<?php


namespace App\Serializer;

use App\Entity\Users;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Exception\BadMethodCallException;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Exception\ExtraAttributesException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Exception\RuntimeException;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class UserAttributeNormalizer implements ContextAwareNormalizerInterface,SerializerAwareInterface
{
    use SerializerAwareTrait;

    const USER_ATTRIBUTE_NORMALIZER_ALREADY_CALLED = 'USER_ATTRIBUTE_NORMALIZER_ALREADY_CALLED';
    const USER_ATTRIBUTE_DENORMALIZER_ALREADY_CALLED = 'USER_ATTRIBUTE_DENORMALIZER_ALREADY_CALLED';


    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {

        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     *
     * @param array $context options that normalizers have access to
     */
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        if(isset($context[self::USER_ATTRIBUTE_NORMALIZER_ALREADY_CALLED])){
            return false;
        }

        return $data instanceof Users;

    }

    public function normalize($object, $format = null, array $context = [])
    {
        if($this->isUserHimself($object)){
            $context['groups'][]='get-owner';
        }
        if ($this->isUserClient($object)){
            $context['groups'][]='get-client-uid';
            $context['groups'][]='get-users-client';
        }
        if ($this->isUserSurveyor($object)){
            $context['groups'][]='get-surveyor-uid';
            $context['groups'][]='get-users-surveyor';
        }

        //Continue with serialization
        return $this->passOn($object,$format,$context);
    }

    private function isUserClient($object){
        return $object->getRoles()[0] === 'ROLE_CLIENT';
    }

    private function isUserSurveyor($object){
        return $object->getRoles()[0] === 'ROLE_SURVEYOR';
    }

    private function isUserHimself($object){
        return $object->getUsername() === $this->tokenStorage->getToken()->getUsername();
    }

    private function passOn($object,$format,$context){
        if(!$this->serializer instanceof NormalizerInterface){
            throw new \LogicException(sprintf('Cannot normalizer object "%s" because the injected serializer is not a normalizer.',$object));
        }
        $context[self::USER_ATTRIBUTE_NORMALIZER_ALREADY_CALLED] = true;

        return  $this->serializer->normalize($object,$format,$context);
    }


}