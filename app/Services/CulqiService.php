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
    protected $data;

    public function __construct($data)
    {
        $this->baseUri = config('services.culqi.base_url');
        $this->key = config('services.culqi.key');
        $this->secret = config('services.culqi.secret');
        $this->culqi = new \Culqi\Culqi(array('api_key' => config('services.culqi.secret')));
        $this->data = $data;
    }

    /**
     * Get access and generate token using Bearer public key
     *
     * @return void
     */
    public function generateToken()
    {
        try {
            $culqi = new Client();
            $response = $culqi->request('POST', $this->baseUri.'/tokens', [
                'body' => json_encode($this->data),
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
     * Get access and gener token using a user and password
     *
     * @return void
     */
    public function charge(array $array)
    {
        //Creamos Cargo a una tarjeta
        try {
            $data = array_merge($array, ["source_id" => $this->generateToken()]);
            $charge = $this->culqi->Charges->create($data);
            return $charge;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
