<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MastodonApiService
{

    private $getParams;
    private $mamotApi;

    public function __construct(ParameterBagInterface $getParams, HttpClientInterface $mamotApi)
    {
        $this->getParams = $getParams;
        $this->client = $mamotApi;
        $this->jeton = $this->getParams->get('MASTODON_JETON');
    }



    public function test()
    {
        // $response=$this->client->request('GET', "https://mamot.fr/api/v1/accounts/verify_credentials"
        // ,[
        //     'headers' => [
        //         'Authorization' => 'Bearer X5HbFtr_JG_KKtT_lzs1BpLbYvMHbAToSecXLlcysnE'
        //     ],

        // ] );
        $id = 666;
        $jeton = "Bearer " . $this->getParams->get('MASTODON_JETON');
        $response = $this->client->request('GET', 'https://mamot.fr/api/v1/admin/reports', [
            'auth_bearer' => $this->jeton,

        ]);

        dd($response->toArray());

        if (200 == $response->getStatusCode()) {
            dd($response->getContent());
        } else {
            dd($response->getInfo());
        }
    }

    public function getAccount():array
    {
        $response = $this->client->request('GET', '/api/v1/accounts/verify_credentials');
        return $response->toArray();
    }


    public function showAccount(int $id):array
    {
        $response = $this->client->request('GET', '/api/v1/accounts/' . $id);
        return $response->toArray();
    }

    public function updateAccount()
    {
        return 0;
    }


    // section Timeline


    public function getPublicTimeline(array $arrayPathQuery = []): array
    {
        $response = $this->client->request(
            'GET',
            'api/v1/timelines/public',
            [
                'query' => $arrayPathQuery
            ]
        );

        return $response->toArray();
    }

    public function getHomeTimeline(array $arrayPathQuery = []): array
    {
        $response = $this->client->request(
            'GET',
            'api/v1/timelines/home',
            [
              
                'query' => $arrayPathQuery
            ]
        );

        return $response->toArray();
    }

    // Pouet (statuses)

    public function getPouetUser(int $id, array $arrayPathQuery = [])
    {
        $response = $this->client->request(
            'GET',
            '/api/v1/accounts/' . $id . '/statuses',
            [
                'query' => $arrayPathQuery
            ]
        );

        dd($response->toArray());
    }


    public function showPouet($id, array $arrayPathQuery = [])
    {

        $response = $this->client->request(
            'GET',
            '/api/v1/accounts/' . $id,
            [
                'query' => $arrayPathQuery
            ]
        );
    }

    public function newPouet(array $arrayDataParametre)
    {

        $response = $this->client->request(
            'POST',
            "/api/v1/statuses",
            [
               
                'body' => $arrayDataParametre
            ]
        );
    }

    public function deletePouet(int $id)
    {
        $response = $this->client->request(
            'DELETE',
            '/api/v1/statuses/' . $id
            
                
            
        );
        // dd($response->getStatusCode());
    }

    public function getPouetId($id): array
    {
        $response = $this->client->request(
            'GET',
            'api/v1/statuses/' . $id  );

        return $response->toArray();
    }
    public function getBoostedBy(int $id)
    {
        $response = $this->client->request(
            'GET',
            '/api/v1/statuses/' . $id . '/reblogged_by' );

        dd($response->toArray());
    }


    public function getFavouritedId(int $id): array
    {
        $response = $this->client->request(
            'GET',
            '/api/v1/statuses/' . $id . '/favourited_by'  );

        dd($response->toArray());
    }
    /**
     * Epingler le pouet en haut de la list
     *
     * @param integer $id
     * @return array
     */
    public function postPinToProfile(int $id): array
    {

        $response = $this->client->request(
            'GET',
            '/api/v1/statuses/' . $id . '/pin',
            [
          
            ]
        );
        dd($response->toArray());
    }

    /**
     * Supprime le pouet épingler 
     *
     * @param integer $id
     * @return array
     */
    public function postUnpinToProfile(int $id): array
    {

        $response = $this->client->request(
            'GET',
            '/api/v1/statuses/' . $id . '/unpin',
            [
           

            ]
        );

        dd($response->toArray());
    }





    public function getNotifications(array $arrayPathQuery = [])
    {
        $response = $this->client->request(
            'GET',
            '/api/v1/notifications',
            [
             
                'query' => $arrayPathQuery
            ]
        );

        dd($response->toArray());
    }


    public function serach(array $arrayPathQuery = [])
    {
        $response = $this->client->request(
            'GET',
            '/api/v2/search',
            [
                
                'query' => $arrayPathQuery
            ]
        );

        dd($response->toArray());
    }
}
