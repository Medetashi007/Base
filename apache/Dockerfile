FROM httpd:2.4

ARG USERNAME=dev
ARG USER_ID=1000
ARG GROUP_ID=1000

RUN apt-get update && apt-get install -y bash

RUN mkdir -p /etc/sudoers.d
RUN groupadd -g $GROUP_ID $USERNAME || groupmod -o -g $GROUP_ID $USERNAME || true
# ユーザーが存在しない場合は作成し、sudoグループに追加
RUN useradd -l -u $USER_ID -g $GROUP_ID -m $USERNAME -s /bin/bash || usermod -o -u $USER_ID -g $GROUP_ID $USERNAME \
    && echo "$USERNAME ALL=(ALL) NOPASSWD:ALL" >> /etc/sudoers.d/$USERNAME \
    && chmod 0440 /etc/sudoers.d/$USERNAME
# PHP-FPM の実行に必要なディレクトリの所有権を設定
RUN mkdir -p /run/php \
    && chown -R $USERNAME:$USERNAME /run/php
RUN mkdir -p /usr/local/apache2/logs \
    && chown -R $USERNAME:$USERNAME /usr/local/apache2/logs

USER $USERNAME

CMD [ "httpd-foreground" ]
