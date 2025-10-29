<?php

namespace Codecs;

use Logger\{ EmitsLogs, Logger };

/**
 * @api
 * @abstract
 * @since 1.1.0
 * @version 1.0.0
 * @package codecs
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
abstract class Codec implements ICodec {

    use EmitsLogs;

    /**
     * The logger instance.
     * 
     * @internal
     * @since 1.0.0
     * 
     * @var Logger|null $logger
     */
    protected ?Logger $logger = null;

    /**
     * Sets the logger instance.
     * 
     * @api
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param Logger|null $logger
     * @return void
     */
    public function setLogger(?Logger $logger): void {

        $this->logger = $logger;
    }

    /**
     * Encodes a value into a string representation.
     * 
     * @api
     * @final
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param mixed $value
     * @return string
     */
    public final function encode(mixed $value): string {

        $logUnit = static::class . '::' . __FUNCTION__;

        $this->debugLog('pre-encode', [ 'type' => ($type = gettype($value)) === 'object' ? get_class($value) : $type ], $logUnit);

        $code = $this->doEncode($value);

        $this->debugLog('post-encode', [ 'length' => (function_exists('mb_strlen') ? mb_strlen($code) : strlen($code)) ], $logUnit);

        return $code;
    }

    /**
     * Decodes a string representation back into its original value.
     * 
     * @api
     * @final
     * @override
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $code
     * @return mixed
     */
    public final function decode(string $code): mixed {

        $logUnit = static::class . '::' . __FUNCTION__;

        $this->debugLog('pre-decode', [ 'length' => (function_exists('mb_strlen') ? mb_strlen($code) : strlen($code)) ], $logUnit);

        /** @var mixed $value */
        $value = $this->doDecode($code);

        $this->debugLog('post-decode', [ 'type' => ($type = gettype($value)) === 'object' ? get_class($value) : $type ], $logUnit);

        return $value;
    }

    /**
     * Encodes a value into a string representation.
     * 
     * @internal
     * @abstract
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param mixed $value
     * @return string
     */
    protected abstract function doEncode(mixed $value): string;

    /**
     * Decodes a string representation back into its original value.
     * 
     * @internal
     * @abstract
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $code
     * @return mixed
     */
    protected abstract function doDecode(string $code): mixed;
}
