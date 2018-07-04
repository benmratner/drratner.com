#!/usr/bin/env bash


# MySQL configuration needed before install
debconf-set-selections <<< 'mysql-server-5.6 mysql-server/root_password password rootpass'
debconf-set-selections <<< 'mysql-server-5.6 mysql-server/root_password_again password rootpass'


# Update and install packages
apt-get update > /vagrant/vagrant.log
apt-get install -y apache2 mysql-server
apt-get install -y php5 php5-curl php5-gd php5-mysql php5-common php5-mcrypt libapache2-mod-php5
php5enmod mcrypt
apt-get install -y curl git htop php5-cli tree > /vagrant/vagrant.log


# PHP Setup
echo "Setting up PHP"
sudo cp /vagrant/config/vagrant/etc/php5/apache2/php.ini /etc/php5/apache2/php.ini


# Apache Setup
echo "Setting up Apache"
sudo service apache2 stop
rm -rf /var/www
rm -rf /var/lock/apache2
ln -fs /vagrant/config/vagrant/etc/apache2/sites-available/SITE_PACKAGE.conf /etc/apache2/sites-available/SITE_PACKAGE.conf
sudo ln -fs /vagrant /var/www
sed -i -e 's/APACHE_RUN_USER=www-data/APACHE_RUN_USER=vagrant/g' /etc/apache2/envvars
sed -i -e 's/APACHE_RUN_GROUP=www-data/APACHE_RUN_GROUP=vagrant/g' /etc/apache2/envvars
a2dissite 000-default
a2ensite SITE_PACKAGE
a2enmod rewrite
sudo service apache2 restart


# MySQL Setup
echo "Setting up MySql"
echo "CREATE USER 'wordpressuser'@'localhost' IDENTIFIED BY 'wordpresspass'" | mysql -uroot -prootpass
echo "CREATE DATABASE wordpress" | mysql -uroot -prootpass
echo "GRANT ALL ON wordpress.* TO 'wordpressuser'@'localhost'" | mysql -uroot -prootpass
echo "flush privileges" | mysql -uroot -prootpass


# WordPress Setup
echo "Setting up initial wordpress things";
cd /vagrant/
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp
cd /vagrant/wp-content
mkdir -p uploads
chmod 777 uploads
cp /vagrant/config/wordpress/wp-config.php.dev /vagrant/wp-config.php

echo "Done";
