<?php
/**
 * RoomDocument
 *
 * PHP version 5
 *
 * @category Class
 * @package  DocuSign\Rooms
 * @author   Swaagger Codegen team
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

namespace DocuSign\Rooms\Model;

use \ArrayAccess;
use \DocuSign\Rooms\ObjectSerializer;

/**
 * RoomDocument Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\Rooms
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class RoomDocument implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'RoomDocument';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'document_id' => 'int',
        'name' => 'string',
        'owner_id' => 'int',
        'size' => 'int',
        'folder_id' => 'int',
        'created_date' => '\DateTime',
        'is_signed' => 'bool',
        'docu_sign_form_id' => 'string',
        'is_archived' => 'bool',
        'is_virtual' => 'bool',
        'owner' => '\DocuSign\Rooms\Model\RoomDocumentOwner'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'document_id' => 'int32',
        'name' => null,
        'owner_id' => 'int32',
        'size' => 'int64',
        'folder_id' => 'int32',
        'created_date' => 'date-time',
        'is_signed' => null,
        'docu_sign_form_id' => null,
        'is_archived' => null,
        'is_virtual' => null,
        'owner' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'document_id' => 'documentId',
        'name' => 'name',
        'owner_id' => 'ownerId',
        'size' => 'size',
        'folder_id' => 'folderId',
        'created_date' => 'createdDate',
        'is_signed' => 'isSigned',
        'docu_sign_form_id' => 'docuSignFormId',
        'is_archived' => 'isArchived',
        'is_virtual' => 'isVirtual',
        'owner' => 'owner'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'document_id' => 'setDocumentId',
        'name' => 'setName',
        'owner_id' => 'setOwnerId',
        'size' => 'setSize',
        'folder_id' => 'setFolderId',
        'created_date' => 'setCreatedDate',
        'is_signed' => 'setIsSigned',
        'docu_sign_form_id' => 'setDocuSignFormId',
        'is_archived' => 'setIsArchived',
        'is_virtual' => 'setIsVirtual',
        'owner' => 'setOwner'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'document_id' => 'getDocumentId',
        'name' => 'getName',
        'owner_id' => 'getOwnerId',
        'size' => 'getSize',
        'folder_id' => 'getFolderId',
        'created_date' => 'getCreatedDate',
        'is_signed' => 'getIsSigned',
        'docu_sign_form_id' => 'getDocuSignFormId',
        'is_archived' => 'getIsArchived',
        'is_virtual' => 'getIsVirtual',
        'owner' => 'getOwner'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['document_id'] = isset($data['document_id']) ? $data['document_id'] : null;
        $this->container['name'] = isset($data['name']) ? $data['name'] : null;
        $this->container['owner_id'] = isset($data['owner_id']) ? $data['owner_id'] : null;
        $this->container['size'] = isset($data['size']) ? $data['size'] : null;
        $this->container['folder_id'] = isset($data['folder_id']) ? $data['folder_id'] : null;
        $this->container['created_date'] = isset($data['created_date']) ? $data['created_date'] : null;
        $this->container['is_signed'] = isset($data['is_signed']) ? $data['is_signed'] : null;
        $this->container['docu_sign_form_id'] = isset($data['docu_sign_form_id']) ? $data['docu_sign_form_id'] : null;
        $this->container['is_archived'] = isset($data['is_archived']) ? $data['is_archived'] : null;
        $this->container['is_virtual'] = isset($data['is_virtual']) ? $data['is_virtual'] : null;
        $this->container['owner'] = isset($data['owner']) ? $data['owner'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets document_id
     *
     * @return int
     */
    public function getDocumentId()
    {
        return $this->container['document_id'];
    }

    /**
     * Sets document_id
     *
     * @param int $document_id document_id
     *
     * @return $this
     */
    public function setDocumentId($document_id)
    {
        $this->container['document_id'] = $document_id;

        return $this;
    }

    /**
     * Gets name
     *
     * @return string
     */
    public function getName()
    {
        return $this->container['name'];
    }

    /**
     * Sets name
     *
     * @param string $name name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->container['name'] = $name;

        return $this;
    }

    /**
     * Gets owner_id
     *
     * @return int
     */
    public function getOwnerId()
    {
        return $this->container['owner_id'];
    }

    /**
     * Sets owner_id
     *
     * @param int $owner_id owner_id
     *
     * @return $this
     */
    public function setOwnerId($owner_id)
    {
        $this->container['owner_id'] = $owner_id;

        return $this;
    }

    /**
     * Gets size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->container['size'];
    }

    /**
     * Sets size
     *
     * @param int $size size
     *
     * @return $this
     */
    public function setSize($size)
    {
        $this->container['size'] = $size;

        return $this;
    }

    /**
     * Gets folder_id
     *
     * @return int
     */
    public function getFolderId()
    {
        return $this->container['folder_id'];
    }

    /**
     * Sets folder_id
     *
     * @param int $folder_id folder_id
     *
     * @return $this
     */
    public function setFolderId($folder_id)
    {
        $this->container['folder_id'] = $folder_id;

        return $this;
    }

    /**
     * Gets created_date
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->container['created_date'];
    }

    /**
     * Sets created_date
     *
     * @param \DateTime $created_date created_date
     *
     * @return $this
     */
    public function setCreatedDate($created_date)
    {
        $this->container['created_date'] = $created_date;

        return $this;
    }

    /**
     * Gets is_signed
     *
     * @return bool
     */
    public function getIsSigned()
    {
        return $this->container['is_signed'];
    }

    /**
     * Sets is_signed
     *
     * @param bool $is_signed is_signed
     *
     * @return $this
     */
    public function setIsSigned($is_signed)
    {
        $this->container['is_signed'] = $is_signed;

        return $this;
    }

    /**
     * Gets docu_sign_form_id
     *
     * @return string
     */
    public function getDocuSignFormId()
    {
        return $this->container['docu_sign_form_id'];
    }

    /**
     * Sets docu_sign_form_id
     *
     * @param string $docu_sign_form_id docu_sign_form_id
     *
     * @return $this
     */
    public function setDocuSignFormId($docu_sign_form_id)
    {
        $this->container['docu_sign_form_id'] = $docu_sign_form_id;

        return $this;
    }

    /**
     * Gets is_archived
     *
     * @return bool
     */
    public function getIsArchived()
    {
        return $this->container['is_archived'];
    }

    /**
     * Sets is_archived
     *
     * @param bool $is_archived is_archived
     *
     * @return $this
     */
    public function setIsArchived($is_archived)
    {
        $this->container['is_archived'] = $is_archived;

        return $this;
    }

    /**
     * Gets is_virtual
     *
     * @return bool
     */
    public function getIsVirtual()
    {
        return $this->container['is_virtual'];
    }

    /**
     * Sets is_virtual
     *
     * @param bool $is_virtual is_virtual
     *
     * @return $this
     */
    public function setIsVirtual($is_virtual)
    {
        $this->container['is_virtual'] = $is_virtual;

        return $this;
    }

    /**
     * Gets owner
     *
     * @return \DocuSign\Rooms\Model\RoomDocumentOwner
     */
    public function getOwner()
    {
        return $this->container['owner'];
    }

    /**
     * Sets owner
     *
     * @param \DocuSign\Rooms\Model\RoomDocumentOwner $owner owner
     *
     * @return $this
     */
    public function setOwner($owner)
    {
        $this->container['owner'] = $owner;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}

