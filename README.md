<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Laravel Quiz App

これは、Laravelフレームワークを使用して構築されたクイズアプリケーションです。ユーザーはさまざまなカテゴリのクイズに挑戦でき、管理者はクイズのカテゴリや問題を作成、編集、削除できます。

## 主な機能

### プレイヤー向け機能
- クイズカテゴリ一覧の表示
- 選択したカテゴリのクイズに挑戦
- 回答後に正誤判定と結果を表示

### 管理者向け機能
- ログイン認証
- カテゴリのCRUD（作成、読み取り、更新、削除）
- 各カテゴリに紐づくクイズのCRUD
- クイズの問題文と4つの選択肢（うち1つが正解）を設定可能

## 必要なもの

- PHP ^8.2
- Composer
- Node.js
- npm (or yarn)
- SQLite (またはMySQLやPostgreSQLなどのデータベース)

## インストールとセットアップ

1. **リポジトリをクローンします**
   ```bash
   git clone https://github.com/your-username/quiz-app.git
   cd quiz-app
   ```

2. **PHPの依存関係をインストールします**
   ```bash
   composer install
   ```

3. **`.env`ファイルを作成します**
   `.env.example`ファイルをコピーして`.env`ファイルを作成します。
   ```bash
   cp .env.example .env
   ```

4. **アプリケーションキーを生成します**
   ```bash
   php artisan key:generate
   ```

5. **データベースを設定します**
   デフォルトではSQLiteを使用します。`database/database.sqlite`に空のファイルを作成してください。
   ```bash
   touch database/database.sqlite
   ```
   `.env`ファイルで他のデータベース（MySQLなど）を使用する場合は、設定を適宜変更してください。

6. **データベースマイグレーションを実行します**
   テーブルを作成するために、以下のコマンドを実行します。
   ```bash
   php artisan migrate
   ```

7. **（任意）ダミーデータを投入します**
   テスト用のカテゴリやクイズを生成するには、シーダーを実行します。
   ```bash
   php artisan db:seed
   ```

8. **JavaScriptの依存関係をインストールします**
   ```bash
   npm install
   ```

9. **開発サーバーを起動します**
   ViteとPHPのビルトインサーバーを起動します。
   ```bash
   npm run dev
   ```
   または、`composer.json`の`scripts`に定義されている`dev`コマンドでも起動できます。
   ```bash
   composer run dev
   ```

   アプリケーションには `http://localhost:8000` でアクセスできます。

## 使い方

- **クイズをプレイする**: トップページ (`/`) にアクセスすると、カテゴリ一覧が表示されます。カテゴリを選択してクイズを開始します。
- **管理画面**: `/admin/top` にアクセスし、ログインすると管理機能が利用できます。（ユーザー登録は `/register` から行えます）

## テスト

PHPUnitを使用してテストを実行できます。

```bash
php artisan test
```

## 使用技術

- **バックエンド**: Laravel 11, PHP 8.2
- **フロントエンド**: Blade, Tailwind CSS, Alpine.js, Vite
- **データベース**: SQLite (デフォルト)
- **認証**: Laravel Breeze



## 開発起動メモ


・起動3STEP
```bash
Docker Desktop の起動
sail npm run dev
sail up -d       
```

・終了3STEP
```bash
Docker Desktop の終了
sail down     
Ctrl+C （sail up -d　が起動しているターミナルで）       
```
