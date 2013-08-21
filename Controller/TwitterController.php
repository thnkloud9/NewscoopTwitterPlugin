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
        return $this->render('NewscoopTwitterPluginBundle:Default:index.html.smarty');
    }

}
