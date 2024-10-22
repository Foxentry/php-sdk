<?php

declare(strict_types=1);

namespace Foxentry;

use Foxentry\Exception\BadRequestException;
use Foxentry\Exception\ForbiddenException;
use Foxentry\Exception\FoxentryException;
use Foxentry\Exception\NotFoundException;
use Foxentry\Exception\PaymentRequiredException;
use Foxentry\Exception\ServerErrorException;
use Foxentry\Exception\TooManyRequestsException;
use Foxentry\Exception\UnauthorizedException;
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
     */
    private string $baseUri = "https://api.foxentry.com/";

    /**
     * The HTTP request method (e.g., "GET" or "POST").
     *
     */
    private string $method = "POST";

    /**
     * The HTTP headers for the API request.
     *
     * @var array<string, mixed>
     */
    private array $headers = [
        "Foxentry-Include-Request-Details" => false,
        "Content-Type" => "application/json",
        "Accept" => "application/json",
        "User-Agent" => "FoxentrySdk (PHP/2.3.0; ApiReference/2.0)",
    ];

    /**
     * The request body data to send to the API.
     *
     */
    private object $body;

    /**
     * A custom ID for the request (optional).
     *
     */
    private ?string $customId = null;

    /**
     * The query parameters for the API request.
     *
     * @var array<string, mixed>
     */
    private array $query;

    /**
     * Additional options for the API request (optional).
     *
     * @var array<string, mixed>|null
     */
    private ?array $options = null;

    /**
     * The API endpoint to send the request to.
     *
     */
    private string $endpoint;

    /**
     * The HTTP client for making requests.
     *
     */
    private HttpClient $httpClient;

    /**
     * The API key used for authentication.
     *
     */
    private string $apiKey;

    /**
     * Information about the client making the request (optional).
     *
     * @var array<string, mixed>
     */
    private ?array $client = null;

    public function __construct(string $apiVersion, ?string $apiKey)
    {
        $this->setHeader("Api-Version", $apiVersion);

        if ($apiKey) {
            $this->setAuth($apiKey);
        }

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
    public function setHeader(string $key, mixed $value): void
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
     * @param array<string, mixed> $query The query parameters to set
     */
    public function setQuery(array $query): void
    {
        $this->query = $query;
    }

    /**
     * Set options for the request.
     *
     * @param array<string, mixed> $options The options to set
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
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new \InvalidArgumentException("The specified IP address is not valid.");
        }

        if ($this->client === null) {
            $this->client = [];
        }

        $this->client['ip'] = $ip;
    }

    /**
     * Set the client's country information for the request.
     *
     * @param string $country The client country code in format ISO-3166-1 alpha-2.
     */
    public function setClientCountry(string $country): void
    {
        if (strlen($country) != 2) {
            throw new \InvalidArgumentException("The provided country code does not conform to the ISO-3166-1 alpha-2 format.");
        }

        if ($this->client === null) {
            $this->client = [];
        }

        $this->client['country'] = $country;
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

        if ($this->client === null) {
            $this->client = [];
        }

        $this->client['location'] = $location;
    }

    /**
     * Send the API request.
     *
     * @return Response The response from the API
     *
     * @throws TooManyRequestsException
     * @throws BadRequestException
     * @throws ForbiddenException
     * @throws NotFoundException
     * @throws PaymentRequiredException
     * @throws ServerErrorException
     * @throws UnauthorizedException
     * @throws FoxentryException
     * @throws GuzzleException
     */
    public function send(): Response
    {
        try {
            $this->buildBody();
            $this->validate();

            $response = $this->httpClient->request($this->method, $this->endpoint, [
                "headers" => $this->headers,
                "body" => json_encode($this->body),
            ]);

            $responseHeaders = $response->getHeaders();
            $responseBody = $response->getBody()->getContents();

            return new Response($responseBody, $responseHeaders);
        } catch (RequestException $e) {
            throw FoxentryException::fromRequestException($e);
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
                "client" => $this->client,
            ],
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
