# Http

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Structure

If any of the following are applicable to your project, then the directory structure should follow industry best practices by being named the following.

```
bin/        
config/
src/
tests/
vendor/
```


## Install

Via Composer

``` bash
$ composer require Stadly/Http
```

## Usage

``` php
$skeleton = new Stadly\Http();
echo $skeleton->echoPhrase('Hello, League!');
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Header fields overview

GENERAL HEADER FIELDS
Representation Metadata:
    Content-Type            https://tools.ietf.org/html/rfc7231#section-3.1.1.5     x
    Content-Encoding        https://tools.ietf.org/html/rfc7231#section-3.1.2.2
    Content-Language        https://tools.ietf.org/html/rfc7231#section-3.1.3.2
    Content-Location        https://tools.ietf.org/html/rfc7231#section-3.1.4.2
Payload Semantics:
    Content-Length          https://tools.ietf.org/html/rfc7230#section-3.3.2
    Content-Range           https://tools.ietf.org/html/rfc7233#section-4.2
    Trailer                 https://tools.ietf.org/html/rfc7230#section-4.4
    Transfer-Encoding       https://tools.ietf.org/html/rfc7230#section-3.3.1

REQUEST HEADER FIELDS
Controls:
    Cache-Control           https://tools.ietf.org/html/rfc7234#section-5.2         x
    Expect                  https://tools.ietf.org/html/rfc7231#section-5.1.1
    Host                    https://tools.ietf.org/html/rfc7230#section-5.4
    Max-Forwards            https://tools.ietf.org/html/rfc7231#section-5.1.2
    Pragma                  https://tools.ietf.org/html/rfc7234#section-5.4         x
    Range                   https://tools.ietf.org/html/rfc7233#section-3.1         x
    TE                      https://tools.ietf.org/html/rfc7230#section-4.3
Conditionals:
    If-Match                https://tools.ietf.org/html/rfc7232#section-3.1         x
    If-None-Match           https://tools.ietf.org/html/rfc7232#section-3.2         x
    If-Modified-Since       https://tools.ietf.org/html/rfc7232#section-3.3         x
    If-Unmodified-Since     https://tools.ietf.org/html/rfc7232#section-3.4         x
    If-Range                https://tools.ietf.org/html/rfc7233#section-3.2         x
Content Negotiation:
    Accept                  https://tools.ietf.org/html/rfc7231#section-5.3.2
    Accept-Charset          https://tools.ietf.org/html/rfc7231#section-5.3.3
    Accept-Encoding         https://tools.ietf.org/html/rfc7231#section-5.3.4
    Accept-Language         https://tools.ietf.org/html/rfc7231#section-5.3.5
Authentication Credentials:
    Authorization           https://tools.ietf.org/html/rfc7235#section-4.2
    Proxy-Authorization     https://tools.ietf.org/html/rfc7235#section-4.4
Request Context:
    From                    https://tools.ietf.org/html/rfc7231#section-5.5.1
    Referer                 https://tools.ietf.org/html/rfc7231#section-5.5.2
    User-Agent              https://tools.ietf.org/html/rfc7231#section-5.5.3

RESPONSE HEADER FIELDS
Control Data:
    Age                     https://tools.ietf.org/html/rfc7234#section-5.1
    Cache-Control           https://tools.ietf.org/html/rfc7234#section-5.2         x
    Expires                 https://tools.ietf.org/html/rfc7234#section-5.3         x
    Date                    https://tools.ietf.org/html/rfc7231#section-7.1.1.2     x
    Location                https://tools.ietf.org/html/rfc7231#section-7.1.2
    Retry-After             https://tools.ietf.org/html/rfc7231#section-7.1.3
    Vary                    https://tools.ietf.org/html/rfc7231#section-7.1.4
    Warning                 https://tools.ietf.org/html/rfc7234#section-5.5
Validator Header Fields:
    ETag                    https://tools.ietf.org/html/rfc7232#section-2.3         x
    Last-Modified           https://tools.ietf.org/html/rfc7232#section-2.2         x
Authentication Challenges:
    WWW-Authenticate        https://tools.ietf.org/html/rfc7235#section-4.1
    Proxy-Authenticate      https://tools.ietf.org/html/rfc7235#section-4.3
Response Context:
    Accept-Ranges           https://tools.ietf.org/html/rfc7233#section-2.3         x
    Allow                   https://tools.ietf.org/html/rfc7231#section-7.4.1
    Server                  https://tools.ietf.org/html/rfc7231#section-7.4.2
Other:
    Content-Disposition     https://tools.ietf.org/html/rfc6266#section-4           x


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email magnar@myrtveit.com instead of using the issue tracker.

## Credits

- [Magnar Ovedal Myrtveit][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/Stadly/Http.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Stadly/Http/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Stadly/Http.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Stadly/Http.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/Stadly/Http.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/Stadly/Http
[link-travis]: https://travis-ci.org/Stadly/Http
[link-scrutinizer]: https://scrutinizer-ci.com/g/Stadly/Http/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Stadly/Http
[link-downloads]: https://packagist.org/packages/Stadly/Http
[link-author]: https://github.com/Stadly
[link-contributors]: ../../contributors
