<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserExtension extends AbstractExtension
{
private $tokenStorage;

public function __construct(TokenStorageInterface $tokenStorage)
{
$this->tokenStorage = $tokenStorage;
}

public function getFunctions(): array
{
return [
new TwigFunction('get_user', [$this, 'getUser']),
];
}

public function getUser(): ?UserInterface
{
$token = $this->tokenStorage->getToken();
if (null !== $token) {
$user = $token->getUser();
if ($user instanceof UserInterface) {
return $user;
}
}

return null;
}
}
