# Scoolyn Laravel Application - Kubernetes Deployment

## Prerequisites
- Kubernetes cluster with NGINX Ingress Controller
- cert-manager for SSL certificates
- kubectl configured

## Deployment Files

### Core Components
- `namespace.yaml` - Application namespace
- `mysql-secret.yaml` - MySQL credentials
- `laravel-secret.yaml` - Laravel APP_KEY
- `laravel-configmap.yaml` - Environment variables

### Database
- `mysql-pvc.yaml` - Persistent storage for MySQL
- `mysql-deployment.yaml` - MySQL database deployment
- `mysql-service.yaml` - MySQL internal service

### Application
- `laravel-deployment.yaml` - Laravel app deployment (3 replicas)
- `laravel-service.yaml` - Laravel internal service
- `laravel-ingress.yaml` - External access with SSL
- `hpa.yaml` - Auto-scaling configuration

## Quick Deploy
```bash
./deploy.sh
```

## Manual Deploy
```bash
kubectl apply -f namespace.yaml
kubectl apply -f mysql-secret.yaml
kubectl apply -f laravel-secret.yaml
kubectl apply -f laravel-configmap.yaml
kubectl apply -f mysql-pvc.yaml
kubectl apply -f mysql-deployment.yaml
kubectl apply -f mysql-service.yaml
kubectl apply -f laravel-deployment.yaml
kubectl apply -f laravel-service.yaml
kubectl apply -f laravel-ingress.yaml
kubectl apply -f hpa.yaml
```

## Configuration Notes
- Update `scoolyn.example.com` in ingress.yaml to your domain
- Generate proper APP_KEY: `php artisan key:generate --show | base64`
- Modify resource limits based on your cluster capacity
- Update MySQL credentials in secrets before production use

## Monitoring
```bash
kubectl get all -n scoolyn
kubectl logs -f deployment/laravel-app -n scoolyn
kubectl logs -f deployment/mysql -n scoolyn
```