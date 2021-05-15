# 概要
MVCモデルを採用したPHPフレームワーク。
ViewにはTiwgを、Modelにはdoctrineを採用している。

# 環境
下記のバージョンで動作確認済み
* CentOS
    8
* Apache
    2.4.37
* mysql
    5.7
* PHP
    7.3系

# 設置方法
### リポジトリをcloneする
`git clone https://github.com/stein8903/mvc_fw.git`
### composerのパッケージをインストールする（上記のPHPバージョンの環境でinstallした方があとで困ることない）
`composer install`
### dbの設定を行う
`cp .env_sample .env`

# tag管理
* v1: 何も追加されていない状態
* v2: Routing機能と簡単なController機能が完成された状態
* v3: View機能とComposerが導入された状態
* v4: model機能が追加された状態