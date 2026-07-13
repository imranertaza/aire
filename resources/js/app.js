import {
    createApp
} from "vue";
import {
    createPinia
} from "pinia";
import router from "./router";

import "bootstrap-icons/font/bootstrap-icons.css";
import "@fortawesome/fontawesome-free/css/all.min.css";
import "ionicons/css/ionicons.min.css";
import "vue3-toastify/dist/index.css";
import "@/assets/dist/css/adminlte.min.css";
import App from "./App.vue";
import axios from "axios";
import Vue3Toastify from "vue3-toastify";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import $ from "jquery";
window.$ = window.jQuery = $;
import "summernote/dist/summernote-lite.css";
import "summernote/dist/summernote-lite.js";
import {
    useLoadingStore
} from "./store/useLoadingStore";


const app = createApp(App);
app.use(createPinia());
app.use(router);
app.use(VueSweetalert2);
app.use(Vue3Toastify, {
    autoClose: 3000,
    position: "top-right",
    theme: "light",
});
const token = localStorage.getItem("token");

axios.defaults.withCredentials = true;
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.interceptors.request.use((config) => {
    const loadingStore = useLoadingStore();

    // Normalize method to lowercase
    const method = config.method?.toLowerCase();

    if (["post", "put", "patch", "delete", "get"].includes(method)) {
        // Dynamic message based on method
        const msgMap = {
            post: "Working...",
            put: "Updating...",
            patch: "Updating...",
            delete: "Deleting..."
        };
        loadingStore.start(msgMap[method] || "Processing...");

        // Attach upload progress handler if applicable
        config.onUploadProgress = (event) => {
            if (event.total) {
                const percent = Math.round((event.loaded * 100) / event.total);
                loadingStore.setProgress(percent);
            }
        };
    }

    return config;
});

axios.interceptors.response.use(
    (response) => {
        const loadingStore = useLoadingStore();
        const method = response.config.method?.toLowerCase();

        if (["post", "put", "patch", "delete","get"].includes(method)) {
            loadingStore.stop();
        }
        return response;
    },
    (error) => {
        const loadingStore = useLoadingStore();
        const method = error.config?.method?.toLowerCase();

        if (["post", "put", "patch", "delete", "get"].includes(method)) {
            loadingStore.stop();
        }
        return Promise.reject(error);
    }
);
if (token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`;
}
app.mount("#app");
