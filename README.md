# Foxentry PHP API Client library Documentation

## Introduction

The Foxentry PHP API Client library enables seamless integration of various data validation features into your applications. Whether you require validation for phone numbers, addresses, emails, or other data types, this library offers a user-friendly interface to interact with the Foxentry API. For more comprehensive information about Foxentry, please visit [foxentry.com](https://foxentry.com/)

If you have questions or need further assistance, reach out to us at [info@foxentry.cz](mailto:info@foxentry.cz)

## Requirements
To use the Foxentry API client, you need the following:

-   [A Foxentry account](https://app.foxentry.com/registration)
-   An Application project created with a generated API key
-   PHP version 7.4 or higher

## Installation

To begin using the Foxentry PHP API Client library, follow these installation steps:

### With Composer

1. Install the library using Composer:
```shell  
composer require foxentry/php-api-client  
```  

2. Include the Composer autoloader in your PHP script:
```php  
require_once 'vendor/autoload.php';  
```

### Without Composer

1.  Download the library and add it to your project.
2.  Include the file **vendor/autoload.php** in your PHP script.
```php
include_once "foxentry-php-client/vendor/autoload.php"
```

## Getting started

To initiate the usage of the Foxentry PHP API Client library, create an instance of the API client with your API key. This instance allows you to access various resources (e.g., phone, location, email, etc.) and call their methods to access the Foxentry API's functionalities.

### Full example of e-mail validation
```php  
// Require the autoloader file to load necessary dependencies from the "vendor" directory.
require "vendor/autoload.php";

// Import the Foxentry\ApiClient class, making it available for use in this script.
use Foxentry\ApiClient;

/*
Create a new instance of the ApiClient class and provide your API key. 
The API key can be generated in the Foxentry administration under Settings > API Keys section. 
*/
$api = new ApiClient("[YOUR API KEY]");

// Set custom parameters for the email validation request.
$response = $api->email
    ->setCustomId("CustomRequestID") // Sets a custom request ID.
    ->setClientIP("127.0.0.1") // Sets the client IP address.
    ->setClientCountry("CZ") // Sets the client country code.
    ->setOptions([
        "validationType" => "basic",// Set the validation type to "basic".
        "acceptDisposableEmails" => false // Disables acceptance of disposable emails.
    ])
    ->validate("info@foxentry.cz"); // Sends request to Foxentry API and performs email validation.

// Displays the result of email validation.
echo $response->getResult()->isValid ? "E-mail is Valid" : "E-mail is invalid";
```  

## APIClient class

The APIClient class is the main class responsible for communication with the API.

It offers the following methods:

| Method | Parameters | Description |
| -------- | --------- |--------- |
| setApiVersion | `version mumber` | Sets specific API version, that will be used |
| includeRequestDetails | `true/false` | Includes request details with every request |

To access various resources from this class, simply provide the resource name, and you will be able to access the resource's methods, e.g., `$api->email->search($query)`, `$api->company->get($query)`, etc.

## Resources

The API client provides various resources, each with its own related methods listed below. You can click on the methods to navigate to the [API documentation](https://foxentry.dev/), where you can explore all request inputs, options, and more.

| Resource | Methods                                                                                                                                                                                                                                               |
| -------- |-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Company | [validate](https://foxentry.dev/reference/validatecompanydata)<br>[search](https://foxentry.dev/reference/companysearch)<br>[get](https://foxentry.dev/reference/getcompanydata)                                                                      |
| Email   | [validate](https://foxentry.dev/reference/validateemail)<br>[search](https://foxentry.dev/reference/emailsearch)                                                                                                                                      |
| Location | [validate](https://foxentry.dev/reference/locationvalidation)<br>[search](https://foxentry.dev/reference/locationsearch)<br>[get](https://foxentry.dev/reference/locationget)<br> [localization](https://foxentry.dev/reference/locationlocalization) |
| Name   | [validate](https://foxentry.dev/reference/namevalidation)                                                                                                                                                                                             |
| Phone   | [validate](https://foxentry.dev/reference/validatephonenumber)                                                                                                                                                                                        |

In each method, you **must specify query parameters** according to the specific endpoint in the [API documentation](https://foxentry.dev/).

To specify options, use the method **setOptions([])**

To specify the client, use the methods **setClientIP($ip)**, **setClientCountry($country)** or **setClientLocation($lat, $lon)**.

## Response class

Response class is returned with every request providing methods below:

| Method             | Parameters | Description|
|--------------------| --------- |--------- |
| getStatus          | `None` | Returns status code of the response |
| getResponse        | `None` | Returns full response from the API |
| getRequest         | `None` | Returns informations about the sent request |
| getResult          | `None` | Returns result object from the response |
| getResultCorrected | `None` | Returns corrected results from the response |
| getSuggestions     | `None` | Returns suggestions from the response |
| getErrors          | `None` | Returns errors from the response |

## Testing

The library includes unit tests to ensure its functionality. You can run the unit tests using **PHPUnit**. Don't forget to set your API key for these tests, which is located in `\tests\Config.php` file.