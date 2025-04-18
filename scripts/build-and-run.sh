#!/bin/bash

# Created by ChatGPT lol

# Exit on error
set -e

# === CONFIG ===
IMAGE_NAME="kotki"
CONTAINER_NAME="kotki"
HOST_PORT=6969
CONTAINER_PORT=80
DOCKER_NETWORK="app_network"

echo "📦 Building Docker image: $IMAGE_NAME"
docker build -t $IMAGE_NAME .

echo "🧹 Stopping and removing old container (if it exists)..."
docker stop $CONTAINER_NAME 2>/dev/null || true
docker rm $CONTAINER_NAME 2>/dev/null || true

echo "🚀 Running Docker container: $CONTAINER_NAME"
docker run -d \
  --name $CONTAINER_NAME \
  --network $DOCKER_NETWORK \
  -p $HOST_PORT:$CONTAINER_PORT \
  $IMAGE_NAME

echo "✅ App is running at http://localhost:$HOST_PORT"
