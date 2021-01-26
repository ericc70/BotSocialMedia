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

    public function auth()
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
        // $connection->post("statuses/update", ["status" => $content]);
        dd($this->auth()->post("statuses/update", ["status" => $content]));
    }

    public function getAlllTweet(){

     
        dd($this->auth()->get("statuses/home_timeline"));
    }

    public function getTweet(int $id){
        
    }

}
