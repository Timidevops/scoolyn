#!/bin/bash

# Setup Horizontal and Cluster Autoscaling for kops cluster

echo "Setting up autoscaling for kops cluster..."

# 1. Update kops cluster configuration for autoscaling
echo "Step 1: Configure kops cluster for autoscaling"
echo "Run these commands to enable autoscaling in your kops cluster:"
echo ""
echo "# Edit your cluster configuration"
echo "kops edit cluster --name=YOUR_CLUSTER_NAME"
echo ""
echo "# Add these settings to spec section:"
echo "spec:"
echo "  cloudProvider:"
echo "    aws:"
echo "      nodeTerminationHandler:"
echo "        enabled: true"
echo ""
echo "# Edit instance group for worker nodes"
echo "kops edit instancegroup nodes --name=YOUR_CLUSTER_NAME"
echo ""
echo "# Add autoscaling settings:"
echo "spec:"
echo "  minSize: 2"
echo "  maxSize: 10"
echo "  cloudLabels:"
echo "    k8s.io/cluster-autoscaler/enabled: \"true\""
echo "    k8s.io/cluster-autoscaler/YOUR_CLUSTER_NAME: \"owned\""
echo ""
echo "# Apply changes"
echo "kops update cluster --name=YOUR_CLUSTER_NAME --yes"
echo ""

# 2. Install metrics server
echo "Step 2: Installing metrics server..."
kubectl apply -f metrics-server.yaml

# 3. Wait for metrics server
echo "Waiting for metrics server to be ready..."
kubectl wait --for=condition=ready pod -l k8s-app=metrics-server -n kube-system --timeout=300s

# 4. Install cluster autoscaler
echo "Step 3: Installing cluster autoscaler..."
echo "IMPORTANT: Update YOUR_CLUSTER_NAME in cluster-autoscaler.yaml before applying"
read -p "Have you updated the cluster name in cluster-autoscaler.yaml? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    kubectl apply -f cluster-autoscaler.yaml
else
    echo "Please update cluster-autoscaler.yaml with your cluster name first"
    exit 1
fi

# 5. Verify installation
echo "Step 4: Verifying installation..."
echo "Checking metrics server..."
kubectl get deployment metrics-server -n kube-system

echo "Checking cluster autoscaler..."
kubectl get deployment cluster-autoscaler -n kube-system

echo "Checking HPA..."
kubectl get hpa -n scoolyn

echo ""
echo "Setup completed!"
echo ""
echo "To test autoscaling:"
echo "1. Generate load: kubectl run -i --tty load-generator --rm --image=busybox --restart=Never -- /bin/sh"
echo "2. Inside the pod: while true; do wget -q -O- http://laravel-service.scoolyn.svc.cluster.local; done"
echo "3. Watch scaling: kubectl get hpa -n scoolyn -w"
echo "4. Watch nodes: kubectl get nodes -w"