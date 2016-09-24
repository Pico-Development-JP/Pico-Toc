<?php
if (php_sapi_name() != 'cli') return;
require_once('Base.php');

class SeminormalCaseTest extends TOCTestBase
{
  /**
  * 以下の状態において、TOCテキストおよび、コンテントへのid挿入が正常に行われることを確認する
  *
  * 入力値：見出し一つのみ。見出しレベルは3
  */
  public function test1HeaderFrom3() {
    Closure::bind(function() {
      $test = $this->getTest();
      $html = $this->getHTML("### This is a Test");
      $toc = $test->createTOC($html);
      $this->assertContains('<h3 id="toc_1">This is a Test</h3>', $html);
      $this->assertEquals('<ol><li><a href="#toc_1">This is a Test</a></li></ol>', $toc);
    }, $this, 'Pico_TOC')->__invoke();
  }

  /**
  * 以下の状態において、TOCテキストおよび、コンテントへのid挿入が正常に行われることを確認する
  *
  * 入力値：見出し三つ。見出しレベルは3、見出しレベルがすべて同一
  */
  public function test3HeaderFrom3FlatLevel() {
    Closure::bind(function() {
      $test = $this->getTest();
      $html = $this->getHTML("### This is a Test\n### This Level 3\n### This Level 3");
      $toc = $test->createTOC($html);
      $this->assertContains('<h3 id="toc_1">This is a Test</h3>', $html);
      $this->assertContains('<h3 id="toc_2">This Level 3</h3>', $html);
      $this->assertContains('<h3 id="toc_3">This Level 3</h3>', $html);
      $this->assertEquals('<ol><li><a href="#toc_1">This is a Test</a></li>' .
        '<li><a href="#toc_2">This Level 3</a></li>' . 
        '<li><a href="#toc_3">This Level 3</a></li></ol>', $toc);
    }, $this, 'Pico_TOC')->__invoke();
  }

  /**
  * 以下の状態において、TOCテキストおよび、コンテントへのid挿入が正常に行われることを確認する
  *
  * 入力値：見出し三つ。見出しレベルが3，4，5
  */
  public function test3HeaderFrom3StepupLevel() {
    Closure::bind(function() {
      $test = $this->getTest();
      $html = $this->getHTML("### This is a Test\n#### This Level 4\n##### This Level 5");
      $toc = $test->createTOC($html);
      $this->assertContains('<h3 id="toc_1">This is a Test</h3>', $html);
      $this->assertContains('<h4 id="toc_2">This Level 4</h4>', $html);
      $this->assertContains('<h5 id="toc_3">This Level 5</h5>', $html);
      $this->assertEquals('<ol><li><a href="#toc_1">This is a Test</a>' .
        '<ol><li><a href="#toc_2">This Level 4</a>' . 
        '<ol><li><a href="#toc_3">This Level 5</a></li></ol></li></ol></li></ol>', $toc);
    }, $this, 'Pico_TOC')->__invoke();
  }

}