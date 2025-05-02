FROM debian:bookworm

# Instalar servicios necesarios
RUN apt update && apt install -y apache2 php php-mysqli mariadb-server openssh-server sudo neofetch

ENV MYSQL_ROOT_PASSWORD=root
ENV MYSQL_DATABASE=soberbia

# Mysql
COPY mysql/soberbia.sql /docker-entrypoint-initdb.d/

# Copiar archivos web
COPY apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY html/ /var/www/html/
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Crear usuario vulnerable
RUN useradd -m dante && echo 'dante:s3cr3t@' | chpasswd && \
    echo 'dante ALL=(ALL) NOPASSWD: /usr/bin/neofetch ' >> /etc/sudoers.d/user

# SSH
RUN mkdir /var/run/sshd
RUN echo 'PermitRootLogin yes' >> /etc/ssh/sshd_config

# Crear base de datos
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80 22 3306
ENTRYPOINT ["/entrypoint.sh"]
