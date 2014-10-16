<?php

namespace Newscoop\TwitterPluginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TwitterController extends Controller
{
    /**
     * @Route("/plugin/twitter/latesttweet")
     */
    public function indexAction(Request $request)
    {
        $cache_key = md5("__twitterplugin_cache_user_timeline");

        if ($jsonString = $this->container->get('newscoop.cache')->fetch($cache_key)) {
            $json = unserialize($jsonString);
        } else {
            $twitterClient = $this->container->get('guzzle.twitter.client');
            $json = $twitterClient->get('statuses/user_timeline.json')
             ->send()->getBody();
            $this->container->get('newscoop.cache')->save($cache_key, serialize($json));
        }

        $twitterFeed = json_decode($json, true);

        // get the latest tweet
        $latestTweet = $twitterFeed[0];

        $tweetDate = $latestTweet["created_at"];
        $postedLast = explode(" ", $tweetDate);
        $tweetCreatedAt = $postedLast[0]." - ".$postedLast[1]." ".$postedLast[2].", ".$postedLast[5] . " @ " . $postedLast[3];

        $tweetCreatedBy = $latestTweet["user"]["screen_name"];

        $tweetMsg = $latestTweet["text"];
        $tweetMsg = preg_replace("/([\w]+\:\/\/[\w-?&;#~=.\/\@]+[\w\/])/", "<a target='_blank' href='$1'>$1</a>", $tweetMsg);
        $tweetMsg = preg_replace("/#([A-Za-z0-9\/.]*)/", "<a target='_blank' href='http://twitter.com/search?q=$1'>#$1</a>", $tweetMsg);
        $tweetMsg = preg_replace("/@([A-Za-z0-9\/.]+)/", "<a target='_blank' href='http://www.twitter.com/$1'>@$1</a>", $tweetMsg);

        $html = "<p class='entry'>".$tweetMsg."</p>";
        $html .= "<p class='tweet_meta'> <a href='http://twitter.com/".$tweetCreatedBy."' class='account_name' target='_blank'>@".$tweetCreatedBy."</a>";
        $html .= "<span class='tweet_published'> <a href='http://www.twitter.com/".$tweetCreatedBy."/status/". $latestTweet["id"]."' target='_blank'>".$tweetCreatedAt."</a></span>";

        return new Response($html);

    }

}
