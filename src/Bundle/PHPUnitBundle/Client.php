<?php

namespace Bundle\PHPUnitBundle;

use Symfony\Foundation\Test\Client as BaseClient;

class Client extends BaseClient
{
    /**
     * Makes a request.
     *
     * @param Symfony\Components\HttpKernel\Request  $request A Request instance
     *
     * @param Symfony\Components\HttpKernel\Response $response A Response instance
     */
    protected function doRequest($request)
    {
        $attributes = $this->kernel->getContainer()->user->getAttributes();
        $session = $this->kernel->getContainer()->getUser_Session_TestService();
        $session->write('_user', $attributes);
        $session->sessionClose();

        $this->kernel->reboot();

        return $this->kernel->handle($request);
    }
}
