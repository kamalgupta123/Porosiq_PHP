<?php
/**
 * TaskListsApi
 * PHP version 5
 *
 * @category Class
 * @package  DocuSign\Rooms
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * DocuSign Rooms API - v2
 *
 * An API for an integrator to access the features of DocuSign Rooms
 *
 * OpenAPI spec version: v2
 * Contact: devcenter@docusign.com
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 2.4.13-SNAPSHOT
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace DocuSign\Rooms\Api\TaskListsApi;



namespace DocuSign\Rooms\Api;

use \DocuSign\Rooms\Client\ApiClient;
use \DocuSign\Rooms\Client\ApiException;
use \DocuSign\Rooms\Configuration;
use \DocuSign\Rooms\ObjectSerializer;

/**
 * TaskListsApi Class Doc Comment
 *
 * @category Class
 * @package  DocuSign\Rooms
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class TaskListsApi
{
    /**
     * API Client
     *
     * @var \DocuSign\Rooms\Client\ApiClient instance of the ApiClient
     */
    protected $apiClient;

    /**
     * Constructor
     *
     * @param \DocuSign\Rooms\Client\ApiClient|null $apiClient The api client to use
     */
    public function __construct(\DocuSign\Rooms\Client\ApiClient $apiClient = null)
    {
        if ($apiClient === null) {
            $apiClient = new ApiClient();
        }

        $this->apiClient = $apiClient;
    }

    /**
     * Get API client
     *
     * @return \DocuSign\Rooms\Client\ApiClient get the API client
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }

    /**
     * Set the API client
     *
     * @param \DocuSign\Rooms\Client\ApiClient $apiClient set the API client
     *
     * @return TaskListsApi
     */
    public function setApiClient(\DocuSign\Rooms\Client\ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }

    /**
     * Operation createTaskList
     *
     * Add a task list to a room based on a task list template.
     *
    * @param int $room_id Room ID.
    * @param string $account_id 
     * @param \DocuSign\Rooms\Model\TaskListForCreate $body  (optional)
     * @throws \DocuSign\Rooms\Client\ApiException on non-2xx response
     * @return \DocuSign\Rooms\Model\TaskList
     */
    public function createTaskList($room_id, $account_id, $body = null)
    {
        list($response) = $this->createTaskListWithHttpInfo($room_id, $account_id, $body);
        return $response;
    }

    /**
     * Operation createTaskListWithHttpInfo
     *
     * Add a task list to a room based on a task list template.
     *
    * @param int $room_id Room ID.
    * @param string $account_id 
     * @param \DocuSign\Rooms\Model\TaskListForCreate $body  (optional)
     * @throws \DocuSign\Rooms\Client\ApiException on non-2xx response
     * @return array of \DocuSign\Rooms\Model\TaskList, HTTP status code, HTTP response headers (array of strings)
     */
    public function createTaskListWithHttpInfo($room_id, $account_id, $body = null)
    {
        // verify the required parameter 'room_id' is set
        if ($room_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $room_id when calling createTaskList');
        }
        // verify the required parameter 'account_id' is set
        if ($account_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $account_id when calling createTaskList');
        }
        // parse inputs
        $resourcePath = "/v2/accounts/{accountId}/rooms/{roomId}/task_lists";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType(['application/json-patch+json', 'application/json', 'text/json', 'application/_*+json']);


        // path params
        if ($room_id !== null) {
            $resourcePath = str_replace(
                "{" . "roomId" . "}",
                $this->apiClient->getSerializer()->toPathValue($room_id),
                $resourcePath
            );
        }
        // path params
        if ($account_id !== null) {
            $resourcePath = str_replace(
                "{" . "accountId" . "}",
                $this->apiClient->getSerializer()->toPathValue($account_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        // body params
        $_tempBody = null;
        if (isset($body)) {
            $_tempBody = $body;
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
                '\DocuSign\Rooms\Model\TaskList',
                '/v2/accounts/{accountId}/rooms/{roomId}/task_lists'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\DocuSign\Rooms\Model\TaskList', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 201:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Rooms\Model\TaskList', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Rooms\Model\ApiError', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Rooms\Model\ApiError', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation deleteTaskList
     *
     * Deletes a task list. If there are attached documents they will remain in the associated
     *
    * @param int $task_list_id Task List ID
    * @param string $account_id 
     * @throws \DocuSign\Rooms\Client\ApiException on non-2xx response
     * @return void
     */
    public function deleteTaskList($task_list_id, $account_id)
    {
        list($response) = $this->deleteTaskListWithHttpInfo($task_list_id, $account_id);
        return $response;
    }

    /**
     * Operation deleteTaskListWithHttpInfo
     *
     * Deletes a task list. If there are attached documents they will remain in the associated
     *
    * @param int $task_list_id Task List ID
    * @param string $account_id 
     * @throws \DocuSign\Rooms\Client\ApiException on non-2xx response
     * @return array of null, HTTP status code, HTTP response headers (array of strings)
     */
    public function deleteTaskListWithHttpInfo($task_list_id, $account_id)
    {
        // verify the required parameter 'task_list_id' is set
        if ($task_list_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $task_list_id when calling deleteTaskList');
        }
        // verify the required parameter 'account_id' is set
        if ($account_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $account_id when calling deleteTaskList');
        }
        // parse inputs
        $resourcePath = "/v2/accounts/{accountId}/task_lists/{taskListId}";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);


        // path params
        if ($task_list_id !== null) {
            $resourcePath = str_replace(
                "{" . "taskListId" . "}",
                $this->apiClient->getSerializer()->toPathValue($task_list_id),
                $resourcePath
            );
        }
        // path params
        if ($account_id !== null) {
            $resourcePath = str_replace(
                "{" . "accountId" . "}",
                $this->apiClient->getSerializer()->toPathValue($account_id),
                $resourcePath
            );
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
                'DELETE',
                $queryParams,
                $httpBody,
                $headerParams,
                null,
                '/v2/accounts/{accountId}/task_lists/{taskListId}'
            );

            return [null, $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Rooms\Model\ApiError', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Rooms\Model\ApiError', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }

    /**
     * Operation getTaskLists
     *
     * Returns the summary for all viewable task lists in a
     *
    * @param int $room_id Room ID
    * @param string $account_id 
     * @throws \DocuSign\Rooms\Client\ApiException on non-2xx response
     * @return \DocuSign\Rooms\Model\TaskListSummaryList
     */
    public function getTaskLists($room_id, $account_id)
    {
        list($response) = $this->getTaskListsWithHttpInfo($room_id, $account_id);
        return $response;
    }

    /**
     * Operation getTaskListsWithHttpInfo
     *
     * Returns the summary for all viewable task lists in a
     *
    * @param int $room_id Room ID
    * @param string $account_id 
     * @throws \DocuSign\Rooms\Client\ApiException on non-2xx response
     * @return array of \DocuSign\Rooms\Model\TaskListSummaryList, HTTP status code, HTTP response headers (array of strings)
     */
    public function getTaskListsWithHttpInfo($room_id, $account_id)
    {
        // verify the required parameter 'room_id' is set
        if ($room_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $room_id when calling getTaskLists');
        }
        // verify the required parameter 'account_id' is set
        if ($account_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $account_id when calling getTaskLists');
        }
        // parse inputs
        $resourcePath = "/v2/accounts/{accountId}/rooms/{roomId}/task_lists";
        $httpBody = '';
        $queryParams = [];
        $headerParams = [];
        $formParams = [];
        $_header_accept = $this->apiClient->selectHeaderAccept(['text/plain', 'application/json', 'text/json']);
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = $this->apiClient->selectHeaderContentType([]);


        // path params
        if ($room_id !== null) {
            $resourcePath = str_replace(
                "{" . "roomId" . "}",
                $this->apiClient->getSerializer()->toPathValue($room_id),
                $resourcePath
            );
        }
        // path params
        if ($account_id !== null) {
            $resourcePath = str_replace(
                "{" . "accountId" . "}",
                $this->apiClient->getSerializer()->toPathValue($account_id),
                $resourcePath
            );
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
                '\DocuSign\Rooms\Model\TaskListSummaryList',
                '/v2/accounts/{accountId}/rooms/{roomId}/task_lists'
            );

            return [$this->apiClient->getSerializer()->deserialize($response, '\DocuSign\Rooms\Model\TaskListSummaryList', $httpHeader), $statusCode, $httpHeader];
        } catch (ApiException $e) {
            switch ($e->getCode()) {
                case 200:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Rooms\Model\TaskListSummaryList', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 400:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Rooms\Model\ApiError', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
                case 401:
                    $data = $this->apiClient->getSerializer()->deserialize($e->getResponseBody(), '\DocuSign\Rooms\Model\ApiError', $e->getResponseHeaders());
                    $e->setResponseObject($data);
                    break;
            }

            throw $e;
        }
    }
}
