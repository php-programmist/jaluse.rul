FROM jwilder/nginx-proxy

RUN apt-get update
RUN apt-get install nano -y
RUN apt-get install vim -y
RUN apt-get install openssl

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["nginx", "-g", "daemon off;"]