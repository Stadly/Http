# Http

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A PHP library for parsing and building HTTP headers.

## Install

Via Composer

``` bash
$ composer require stadly/http
```

## Usage

### Parsing HTTP headers

Header values can be parsed using `fromValue` on each header class:

``` php
use Stadly\Http\Header\Common\ContentType;
use Stadly\Http\Header\Request\IfNoneMatch;
use Stadly\Http\Header\Response\ContentDisposition;

$contentType = ContentType::fromValue($_SERVER['HTTP_CONTENT_TYPE']);
$ifNoneMatch = IfNoneMatch::fromValue($_SERVER['HTTP_IF_NONE_MATCH']);
$contentDisposition = ContentDisposition::fromValue($_SERVER['HTTP_CONTENT_DISPOSITION']);
```

Header strings can be parsed using `HeaderFactory::fromString`:

``` php
use Stadly\Http\Header\Request\HeaderFactory as RequestHeaderFactory;
use Stadly\Http\Header\Response\HeaderFactory as ResponseHeaderFactory;

$requestHeaders = [
    'Content-Type: text/html; charset=UTF-8',
    'If-Match: "67ab43", "54ed21", W/"7892dd"',
    'Range: bytes=10-100, 200-300',
];
foreach ($requestHeaders as $headerString) {
    $header = RequestHeaderFactory::fromString($headerString);
}

$responseHeaders = [
    'Content-Type: multipart/form-data; boundary="abc def"',
    'Cache-Control: no-cache="foo, bar", max-age=120, must-revalidate',
    "Content-Disposition: attachment; filename=unicorn.jpg; filename*=UTF-8''%F0%9F%A6%84.jpg",
];
foreach ($responseHeaders as $headerString) {
    $header = ResponseHeaderFactory::fromString($headerString);
}
```

Note that header strings include the header name, while header values do not. The following results in identical headers:

``` php
use Stadly\Http\Header\Response\ContentDisposition;
use Stadly\Http\Header\Response\HeaderFactory;

$header1 = ContentDisposition::fromValue('inline; filename=image.jpg');
$header2 = HeaderFactory::fromString('Content-Disposition: inline; filename=image.jpg');
```

### Example usage

Example parsing the `If-None-Match` request header and using it to determine whether to serve a file. The response headers `Content-Disposition` and `ETag` are built for serving the file.

``` php
use Stadly\Http\Header\Request\IfNoneMatch;
use Stadly\Http\Header\Response\ContentDisposition;
use Stadly\Http\Header\Response\ETag;
use Stadly\Http\Header\Value\EntityTag\EntityTag;

$entityTag = new EntityTag(md5($filename));
$ifNoneMatch = IfNoneMatch::fromValue($_SERVER['HTTP_IF_NONE_MATCH']);

if ($ifNoneMatch->evaluate($entityTag)) {
    // Serve file.
    $contentDisposition = new ContentDisposition('attachment');
    $contentDisposition->setFilename(basename($filename));
    header((string)$contentDisposition);

    $eTag = new ETag($entityTag);
    header((string)$eTag);

    readfile($filename);
} else {
    // 304 Not modified.
    http_response_code(304);
}
```

## Header fields overview

The checked header fields have been implemented.

### Common header fields

#### Representation Metadata
 - [x] Content-Type            https://tools.ietf.org/html/rfc7231#section-3.1.1.5
 - [ ] Content-Encoding        https://tools.ietf.org/html/rfc7231#section-3.1.2.2
 - [ ] Content-Language        https://tools.ietf.org/html/rfc7231#section-3.1.3.2
 - [ ] Content-Location        https://tools.ietf.org/html/rfc7231#section-3.1.4.2

#### Payload Semantics
 - [ ] Content-Length          https://tools.ietf.org/html/rfc7230#section-3.3.2
 - [ ] Content-Range           https://tools.ietf.org/html/rfc7233#section-4.2
 - [ ] Trailer                 https://tools.ietf.org/html/rfc7230#section-4.4
 - [ ] Transfer-Encoding       https://tools.ietf.org/html/rfc7230#section-3.3.1

### Request header fields

#### Controls
 - [ ] Cache-Control           https://tools.ietf.org/html/rfc7234#section-5.2
 - [ ] Expect                  https://tools.ietf.org/html/rfc7231#section-5.1.1
 - [ ] Host                    https://tools.ietf.org/html/rfc7230#section-5.4
 - [ ] Max-Forwards            https://tools.ietf.org/html/rfc7231#section-5.1.2
 - [ ] Pragma                  https://tools.ietf.org/html/rfc7234#section-5.4
 - [x] Range                   https://tools.ietf.org/html/rfc7233#section-3.1
 - [ ] TE                      https://tools.ietf.org/html/rfc7230#section-4.3

#### Conditionals
 - [x] If-Match                https://tools.ietf.org/html/rfc7232#section-3.1
 - [x] If-None-Match           https://tools.ietf.org/html/rfc7232#section-3.2
 - [x] If-Modified-Since       https://tools.ietf.org/html/rfc7232#section-3.3
 - [x] If-Unmodified-Since     https://tools.ietf.org/html/rfc7232#section-3.4
 - [x] If-Range                https://tools.ietf.org/html/rfc7233#section-3.2

#### Content Negotiation
 - [ ] Accept                  https://tools.ietf.org/html/rfc7231#section-5.3.2
 - [ ] Accept-Charset          https://tools.ietf.org/html/rfc7231#section-5.3.3
 - [ ] Accept-Encoding         https://tools.ietf.org/html/rfc7231#section-5.3.4
 - [ ] Accept-Language         https://tools.ietf.org/html/rfc7231#section-5.3.5

#### Authentication Credentials
 - [ ] Authorization           https://tools.ietf.org/html/rfc7235#section-4.2
 - [ ] Proxy-Authorization     https://tools.ietf.org/html/rfc7235#section-4.4

#### Request Context
 - [ ] From                    https://tools.ietf.org/html/rfc7231#section-5.5.1
 - [ ] Referer                 https://tools.ietf.org/html/rfc7231#section-5.5.2
 - [ ] User-Agent              https://tools.ietf.org/html/rfc7231#section-5.5.3

### Response header fields

#### Control Data
 - [ ] Age                     https://tools.ietf.org/html/rfc7234#section-5.1
 - [x] Cache-Control           https://tools.ietf.org/html/rfc7234#section-5.2
 - [ ] Expires                 https://tools.ietf.org/html/rfc7234#section-5.3
 - [ ] Date                    https://tools.ietf.org/html/rfc7231#section-7.1.1.2
 - [ ] Location                https://tools.ietf.org/html/rfc7231#section-7.1.2
 - [ ] Retry-After             https://tools.ietf.org/html/rfc7231#section-7.1.3
 - [ ] Vary                    https://tools.ietf.org/html/rfc7231#section-7.1.4
 - [ ] Warning                 https://tools.ietf.org/html/rfc7234#section-5.5

#### Validator Header Fields
 - [x] ETag                    https://tools.ietf.org/html/rfc7232#section-2.3
 - [ ] Last-Modified           https://tools.ietf.org/html/rfc7232#section-2.2

#### Authentication Challenges
 - [ ] WWW-Authenticate        https://tools.ietf.org/html/rfc7235#section-4.1
 - [ ] Proxy-Authenticate      https://tools.ietf.org/html/rfc7235#section-4.3

#### Response Context
 - [ ] Accept-Ranges           https://tools.ietf.org/html/rfc7233#section-2.3
 - [ ] Allow                   https://tools.ietf.org/html/rfc7231#section-7.4.1
 - [ ] Server                  https://tools.ietf.org/html/rfc7231#section-7.4.2

#### Other
 - [x] Content-Disposition     https://tools.ietf.org/html/rfc6266#section-4

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email magnar@myrtveit.com instead of using the issue tracker.

## Credits

- [Magnar Ovedal Myrtveit][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/stadly/http.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/Stadly/Http.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Stadly/Http.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/stadly/http.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/stadly/http
[link-scrutinizer]: https://scrutinizer-ci.com/g/Stadly/Http/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/Stadly/Http
[link-downloads]: https://packagist.org/packages/stadly/http
[link-author]: https://github.com/Stadly
[link-contributors]: ../../contributors
