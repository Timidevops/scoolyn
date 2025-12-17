#!/bin/bash

# Start SonarQube
echo "Starting SonarQube..."
docker-compose -f docker-compose.sonar.yml up -d

# Wait for SonarQube to be ready
echo "Waiting for SonarQube to start..."
sleep 30

# Check if SonarQube is ready
until curl -s http://localhost:9000/api/system/status | grep -q '"status":"UP"'; do
  echo "Waiting for SonarQube to be ready..."
  sleep 10
done

echo "SonarQube is ready!"
echo "Access SonarQube at: http://localhost:9000"
echo "Default credentials: admin/admin"
echo ""
echo "To run analysis, execute:"
echo "docker run --rm --network host -v \$(pwd):/usr/src sonarsource/sonar-scanner-cli"