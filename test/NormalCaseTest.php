<?php
if (php_sapi_name() != 'cli') return;
require_once('Base.php');

class NormalCaseTest extends TOCTestBase
{
  /**
  * 以下の状態において、TOCテキストおよび、コンテントへのid挿入が正常に行われることを確認する
  *
  * 入力値：見出し一つのみ
  */
  public function test1HeaderFrom1() {
    Closure::bind(function() {
      $test = $this->getTest();
      $html = $this->getHTML("# This is a Test");
      $toc = $test->createTOC($html);
      $this->assertContains('<h1 id="toc_1">This is a Test</h1>', $html);
      $this->assertEquals('<ol><li><a href="#toc_1">This is a Test</a></li></ol>', $toc);
    }, $this, 'Pico_TOC')->__invoke();
  }

  /**
  * 以下の状態において、TOCテキストおよび、コンテントへのid挿入が正常に行われることを確認する
  *
  * 入力値：見出し三つ。見出しレベルがすべて同一
  */
  public function test3HeaderFrom1FlatLevel() {
    Closure::bind(function() {
      $test = $this->getTest();
      $html = $this->getHTML("# This is a Test\n# This Level 1\n# This Level 1");
      $toc = $test->createTOC($html);
      $this->assertContains('<h1 id="toc_1">This is a Test</h1>', $html);
      $this->assertContains('<h1 id="toc_2">This Level 1</h1>', $html);
      $this->assertContains('<h1 id="toc_3">This Level 1</h1>', $html);
      $this->assertEquals('<ol><li><a href="#toc_1">This is a Test</a></li>' .
        '<li><a href="#toc_2">This Level 1</a></li>' . 
        '<li><a href="#toc_3">This Level 1</a></li></ol>', $toc);
    }, $this, 'Pico_TOC')->__invoke();
  }

  /**
  * 以下の状態において、TOCテキストおよび、コンテントへのid挿入が正常に行われることを確認する
  *
  * 入力値：見出し三つ。見出しレベルが1，2，3
  */
  public function test3HeaderFrom1StepupLevel() {
    Closure::bind(function() {
      $test = $this->getTest();
      $html = $this->getHTML("# This is a Test\n## This Level 2\n### This Level 3");
      $toc = $test->createTOC($html);
      $this->assertContains('<h1 id="toc_1">This is a Test</h1>', $html);
      $this->assertContains('<h2 id="toc_2">This Level 2</h2>', $html);
      $this->assertContains('<h3 id="toc_3">This Level 3</h3>', $html);
      $this->assertEquals('<ol><li><a href="#toc_1">This is a Test</a>' .
        '<ol><li><a href="#toc_2">This Level 2</a>' . 
        '<ol><li><a href="#toc_3">This Level 3</a></li></ol></li></ol></li></ol>', $toc);
    }, $this, 'Pico_TOC')->__invoke();
  }

  /**
  * 以下の状態において、TOCテキストおよび、コンテントへのid挿入が正常に行われることを確認する
  *
  * 入力値：見出し三つで、見出しレベルの増減を含む
  */
  public function test3HeaderFrom1WithLevelUpDown() {
    Closure::bind(function() {
      $test = $this->getTest();
      $html = $this->getHTML("# This is a Test\n## This Level 2\n# This Level 1");
      $toc = $test->createTOC($html);
      $this->assertContains('<h1 id="toc_1">This is a Test</h1>', $html);
      $this->assertContains('<h2 id="toc_2">This Level 2</h2>', $html);
      $this->assertContains('<h1 id="toc_3">This Level 1</h1>', $html);
      $this->assertEquals('<ol><li><a href="#toc_1">This is a Test</a>' .
        '<ol><li><a href="#toc_2">This Level 2</a></li></ol></li>' . 
        '<li><a href="#toc_3">This Level 1</a></li></ol>', $toc);
    }, $this, 'Pico_TOC')->__invoke();
  }

  /**
  * 以下の状態において、TOCテキストおよび、コンテントへのid挿入が正常に行われることを確認する
  *
  * 入力値：見出し三つ。見出しレベルが一度に二つ以上増減する
  */
  public function test3HeaderFrom1WithLevelJumpUpAndDown() {
    Closure::bind(function() {
      $test = $this->getTest();
      $html = $this->getHTML("# This is a Test\n#### This Level 4\n## This Level 2");
      $toc = $test->createTOC($html);
      $this->assertContains('<h1 id="toc_1">This is a Test</h1>', $html);
      $this->assertContains('<h4 id="toc_2">This Level 4</h4>', $html);
      $this->assertContains('<h2 id="toc_3">This Level 2</h2>', $html);
      $this->assertEquals('<ol><li><a href="#toc_1">This is a Test</a>' .
        '<ol><li><ol><li><ol><li><a href="#toc_2">This Level 4</a></li></ol></li></ol></li>' . 
        '<li><a href="#toc_3">This Level 2</a></li></ol></li></ol>', $toc);
    }, $this, 'Pico_TOC')->__invoke();
  }

}