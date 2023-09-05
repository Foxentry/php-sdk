<?php

namespace Foxentry;

use Foxentry\Resources\Company;
use Foxentry\Resources\Email;
use Foxentry\Resources\Location;
use Foxentry\Resources\Name;
use Foxentry\Resources\Phone;

/**
 * API client class for interacting with Foxentry API.
 *
 * @package Foxentry
 */
class ApiClient
{
    /**
     * Email resource.
     *
     * @var Email
     */
    public Email $email;

    /**
     * Location resource.
     *
     * @var Location
     */
    public Location $location;

    /**
     * Company resource.
     *
     * @var Company
     */
    public Company $company;

    /**
     * Name resource.
     *
     * @var Name
     */
    public Name $name;

    /**
     * Phone resource.
     *
     * @var Phone
     */
    public Phone $phone;

    /**
     * Request object for making API requests.
     *
     * @var Request
     */
    private Request $request;

    /**
     * ApiClient constructor.
     *
     * @param string $apiKey The API key for authentication
     */
    public function __construct(string $apiKey)
    {
        $this->request = new Request();
        $this->request->setBearerAuth($apiKey);

        $this->initializeResources();
    }

    /**
     * Set the API version for requests.
     *
     * @param string $version The API version to set
     */
    public function setApiVersion(string $version): void
    {
        $this->request->setHeader("Api-Version", $version);
    }

    /**
     * Include request details in API responses.
     *
     * @param bool $value Whether to include request details (default: true)
     */
    public function includeRequestDetails(bool $value = true): void
    {
        $this->request->setHeader("Foxentry-Include-Request-Details", $value);
    }

    /**
     * Initialize the API resources.
     */
    private function initializeResources(): void
    {
        $this->company = new Company($this->request);
        $this->email = new Email($this->request);
        $this->location = new Location($this->request);
        $this->name = new Name($this->request);
        $this->phone = new Phone($this->request);
    }
}