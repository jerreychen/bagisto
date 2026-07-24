#!/bin/bash
# Bagisto 开发服务器一键启动脚本
# 用法: bash .workbuddy/start-dev.sh
set -e
cd /Users/chenjilv/Codeup/bagisto-2.4

if lsof -i :8000 >/dev/null 2>&1; then
  echo "端口 8000 已被占用（服务可能已在运行），跳过启动。"
  curl -s -o /dev/null -w "首页 HTTP:%{http_code}\n" http://localhost:8000/ || true
  exit 0
fi

echo "正在启动 Bagisto 开发服务器 ..."
# 注意: 沙箱无 setsid 命令, 用 nohup 让进程脱离终端常驻 (跨对话存活)
nohup php artisan serve --host=0.0.0.0 --port=8000 > /tmp/bagisto-serve.log 2>&1 &
disown 2>/dev/null || true
echo "已启动, pid=$!"

sleep 5
curl -s -o /dev/null -w "首页 HTTP:%{http_code}\n" --max-time 10 http://localhost:8000/ || echo "启动中, 请稍候手动访问 http://localhost:8000"
echo "日志: tail -f /tmp/bagisto-serve.log"
