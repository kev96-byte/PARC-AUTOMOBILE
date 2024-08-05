<?php
namespace App\EventListener;

use Doctrine\ORM\Event\PreRemoveEventArgs;
use Psr\Log\LoggerInterface;

class PreRemoveListener
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function preRemove(PreRemoveEventArgs $event): void
    {
        $this->logger->debug('-- PreRemoveListener::PREREMOVE --');
    }
}
