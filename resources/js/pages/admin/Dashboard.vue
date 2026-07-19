<template>
    <DashboardHeader title="Welcome to Admin Dashboard" />

    <!-- Stats Cards Row 1 -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>1,284</h3>
                    <p>Total Products</p>
                </div>
                <div class="icon"><i class="fas fa-box-open"></i></div>
                <router-link :to="{ name: 'Products' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>$48,295</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>326</h3>
                    <p>New Orders</p>
                </div>
                <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>5,820</h3>
                    <p>Total Customers</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 2 -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>74</h3>
                    <p>Product Categories</p>
                </div>
                <div class="icon"><i class="fas fa-tags"></i></div>
                <router-link :to="{ name: 'ProductCategories' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>38</h3>
                    <p>Brands</p>
                </div>
                <div class="icon"><i class="fas fa-trademark"></i></div>
                <router-link :to="{ name: 'Brands' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box" style="background-color:#17a2b8;color:#fff">
                <div class="inner">
                    <h3>12</h3>
                    <p>Pending Reviews</p>
                </div>
                <div class="icon"><i class="fas fa-star-half-alt"></i></div>
                <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>89</h3>
                    <p>Low Stock Items</p>
                </div>
                <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                <router-link :to="{ name: 'Products' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shopping-cart mr-2"></i>Recent Orders</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in recentOrders" :key="order.id">
                                <td><strong>#{{ order.id }}</strong></td>
                                <td>{{ order.customer }}</td>
                                <td>{{ order.product }}</td>
                                <td>{{ order.amount }}</td>
                                <td>
                                    <span class="badge" :class="order.statusClass">{{ order.status }}</span>
                                </td>
                                <td>{{ order.date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products & Quick Stats -->
    <div class="row">
        <!-- Top Products -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-box-open mr-2"></i>Top Selling Products</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="p in topProducts" :key="p.name">
                                <td>{{ p.name }}</td>
                                <td>{{ p.category }}</td>
                                <td>{{ p.sold }}</td>
                                <td>{{ p.revenue }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-chart-pie mr-2"></i>Quick Stats</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <span>Conversion Rate</span>
                        <strong class="text-success">3.8%</strong>
                    </div>
                    <div class="progress mb-4" style="height:8px">
                        <div class="progress-bar bg-success" style="width:38%"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Orders Fulfilled</span>
                        <strong class="text-info">78%</strong>
                    </div>
                    <div class="progress mb-4" style="height:8px">
                        <div class="progress-bar bg-info" style="width:78%"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Customer Satisfaction</span>
                        <strong class="text-warning">91%</strong>
                    </div>
                    <div class="progress mb-4" style="height:8px">
                        <div class="progress-bar bg-warning" style="width:91%"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Return Rate</span>
                        <strong class="text-danger">5.2%</strong>
                    </div>
                    <div class="progress" style="height:8px">
                        <div class="progress-bar bg-danger" style="width:52%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import { ref } from 'vue'

const recentOrders = ref([
    { id: '10045', customer: 'Alice Johnson',   product: 'Running Shoes Pro',   amount: '$129.99', status: 'Delivered',  statusClass: 'badge-success', date: 'Jul 18, 2026' },
    { id: '10044', customer: 'Bob Martinez',    product: 'Wireless Headphones', amount: '$89.50',  status: 'Processing', statusClass: 'badge-warning', date: 'Jul 18, 2026' },
    { id: '10043', customer: 'Clara Smith',     product: 'Leather Wallet',      amount: '$45.00',  status: 'Shipped',    statusClass: 'badge-info',    date: 'Jul 17, 2026' },
    { id: '10042', customer: 'David Lee',       product: 'Smart Watch Series 5',amount: '$249.00', status: 'Delivered',  statusClass: 'badge-success', date: 'Jul 17, 2026' },
    { id: '10041', customer: 'Eva Turner',      product: 'Cotton T-Shirt Pack', amount: '$35.00',  status: 'Cancelled',  statusClass: 'badge-danger',  date: 'Jul 16, 2026' },
    { id: '10040', customer: 'Frank Brown',     product: 'Coffee Maker Deluxe', amount: '$175.00', status: 'Delivered',  statusClass: 'badge-success', date: 'Jul 16, 2026' },
])

const topProducts = ref([
    { name: 'Running Shoes Pro',    category: 'Footwear',     sold: 842,  revenue: '$109,257' },
    { name: 'Smart Watch Series 5', category: 'Electronics',  sold: 631,  revenue: '$157,119' },
    { name: 'Wireless Headphones',  category: 'Electronics',  sold: 574,  revenue: '$51,363' },
    { name: 'Leather Wallet',       category: 'Accessories',  sold: 480,  revenue: '$21,600' },
    { name: 'Coffee Maker Deluxe',  category: 'Home & Living',sold: 312,  revenue: '$54,600' },
])
</script>
