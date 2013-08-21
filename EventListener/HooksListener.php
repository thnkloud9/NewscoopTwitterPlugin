<?php

namespace Newscoop\TwitterPluginBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Newscoop\EventDispatcher\Events\PluginHooksEvent;

class HooksListener
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function sidebar(PluginHooksEvent $event)
    {
        $response = $this->container->get('templating')->renderResponse(
            'NewscoopTwitterPluginBundle:Hooks:sidebar.html.twig',
            array(
                'pluginName' => 'TwitterPluginBundle',
                'info' => 'This is response from plugin hook!'
            )
        );

        $event->addHookResponse($response);
    }
}
