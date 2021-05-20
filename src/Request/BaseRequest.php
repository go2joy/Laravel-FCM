<?php

namespace LaravelFCM\Request;

/**
 * Class BaseRequest.
 */
abstract class BaseRequest
{
    /**
     * @internal
     *
     * @var \GuzzleHttp\ClientInterface
     */
    protected $client;

    /**
     * @internal
     *
     * @var array
     */
    protected $config;

    /**
     * BaseRequest constructor.
     */
    public function __construct()
    {
        $this->config = app('config')->get('fcm.http', []);
    }

    /**
     * Build the header for the request.
     *
     * @return array
     */
    protected function buildRequestHeader($partner = false)
    {
        if ($partner == true) {
            return [
                'Authorization' => 'key='.$this->config['server_key_partner'],
                'Content-Type' => 'application/json',
                'project_id' => $this->config['sender_id_partner'],
            ];
        }else{
            return [
                'Authorization' => 'key='.$this->config['server_key'],
                'Content-Type' => 'application/json',
                'project_id' => $this->config['sender_id'],
            ];
        }
    }

    /**
     * Build the body of the request.
     *
     * @return mixed
     */
    abstract protected function buildBody();

    /**
     * Return the request in array form.
     *
     * @return array
     */
    public function build($partner = false)
    {
        return [
            'headers' => $this->buildRequestHeader($partner),
            'json' => $this->buildBody(),
        ];
    }
}
