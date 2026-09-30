<template>
    <DashboardHeader title="Welcome to Admin Dashboard">
        <button class="btn btn-sm btn-outline-primary" @click="fetchDashboardData" :disabled="loading" title="Refresh Dashboard">
            <i class="fas fa-sync-alt mr-1" :class="{ 'fa-spin': loading }"></i> Refresh
        </button>
    </DashboardHeader>

    <!-- Stats Cards Row 1 -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ stats.totalProducts ?? '0' }}</h3>
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
                    <h3>{{ stats.totalRevenue ?? '$0.00' }}</h3>
                    <p>Total Revenue</p>
                </div>
                <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                <router-link :to="{ name: 'Orders' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ stats.newOrders ?? '0' }}</h3>
                    <p>New Orders</p>
                </div>
                <div class="icon"><i class="fas fa-shopping-cart"></i></div>
                <router-link :to="{ name: 'Orders' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ stats.totalCustomers ?? '0' }}</h3>
                    <p>Total Customers</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <router-link :to="{ name: 'Customers' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row 2 -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ stats.totalCategories ?? '0' }}</h3>
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
                    <h3>{{ stats.totalBrands ?? '0' }}</h3>
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
                    <h3>{{ stats.pendingReviews ?? '0' }}</h3>
                    <p>Pending Reviews</p>
                </div>
                <div class="icon"><i class="fas fa-star-half-alt"></i></div>
                <router-link :to="{ name: 'Reviews' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ stats.lowStockItems ?? '0' }}</h3>
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
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-shopping-cart mr-2"></i>Recent Orders</h3>
                    <router-link :to="{ name: 'Orders' }" class="btn btn-tool btn-sm text-primary">
                        View All Orders <i class="fas fa-arrow-right ml-1"></i>
                    </router-link>
                </div>
                <div class="card-body p-0 table-responsive">
                    <div v-if="loading" class="text-center py-4">
                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                        <p class="mt-2 text-muted mb-0">Loading recent orders...</p>
                    </div>
                    <table v-else class="table table-striped table-hover mb-0">
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
                            <tr v-if="recentOrders.length === 0">
                                <td colspan="6" class="text-center py-4 text-muted">No orders found.</td>
                            </tr>
                            <tr v-for="order in recentOrders" :key="order.id">
                                <td><strong>#{{ order.id }}</strong></td>
                                <td>{{ order.customer }}</td>
                                <td>{{ order.product }}</td>
                                <td><strong>{{ order.amount }}</strong></td>
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
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-box-open mr-2"></i>Top Selling Products</h3>
                    <router-link :to="{ name: 'Products' }" class="btn btn-tool btn-sm text-primary">
                        View All Products <i class="fas fa-arrow-right ml-1"></i>
                    </router-link>
                </div>
                <div class="card-body p-0 table-responsive">
                    <div v-if="loading" class="text-center py-4">
                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                        <p class="mt-2 text-muted mb-0">Loading products...</p>
                    </div>
                    <table v-else class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="topProducts.length === 0">
                                <td colspan="4" class="text-center py-4 text-muted">No products found.</td>
                            </tr>
                            <tr v-for="p in topProducts" :key="p.id || p.name">
                                <td>{{ p.name }}</td>
                                <td><span class="badge badge-light border">{{ p.category }}</span></td>
                                <td>{{ p.sold }}</td>
                                <td><strong>{{ p.revenue }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-md-5">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title mb-0"><i class="fas fa-chart-pie mr-2"></i>Quick Stats</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Conversion Rate</span>
                        <strong class="text-success">{{ quickStats.conversionRate }}%</strong>
                    </div>
                    <div class="progress mb-4" style="height:8px">
                        <div class="progress-bar bg-success" :style="{ width: Math.min(quickStats.conversionRate, 100) + '%' }"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Orders Fulfilled</span>
                        <strong class="text-info">{{ quickStats.ordersFulfilled }}%</strong>
                    </div>
                    <div class="progress mb-4" style="height:8px">
                        <div class="progress-bar bg-info" :style="{ width: Math.min(quickStats.ordersFulfilled, 100) + '%' }"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Customer Satisfaction</span>
                        <strong class="text-warning">{{ quickStats.customerSatisfaction }}%</strong>
                    </div>
                    <div class="progress mb-4" style="height:8px">
                        <div class="progress-bar bg-warning" :style="{ width: Math.min(quickStats.customerSatisfaction, 100) + '%' }"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Return / Cancel Rate</span>
                        <strong class="text-danger">{{ quickStats.returnRate }}%</strong>
                    </div>
                    <div class="progress" style="height:8px">
                        <div class="progress-bar bg-danger" :style="{ width: Math.min(quickStats.returnRate, 100) + '%' }"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import axios from 'axios';
import { onMounted, ref } from 'vue';

const loading = ref(true);

const stats = ref({
    totalProducts: '0',
    totalRevenue: '$0.00',
    newOrders: '0',
    totalCustomers: '0',
    totalCategories: '0',
    totalBrands: '0',
    pendingReviews: '0',
    lowStockItems: '0',
});

const recentOrders = ref([]);
const topProducts = ref([]);
const quickStats = ref({
    conversionRate: 0,
    ordersFulfilled: 0,
    customerSatisfaction: 0,
    returnRate: 0,
});

/**
 * Fetch real-time dashboard statistics and tables from the backend API.
 */
const fetchDashboardData = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/api/dashboard');
        const data = response.data?.data;
        if (data) {
            if (data.stats) {
                stats.value = data.stats;
            }
            if (Array.isArray(data.recentOrders)) {
                recentOrders.value = data.recentOrders;
            }
            if (Array.isArray(data.topProducts)) {
                topProducts.value = data.topProducts;
            }
            if (data.quickStats) {
                quickStats.value = data.quickStats;
            }
        }
    } catch (error) {
        console.error('Failed to load dashboard data:', error);
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchDashboardData();
});
</script>
