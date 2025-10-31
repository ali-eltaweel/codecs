<?php

namespace Codecs;

use Logger\Logger;

/**
 * A compound codec that combines multiple codecs into a single one.
 * 
 * @api
 * @final
 * @since 1.0.0
 * @version 1.2.0
 * @package codecs
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class CompoundCodec extends Codec {

    /**
     * The codecs that make up this compound codec.
     * 
     * @internal
     * @since 1.0.0
     * 
     * @var array<ICodec>
     */
    private array $codecs;

    /**
     * Creates a new instance of the compound codec.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param ICodec ...$codecs The codecs to combine.
     */
    public final function __construct(ICodec $codec, ICodec ...$codecs) {

        $this->codecs = [ $codec, ...$codecs ];
    }

    /**
     * Sets the logger to be used by this codec and its child codecs.
     * 
     * @api
     * @final
     * @since 1.1.0
     * @version 1.0.0
     * 
     * @param Logger|null $logger
     * @return void
     */
    public final function setLogger(?Logger $logger): void {

        parent::setLogger($logger);

        foreach ($this->codecs as $codec) {
            
            $codec->setLogger($logger);
        }
    }

    /**
     * Appends a codec to the end of the compound codec.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.2.0
     * 
     * @param ICodec $codec
     * @return CompoundCodec This instance for method chaining.
     */
    public final function append(ICodec $codec): static {

        $this->infoLog(fn() => [
            'Appending codec' => [ 'type' => $codec::class, 'id' => spl_object_id($codec) ]
        ], static::class . '::' . __FUNCTION__);

        array_push($this->codecs, $codec);

        $codec->setLogger($this->logger);

        return $this;
    }

    /**
     * Prepends a codec to the beginning of the compound codec.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.2.0
     * 
     * @param ICodec $codec
     * @return CompoundCodec This instance for method chaining.
     */
    public final function prepend(ICodec $codec): static {

        $this->infoLog(fn() => [
            'Prepending codec' => [ 'type' => $codec::class, 'id' => spl_object_id($codec) ]
        ], static::class . '::' . __FUNCTION__);

        array_unshift($this->codecs, $codec);

        $codec->setLogger($this->logger);

        return $this;
    }
    
    /**
     * Encodes a value into a string representation.
     * 
     * @final
     * @internal
     * @override
     * @since 1.1.0
     * @version 1.0.0
     * 
     * @param mixed $value
     * @return string
     */
    protected final function doEncode(mixed $value): string {

        return array_reduce($this->codecs, fn(mixed $_value, ICodec $codec) => $codec->encode($_value), $value);
    }

    /**
     * Decodes a string representation back into its original value.
     * 
     * @final
     * @internal
     * @override
     * @since 1.1.0
     * @version 1.0.0
     * 
     * @param string $code
     * @return mixed
     */
    protected final function doDecode(string $code): mixed {

        return array_reduce(array_reverse($this->codecs), fn(string $_code, ICodec $codec) => $codec->decode($_code), $code);
    }
}
