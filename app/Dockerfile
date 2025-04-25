FROM php:8.4-fpm

ARG USERNAME=dev
ARG USER_ID=1000
ARG GROUP_ID=1000

RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    nodejs npm \
    && docker-php-ext-install pdo_mysql zip mbstring exif gd

# sudoers.d ディレクトリが存在することを確認
RUN mkdir -p /etc/sudoers.d
# グループが存在しない場合は作成
RUN groupadd -g $GROUP_ID $USERNAME || groupmod -o -g $GROUP_ID $USERNAME || true
# ユーザーが存在しない場合は作成し、sudoグループに追加
RUN useradd -l -u $USER_ID -g $GROUP_ID -m $USERNAME -s /bin/bash || usermod -o -u $USER_ID -g $GROUP_ID $USERNAME \
    && echo "$USERNAME ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME

WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

USER $USERNAME

CMD ["php-fpm"]