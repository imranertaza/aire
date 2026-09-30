<template>
    <DashboardHeader title="Welcome to Admin Dashboard" />

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ stats.totalPosts }}</h3>
                    <p>Total Posts</p>
                </div>
                <div class="icon"><i class="fas fa-file-alt"></i></div>
                <router-link :to="{ name: 'Posts' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ stats.totalNews }}</h3>
                    <p>Total News</p>
                </div>
                <div class="icon"><i class="fas fa-newspaper"></i></div>
                <router-link :to="{ name: 'News' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ stats.totalNotices }}</h3>
                    <p>Total Notices</p>
                </div>
                <div class="icon"><i class="fas fa-bell"></i></div>
                <router-link :to="{ name: 'Notices' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ stats.totalFixtures }}</h3>
                    <p>Total Match Fixtures</p>
                </div>
                <div class="icon"><i class="fas fa-futbol"></i></div>
                <router-link :to="{ name: 'Notices' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ stats.totalPlayers }}</h3>
                    <p>Total Players</p>
                </div>
                <div class="icon"><i class="fas fa-users"></i></div>
                <router-link :to="{ name: 'Players' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ stats.totalMembers }}</h3>
                    <p>Total Executive Members</p>
                </div>
                <div class="icon"><i class="fas fa-user-tie"></i></div>
                <router-link :to="{ name: 'CommitteeMembers' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ stats.totalRunningEvents }}</h3>
                    <p>Total Running Events</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-check"></i></div>
                <router-link :to="{ name: 'Events' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ stats.totalUpcomingEvents }}</h3>
                    <p>Total Upcoming Events</p>
                </div>
                <div class="icon"><i class="fas fa-calendar-plus"></i></div>
                <router-link :to="{ name: 'Events' }" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import DashboardHeader from '@/components/DashboardHeader.vue';
import { ref, onMounted } from 'vue'
import axios from 'axios'

const stats = ref({
    totalPosts: 0,
    totalNews: 0,
    totalNotices: 0,
    totalFixtures: 0,
    totalPlayers: 0,
    totalMembers: 0,
    totalRunningEvents: 0,
    totalUpcomingEvents: 0,
})

const fetchStats = async () => {
    try {
        const res = await axios.get('/api/dashboard')
        stats.value = res.data.data
    } catch (error) {
        console.error('Failed to load stats', error)
    }
}

onMounted(fetchStats)
</script>
