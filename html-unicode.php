<?php
/**
 * @file
 * Convert html tags to unicode charachters. This is needed for example when you want to make sure a html tag is handled as ONE charachter.
 * This code is a port from examples in the comments here: https://code.google.com/p/google-diff-match-patch/wiki/Plaintext
 *
 */

class HtmlUnicode {
  private $htmlHash;
  private $currentHash;

  function __construct() {
    // Clear the hash table
    $this->clearHash();
  }

  /**
   * Generate a hash for a html tag and saves both to the hash table.
   * They are saved so we can convert back to html again.
   *
   * @param string $tag
   *  The html tag you want to generate a unicode char for.
   *
   * @return string
   *  Returns the generated unicode char.
   */
  private function pushHash($tag) {
    $this->htmlHash;
    $this->currentHash;

    if (!isset($this->htmlHash[$tag])) {
      $unicode = '"\u' . base_convert($this->currentHash, 10, 16) . '"';

      $this->htmlHash[$tag] = json_decode($unicode);

      $this->currentHash++;
    }

    return $this->htmlHash[$tag];
  }

  /**
   * Clear the hash table.
   */
  public function clearHash() {
    $this->htmlHash = NULL;
    $this->currentHash = 10240;
  }

  /**
   * Replace all html tags with unicode chars.
   *
   * @param string $html
   *  String that contains html
   *
   * @return string
   *  Returns the plain text without html tags
   */
  public function html2plain($html) {

    $document = new DOMDocument();
    $document->loadHTML($html);
    $elements = $document->getElementsByTagName('body')->item(0);

    foreach ($elements->childNodes as $node) {
      $open_tag_pattern = '/(<' . $node->tagName . ' .*?>)/i';
      $open_tag = '<' . $node->tagName . '/>';
      $close_tag = '</' . $node->tagName . '>';

      $html = preg_replace($open_tag_pattern, $this->pushHash($open_tag), $html);
      $html = str_ireplace($close_tag, $this->pushHash($close_tag), $html);
    }

    return $html;
  }

  /**
   * Replace unicode chars back to html tags.
   *
   * @param string $plain
   *  String that contains unicode chars an NO html.
   *
   * @return string
   *  Returns html text without the unicode chars.
   */
  public function plain2html($plain) {
    foreach ($this->htmlHash as $tag => $uni) {
      $plain = str_replace($uni, $tag, $plain);
    }

    return $plain;
  }
}
