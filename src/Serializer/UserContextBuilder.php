<?php


namespace App\Serializer;


use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\Serializer\SerializerContextBuilderInterface;
use App\Entity\ClientsUID;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class UserContextBuilder implements SerializerContextBuilderInterface
{
    /**
     * @var SerializerContextBuilderInterface
     */
    private $decorated;
    /**
     * @var AuthorizationCheckerInterface
     */
    private $authorizationChecker;

    public function __construct(SerializerContextBuilderInterface $decorated, AuthorizationCheckerInterface $authorizationChecker)
    {

        $this->decorated = $decorated;
        $this->authorizationChecker = $authorizationChecker;
    }


    /**
     * Creates a serialization context from a Request.
     *
     * @param Request $request
     * @param bool $normalization
     * @param array|null $extractedAttributes
     * @return array
     */
    public function createFromRequest(Request $request, bool $normalization, array $extractedAttributes = null): array
    {
        $context = $this->decorated->createFromRequest($request,$normalization,$extractedAttributes);
        //class being serialized/deserialize
        $resourceClass = $context['resource_class']??null;
        if ((Users::class === $resourceClass || ClientsUID::class == $resourceClass) && isset($context['groups'])&& $normalization === true && $this->authorizationChecker->isGranted(Users::ROLE_SUBADMIN) ){
            $context['groups'][] = 'get-admin';
        }

        return $context;
    }
}