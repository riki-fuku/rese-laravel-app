# アプリケーション名

### 飲食店予約管理システム

![TOP画像](src/public/images/top_image.jpg "top")

#### サービス名

Rese

#### 概要説明

#### 一般ユーザー

登録されている飲食店の検索・予約・お気に入り登録・決済を利用するためのアプリケーション

#### 店舗代表者ユーザー

店舗の登録・編集・予約確認・お知らせメール送信を利用するためのアプリケーション

#### 管理者ユーザー

店舗代表者の作成・編集・お知らせメール送信を利用するためのアプリケーション

## 作成した目的

(Advance ターム)

外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。

##### 参考

https://docs.google.com/spreadsheets/d/1IF4y5eBm6zgM_64wsPAc_UwLsdiPoZTR2HceWD0icgg/edit#gid=509071084

## 他のリポジトリ

バックエンドの API の実装を Laravel で行い
フロントエンドの実装は Vue.js で実装する

#### Vue.js(フロントエンド)のリポジトリ

https://github.com/riki-fuku/rese-vue-app

## アプリケーション URL デプロイの URL を貼り付る

#### 本番環境(一般ユーザー)

https://d2aqnqqkh4vm3z.cloudfront.net/

| ユーザー名 | user1 |
| メールアドレス | user1@mail.com |
| パスワード | hogehoge |

#### 本番環境(一般ユーザー)

https://d2aqnqqkh4vm3z.cloudfront.net/agent/

| ユーザー名 | agent1 |
| メールアドレス | agent1@mail.com |
| パスワード | hogehoge |

#### 本番環境(一般ユーザー)

https://d2aqnqqkh4vm3z.cloudfront.net/admin/

| ユーザー名 | admin1 |
| メールアドレス | admin1@mail.com |
| パスワード | hogehoge |

## 機能一覧

#### 一般ユーザー

登録されている飲食店の検索・予約・お気に入り登録・決済を利用するためのアプリケーション

-   ユーザー登録
-   ログイン・ログアウト
-   店舗検索
-   店舗予約の確認・変更・削除
-   店舗お気に入りの確認・登録・解除
-   来店時の QR コード表示
-   店舗評価
-   決済

#### 店舗代表者ユーザー

-   ログイン・ログアウト
-   店舗情報の作成・編集
-   店舗に対する予約確認
-   店舗に対する予約詳細・来店更新
-   決済用のの QR コード表示
-   お知らせメール送信

#### 管理者ユーザー

-   ログイン・ログアウト
-   店舗代表者の作成・編集・有効化/無効化
-   お知らせメール送信

## 使用技術(実行環境)

-   Laravel 8.83.27
-   php 8.2.1
-   mysql 8.0.26
-   nginx 1.21.1

## テーブル設計

[テーブル設計書](https://docs.google.com/spreadsheets/d/1IF4y5eBm6zgM_64wsPAc_UwLsdiPoZTR2HceWD0icgg/edit#gid=1635115377)

## ER 図

[ER 図](https://docs.google.com/spreadsheets/d/1IF4y5eBm6zgM_64wsPAc_UwLsdiPoZTR2HceWD0icgg/edit#gid=320603785)

## 環境構築

-   Doker
-   Docker Compose

## 参考

[福島さん Web 開発上級 生徒様用案件シート Ver.2.0](https://docs.google.com/spreadsheets/d/1IF4y5eBm6zgM_64wsPAc_UwLsdiPoZTR2HceWD0icgg/edit#gid=935968078)
