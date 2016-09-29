# Haxball Replay Parser

Parses a [haxball](http://haxball.com) replay file

```
composer require jonnyynnoj/haxball-replay-parser
```

## Usage

```php
$file = fopen('path\to\replay.hbr', 'r');
// OR
$file = file_get_contents('path\to\replay.hbr');

$parser = new ReplayParser\Parser($file);
$replay = $parser->parse();
```

Output as JSON:

```php
echo json_encode($replay);
```
