<?php

namespace Codecs;

use Logger\IHasLogger;

/**
 * @api
 * @interface
 * @since 1.0.0
 * @version 1.1.0
 * @package codecs
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
interface ICodec extends IHasLogger {

    /**
     * Encodes a value into a string representation.
     * 
     * @api
     * @abstract
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param mixed $value
     * @return string
     */
    function encode(mixed $value): string;

    /**
     * Decodes a string representation back into its original value.
     * 
     * @api
     * @abstract
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param string $code
     * @return mixed
     */
    function decode(string $code): mixed;
}
