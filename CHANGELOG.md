# Changelog

All notable changes to `Http` will be documented in this file.

Updates should follow the [Keep a CHANGELOG](http://keepachangelog.com/) principles.

## [Unreleased](https://github.com/Stadly/HttpTest/compare/v0.6.0...HEAD)

### Added
- Nothing

### Changed
- Refactored code for checking whether byte range covers entire file.
- Refactored code for calculating last byte position for byte ranges.

### Deprecated
- Nothing

### Removed
- Nothing

### Fixed
- Nothing

### Security
- Nothing

## [0.6.0](https://github.com/Stadly/HttpTest/compare/v0.5.0...v0.6.0) - 2018-08-08

### Added
- Possible to check if a byte range is valid.
- Possible to check if a byte range covers an entire file.

### Changed
- Possible to create byte ranges with first byte position greater than last byte position.
- Refactored logic for interpreting rfc850 dates.

### Fixed
- Byte range set factory could not create byte ranges from strings containing whitespace.

## [0.5.0](https://github.com/Stadly/HttpTest/compare/v0.4.1...v0.5.0) - 2018-08-07

### Added
- Possible to iterate over byte range set.
- Possible to iterate over entity tag set.
- Byte range method calculating first byte position when taking file size into consideration.
- Byte range method calculating last byte position when taking file size into consideration.
- Byte range method calculating length of range when taking file size into consideration.

### Changed
- Byte range is not satisfiable when covering to or from end of file and file size is unknown.

### Fixed
- Parameter type hint for ByteRangeSet::isSatisfiable.

## [0.4.1](https://github.com/Stadly/HttpTest/compare/v0.4.0...v0.4.1) - 2018-08-02

### Changed
- Refactored code for constructing date from rfc850 formatted string.

## [0.4.0](https://github.com/Stadly/HttpTest/compare/v0.3.1...v0.4.0) - 2018-08-02

### Added
- HTTP Header value date.

## [0.3.1](https://github.com/Stadly/HttpTest/compare/v0.3.0...v0.3.1) - 2018-08-01

### Added
- Tests for checking byte range and byte range set satisfiability.

### Fixed
- Failing tests.

## [0.3.0](https://github.com/Stadly/HttpTest/compare/v0.2.0...v0.3.0) - 2018-08-01

### Added
- Can check whether byte ranges and byte range sets are satisfiable.

### Changed
- Can create suffix byte ranges of length zero.

## [0.2.0](https://github.com/Stadly/HttpTest/compare/v0.1.0...v0.2.0) - 2018-07-27

### Added
- Separate RFC rules for capturing expressions.
- Method for generating #rule expressions.
- Change header value structure.
- Range HTTP header.

## 0.1.0 - 2018-07-24

### Added
- Content-Type HTTP header.
- ETag HTTP header.
- If-Match HTTP header.
- If-None-Match HTTP header.
