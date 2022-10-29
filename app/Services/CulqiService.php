<?php
namespace App\Services;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Exception;

class CulqiService
{
    protected $key;
    protected $secret;
    protected $baseUri;
    protected $culqi;
    protected $card;

    public function __construct($card = null)
    {
        $this->baseUri = config('services.culqi.base_url');
        $this->key = config('services.culqi.key');
        $this->secret = config('services.culqi.secret');
        $this->culqi = new \Culqi\Culqi(array('api_key' => config('services.culqi.secret')));
        $this->card = $card;
    }

    /**
     * Get access and generate token using Bearer public key
     *
     * @return void
     */
    public function generateToken()
    {
        try {
            $client = new Client();
            $response = $client->request('POST', $this->baseUri.'/tokens', [
                'body' => json_encode($this->card),
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $this->key
                ]
            ]);
            $token = json_decode($response->getBody()->getContents(), true);
            return $token['id'];
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * store charge
     *
     * @return void
     */
    public function charge(array $array)
    {
        //Creamos Cargo a una tarjeta
        try {
            //$data = array_merge($array, ["source_id" => $this->generateToken()]);
            $charge = $this->culqi->Charges->create($array);
            return $charge;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * store customer
     *
     * @return void
     */
    public function customer(array $data)
    {
        //Creamos un cliente
        try {
            $customer = $this->culqi->Customers->create($data);
            return $customer;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    /**
     * store card
     *
     * @return void
     */
    public function card(array $array)
    {
        //Creamos una tarjeta a cliente
        try {
            $data = array_merge($array, ["token_id" => $this->generateToken()]);
            //$charge = $this->culqi->Charges->create($array);
            $card = $this->culqi->Cards->create($data);
            return $card;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteCard($id)
    {
        try {
            $client = new Client();
            $response = $client->request('DELETE', $this->baseUri.'/cards/{$id}', [
                'body' => json_encode($this->card),
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer ' . $this->key
                ]
            ]);
            return $response;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
