<?php

class HtmlUnicode {
  private $htmlHash;
  private $currentHash;

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

  public function clearHash() {
    $this->htmlHash = NULL;
    $this->currentHash = 10240;
  }

  public function html2plain($html) {

    $document = new DOMDocument();
    $document->loadHTML($html);
    $elements = $document->getElementsByTagName('body')->item(0);

    foreach ($elements->childNodes as $node) {
      $open_tag = htmlentities('<' . $node->tagName . '>');
      $close_tag = htmlentities('</' . $node->tagName . '>');

      $html = str_replace(html_entity_decode($open_tag), $this->pushHash($open_tag), $html);
      $html = str_replace(html_entity_decode($close_tag), $this->pushHash($close_tag), $html);
    }

    return $html;
  }

  public function plain2html($plain) {
    foreach ($this->htmlHash as $tag => $uni) {
      $plain = str_replace($uni, $tag, $plain);
    }

    return $plain;
  }
}
