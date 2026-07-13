<template>
  <DashboardHeader title="Update Player" />

  <section class="content">
    <div class="container-fluid">
      <div class="row row-cols-1">
        <div class="card card-purple">
          <div class="card-header">
            <h3 class="card-title">Edit Player</h3>
          </div>

          <form @submit.prevent="updatePlayer">
            <div class="card-body">
              <div class="row">
                <!-- Left Column -->
                <div class="col-md-8">
                  <!-- Player Name -->
                  <div class="form-group">
                    <label>Player Name</label>
                    <input
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>

                  <!-- Sport -->
                  <div class="form-group">
                    <label>Sport</label>
                    <input
                      v-model="form.sport"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>

                  <!-- Position -->
                  <div class="form-group">
                    <label>Position</label>
                    <input
                      v-model="form.position"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>

                  <!-- Team -->
                  <div class="form-group">
                    <label>Team</label>
                    <input
                      v-model="form.team"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>

                  <!-- Country -->
                  <div class="form-group">
                    <label>Country</label>
                    <input v-model="form.country" type="text" class="form-control" />
                  </div>

                  <!-- Birthdate -->
                  <div class="form-group">
                    <label>Birthdate</label>
                    <input
                      v-model="form.birthdate"
                      type="date"
                      class="form-control"
                      required
                    />
                  </div>

                  <!-- Height -->
                  <div class="form-group">
                    <label>Height (cm)</label>
                    <input v-model="form.height" type="text" class="form-control" />
                  </div>

                  <!-- Weight -->
                  <div class="form-group">
                    <label>Weight (kg)</label>
                    <input v-model="form.weight" type="text" class="form-control" />
                  </div>

                  <!-- Hometown -->
                  <div class="form-group">
                    <label>Hometown</label>
                    <input v-model="form.hometown" type="text" class="form-control" />
                  </div>

                  <!-- Rankings -->
                  <div class="form-group">
                    <label>Asian Ranking</label>
                    <input
                      v-model="form.asian_ranking"
                      type="text"
                      class="form-control"
                    />
                  </div>
                  <div class="form-group">
                    <label>National Ranking</label>
                    <input
                      v-model="form.national_ranking"
                      type="text"
                      class="form-control"
                    />
                  </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                  <!-- Image Upload -->
                  <div class="form-group">
                    <label>Upload Image</label>
                    <Vue3Dropzone
                      v-model="fileUpload"
                      v-model:previews="previews"
                      mode="edit"
                      :allowSelectOnPreview="true"
                    />
                    <small class="text-muted">Recommended: 262 × 225px</small>

                    <!-- Preview -->
                    <div v-if="previews && previews.length" class="mt-3">
                      <div v-for="(preview, idx) in previews" :key="idx">
                        <img
                          :src="preview"
                          alt="Preview"
                          class="img-fluid rounded border"
                          style="max-height: 120px"
                        />
                      </div>
                    </div>
                  </div>

                  <!-- Status -->
                  <div class="form-group">
                    <label>Status</label>
                    <select v-model="form.status" class="custom-select">
                      <option value="1">Active</option>
                      <option value="0">Inactive</option>
                    </select>
                  </div>

                  <div>
                    <button type="submit" class="btn btn-success btn-block">
                      Update
                    </button>
                    <RouterLink
                      :to="{ name: 'Players' }"
                      class="btn btn-secondary btn-block mt-2"
                    >
                      Cancel
                    </RouterLink>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import axios from "axios";
import { onMounted, reactive, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import DashboardHeader from "@/components/DashboardHeader.vue";
import { useToast } from "@/composables/useToast";
import { getImageUrl } from "@/layouts/helpers/helpers";
import Vue3Dropzone from "@jaxtheprime/vue3-dropzone";
import "@jaxtheprime/vue3-dropzone/dist/style.css";

const toast = useToast();
const route = useRoute();
const router = useRouter();
const previews = ref([]);

const form = reactive({
  id: null,
  name: "",
  sport: "",
  position: "",
  team: "",
  country: "",
  birthdate: "",
  height: "",
  weight: "",
  hometown: "",
  asian_ranking: "",
  national_ranking: "",
  image: "",
  status: "1",
});

const fileUpload = ref(null);

// Fetch player
const fetchPlayer = async () => {
  try {
    const res = await axios.get(`/api/players/${route.params.id}`);
    Object.assign(form, res.data.data);
    if (form.image) {
      previews.value = [getImageUrl(form.image)];
    }
  } catch (err) {
    toast.error("Failed to load player");
    console.error(err);
  }
};

// Update player
const updatePlayer = async () => {
  const payload = new FormData();
  if (!previews.value[0]) {
    payload.append("remove_image", 1);
  }
  for (const key in form) {
    if (key !== "image") {
      payload.append(key, form[key]);
    }
  }
  if (fileUpload.value && fileUpload.value[0]) {
    payload.append("image", fileUpload.value[0].file);
  }

  try {
    await axios.post(`/api/players/${form.id}?_method=PUT`, payload, {
      headers: { "Content-Type": "multipart/form-data" },
    });
    router.push({ name: "Players", query: { toast: "Player updated successfully" } });
  } catch (err) {
    toast.validationError(err);
  }
};

defineProps({
  id: {
    type: [String, Number],
  },
});

onMounted(() => {
  fetchPlayer();
});
</script>
