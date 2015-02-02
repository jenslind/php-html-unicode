<?php
$_htmlHash;
$_currentHash;
$_is_debug = false;

function pushHash($tag) {
  global $_htmlHash;
  global $_currentHash;

  if (!isset($_htmlHash[$tag])) {
    $unicode = '"\u' . base_convert($_currentHash, 10, 16) . '"';

    $_htmlHash[$tag] = json_decode($unicode);

    $_currentHash++;
  }

  return $_htmlHash[$tag];
}

function clearHash() {
  global $_htmlHash;
  global $_currentHash;

  $_htmlHash = NULL;
  $_currentHash = 10240;
}

function html2plain($html) {

  $document = new DOMDocument();
  $document->loadHTML($html);
  $elements = $document->getElementsByTagName('body')->item(0);

  foreach ($elements->childNodes as $node) {
    $open_tag = htmlentities('<' . $node->tagName . '>');
    $close_tag = htmlentities('</' . $node->tagName . '>');

    $html = str_replace(html_entity_decode($open_tag), pushHash($open_tag), $html);
    $html = str_replace(html_entity_decode($close_tag), pushHash($close_tag), $html);
  }

  return $html;
}


function plain2html($plain) {
  global $_htmlHash;

  foreach ($_htmlHash as $tag => $uni) {
    $plain = str_replace($uni, $tag, $plain);
  }

  return $plain;
}
