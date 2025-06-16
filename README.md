# Codecs

**A collection of codecs for encoding and decoding data in various formats.**

- [Codecs](#codecs)
  - [Installation](#installation)
  - [Usage](#usage)

***

## Installation

Install *codecs* via Composer:

```bash
composer require ali-eltaweel/codecs
```

## Usage

```php
use Codecs\ICodec;

final class Base64Codec implements ICodec {

    public final function __construct(public readonly bool $strict = false) {}
    
    public final function encode(mixed $value): string {

        return base64_encode($value);
    }

    public final function decode(string $code): mixed {

        return base64_decode($code, $this->strict);
    }
}

$base64Codec = new Base64Codec();

var_dump(
    $base64Codec->encode('Hello, World!'),
    $base64Codec->decode($base64Codec->encode('Hello, World!'))
);

```
