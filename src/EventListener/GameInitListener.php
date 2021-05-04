<?php

namespace App\EventListener;

use App\Entity\Game;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Security;

class GameInitListener
{
    private $security;

    public function __construct(Security $security)
    {
        // Avoid calling getUser() in the constructor: auth may not
        // be complete yet. Instead, store the entire Security object.
        $this->security = $security;
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Game) {
            return;
        }
        //dump("Game created");
        $currUser = $this->security->getUser();
        //dump($currUser, $entity->getUser1(), $entity->getUser2());
        if ($currUser === $entity->getUser1() ||
                $currUser === $entity->getUser2()) {

            dump("Game was created for you!");
            // TODO add redirect on game page or to controller
        }

    }
}
