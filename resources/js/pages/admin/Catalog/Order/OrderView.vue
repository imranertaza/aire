<template>
    <div class="d-print-none">
        <DashboardHeader :title="'Order Details: #' + orderId">
            <div class="d-flex justify-content-end align-items-center">
                <button @click="printInvoice" class="btn btn-primary mr-2">
                    <i class="fas fa-print"></i> Print Invoice
                </button>
                <RouterLink :to="{ name: 'Orders' }" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Orders
                </RouterLink>
            </div>
        </DashboardHeader>
    </div>

    <div class="d-print-none">
        <section class="content" v-if="!loading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" :class="{ active: activeTab === 'details' }" @click.prevent="activeTab = 'details'" href="#">Order Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" :class="{ active: activeTab === 'payment' }" @click.prevent="activeTab = 'payment'" href="#">Payment & Points</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" :class="{ active: activeTab === 'history' }" @click.prevent="activeTab = 'history'" href="#">Status History</a>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <!-- Tab 1: Details -->
                                <div class="tab-pane fade" :class="{ 'show active': activeTab === 'details' }">
                                    <div class="row">
                                        <!-- Invoice Details -->
                                        <div class="col-md-4">
                                            <div class="card card-outline card-info">
                                                <div class="card-header"><h3 class="card-title font-weight-bold">General Info</h3></div>
                                                <div class="card-body p-0">
                                                    <table class="table table-sm">
                                                        <tbody>
                                                            <tr><td><strong>Order ID:</strong></td><td>#{{ order.id }}</td></tr>
                                                            <tr><td><strong>Invoice No:</strong></td><td>{{ order.invoice_no }}</td></tr>
                                                            <tr><td><strong>Order Date:</strong></td><td>{{ formatDate(order.created_at) }}</td></tr>
                                                            <tr><td><strong>IP Address:</strong></td><td>{{ order.ip }}</td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Customer Details -->
                                        <div class="col-md-4">
                                            <div class="card card-outline card-info">
                                                <div class="card-header"><h3 class="card-title font-weight-bold">Customer Details</h3></div>
                                                <div class="card-body p-0">
                                                    <table class="table table-sm">
                                                        <tbody>
                                                            <tr><td><strong>Name:</strong></td><td>{{ order.firstname }} {{ order.lastname }}</td></tr>
                                                            <tr><td><strong>Email:</strong></td><td>{{ order.email }}</td></tr>
                                                            <tr><td><strong>Phone:</strong></td><td>{{ order.telephone }}</td></tr>
                                                            <tr>
                                                                <td><strong>Account:</strong></td>
                                                                <td>
                                                                    <RouterLink v-if="order.customer_id" :to="{ name: 'UpdateCustomer', params: { id: order.customer_id } }">
                                                                        View Account Profile
                                                                    </RouterLink>
                                                                    <span v-else class="text-muted">Guest Checkout</span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card details / Payment method info -->
                                        <div class="col-md-4">
                                            <div class="card card-outline card-info">
                                                <div class="card-header"><h3 class="card-title font-weight-bold">Payment Log</h3></div>
                                                <div class="card-body p-0">
                                                    <table class="table table-sm">
                                                        <tbody>
                                                            <tr><td><strong>Payment Method:</strong></td><td>{{ order.payment_method }}</td></tr>
                                                            <tr><td><strong>Payment Status:</strong></td><td>{{ order.payment_status }}</td></tr>
                                                            <tr v-if="order.payment_transection_code">
                                                                <td><strong>Transaction Code:</strong></td>
                                                                <td>{{ order.payment_transection_code }}</td>
                                                            </tr>
                                                            <tr v-if="order.card_detail">
                                                                <td><strong>Card details:</strong></td>
                                                                <td class="small">
                                                                    Name: {{ order.card_detail.card_name }}<br/>
                                                                    Number: **** **** **** {{ String(order.card_detail.card_number).slice(-4) }}<br/>
                                                                    Expiration: {{ order.card_detail.card_expiration }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <!-- Billing Address -->
                                        <div class="col-md-6">
                                            <div class="card card-outline card-success">
                                                <div class="card-header"><h3 class="card-title font-weight-bold">Billing Address</h3></div>
                                                <div class="card-body">
                                                    <p class="mb-0">
                                                        <strong>{{ order.payment_firstname }} {{ order.payment_lastname }}</strong><br />
                                                        {{ order.payment_address_1 }}<br />
                                                        <span v-if="order.payment_address_2">{{ order.payment_address_2 }}<br /></span>
                                                        City: {{ order.payment_city }} - Postcode: {{ order.payment_postcode }}<br />
                                                        Country: {{ order.payment_country || 'Unknown' }}<br />
                                                        Phone: {{ order.payment_phone }}<br />
                                                        Email: {{ order.payment_email }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Shipping Address -->
                                        <div class="col-md-6">
                                            <div class="card card-outline card-success">
                                                <div class="card-header"><h3 class="card-title font-weight-bold">Shipping Address</h3></div>
                                                <div class="card-body">
                                                    <p class="mb-0">
                                                        <strong>{{ order.shipping_firstname }} {{ order.shipping_lastname }}</strong><br />
                                                        {{ order.shipping_address_1 }}<br />
                                                        <span v-if="order.shipping_address_2">{{ order.shipping_address_2 }}<br /></span>
                                                        City: {{ order.shipping_city }} - Postcode: {{ order.shipping_postcode }}<br />
                                                        Country: {{ order.shipping_country || 'Unknown' }}<br />
                                                        Phone: {{ order.shipping_phone }}<br />
                                                        Method: {{ order.shipping_method || 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Order Items -->
                                    <div class="row mt-4">
                                        <div class="col-md-12">
                                            <h4 class="font-weight-bold mb-3">Order Items</h4>
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item in order.items" :key="item.id">
                                                        <td class="align-middle">
                                                            <div class="d-flex align-items-center">
                                                                <img :src="item.product?.main_image ? getImageCacheUrl(item.product.main_image, 50, 50) : '/images/no-image.jpg'"
                                                                     class="img-thumbnail mr-3 cursor-pointer"
                                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                                     @click="showImagePopup(item.product)" />
                                                                <div>
                                                                    <strong>{{ item.product?.name || 'Unknown Product' }}</strong>
                                                                    <!-- Options/Variations -->
                                                                    <div v-if="order.options?.filter(opt => opt.order_item_id === item.id).length > 0" class="small text-muted mt-1">
                                                                        <span v-for="opt in order.options.filter(o => o.order_item_id === item.id)" :key="opt.id" class="mr-2">
                                                                            <strong>{{ opt.name }}:</strong> {{ opt.value }}
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>{{ item.quantity }}</td>
                                                        <td>{{ item.price }}</td>
                                                        <td class="text-right">{{ item.total_price }}</td>
                                                    </tr>
                                                    <!-- Totals -->
                                                    <tr>
                                                        <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                                        <td class="text-right">{{ order.total }}</td>
                                                    </tr>
                                                    <tr v-if="order.shipping_charge">
                                                        <td colspan="3" class="text-right"><strong>Shipping Charge:</strong></td>
                                                        <td class="text-right">{{ order.shipping_charge }}</td>
                                                    </tr>
                                                    <tr v-if="order.vat">
                                                        <td colspan="3" class="text-right"><strong>VAT ({{ order.vat }}%):</strong></td>
                                                        <td class="text-right">{{ (order.total * order.vat / 100).toFixed(2) }}</td>
                                                    </tr>
                                                    <tr v-if="order.discount">
                                                        <td colspan="3" class="text-right"><strong>Discount:</strong></td>
                                                        <td class="text-right text-danger">-{{ order.discount }}</td>
                                                    </tr>
                                                    <tr class="table-info font-weight-bold">
                                                        <td colspan="3" class="text-right"><strong>Grand Total:</strong></td>
                                                        <td class="text-right text-primary">{{ order.final_amount }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 2: Payment & Points -->
                                <div class="tab-pane fade" :class="{ 'show active': activeTab === 'payment' }">
                                    <div class="row">
                                        <!-- Payment status update -->
                                        <div class="col-md-6">
                                            <div class="card card-outline card-warning">
                                                <div class="card-header"><h3 class="card-title font-weight-bold">Update Payment Status</h3></div>
                                                <form @submit.prevent="updatePaymentStatus">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>Payment Status</label>
                                                            <select v-model="paymentStatusForm.status" class="form-control" required>
                                                                <option value="Pending">Pending</option>
                                                                <option value="Paid">Paid</option>
                                                                <option value="Failed">Failed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-warning" :disabled="submittingPayment">
                                                            <span v-if="submittingPayment" class="spinner-border spinner-border-sm mr-1"></span>
                                                            Save Status
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Customer points update -->
                                        <div class="col-md-6">
                                            <div class="card card-outline card-success">
                                                <div class="card-header"><h3 class="card-title font-weight-bold">Manage Points</h3></div>
                                                <div class="card-body" v-if="!order.customer_id">
                                                    <div class="alert alert-warning mb-0">Manual points cannot be updated for guest checkouts.</div>
                                                </div>
                                                <form v-else @submit.prevent="submitPoints">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <strong>Current Points:</strong> {{ order.customer?.point ?? 0 }} pts <br/>
                                                                <strong>Total points from this order:</strong> {{ order.total_point ?? 0 }} pts
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Action</label>
                                                                    <select v-model="pointsForm.status" class="form-control" required>
                                                                        <option value="add">Add Points</option>
                                                                        <option value="deduct">Deduct Points</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label>Points Amount</label>
                                                                    <input v-model.number="pointsForm.amount" type="number" class="form-control" min="1" required placeholder="0" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-success" :disabled="submittingPoints">
                                                            <span v-if="submittingPoints" class="spinner-border spinner-border-sm mr-1"></span>
                                                            Apply Points
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tab 3: History Timeline -->
                                <div class="tab-pane fade" :class="{ 'show active': activeTab === 'history' }">
                                    <div class="row">
                                        <!-- Timeline logs -->
                                        <div class="col-md-7">
                                            <h4 class="font-weight-bold mb-3">Status Log Timeline</h4>
                                            <div class="timeline" v-if="order.histories?.length > 0">
                                                <div v-for="log in order.histories" :key="log.id">
                                                    <i class="fas fa-clock bg-blue"></i>
                                                    <div class="timeline-item">
                                                        <span class="time"><i class="fas fa-calendar-alt"></i> {{ formatTimelineDate(log.created_at) }}</span>
                                                        <h3 class="timeline-header font-weight-bold">
                                                            Status: <span class="text-primary">{{ log.order_status?.name }}</span>
                                                        </h3>
                                                        <div class="timeline-body">
                                                            {{ log.comment || 'No comments left.' }}
                                                        </div>
                                                        <div class="timeline-footer" v-if="log.notify">
                                                            <span class="badge badge-success">Customer Notified</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else class="alert alert-info">No history timeline logs available for this order.</div>
                                        </div>

                                        <!-- Add log comments form -->
                                        <div class="col-md-5">
                                            <div class="card card-outline card-primary">
                                                <div class="card-header"><h3 class="card-title font-weight-bold">Update Order Status</h3></div>
                                                <form @submit.prevent="submitHistory">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label>Order Status</label>
                                                            <select v-model="historyForm.order_status_id" class="form-control" required>
                                                                <option v-for="status in statuses" :key="status.id" :value="status.id">
                                                                    {{ status.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Comments</label>
                                                            <textarea v-model="historyForm.comment" class="form-control" rows="4" placeholder="Enter comments here..." required></textarea>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input v-model="historyForm.notify" type="checkbox" class="form-check-input" id="notifyCus" />
                                                            <label class="form-check-label" for="notifyCus">Notify Customer</label>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="submit" class="btn btn-primary" :disabled="submittingHistory">
                                                            <span v-if="submittingHistory" class="spinner-border spinner-border-sm mr-1"></span>
                                                            Submit Log
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>

    <!-- Hidden Print-Only Invoice -->
    <div class="print-invoice-area d-none d-print-block p-4" v-if="order.id">
        <!-- Invoice Header -->
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <div>
                <h2 class="font-weight-bold text-primary mb-1">C-CART STORE</h2>
                <p class="text-muted mb-0 small">123 Business Road, Suite 100<br/>Dhaka, Bangladesh<br/>Phone: +880123456789</p>
            </div>
            <div class="text-right">
                <h3 class="font-weight-bold mb-1">INVOICE</h3>
                <p class="mb-0"><strong>Invoice No:</strong> #{{ order.invoice_no || order.id }}</p>
                <p class="mb-0"><strong>Date:</strong> {{ formatDate(order.created_at) }}</p>
            </div>
        </div>

        <!-- Addresses -->
        <div class="row mb-4">
            <div class="col-6">
                <h5 class="font-weight-bold text-muted border-bottom pb-1 mb-2">Billed To</h5>
                <p class="mb-0">
                    <strong>{{ order.payment_firstname }} {{ order.payment_lastname }}</strong><br/>
                    {{ order.payment_address_1 }}<br/>
                    <span v-if="order.payment_address_2">{{ order.payment_address_2 }}<br/></span>
                    City: {{ order.payment_city }} - Postcode: {{ order.payment_postcode }}<br/>
                    Country: {{ order.payment_country || 'Bangladesh' }}<br/>
                    Phone: {{ order.payment_phone }}<br/>
                    Email: {{ order.payment_email }}
                </p>
            </div>
            <div class="col-6">
                <h5 class="font-weight-bold text-muted border-bottom pb-1 mb-2">Shipped To</h5>
                <p class="mb-0">
                    <strong>{{ order.shipping_firstname }} {{ order.shipping_lastname }}</strong><br/>
                    {{ order.shipping_address_1 }}<br/>
                    <span v-if="order.shipping_address_2">{{ order.shipping_address_2 }}<br/></span>
                    City: {{ order.shipping_city }} - Postcode: {{ order.shipping_postcode }}<br/>
                    Country: {{ order.shipping_country || 'Bangladesh' }}<br/>
                    Phone: {{ order.shipping_phone }}
                </p>
            </div>
        </div>

        <!-- Payment/Shipping Methods -->
        <div class="row mb-4 bg-light p-2 rounded">
            <div class="col-6">
                <strong>Payment Method:</strong> {{ order.payment_method }}
            </div>
            <div class="col-6">
                <strong>Shipping Method:</strong> {{ order.shipping_method || 'Flat Rate' }}
            </div>
        </div>

        <!-- Items Table -->
        <table class="table table-bordered mb-4">
            <thead>
                <tr class="bg-secondary text-white">
                    <th>Product Description</th>
                    <th class="text-center" style="width: 10%;">Qty</th>
                    <th class="text-right" style="width: 20%;">Price</th>
                    <th class="text-right" style="width: 20%;">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in order.items" :key="item.id">
                    <td>
                        <strong>{{ item.product?.name || 'Unknown Product' }}</strong>
                        <div v-if="order.options?.filter(opt => opt.order_item_id === item.id).length > 0" class="small text-muted">
                            <span v-for="opt in order.options.filter(o => o.order_item_id === item.id)" :key="opt.id" class="mr-2">
                                <strong>{{ opt.name }}:</strong> {{ opt.value }}
                            </span>
                        </div>
                    </td>
                    <td class="text-center">{{ item.quantity }}</td>
                    <td class="text-right">{{ item.price }}</td>
                    <td class="text-right">{{ item.total_price }}</td>
                </tr>
                <!-- Summary Rows -->
                <tr>
                    <td colspan="2" class="border-0"></td>
                    <td class="text-right font-weight-bold">Subtotal:</td>
                    <td class="text-right">{{ order.total }}</td>
                </tr>
                <tr v-if="order.shipping_charge">
                    <td colspan="2" class="border-0"></td>
                    <td class="text-right font-weight-bold">Shipping:</td>
                    <td class="text-right">{{ order.shipping_charge }}</td>
                </tr>
                <tr v-if="order.vat">
                    <td colspan="2" class="border-0"></td>
                    <td class="text-right font-weight-bold">VAT ({{ order.vat }}%):</td>
                    <td class="text-right">{{ (order.total * order.vat / 100).toFixed(2) }}</td>
                </tr>
                <tr v-if="order.discount">
                    <td colspan="2" class="border-0"></td>
                    <td class="text-right font-weight-bold">Discount:</td>
                    <td class="text-right text-danger">-{{ order.discount }}</td>
                </tr>
                <tr class="table-primary font-weight-bold" style="font-size: 1.15rem;">
                    <td colspan="2" class="border-0"></td>
                    <td class="text-right text-primary">Grand Total:</td>
                    <td class="text-right text-primary">{{ order.final_amount }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Invoice Footer -->
        <div class="text-center mt-5 pt-4 border-top">
            <h5 class="font-weight-bold">Thank you for shopping with us!</h5>
            <p class="text-muted small">If you have any questions about this invoice, please contact support@c-cart.com</p>
        </div>
    </div>

    <!-- Full Image Popup Modal -->
    <div v-if="imageModal.isOpen" class="image-modal-overlay d-print-none" @click="closeImageModal">
        <div class="image-modal-content" @click.stop>
            <button class="close-btn" @click="closeImageModal">&times;</button>
            <img :src="imageModal.url" class="img-fluid rounded" />
            <h5 class="text-center mt-3 text-white font-weight-bold">{{ imageModal.title }}</h5>
        </div>
    </div>

    <div v-if="loading" class="text-center my-5 d-print-none">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useToast } from '@/composables/useToast';
import { getImageCacheUrl } from '@/layouts/helpers/helpers';

const route = useRoute();
const router = useRouter();
const toast = useToast();

const orderId = ref(route.params.id);
const loading = ref(true);
const activeTab = ref(route.query.selTab || 'details');

const imageModal = reactive({
    isOpen: false,
    url: '',
    title: ''
});

const showImagePopup = (product) => {
    if (!product || !product.main_image) return;
    imageModal.url = '/storage/' + product.main_image;
    imageModal.title = product.name;
    imageModal.isOpen = true;
};

const closeImageModal = () => {
    imageModal.isOpen = false;
};

const order = ref({});
const statuses = ref([]);

const submittingPayment = ref(false);
const submittingPoints = ref(false);
const submittingHistory = ref(false);

const paymentStatusForm = reactive({
    status: 'Pending'
});

const pointsForm = reactive({
    status: 'add',
    amount: 10
});

const historyForm = reactive({
    order_status_id: 1,
    comment: '',
    notify: false
});

const fetchDetails = async () => {
    try {
        const res = await axios.get(`/api/orders/${orderId.value}`);
        order.value = res.data.data.order;
        statuses.value = res.data.data.statuses;

        paymentStatusForm.status = order.value.payment_status;
        historyForm.order_status_id = order.value.status;
    } catch (error) {
        toast.error('Failed to load order details.');
        router.push({ name: 'Orders' });
    } finally {
        loading.value = false;
    }
};

onMounted(() => {
    fetchDetails();
});

const updatePaymentStatus = async () => {
    submittingPayment.value = true;
    try {
        await axios.patch(`/api/orders/${orderId.value}/payment-status`, paymentStatusForm);
        toast.success('Payment status updated successfully!');
        fetchDetails();
    } catch (error) {
        toast.validationError(error);
    } finally {
        submittingPayment.value = false;
    }
};

const submitPoints = async () => {
    submittingPoints.value = true;
    try {
        await axios.post(`/api/orders/${orderId.value}/points`, pointsForm);
        toast.success('Points balance modified successfully!');
        pointsForm.amount = 10;
        fetchDetails();
    } catch (error) {
        toast.validationError(error);
    } finally {
        submittingPoints.value = false;
    }
};

const submitHistory = async () => {
    submittingHistory.value = true;
    try {
        await axios.post(`/api/orders/${orderId.value}/history`, historyForm);
        toast.success('Order status updated successfully!');
        historyForm.comment = '';
        historyForm.notify = false;
        fetchDetails();
    } catch (error) {
        toast.validationError(error);
    } finally {
        submittingHistory.value = false;
    }
};

const formatDate = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const formatTimelineDate = (dateStr) => {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const printInvoice = () => {
    window.print();
};
</script>

<style scoped>
.gap-1 {
    gap: 0.25rem;
}
.timeline {
    position: relative;
    margin: 0 0 30px 0;
    padding: 0;
    list-style: none;
}
.timeline::before {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #cccccc;
    left: 31px;
    margin: 0;
    border-radius: 2px;
}
.timeline > div {
    position: relative;
    margin-right: 10px;
    margin-bottom: 15px;
}
.timeline > div > i {
    width: 30px;
    height: 30px;
    font-size: 15px;
    line-height: 30px;
    position: absolute;
    color: #ffffff;
    background: #007bff;
    border-radius: 50%;
    text-align: center;
    left: 18px;
    top: 0;
}
.timeline > div > .timeline-item {
    box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
    border-radius: 0.25rem;
    background-color: #ffffff;
    color: #495057;
    margin-left: 60px;
    margin-right: 15px;
    padding: 0;
    position: relative;
}
.timeline > div > .timeline-item > .time {
    color: #999999;
    float: right;
    padding: 10px;
    font-size: 12px;
}
.timeline > div > .timeline-item > .timeline-header {
    margin: 0;
    color: #495057;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    padding: 10px;
    font-size: 16px;
    line-height: 1.1;
}
.timeline > div > .timeline-item > .timeline-body,
.timeline > div > .timeline-item > .timeline-footer {
    padding: 10px;
}

@media print {
    /* Hide all dashboard/screen wrapper components */
    body {
        background-color: #ffffff !important;
        color: #000000 !important;
    }
    .wrapper,
    .main-sidebar,
    .main-header,
    .main-footer,
    .content-wrapper,
    .dashboard-header,
    .d-print-none,
    .btn,
    .nav-tabs,
    .card,
    .card-header,
    .timeline,
    nav,
    aside,
    header {
        display: none !important;
    }
    
    /* Make invoice print layout fill the page */
    .print-invoice-area {
        display: block !important;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 0;
    }
}

.image-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.image-modal-content {
    position: relative;
    max-width: 80%;
    max-height: 80%;
}
.image-modal-content img {
    max-height: 75vh;
    width: auto;
}
.close-btn {
    position: absolute;
    top: -45px;
    right: 0;
    background: none;
    border: none;
    color: #ffffff;
    font-size: 2.5rem;
    cursor: pointer;
    line-height: 1;
}
.cursor-pointer {
    cursor: pointer;
}
</style>
