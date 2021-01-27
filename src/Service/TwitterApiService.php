<?php

namespace App\Service;

use Abraham\TwitterOAuth\TwitterOAuth;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class TwitterApiService
{
    private $getParams;

    public function __construct(ParameterBagInterface $getParams, HttpClientInterface $client)
    {
        $this->getParams = $getParams;
        $this->client = $client;
    }

    protected function auth()
    {
        $consumerKey = $this->getParams->get('TWITTER_CONSUMER_KEY');
        $consumerSecret = $this->getParams->get('TWITTER_CONSUMER_SECRET');
        $accesToken = $this->getParams->get('TWITTER_ACCESS_TOKEN');
        $accesTokenSecret = $this->getParams->get('TWITTER_ACCESS_TOKEN_SECRET');
        $connection = new TwitterOAuth($consumerKey, $consumerSecret, $accesToken, $accesTokenSecret);
        return $connection;
    }

    public function verifConnection()
    {
        dd($this->auth()->get("account/verify_credentials"));
    }
    
    public function post(string $content)
    {
         $this->auth()->post("statuses/update", ["status" => $content]);
        return true;
    }

    public function getAlllTweet() :array{
        return $this->auth()->get("statuses/home_timeline");
    }

    public function getTweet(int $id) :object {
        return $this->auth()->get("statuses/show", ['id' =>$id, 'tweet_mode'=> 'extended'] );
    }

    public function getRetweets(int $id) :array {
        return $this->auth()->get("statuses/retweets", ['id' =>$id] );
    }

    public function uploadImage(string $content) :array {
        dd ($this->auth()->get("media/upload", ['media' =>$content]) );
    }
}
