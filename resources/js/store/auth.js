import axios from "axios";
import { defineStore } from "pinia";

/**
 * Pinia store for managing admin authentication state.
 *
 * Stores the authentication token, current user role, and permissions.
 * Provides helper to check permission access.
 */
export const useAuthStore = defineStore('auth', {
    state: () => ({
      token: null,           // Sanctum API token
      role: null,            // Current user role (e.g., 'admin', 'editor')
      permissions: [],       // Array of permission strings
      modules: [],           // Array of enabled module keys
    }),
    actions: {
      /**
       * Fetch current user's role and permissions from backend.
       */
      async fetchRoleAndPermissions() {
        const res = await axios.get('/api/admin/me');
        this.role = res.data.role;
        this.permissions = res.data.permissions;
        this.modules = res.data.modules || [];
      },
      /**
       * Check if current user has a specific permission.
       *
       * @param {string} permission - Permission name to check
       * @returns {boolean} True if user has the permission
       */
      hasPermission(permission) {
        return this.permissions.includes(permission);
      },
      /**
       * Check if a specific module is enabled.
       *
       * @param {string} moduleKey - Module key to check
       * @returns {boolean} True if module is enabled
       */
      isModuleEnabled(moduleKey) {
        return this.modules.includes(moduleKey);
      }
    }
  });
