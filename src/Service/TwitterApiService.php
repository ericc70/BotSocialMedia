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

    public function myAccount(){
      return $this->auth()->get("account/verify_credentials");

    }

    public function post(string $content)
    {
         $this->auth()->post("statuses/update", ["status" => $content]);

        //  if ($this->auth()->getLastHttpCode() == 200) {
        //     // Tweet posted successfully
        // } else {
        //     // Handle error case
        // }
    }

    public function getUserTweet() :array{
        return $this->auth()->get("statuses/user_timeline");
    }
    public function getTimelimeTweet() :array{
        return $this->auth()->get("statuses/home_timeline");
    }
    
    public function getTweet(int $id) :object {
        return $this->auth()->get("statuses/show", ['id' =>$id, 'tweet_mode'=> 'extended'] );
    }

    public function getRetweets(int $id) :array {
        return $this->auth()->get("statuses/retweets", ['id' =>$id] );
    }

    public function deleteTweet($id){

          $this->auth()->post("statuses/destroy", ['id' =>$id] );
    }
   


    /*
    public function uploadImage(string $content) :array {
        dd ($this->auth()->get("media/upload", ['media' =>$content]) );
    }
*/
    /* Mention*/
    public function getMention() :array {
     return   $this->auth()->get("statuses/mentions_timeline" );
    }



    /* direct message */
    public function getDirectMessage():object{
   return   $this->auth()->get("direct_messages/events/list");
   
    }


    // public function getDirectMessage():array {
    //     $id = 1354817184015421454;
    //     dd(  $this->auth()->get('direct_messages/sent'));
      
    //    }

    public function postDirectMessage(string $content, int $id) 
    {

        $params = [
            'event' => [
                'type' => "message_create",
              
                'message_create' => [
                  
                    'target' => [
                        'recipient_id' => $id
                    ],
                    'message_data' => [
                        'text' => $content,

                    
                    ]
                ]
                
            ]
        ];
        
         $this->auth()->post("direct_messages/events/new", $params, true  );
   
    }

    public function deleteDirectMessage(int $id) :void
    {

         $this->auth()->delete("direct_messages/events/destroy", ['id '=> $id]);

    }

    /* welcome_messages */
    public function newWelcomeMessage(String $name, String $message )
    {

        $params = [
            'welcome_message' => [
                'name' => $name,
                'message_data' => [
                    'text' => $message,
                ]
            ]
        ];
      
       $this->auth()->post("direct_messages/welcome_messages/new", $params, true  );
   
    }



    public function getMessagetWelcomeMessage()
    {
    return      $this->auth()->get("direct_messages/welcome_messages/list"   );
    }
    public function getMessagetWelcomeMessageRules()
    {
       return    $this->auth()->get("direct_messages/welcome_messages/rules/list"   );
    }

    public function rulesWelcomeMessage(int $id)
    {
          $params = [
            'welcome_message_rule' => [
                'welcome_message_id' => $id,
            ]
        ];

    return     $this->auth()->post("direct_messages/welcome_messages/rules/new", $params, true );
         
    }

    public function deleteWelcomeMessage($id){

        $this->auth()->delete("direct_messages/welcome_messages/destroy", ['id' =>$id]);
    }

    public function deleteWelcomeMessageRules($id){

      $this->auth()->delete("direct_messages/welcome_messages/rules/destroy", ['id' =>$id] );
    }


    public function showWelecomeMessage($id){
        return $this->auth()->get("direct_messages/welcome_messages/show", ['id' =>$id] ) ;

    }

    // public function putWelcomeMessage(String $message, int $id){
    //     $params = [
            
    //                 'message_data' => [
    //                 'text' => $message,
    //                       ]
    //     ];
     
    //  dd(  $this->auth()->put("direct_messages/welcome_messages/update" )   );
    // }
  

}











/*
    public function postDirectMessage(string $content, int $id)
    {

        $params = [
            'event' => [
                'type' => "message_create",
              
                'message_create' => [
                  
                    'target' => [
                        'recipient_id' => $id
                    ],
                    'message_data' => [
                        'text' => $content,

                        'quick_reply' => [
                            'type' => "options",
                            'options' => [

                                ["label" => "Red Bird"],
                                ["label" => "Red Bird"],
                                ["label" => "Red Bird"],
                             

                            ],
                        ],
                    ]
                ]
                
            ]
        ];
        
       dd(  $this->auth()->post("direct_messages/events/new", $params, true ) );
   
    }*/