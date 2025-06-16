<?php

namespace Codecs;

/**
 * A compound codec that combines multiple codecs into a single one.
 * 
 * @api
 * @final
 * @since 1.0.0
 * @version 1.0.0
 * @package codecs
 * @author Ali M. Kamel <ali.kamel.dev@gmail.com>
 */
final class CompoundCodec implements ICodec {

    /**
     * The codecs that make up this compound codec.
     * 
     * @api
     * @since 1.0.0
     * 
     * @var array<ICodec>
     */
    public readonly array $codecs;

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

        return array_reduce($this->codecs, fn(mixed $_value, ICodec $codec) => $codec->encode($_value), $value);
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

        return array_reduce(array_reverse($this->codecs), fn(string $_code, ICodec $codec) => $codec->decode($_code), $code);
    }

    /**
     * Appends a codec to the end of the compound codec.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param ICodec $codec
     * @return CompoundCodec This instance for method chaining.
     */
    public final function append(ICodec $codec): static {

        array_push($this->codecs, $codec);

        return $this;
    }

    /**
     * Prepends a codec to the beginning of the compound codec.
     * 
     * @api
     * @final
     * @since 1.0.0
     * @version 1.0.0
     * 
     * @param ICodec $codec
     * @return CompoundCodec This instance for method chaining.
     */
    public final function prepend(ICodec $codec): static {

        array_unshift($this->codecs, $codec);

        return $this;
    }
}
