<?php
/**
 * PrefillTabs
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
 * PrefillTabs Class Doc Comment
 *
 * @category    Class
 * @package     DocuSign\eSign
 * @author      Swagger Codegen team
 * @link        https://github.com/swagger-api/swagger-codegen
 */
class PrefillTabs implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'prefillTabs';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'checkbox_tabs' => '\DocuSign\eSign\Model\Checkbox[]',
        'radio_group_tabs' => '\DocuSign\eSign\Model\RadioGroup[]',
        'tab_groups' => '\DocuSign\eSign\Model\TabGroup[]',
        'text_tabs' => '\DocuSign\eSign\Model\Text[]'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'checkbox_tabs' => null,
        'radio_group_tabs' => null,
        'tab_groups' => null,
        'text_tabs' => null
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
        'checkbox_tabs' => 'checkboxTabs',
        'radio_group_tabs' => 'radioGroupTabs',
        'tab_groups' => 'tabGroups',
        'text_tabs' => 'textTabs'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'checkbox_tabs' => 'setCheckboxTabs',
        'radio_group_tabs' => 'setRadioGroupTabs',
        'tab_groups' => 'setTabGroups',
        'text_tabs' => 'setTextTabs'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'checkbox_tabs' => 'getCheckboxTabs',
        'radio_group_tabs' => 'getRadioGroupTabs',
        'tab_groups' => 'getTabGroups',
        'text_tabs' => 'getTextTabs'
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
        $this->container['checkbox_tabs'] = isset($data['checkbox_tabs']) ? $data['checkbox_tabs'] : null;
        $this->container['radio_group_tabs'] = isset($data['radio_group_tabs']) ? $data['radio_group_tabs'] : null;
        $this->container['tab_groups'] = isset($data['tab_groups']) ? $data['tab_groups'] : null;
        $this->container['text_tabs'] = isset($data['text_tabs']) ? $data['text_tabs'] : null;
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
     * Gets checkbox_tabs
     *
     * @return \DocuSign\eSign\Model\Checkbox[]
     */
    public function getCheckboxTabs()
    {
        return $this->container['checkbox_tabs'];
    }

    /**
     * Sets checkbox_tabs
     *
     * @param \DocuSign\eSign\Model\Checkbox[] $checkbox_tabs Specifies a tag on the document in a location where the recipient can select an option.
     *
     * @return $this
     */
    public function setCheckboxTabs($checkbox_tabs)
    {
        $this->container['checkbox_tabs'] = $checkbox_tabs;

        return $this;
    }

    /**
     * Gets radio_group_tabs
     *
     * @return \DocuSign\eSign\Model\RadioGroup[]
     */
    public function getRadioGroupTabs()
    {
        return $this->container['radio_group_tabs'];
    }

    /**
     * Sets radio_group_tabs
     *
     * @param \DocuSign\eSign\Model\RadioGroup[] $radio_group_tabs Specifies a tag on the document in a location where the recipient can select one option from a group of options using a radio button. The radio buttons do not have to be on the same page in a document.
     *
     * @return $this
     */
    public function setRadioGroupTabs($radio_group_tabs)
    {
        $this->container['radio_group_tabs'] = $radio_group_tabs;

        return $this;
    }

    /**
     * Gets tab_groups
     *
     * @return \DocuSign\eSign\Model\TabGroup[]
     */
    public function getTabGroups()
    {
        return $this->container['tab_groups'];
    }

    /**
     * Sets tab_groups
     *
     * @param \DocuSign\eSign\Model\TabGroup[] $tab_groups 
     *
     * @return $this
     */
    public function setTabGroups($tab_groups)
    {
        $this->container['tab_groups'] = $tab_groups;

        return $this;
    }

    /**
     * Gets text_tabs
     *
     * @return \DocuSign\eSign\Model\Text[]
     */
    public function getTextTabs()
    {
        return $this->container['text_tabs'];
    }

    /**
     * Sets text_tabs
     *
     * @param \DocuSign\eSign\Model\Text[] $text_tabs Specifies a that that is an adaptable field that allows the recipient to enter different text information.  When getting information that includes this tab type, the original value of the tab when the associated envelope was sent is included in the response.
     *
     * @return $this
     */
    public function setTextTabs($text_tabs)
    {
        $this->container['text_tabs'] = $text_tabs;

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

