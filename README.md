# Exporter
Library to export data in various input formats to various output formats.

[![Coverage Status](https://coveralls.io/repos/RonRademaker/Exporter/badge.svg?branch=master&service=github)](https://coveralls.io/github/RonRademaker/Exporter?branch=master)
[![Build Status](https://travis-ci.org/RonRademaker/Exporter.svg?branch=master)](https://travis-ci.org/RonRademaker/Exporter)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/93e57612-46fc-402b-b339-f733dd284d10/mini.png)](https://insight.sensiolabs.com/projects/93e57612-46fc-402b-b339-f733dd284d10)

# Installation

``` bash
composer require ronrademaker/exporter
```

# Usage

## Output an array to CSV in a file

``` php
$someArray = [
  ['foo' => 'foo', 'bar' => 'bar'],
  ['foo' => 'foobar', 'bar' => 'baz'],
  ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'],
  ['foo' => 'bar', 'baz' => 'bar'],
  ['foo' => 'baz', 'bar' => 'foobar'],
];

$data = new ArrayData($someArray);
$fileOption = new FileOption($outputFile);
$exporter = new CSVExporter();
$exporter->export($data, [$fileOption]);
```

or

``` php
$someArray = [
  ['foo' => 'foo', 'bar' => 'bar'],
  ['foo' => 'foobar', 'bar' => 'baz'],
  ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'],
  ['foo' => 'bar', 'baz' => 'bar'],
  ['foo' => 'baz', 'bar' => 'foobar'],
];

$data = new ArrayData($someArray);
$fileOption = new FileOption($outputFile);
$exporter = new CSVExporter();
$exporter->setOption($fileOption);
$exporter->setInput($data);
$exporter->export();
```

## Add headers to control output CSV

Only ```baz``` and ```foo``` will be in the resulting CSV and the order of the columns will be as set in the HeadersOption.

``` php
$someArray = [
  ['foo' => 'foo', 'bar' => 'bar'],
  ['foo' => 'foobar', 'bar' => 'baz'],
  ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'],
  ['foo' => 'bar', 'baz' => 'bar'],
  ['foo' => 'baz', 'bar' => 'foobar'],
];
$outputFile = 'output.csv';

$headers = new HeadersOption(['baz', 'foo']);
$data = new ArrayData($someArray);
$fileOption = new FileOption($outputFile);
$exporter = new CSVExporter();
$exporter->export($data, [$headersOption, $fileOption]);
```

## Output to multiple files

``` php
$someArray = [
  ['foo' => 'foo', 'bar' => 'bar'],
  ['foo' => 'foobar', 'bar' => 'baz'],
  ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'],
  ['foo' => 'bar', 'baz' => 'bar'],
  ['foo' => 'baz', 'bar' => 'foobar'],
];
$outputFile = 'output.csv';
$otherFile = sprintf('/data/dropbox/output-%s.csv', date('Ymd'));

$headers = new HeadersOption(['baz', 'foo']);
$data = new ArrayData($someArray);
$options = [
  $headers,
  new FileOption($outputFile),
  new FileOption($otherFile),
];

$exporter = new CSVExporter();
$exporter->export($data, $options);
```

## Error Handling

``` php
$someArray = [
  ['foo' => 'foo', 'bar' => 'bar', ['impossible' => 'input']],
  ['foo' => 'foobar', 'bar' => 'baz'],
  ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'],
  ['foo' => 'bar', 'baz' => 'bar'],
  ['foo' => 'baz', 'bar' => 'foobar'],
];
$outputFile = 'output.csv';
$otherFile = sprintf('/data/dropbox/output-%s.csv', date('Ymd'));

$headers = new HeadersOption(['baz', 'foo']);
$data = new ArrayData($someArray);
$options = [
  $headers,
  new FileOption($outputFile),
  new FileOption($otherFile),
];

try {
  $exporter = new CSVExporter();
  $exporter->export($data, $options);
} catch (UnsupportedDataException $e) {
  echo sprintf('The given input is not valid: %s', $e->getMessage());
}
```

# Exporting multiple, similar input

``` php
$someArray = [
  ['foo' => 'foo', 'bar' => 'bar'],
  ['foo' => 'foobar', 'bar' => 'baz'],
  ['foo' => 'foo', 'bar' => 'bar', 'baz' => 'baz'],
  ['foo' => 'bar', 'baz' => 'bar'],
  ['foo' => 'baz', 'bar' => 'foobar'],
];
$somePluralArray = [
  ['foo' => 'foos', 'bar' => 'bars'],
  ['foo' => 'foobars', 'bar' => 'bazs'],
  ['foo' => 'foos', 'bar' => 'bars', 'baz' => 'bazs'],
  ['foo' => 'bars', 'baz' => 'bars'],
  ['foo' => 'bazs', 'bar' => 'foobars'],
];

$headers = new HeadersOption(['baz', 'foo']);
$exporter = new CSVExporter([$headers]);

$outputFileOption = new FileOption('output.csv');
$outputPluralFileOption = new FileOption('outputs.csv');

$inputData = new ArrayData($someArray);
$inputPluralData = new ArrayData($somePlurarData);

$exporter->setOption($outputFileOption, true);
$exporter->export($inputData);

$exporter->setOption($outputPluralFileOption, true);
$exporter->export($inputPluralData);
```
