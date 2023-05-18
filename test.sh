#!/bin/sh

git checkout master

docker image rm -f typecho-admin-dzh
docker image prune -f
docker build -f ./docker/Dockerfile -t typecho-admin-dzh .

./run.sh
