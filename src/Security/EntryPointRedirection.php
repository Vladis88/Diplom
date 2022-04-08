<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

/**
 * Class that should implements AuthenticationEntryPointInterface
 * and decide behavior for unauthenticated users
 *
 * Class EntryPointRedirection
 */
class EntryPointRedirection implements AuthenticationEntryPointInterface
{
    /**
     * @var FlashBagInterface
     */
    private FlashBagInterface $flashBag;

    /**
     * @var RouterInterface
     */
    private RouterInterface $router;

    /**
     * AccessDeniedHandler constructor.
     *
     * @param FlashBagInterface $flashBag
     * @param RouterInterface $router
     */
    public function __construct(FlashBagInterface $flashBag, RouterInterface $router)
    {
        $this->flashBag = $flashBag;
        $this->router = $router;
    }

    /**
     * {@inheritDoc}
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $this->flashBag->add('error', 'Вам следует войти в систему');

        return new RedirectResponse($this->router->generate('app_login'));
    }
}
