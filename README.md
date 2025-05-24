# domain-swapper
domain-swapper

## Install
```
git clone https://github.com/myridia/domain-swapper.git
cd domain-swapper/dockers
docker-compose up
```

## First Wordpress Setup
* After the Dockers got loaded, setup Wordpress http://127.0.0.1


## Wordpress login
* user: test
* pass: test


## Hard Fork from iqonicdesign  WPMultiHost https://youtu.be/zEV2GVB-BcU

## Info
Contributors: Myridia
Tags: wordpress, changer, host switcher, dynamic host, multiplehosts, multihost
Requires PHP: 5.2.4
Requires at least: 3.0.1
Tested up to: 6.7.1
Stable tag: 1.0.0
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WPMultiHost is a plugin which helps to access same WordPress site from different domains.

## Description 

plugin which helps you to access 1 WordPress site from Multiple domains.



## Whom it will help?

- This for developers sharing to help them share local site on a domain.
- It will allow WordPress site to be accessed from multiple domiain consecutively.
- Will help to use it with NGROK and any other tunnel domains.


## Screenshots 



## Installation 

1. Upload the plugin and activate it (alternatively, install through the WP admin console)
2. Go into Tools, Select sub-menu "host-swapper"
3. Add Allow Host and save setting.
4. Now you are good to go.


# Dockers Space to test and develop this Plugins
A WordPress plugin is integrated into WordPress, so the best way to work with it, is to create a minimal WordPress place where
we can work it.
The Dockers where will simulate the server, so we can access the site locally without computer.

See https://github.com/myridia/hello_haproxy_docker/tree/main for install the certificates into your browser to be able to access the local test  https domains

 
## After you run the docker-compose you can access to
```
  docker-compose up
```

*  Default Wordpress http://127.0.0.1:8080
*  phpmyadmin http://127.0.0.1:81
*  domain1  https://ww1.app.local
*  domain2  https://ww2.app.local
*  domain3  https://ww3.app.local
*  domain4  https://foo.local


## Enter wp cli to to do some work
```
docker exec -it wpcli bash
```

## Generate Language Files
```
wp i18n make-pot . languages/domain_swapper.pot --allow-root
```

## Constatns
```
WPDS_NAME
WPDS_DIR
WPDS_BASE
WPDS_URL
WPDS_URI
WPDS_PATH
WPDS_SLUG
WPDS_BASENAME
WPDS_VERSION
WPDS_TEXT
WPDS_PREFIX
WPDS_SETTINGS


```
