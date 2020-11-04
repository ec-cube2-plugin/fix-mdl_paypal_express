ペイパル決済モジュール挙動修正プラグイン
==================================

本プラグインについて
-----------------

EC-CUBE2用のペイパル決済モジュール挙動修正プラグインです。


修正項目
-------

以下の挙動を修正します。

- テンプレートディレクトリとして、以下のパスを追加します。
    - TEMPLATE_REALDIR . 'mdl_paypal_express/'
    - SMARTPHONE_TEMPLATE_REALDIR . 'mdl_paypal_express/'
    - TEMPLATE_REALDIR . 'dropped_items_noticer/'

- `LOG_REALDIR` が設定されている場合にログディレクトリを `LOG_REALDIR` 以下にします。


EC-CUBE2 CLI
------------

以下のコマンドを追加します。

`paypal-express:copy`
