#neue holen und bauen
docker pull robostlund/nginx-php-mysql-static:latest
docker build -t opentube_dev dev/

#alten Docker beenden
docker rm -f opentube_dev
docker rm -f opentube_dev_phpmyadmin

#neuen Docker starten
docker run -d \
  --restart=always \
  --name opentube_dev \
  -p 8089:80 \
  opentube_dev

docker run -d \
  --name opentube_dev_phpmyadmin \
  --link opentube_dev:db \
  -p 8090:80 \
  phpmyadmin/phpmyadmin:5.0

#  -e PMA_USER=opentube \
#  -e PMA_PASSWORD=opentube \