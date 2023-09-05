<?php

namespace Foxentry;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Request class for handling API requests.
 *
 * @package Foxentry
 */
class Request
{
    private string $baseUri = "https://api.foxentry.com/";

    private string $method = "POST";

    private array $headers = [
        "Foxentry-Include-Request-Details" => false,
        "Content-Type" => "application/json",
        "Accept" => "application/json"
    ];

    private object $body;

    private ?string $customId = null;

    private array $query;

    private ?array $options = null;

    private string $endpoint;

    private HttpClient $httpClient;

    private string $apiKey;

    private ?object $client = null;

    public function __construct()
    {
        $this->httpClient = new HttpClient([
            'base_uri' => $this->baseUri,
        ]);
    }

    /**
     * Set API key for bearer authentication.
     *
     * @param string $apiKey The API key to set
     */
    public function setBearerAuth(string $apiKey): void
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
     * Set client information for the request.
     *
     * @param string|null $ip The client IP address
     * @param string|null $country The client country code in format ISO-3166-1 alpha-2.
     * @param array|null $location The client location information
     *
     * @throws \InvalidArgumentException
     * @see https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2 ISO-3166-1 alpha-2 country code format
     */
    public function setClient(?string $ip = null, ?string $country = null, ?array $location = null): void
    {
        if (!empty($location) && (empty($location["lat"]) || empty($location["lon"])) || (empty($location) && !is_null($location))) {
            throw new \InvalidArgumentException('Client location parameter requires "lat" and "lon" properties to be set.');
        }

        $client = [
            "ip" => $ip,
            "country" => $country,
            "location" => $location
        ];

        $this->client = (object)$client;
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

            $responseBody = $response->getBody()->getContents();

            return new Response($responseBody);
        } catch (GuzzleException $e) {
            throw new \Exception($e->getMessage());
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