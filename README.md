# BetterSerializer (PHP)

This library provides a general serializer for PHP. Currently only JSON serialization format is supported.
The project aims to be an alternative to [JmsSerializer](https://github.com/schmittjoh/serializer). It tries
to be faster then JmsSerializer and it also tries to sustain a better maintainable and understandable code base.
Also, as this is also a learning experiment, one of the goals is to have unit tests with 100% code coverage.

Except the above mentioned goals, the project also aims to provide some cool features - it tries to combine 
the best features from JmsSerializer and from [Jackson](https://github.com/FasterXML/jackson) in Java.

## Current state

Regarding the features from other serializers - none of them are implemented yet :) With two exceptions - if you are
using `@var` docblock annotations in class properties, you don't need to define the `@Type` serialization annotation, which
would be duplicit in this case. Regarding the other feature - you don't have to declare full classified class name
in the `@var` or `@Type` annotations. The serializer automatically checks for the class existence in the same namespace 
which the owning class resides in.

Currently, only JSON de/serialization is implemented. It's possible to de/serialize complex nested data structures
(objects and arrays). Only arrays are supported as collection types for now.

For now the code is only a proof of concept, but it already yields interesting results. Without implementing
metadata caching, the serialization process is already 
[5-6x faster](tests/Performance/Serialization/JsonTest.php) than using JmsSerializer. 
The deserialization process is also faster, but only [cca 3x faster](tests/Performance/Deserialization/JsonTest.php).

Regarding the performance gains - I'd like someone to check the measured values, since the results seem quite great
and I'm suspicious myself :).

## Requirements

This library requires PHP 7.1 and it won't work with older versions. Older versions won't be supported.

## Usage

The usage is quite simple for now. There is a builder which creates an instance of the serializer.
These are examples for [serialization](tests/Integration/Serialization/JsonTest.php) 
and for [deserialization](tests/Integration/Serialization/JsonTest.php) usage.

Regarding class annotations, check these [example DTOs](tests/BetterSerializer/Dto).

## Future Plans
- primitive type conversion (currently there is no conversion of primitive types)
- metadata caching
- XML and YAML support
- various collection classes support (Doctrine collections, internal PHP collections like SplStack)
- data injection using class constructors (internal and static), which should improve performance even more
- various features import from JmsSerializer and Jackson
- framework integrations

**Contributions are welcome! :)**
