<?php

namespace Newscoop\TwitterPluginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class TwitterController extends Controller
{
    /**
     * @Route("/twitternewscoop")
     */
    public function indexAction(Request $request)
    {
        $twitterClient = $this->container->get('guzzle.twitter.client');
        $status = $twitterClient->get('statuses/user_timeline.json')
             ->send()->getBody();

        return $this->render('NewscoopTwitterPluginBundle:Default:index.html.smarty', array(
            'status' => $status
        ));
    }

}
