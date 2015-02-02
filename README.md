### PHP helper functions to convert html tags to unicode chars.

This is a PHP-port from the examples in the comments here: https://code.google.com/p/google-diff-match-patch/wiki/Plaintext

#### Usage
```php
  clearHash();
  $plain = html2plain($html);
  $html = plain2html($plain);
```
