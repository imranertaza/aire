<template>
    <DashboardHeader title="Email Campaigns">
        <div class="d-flex justify-content-end align-items-center">
            <button class="btn btn-secondary" @click="fetchPage(1)">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    </DashboardHeader>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div v-if="campaigns?.data?.length === 0" class="alert alert-info">No email campaigns found.</div>

                    <div v-else>
                        <div class="card shadow-sm border-0">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover mb-0">
                                        <thead class="thead-light">
                                            <tr class="align-middle">
                                                <th style="width: 10px">#</th>
                                                <th>Subject</th>
                                                <th>Audiences</th>
                                                <th>Progress</th>
                                                <th>Failed</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(campaign, index) in campaigns?.data" :key="campaign.id">
                                                <td class="align-middle">{{ index + 1 }}</td>
                                                <td class="align-middle font-weight-bold">{{ campaign.subject }}</td>
                                                <td class="align-middle text-muted">{{ campaign.audiences }}</td>
                                                <td class="align-middle" style="width: 250px;">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <small>Sent: {{ campaign.sent_count }} / {{ campaign.total_recipients }}</small>
                                                        <small>{{ calculatePercentage(campaign.sent_count, campaign.total_recipients) }}%</small>
                                                    </div>
                                                    <div class="progress progress-sm">
                                                        <div class="progress-bar bg-success" :style="{ width: calculatePercentage(campaign.sent_count, campaign.total_recipients) + '%' }"></div>
                                                    </div>
                                                </td>
                                                <td class="align-middle text-danger font-weight-bold">
                                                    {{ campaign.failed_count }}
                                                </td>
                                                <td class="align-middle">
                                                    <span class="badge" :class="campaign.status === 'completed' ? 'badge-success' : 'badge-warning'">
                                                        {{ campaign.status === 'completed' ? 'Completed' : 'Processing...' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle">
                                                    <small>{{ new Date(campaign.created_at).toLocaleString() }}</small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Pagination :pData="campaigns" @page-change="fetchPage" class="mt-3 px-3" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useToast } from '@/composables/useToast';
import DashboardHeader from '@/components/DashboardHeader.vue';
import Pagination from '@/components/Paginations/Pagination.vue';

const toast = useToast();
const campaigns = ref([]);

const fetchPage = async (page = 1) => {
    try {
        const res = await axios.get(`/api/email-campaigns?page=${page}`);
        campaigns.value = res.data.data;
    } catch (error) {
        toast.error('Failed to load email campaigns');
    }
};

const calculatePercentage = (sent, total) => {
    if (total === 0) return 0;
    return Math.round((sent / total) * 100);
};

onMounted(() => {
    fetchPage();
});
</script>
