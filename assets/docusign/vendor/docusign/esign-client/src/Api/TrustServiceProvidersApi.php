<?php
declare(strict_types=1);

/**
 * TrustServiceProvidersApi.
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  DocuSign\eSign
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * DocuSign REST API
 *
 * The DocuSign REST API provides you with a powerful, convenient, and simple Web services API for interacting with DocuSign.
 *
 * OpenAPI spec version: v2.1
 * Contact: devcenter@docusign.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.13-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace DocuSign\eSign\ApiTrustServiceProvidersApi;



namespace DocuSign\eSign\Api;

use DocuSign\eSign\Client\ApiClient;
use DocuSign\eSign\Client\ApiException;
use DocuSign\eSign\Configuration;
use DocuSign\eSign\ObjectSerializer;

/**
 * TrustServiceProvidersApi Class Doc Comment
 *
 * @category Class
 * @package  DocuSign\eSign
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class TrustServiceProvidersApi
{
    /**
     * API Client
     *
     * @var ApiClient instance of the ApiClient
     */
    protected ApiClient $apiClient;

    /**
     * Constructor
     *
     * @param ApiClient|null $apiClient The api client to use
     * @return void
     */
    public function __construct(ApiClient $apiClient = null)
    {
        $this->apiClient = $apiClient ?? new ApiClient();
    }

    /**
     * Get API client
     *
     * @return ApiClient get the API client
     */
    public function getApiClient(): ApiClient
    {
        return $this->apiClient;
    }

    /**
     * Set the API client
     *
     * @param ApiClient $apiClient set the API client
     *
     * @return self
     */
    public function setApiClient(ApiClient $apiClient): self
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
    * Update $resourcePath with $
    *
    * @param string $resourcePath
    * @param string $baseName
    * @param string $paramName
    *
    * @return string
    */
    public function updateResourcePath(string $resourcePath, string $baseName, string $paramName): string
    {
        return str_replace(
            "{" . $baseName . "}",
            $this->apiClient->getSerializer()->toPathValue($paramName),
            $resourcePath
        );
    }


    /**
     * Operation completeSignHash
     *
     * Complete Sign Hash
     *
     * @param \DocuSign\eSign\Model\CompleteSignRequest $complete_sign_request  (optional)
     * @throws ApiException on non-2xx response
     * @return \DocuSign\eSign\Model\CompleteSignHashResponse
     */
    public function completeSignHash($complete_sign_request = null): \DocuSign\eSign\Model\CompleteSignHashResponse
    {
        list($response) = $this->completeSignHashWithHttpInfo($complete_sign_request);
        return $response;
    }

    /**
     * Operation completeSignHashWithHttpInfo
     *
     * Complete Sign Hash
     *
     * @param \DocuSign\eSign\Model\CompleteSignRequest $complete_sign_request  (optional)
     * @throws ApiException on non-2xx response
     * @return array of \DocuSign\eSign\Model\CompleteSignHashResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function completeSignHashWithHttpInfo($complete_sign_request = null): array
    {
        // parse inputs
        $resourcePath = "/v2.1/signature/completesignhash";
        $httpBody = $_tempBody ?? ''; // $_tempBody is the method argument, if present
        $queryParams = $headerParams = $formParams = [];
        $headerParams['Accept'] ??= $this->apiClient->selectHeaderAccept(['application/json']);
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);



        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);
        // body params
        $_tempBody = null;
        if (isset($complete_sign_request)) {
            $_tempBody = $complete_sign_request;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\DocuSign\eSign\Model\CompleteSignHashResponse',
                '/v2.1/signature/completesignhash'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\DocuSign\eSign\Model\CompleteSignHashResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\CompleteSignHashResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\ErrorDetails', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation getSealProviders
     *
     * Returns Account available seals for specified account.
     *
     * @param string $account_id The external account number (int) or account ID Guid.
     * @throws ApiException on non-2xx response
     * @return \DocuSign\eSign\Model\AccountSeals
     */
    public function getSealProviders($account_id): \DocuSign\eSign\Model\AccountSeals
    {
        list($response) = $this->getSealProvidersWithHttpInfo($account_id);
        return $response;
    }

    /**
     * Operation getSealProvidersWithHttpInfo
     *
     * Returns Account available seals for specified account.
     *
     * @param string $account_id The external account number (int) or account ID Guid.
     * @throws ApiException on non-2xx response
     * @return array of \DocuSign\eSign\Model\AccountSeals, HTTP status code, HTTP response headers (array of strings)
     */
    public function getSealProvidersWithHttpInfo($account_id): array
    {
        // verify the required parameter 'account_id' is set
        if ($account_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $account_id when calling getSealProviders');
        }
        // parse inputs
        $resourcePath = "/v2.1/accounts/{accountId}/seals";
        $httpBody = $_tempBody ?? ''; // $_tempBody is the method argument, if present
        $queryParams = $headerParams = $formParams = [];
        $headerParams['Accept'] ??= $this->apiClient->selectHeaderAccept(['application/json']);
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);


        // path params
        if ($account_id !== null) {
            $resourcePath = self::updateResourcePath($resourcePath, "accountId", $account_id);
        }

        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);
        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\DocuSign\eSign\Model\AccountSeals',
                '/v2.1/accounts/{accountId}/seals'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\DocuSign\eSign\Model\AccountSeals', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\AccountSeals', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\ErrorDetails', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation getUserInfo
     *
     * Get User Info To Sign Document
     *
     * @throws ApiException on non-2xx response
     * @return \DocuSign\eSign\Model\UserInfoResponse
     */
    public function getUserInfo(): \DocuSign\eSign\Model\UserInfoResponse
    {
        list($response) = $this->getUserInfoWithHttpInfo();
        return $response;
    }

    /**
     * Operation getUserInfoWithHttpInfo
     *
     * Get User Info To Sign Document
     *
     * @throws ApiException on non-2xx response
     * @return array of \DocuSign\eSign\Model\UserInfoResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function getUserInfoWithHttpInfo(): array
    {
        // parse inputs
        $resourcePath = "/v2.1/signature/userInfo";
        $httpBody = $_tempBody ?? ''; // $_tempBody is the method argument, if present
        $queryParams = $headerParams = $formParams = [];
        $headerParams['Accept'] ??= $this->apiClient->selectHeaderAccept(['application/json']);
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);



        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);
        
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'GET',
                $queryParams,
                $httpBody,
                $headerParams,
                '\DocuSign\eSign\Model\UserInfoResponse',
                '/v2.1/signature/userInfo'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\DocuSign\eSign\Model\UserInfoResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\UserInfoResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\ErrorDetails', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation healthCheck
     *
     * Report status from the TSP to DocuSign
     *
     * @param \DocuSign\eSign\Model\TspHealthCheckRequest $tsp_health_check_request  (optional)
     * @throws ApiException on non-2xx response
     * @return mixed
     */
    public function healthCheck($tsp_health_check_request = null): mixed
    {
        list($response) = $this->healthCheckWithHttpInfo($tsp_health_check_request);
        return $response;
    }

    /**
     * Operation healthCheckWithHttpInfo
     *
     * Report status from the TSP to DocuSign
     *
     * @param \DocuSign\eSign\Model\TspHealthCheckRequest $tsp_health_check_request  (optional)
     * @throws ApiException on non-2xx response
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function healthCheckWithHttpInfo($tsp_health_check_request = null): array
    {
        // parse inputs
        $resourcePath = "/v2.1/signature/healthcheck";
        $httpBody = $_tempBody ?? ''; // $_tempBody is the method argument, if present
        $queryParams = $headerParams = $formParams = [];
        $headerParams['Accept'] ??= $this->apiClient->selectHeaderAccept(['application/json']);
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);



        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);
        // body params
        $_tempBody = null;
        if (isset($tsp_health_check_request)) {
            $_tempBody = $tsp_health_check_request;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                null,
                '/v2.1/signature/healthcheck'
            );

            return [null, $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\ErrorDetails', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation signHashSessionInfo
     *
     * Get Signature Session Info To Sign Document Hash
     *
     * @param \DocuSign\eSign\Model\SignSessionInfoRequest $sign_session_info_request  (optional)
     * @throws ApiException on non-2xx response
     * @return \DocuSign\eSign\Model\SignHashSessionInfoResponse
     */
    public function signHashSessionInfo($sign_session_info_request = null): \DocuSign\eSign\Model\SignHashSessionInfoResponse
    {
        list($response) = $this->signHashSessionInfoWithHttpInfo($sign_session_info_request);
        return $response;
    }

    /**
     * Operation signHashSessionInfoWithHttpInfo
     *
     * Get Signature Session Info To Sign Document Hash
     *
     * @param \DocuSign\eSign\Model\SignSessionInfoRequest $sign_session_info_request  (optional)
     * @throws ApiException on non-2xx response
     * @return array of \DocuSign\eSign\Model\SignHashSessionInfoResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function signHashSessionInfoWithHttpInfo($sign_session_info_request = null): array
    {
        // parse inputs
        $resourcePath = "/v2.1/signature/signhashsessioninfo";
        $httpBody = $_tempBody ?? ''; // $_tempBody is the method argument, if present
        $queryParams = $headerParams = $formParams = [];
        $headerParams['Accept'] ??= $this->apiClient->selectHeaderAccept(['application/json']);
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);



        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);
        // body params
        $_tempBody = null;
        if (isset($sign_session_info_request)) {
            $_tempBody = $sign_session_info_request;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\DocuSign\eSign\Model\SignHashSessionInfoResponse',
                '/v2.1/signature/signhashsessioninfo'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\DocuSign\eSign\Model\SignHashSessionInfoResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\SignHashSessionInfoResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\ErrorDetails', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation updateTransaction
     *
     * Report an error from the tsp to docusign
     *
     * @param \DocuSign\eSign\Model\UpdateTransactionRequest $update_transaction_request  (optional)
     * @throws ApiException on non-2xx response
     * @return \DocuSign\eSign\Model\UpdateTransactionResponse
     */
    public function updateTransaction($update_transaction_request = null): \DocuSign\eSign\Model\UpdateTransactionResponse
    {
        list($response) = $this->updateTransactionWithHttpInfo($update_transaction_request);
        return $response;
    }

    /**
     * Operation updateTransactionWithHttpInfo
     *
     * Report an error from the tsp to docusign
     *
     * @param \DocuSign\eSign\Model\UpdateTransactionRequest $update_transaction_request  (optional)
     * @throws ApiException on non-2xx response
     * @return array of \DocuSign\eSign\Model\UpdateTransactionResponse, HTTP status code, HTTP response headers (array of strings)
     */
    public function updateTransactionWithHttpInfo($update_transaction_request = null): array
    {
        // parse inputs
        $resourcePath = "/v2.1/signature/updatetransaction";
        $httpBody = $_tempBody ?? ''; // $_tempBody is the method argument, if present
        $queryParams = $headerParams = $formParams = [];
        $headerParams['Accept'] ??= $this->apiClient->selectHeaderAccept(['application/json']);
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);



        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);
        // body params
        $_tempBody = null;
        if (isset($update_transaction_request)) {
            $_tempBody = $update_transaction_request;
        }

        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath,
                'POST',
                $queryParams,
                $httpBody,
                $headerParams,
                '\DocuSign\eSign\Model\UpdateTransactionResponse',
                '/v2.1/signature/updatetransaction'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\DocuSign\eSign\Model\UpdateTransactionResponse', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\UpdateTransactionResponse', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\eSign\Model\ErrorDetails', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }
}
