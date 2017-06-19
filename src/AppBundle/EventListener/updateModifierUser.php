<?php
namespace AppBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\EntityInfos;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class updateModifierUser
{
    private $token;

    public function __construct(TokenStorage $token){
        $this->token = $token;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof EntityInfos) {
            return;
        }

        $entityManager = $args->getEntityManager();

        if ($this->token->getToken()) {
            $id = $this->token->getToken()->getUser()->getId();
            $entity->setModifierUserId($id);
        }

    }
}
