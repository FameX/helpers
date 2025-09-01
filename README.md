helpers
=======

Various small helper classes

## Installation

Just add `"famex/helpers": "0.2.*",` to your `composer.json` file.

## Classes

`DateHelper` currently provides one static function:

`getDateDiff($time1, $time2, $precision = 2)` which takes two UNIX timestamps and returns a string in the format `x days`.

`LatLongDistHelper` currently provides one static function:

`calculate($lat1, $lon1, $lat2, $lon2, $unit = "K")` which returns the distance between two lat/long pairs in km (`K`) or miles (`M`)