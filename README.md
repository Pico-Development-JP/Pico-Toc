# pico-toc

記事の段落から、自動的に見出しリスト(Table Of Contents)を生成するプラグイン

記事のcontentを解析し、&lt;ol&gt;タグおよび&lt;li&gt;タグで目次を生成します。
pico-headerlvmodプラグインとの並行利用も念頭に入れて作成されているため、プラグインの呼び出し順番を考慮することなく、そのまま利用可能です。

## 使用方法

1. プラグインをダウンロードし、`plugins`フォルダに`pico_toc`というフォルダ名で保存する
2. `config/config.yml`に、`Pico_TOC.enabled = true`という行を書き加える

## テンプレートに追加する値

なし

## 追加するTwig変数

* TOC:記事内のもくじを示す、HTMLスニペット

### テンプレート内での利用例

```html
{% if TOC %}
  <div class="toc panel panel-info">
    <h3 class="panel-heading">もくじ</h3>
    <div class="panel-body">
      {{TOC}}
    </div>
  </div>
{% endif %}
```

## コンフィグオプション

なし
