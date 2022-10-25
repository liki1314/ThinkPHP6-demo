<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: cls.proto

namespace Cls;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>cls.LogGroup</code>
 */
class LogGroup extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>repeated .cls.Log logs = 1;</code>
     */
    private $logs;
    /**
     * Generated from protobuf field <code>string contextFlow = 2;</code>
     */
    private $contextFlow = '';
    /**
     * Generated from protobuf field <code>string filename = 3;</code>
     */
    private $filename = '';
    /**
     * Generated from protobuf field <code>string source = 4;</code>
     */
    private $source = '';
    /**
     * Generated from protobuf field <code>repeated .cls.LogTag logTags = 5;</code>
     */
    private $logTags;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Cls\Log[]|\Google\Protobuf\Internal\RepeatedField $logs
     *     @type string $contextFlow
     *     @type string $filename
     *     @type string $source
     *     @type \Cls\LogTag[]|\Google\Protobuf\Internal\RepeatedField $logTags
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Cls::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>repeated .cls.Log logs = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Generated from protobuf field <code>repeated .cls.Log logs = 1;</code>
     * @param \Cls\Log[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setLogs($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Cls\Log::class);
        $this->logs = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string contextFlow = 2;</code>
     * @return string
     */
    public function getContextFlow()
    {
        return $this->contextFlow;
    }

    /**
     * Generated from protobuf field <code>string contextFlow = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setContextFlow($var)
    {
        GPBUtil::checkString($var, True);
        $this->contextFlow = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string filename = 3;</code>
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Generated from protobuf field <code>string filename = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setFilename($var)
    {
        GPBUtil::checkString($var, True);
        $this->filename = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string source = 4;</code>
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Generated from protobuf field <code>string source = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setSource($var)
    {
        GPBUtil::checkString($var, True);
        $this->source = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .cls.LogTag logTags = 5;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getLogTags()
    {
        return $this->logTags;
    }

    /**
     * Generated from protobuf field <code>repeated .cls.LogTag logTags = 5;</code>
     * @param \Cls\LogTag[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setLogTags($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Cls\LogTag::class);
        $this->logTags = $arr;

        return $this;
    }

}

