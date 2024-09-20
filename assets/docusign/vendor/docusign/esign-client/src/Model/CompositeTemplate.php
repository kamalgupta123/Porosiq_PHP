<?php
/**
 * CompositeTemplate
 *
 * PHP version 7.4
 *
 * @category Class
 * @package  DocuSign\eSign
 * @author   Swaagger Codegen team
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

namespace DocuSign\eSign\Model;

use \ArrayAccess;
use DocuSign\eSign\ObjectSerializer;

/**
 * CompositeTemplate Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class CompositeTemplate implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'compositeTemplate';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'composite_template_id' => 'string',
        'document' => '\DocuSign\eSign\Model\Document',
        'inline_templates' => '\DocuSign\eSign\Model\InlineTemplate[]',
        'pdf_meta_data_template_sequence' => 'string',
        'server_templates' => '\DocuSign\eSign\Model\ServerTemplate[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'composite_template_id' => null,
        'document' => null,
        'inline_templates' => null,
        'pdf_meta_data_template_sequence' => null,
        'server_templates' => null
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
        'composite_template_id' => 'compositeTemplateId',
        'document' => 'document',
        'inline_templates' => 'inlineTemplates',
        'pdf_meta_data_template_sequence' => 'pdfMetaDataTemplateSequence',
        'server_templates' => 'serverTemplates'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'composite_template_id' => 'setCompositeTemplateId',
        'document' => 'setDocument',
        'inline_templates' => 'setInlineTemplates',
        'pdf_meta_data_template_sequence' => 'setPdfMetaDataTemplateSequence',
        'server_templates' => 'setServerTemplates'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'composite_template_id' => 'getCompositeTemplateId',
        'document' => 'getDocument',
        'inline_templates' => 'getInlineTemplates',
        'pdf_meta_data_template_sequence' => 'getPdfMetaDataTemplateSequence',
        'server_templates' => 'getServerTemplates'
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
        $this->container['composite_template_id'] = isset($data['composite_template_id']) ? $data['composite_template_id'] : null;
        $this->container['document'] = isset($data['document']) ? $data['document'] : null;
        $this->container['inline_templates'] = isset($data['inline_templates']) ? $data['inline_templates'] : null;
        $this->container['pdf_meta_data_template_sequence'] = isset($data['pdf_meta_data_template_sequence']) ? $data['pdf_meta_data_template_sequence'] : null;
        $this->container['server_templates'] = isset($data['server_templates']) ? $data['server_templates'] : null;
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
     * Gets composite_template_id
     *
     * @return string
     */
    public function getCompositeTemplateId()
    {
        return $this->container['composite_template_id'];
    }

    /**
     * Sets composite_template_id
     *
     * @param string $composite_template_id The identify of this composite template. It is used as a reference when adding document object information. If used, the document's `content-disposition` must include the composite template ID to which the document should be added. If a composite template ID is not specified in the content-disposition, the document is applied based on the value of the `documentId` property only. If no document object is specified, the composite template inherits the first document.
     *
     * @return $this
     */
    public function setCompositeTemplateId($composite_template_id)
    {
        $this->container['composite_template_id'] = $composite_template_id;

        return $this;
    }

    /**
     * Gets document
     *
     * @return \DocuSign\eSign\Model\Document
     */
    public function getDocument()
    {
        return $this->container['document'];
    }

    /**
     * Sets document
     *
     * @param \DocuSign\eSign\Model\Document $document document
     *
     * @return $this
     */
    public function setDocument($document)
    {
        $this->container['document'] = $document;

        return $this;
    }

    /**
     * Gets inline_templates
     *
     * @return \DocuSign\eSign\Model\InlineTemplate[]
     */
    public function getInlineTemplates()
    {
        return $this->container['inline_templates'];
    }

    /**
     * Sets inline_templates
     *
     * @param \DocuSign\eSign\Model\InlineTemplate[] $inline_templates Zero or more inline templates and their position in the overlay. If supplied, they are overlaid into the envelope in the order of their Sequence value.
     *
     * @return $this
     */
    public function setInlineTemplates($inline_templates)
    {
        $this->container['inline_templates'] = $inline_templates;

        return $this;
    }

    /**
     * Gets pdf_meta_data_template_sequence
     *
     * @return string
     */
    public function getPdfMetaDataTemplateSequence()
    {
        return $this->container['pdf_meta_data_template_sequence'];
    }

    /**
     * Sets pdf_meta_data_template_sequence
     *
     * @param string $pdf_meta_data_template_sequence 
     *
     * @return $this
     */
    public function setPdfMetaDataTemplateSequence($pdf_meta_data_template_sequence)
    {
        $this->container['pdf_meta_data_template_sequence'] = $pdf_meta_data_template_sequence;

        return $this;
    }

    /**
     * Gets server_templates
     *
     * @return \DocuSign\eSign\Model\ServerTemplate[]
     */
    public function getServerTemplates()
    {
        return $this->container['server_templates'];
    }

    /**
     * Sets server_templates
     *
     * @param \DocuSign\eSign\Model\ServerTemplate[] $server_templates 0 or more server-side templates and their position in the overlay. If supplied, they are overlaid into the envelope in the order of their Sequence value
     *
     * @return $this
     */
    public function setServerTemplates($server_templates)
    {
        $this->container['server_templates'] = $server_templates;

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

