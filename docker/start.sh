#!/bin/bash
set -e

echo "Starting Laravel container..."

mkdir -p /var/log/nginx
mkdir -p /var/www/html/storage/logs

touch /var/log/nginx/access.log
touch /var/log/nginx/error.log
touch /var/www/html/storage/logs/laravel.log


echo "Starting CloudWatch Agent..."

TASK_META=$(curl -sf "${ECS_CONTAINER_METADATA_URI_V4}/task" || true)

if [ -n "$TASK_META" ]; then
  TASK_ID=$(echo "$TASK_META" | grep -o '"TaskARN":"[^"]*"' | cut -d'/' -f3 | tr -d '"')
else
  TASK_ID=$(hostname)
fi


sed -i "s/{instance_id}/$TASK_ID/g" \
/opt/aws/amazoncloudwatchagent/etc/amazoncloudwatch-agent.json


/opt/aws/amazoncloudwatch-agent/bin/config-translator \
 --input /opt/aws/amazoncloudwatchagent/etc/amazoncloudwatch-agent.json \
 --output /opt/aws/amazoncloudwatchagent/etc/amazoncloudwatch-agent.toml \
 --mode ec2 \
 --os linux


/opt/aws/amazoncloudwatch-agent/bin/amazon-cloudwatch-agent \
-config /opt/aws/amazoncloudwatchagent/etc/amazoncloudwatch-agent.toml \
-pidfile /var/run/amazon-cloudwatch-agent.pid &


echo "CloudWatch Agent started"


php artisan config:clear
php artisan route:clear
php artisan view:clear


echo "Running migrations..."

php artisan migrate --force


echo "Starting PHP-FPM..."

php-fpm -D


echo "Starting Nginx..."

exec nginx -g "daemon off;"