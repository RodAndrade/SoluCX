FROM ubuntu:18.04
LABEL maintainer="Rodrigo Andrade"

# Basic ubuntu repository updates
RUN apt-get update && apt-get upgrade -y

# Install nginx stack
RUN apt-get install --no-install-recommends --no-install-suggests -y \
	nginx
	
RUN apt-get update -y

RUN apt-get upgrade -y

RUN apt-get install software-properties-common -y

# Add PPA about PHP 7.4
RUN add-apt-repository ppa:ondrej/php -y

RUN apt-get update -y

# Install php stack
RUN apt-get install --no-install-recommends --no-install-suggests -y \
	php7.4 \
	php7.4-fpm \
	php7.4-intl \
	php7.4-zip \
	php7.4-curl \
	php7.4-gd \
	php7.4-json \
	php7.4-xml \
	php7.4-mbstring \
	php7.4-xmlrpc \
	php7.4-cli \
	php7.4-mysql \
	php7.4-xsl

# Installs mysql client if necessary
RUN apt-get install --no-install-recommends --no-install-suggests -y \
	mysql-client
	
RUN apt-get update -y

# Exposes some ports
EXPOSE 8000

# Run our entrypoint
ENTRYPOINT ["/solucx/docker-assets/entrypoint.sh"]

# Shutdown machine after creation
STOPSIGNAL SIGTERM

CMD ["nginx", "-g"]
