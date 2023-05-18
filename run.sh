docker run -it --rm \
    -p 8080:80 \
    --mount type=tmpfs,destination=/tmp \
    -e APP_DEBUG=true \
    -e PHP_MAX_EXECUTION_TIME=1800 \
    -v /Users/zane/My/Projects/typecho-admin-dzh/data:/data \
    typecho-admin-dzh:latest
