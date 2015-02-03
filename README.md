### PHP helper functions to convert html tags to unicode chars.

This is a PHP-port from the examples in the comments here: https://code.google.com/p/google-diff-match-patch/wiki/Plaintext

#### Usage
```php
  $htmlUnicode = new HtmlUnicode;
  $plain = $htmlUnicode->html2plain($html);
  $html = $htmlUnicode->plain2html($plain);
```
