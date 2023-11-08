<?php

namespace Foxentry;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;

/**
 * Request class for handling API requests.
 *
 * @package Foxentry
 */
class Request
{
    /**
     * The base URI for the Foxentry API.
     *
     * @var string
     */
    private string $baseUri = "https://api.foxentry.com/";

    /**
     * The HTTP request method (e.g., "GET" or "POST").
     *
     * @var string
     */
    private string $method = "POST";

    /**
     * The HTTP headers for the API request.
     *
     * @var array
     */
    private array $headers = [
        "Foxentry-Include-Request-Details" => false,
        "Content-Type" => "application/json",
        "Accept" => "application/json"
    ];

    /**
     * The request body data to send to the API.
     *
     * @var object
     */
    private object $body;

    /**
     * A custom ID for the request (optional).
     *
     * @var string|null
     */
    private ?string $customId = null;

    /**
     * The query parameters for the API request.
     *
     * @var array
     */
    private array $query;

    /**
     * Additional options for the API request (optional).
     *
     * @var array|null
     */
    private ?array $options = null;

    /**
     * The API endpoint to send the request to.
     *
     * @var string
     */
    private string $endpoint;

    /**
     * The HTTP client for making requests.
     *
     * @var HttpClient
     */
    private HttpClient $httpClient;

    /**
     * The API key used for authentication.
     *
     * @var string
     */
    private string $apiKey;

    /**
     * Information about the client making the request (optional).
     *
     * @var object|null
     */
    private ?object $client = null;

    public function __construct()
    {
        $this->httpClient = new HttpClient([
            'base_uri' => $this->baseUri,
        ]);
    }

    /**
     * Set API key for authentication.
     *
     * @param string $apiKey The API key to set
     */
    public function setAuth(string $apiKey): void
    {
        $this->apiKey = $apiKey;
        $this->setHeader("Authorization", "Bearer $this->apiKey");
    }

    /**
     * Set a custom header.
     *
     * @param string $key The header key
     * @param mixed $value The header value
     */
    public function setHeader(string $key, $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * Set a custom ID for the request.
     *
     * @param string $id The custom ID to set
     */
    public function setCustomId(string $id): void
    {
        $this->customId = $id;
    }

    /**
     * Set query parameters for the request.
     *
     * @param array $query The query parameters to set
     */
    public function setQuery(array $query): void
    {
        $this->query = $query;
    }

    /**
     * Set options for the request.
     *
     * @param array $options The options to set
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    /**
     * Set the API endpoint.
     *
     * @param string $endpoint The API endpoint to set
     */
    public function setEndpoint(string $endpoint): void
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Set the client's IP address for the request.
     *
     * @param string $ip The client IP address
     */
    public function setClientIP(string $ip): void
    {
        if(!filter_var($ip, FILTER_VALIDATE_IP))
            throw new \InvalidArgumentException("The specified IP address is not valid.");

        if(empty($this->client))
            $this->client = new \stdClass();

        $this->client->ip = $ip;
    }

    /**
     * Set the client's country information for the request.
     *
     * @param string $country The client country code in format ISO-3166-1 alpha-2.
     */
    public function setClientCountry(string $country): void
    {
        if(strlen($country) != 2)
            throw new \InvalidArgumentException("The provided country code does not conform to the ISO-3166-1 alpha-2 format.");

        if(empty($this->client))
            $this->client = new \stdClass();

        $this->client->country = $country;
    }

    /**
     * Set the client's location information for the request.
     *
     * @param float $lon The client's longitude
     * @param float $lat The client's latitude
     */
    public function setClientLocation(float $lat, float $lon): void
    {
        $location = [
            "lat" => $lat,
            "lon" => $lon,
        ];

        if(empty($this->client))
            $this->client = new \stdClass();

        $this->client->location = (object)$location;
    }

    /**
     * Send the API request.
     *
     * @return Response The response from the API
     *
     * @throws \Exception
     */
    public function send(): Response
    {
        try {
            $this->buildBody();
            $this->validate();

            $response = $this->httpClient->request($this->method, $this->endpoint, [
                "headers" => $this->headers,
                "body" => json_encode($this->body)
            ]);

            $responseHeaders = $response->getHeaders();
            $responseBody = $response->getBody()->getContents();

            return new Response($responseBody, $responseHeaders);
        } catch (RequestException $e) {
            $error = $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : $e->getMessage();
            throw new \Exception($error);
        }
    }

    /**
     * Build the request body.
     */
    private function buildBody(): void
    {
        $body = [
            "request" => [
                "customId" => $this->customId,
                "query" => $this->query,
                "options" => $this->options,
                "client" => $this->client
            ]
        ];

        $this->body = (object)$body;
    }

    /**
     * Validate the request parameters.
     *
     * @throws \Exception
     */
    private function validate(): void
    {
        if (empty($this->apiKey)) {
            throw new \Exception('You have not entered an API key. Please set your Foxentry project\'s API key');
        }

        if (empty($this->endpoint)) {
            throw new \Exception('Endpoint not set. Use "setEndpoint" method to specify the API endpoint.');
        }

        if (empty($this->query)) {
            throw new \Exception('Request query is empty.');
        }

        if (empty($this->body)) {
            throw new \Exception('Request body is empty.');
        }
    }
}