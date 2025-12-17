#!/bin/bash

echo "Deploying Scoolyn Laravel Application to Kubernetes..."

# Apply namespace first
kubectl apply -f namespace.yaml

# Apply secrets and configmaps
kubectl apply -f mysql-secret.yaml
kubectl apply -f laravel-secret.yaml
kubectl apply -f laravel-configmap.yaml

# Apply PVC
kubectl apply -f mysql-pvc.yaml

# Deploy MySQL
kubectl apply -f mysql-deployment.yaml
kubectl apply -f mysql-service.yaml

# Wait for MySQL to be ready
echo "Waiting for MySQL to be ready..."
kubectl wait --for=condition=ready pod -l app=mysql -n scoolyn --timeout=300s

# Deploy Laravel application
kubectl apply -f laravel-deployment.yaml
kubectl apply -f laravel-service.yaml

# Apply ingress and HPA
kubectl apply -f laravel-ingress.yaml
kubectl apply -f hpa.yaml

echo "Deployment completed!"
echo "Check status with: kubectl get all -n scoolyn"
echo "Update your DNS to point scoolyn.example.com to your ingress controller IP"