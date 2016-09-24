<?php 
if (php_sapi_name() != 'cli') return;
require_once(__DIR__."/../../../lib/test.php");
require_once(__DIR__."/../pico_toc.php");

class TOCTestBase extends PHPUnit_Framework_TestCase {

  private $pico;

  private $parsedown;
  
  public function setUp() {
    $this->pico = $GLOBALS['pico'];
    $this->parsedown = new ParsedownExtra();
  }

  /**
   * テスト用のPico_TOCオブジェクトを取得する
   */
  public function getTest() {
    $test = new Pico_TOC($this->pico);
    return $test;
  }

  /**
   * テスト用のHTMLファイルを取得する
   */
  public function getHTML(string $markdown) {
    return $this->parsedown->text($markdown);
  }
  
  /**
   * 警告を出さないためのダミーテスト
   */
  public function test(){
    $this->assertNull(null);
  }
};
?>