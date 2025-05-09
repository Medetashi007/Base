# ベースプロジェクト

## 目的

Medetashiが主催するプロジェクトのベースを作る。  
各プラットフォームを有機的に繋ぎ合わせるセキュアなサービスが期待される。  

## 環境構築

1. WSL、Docker Desktopをinstall
2. プロジェクトディレクトリ構成の作成
3. yml、Dockerfileの作成
4. Laravelプロジェクトのinstall
5. node、nvm、vue、inertiaのinstall

## 環境構築（後からプロジェクトに参加した人向け）

1. SSHキーを作成し、Githubに登録、SSH接続を確認する  
    ```
    # nvmをダウンロードしてインストールする：
    curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash
    
    # シェルを再起動する代わりに実行する
    \. "$HOME/.nvm/nvm.sh"
    
    # Node.jsをダウンロードしてインストールする：
    nvm install 22
    
    # Node.jsのバージョンを確認する：
    node -v # "v22.15.0"が表示される。
    nvm current # "v22.15.0"が表示される。
    
    # npmのバージョンを確認する：
    npm -v # "10.9.2"が表示される。
    ```

2. 既存のプロジェクトをUbuntu配下にダウンロードする 
    ```
    git clone git@github.com:Medetashi007/Base.git  
    ```
3. 「環境構築」の5番を行う。但し、inertiaを入れる際はクライアントのみで良い。  
    サーバーサイドに入れるとファイルが初期化される恐れがあるので注意。  
