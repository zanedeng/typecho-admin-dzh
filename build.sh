
echo "begin build ..."

docker image rm -f ku8_top:latest
docker image rm -f reg.ku8.top/zane/ku8_top:latest
docker image prune -f
docker build -f ./docker/Dockerfile -t ku8_top:latest .
docker tag ku8_top:latest reg.ku8.top/zane/ku8_top:latest
docker push reg.ku8.top/zane/ku8_top:latest

echo "end build ..."