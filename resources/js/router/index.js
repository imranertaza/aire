
import {
    useAuthStore
} from "@/store/auth";
import {
    createRouter,
    createWebHistory
} from "vue-router";

const routes = [{
    path: "/admin",
    children: [{
        path: "login",
        name: "AdminLogin",
        component: () => import('@/pages/admin/auth/Login.vue')
    },
    {
        path: "",
        prefix: "admin",
        component: () => import('@/layouts/AdminLayout.vue'),
        meta: {
            requiresAuth: true,
            role: "admin"
        },

        children: [

            {
                path: "",
                name: "Dashboard",
                component: () => import('@/pages/admin/Dashboard.vue'),
                meta: {
                    permission: "view-dashboard"
                },
            },

            {
                path: "admin-profile",
                name: "adminProfile",
                component: () => import('@/pages/admin/auth/Profile.vue'),
                meta: {
                    permission: "view-dashboard"
                },
            },

            // Role & Permission Management
            {
                path: "manage-admins-roles",
                name: "RolePermission",
                component: () => import('@/pages/admin/users/ManageUser.vue'),
                meta: {
                    permission: "view-users"
                }, // viewing admins/roles
            },
            {
                path: "admins/:id/edit",
                name: "AdminUserUpdate",
                component: () => import('@/pages/admin/users/AdminUserUpdate.vue'),
                meta: {
                    permission: "update-users"
                },
            },
            {
                path: "manage-role-permissions",
                name: "RolePermissionManager",
                component: () => import('@/pages/admin/users/RolePermissionManager.vue'),
                meta: {
                    permission: "update-user-role"
                }, // updating role permissions
            },

            // Pages CRUD
            {
                path: "manage-pages",
                name: "Pages",
                component: () => import('@/pages/admin/Pages/Pages.vue'),
                meta: {
                    permission: "view-pages"
                },
            },
            {
                path: "pages/:id",
                name: "ShowPage",
                component: () => import('@/pages/admin/Pages/ShowPage.vue'),
                props: true,
                meta: {
                    permission: "view-pages"
                },
            },
            {
                path: "edit-pages/:id",
                name: "UpdatePages",
                component: () => import('@/pages/admin/Pages/UpdatePages.vue'),
                props: true,
                meta: {
                    permission: "edit-pages"
                },
            },
            {
                path: "create-page",
                name: "CreatePage",
                component: () => import('@/pages/admin/Pages/CreatePage.vue'),
                meta: {
                    permission: "create-pages"
                },
            },
            // Posts CRUD
            {
                path: "manage-posts",
                name: "Posts",
                component: () => import('@/pages/admin/Post/Post.vue'),
                meta: {
                    permission: "view-posts"
                },
            },
            {
                path: "posts/:id",
                name: "ShowPost",
                component: () => import('@/pages/admin/Post/ShowPost.vue'),
                props: true,
                meta: {
                    permission: "view-posts"
                },
            },
            {
                path: "edit-posts/:id",
                name: "UpdatePost",
                component: () => import('@/pages/admin/Post/UpdatePost.vue'),
                props: true,
                meta: {
                    permission: "edit-posts"
                },
            },
            {
                path: "create-posts",
                name: "CreatePost",
                component: () => import('@/pages/admin/Post/CreatePost.vue'),
                meta: {
                    permission: "create-posts"
                },
            },

            // Settings
            {
                path: "generale-settings",
                name: "GeneralSettings",
                component: () => import('@/pages/admin/Settings/GeneralSettings.vue'),
                meta: {
                    permission: "update-settings"
                },
            },

            {
                path: "categories",
                name: "CategoryIndex",
                component: () => import('@/pages/admin/Post/Category/Category.vue'),
                meta: {
                    permission: "view-categories",
                },
            },
            {
                path: "categories/create",
                name: "CategoryCreate",
                component: () => import('@/pages/admin/Post/Category/CategoryCreate.vue'),
                meta: {
                    permission: "create-categories",
                },
            },
            {
                path: "categories/:id/edit",
                name: "UpdateCategory",
                component: () => import('@/pages/admin/Post/Category/CategoryEdit.vue'),
                props: true,
                meta: {
                    permission: "edit-categories",
                },
            },
            {
                path: "admin/categories/:id",
                name: "CategoryShow",
                component: () => import('@/pages/admin/Post/Category/CategoryShow.vue'),
                props: true,
                meta: {
                    permission: "view-categories",
                },
            },
            // News CRUD
            {
                path: "manage-news",
                name: "News",
                component: () => import('@/pages/admin/News/News.vue'),
                meta: {
                    permission: "view-news"
                },
            },
            {
                path: "news/:id",
                name: "ShowNews",
                component: () => import('@/pages/admin/News/ShowNews.vue'),
                props: true,
                meta: {
                    permission: "view-news"
                },
            },
            {
                path: "edit-news/:id",
                name: "UpdateNews",
                component: () => import('@/pages/admin/News/UpdateNews.vue'),
                props: true,
                meta: {
                    permission: "edit-news"
                },
            },
            {
                path: "create-news",
                name: "CreateNews",
                component: () => import('@/pages/admin/News/CreateNews.vue'),
                meta: {
                    permission: "create-news"
                },
            },

            {
                path: "news-categories",
                name: "NewsCategoryIndex",
                component: () => import('@/pages/admin/News/NewsCategory/NewsCategory.vue'),
                meta: {
                    permission: "view-news-categories",
                },
            },
            {
                path: "news-categories/create",
                name: "NewsCategoryCreate",
                component: () => import('@/pages/admin/News/NewsCategory/NewsCategoryCreate.vue'),
                meta: {
                    permission: "create-news-categories",
                },
            },
            {
                path: "news-categories/edit/:id",
                name: "UpdateNewsCategory",
                component: () => import('@/pages/admin/News/NewsCategory/NewsCategoryEdit.vue'),
                props: true,
                meta: {
                    permission: "edit-news-categories",
                },
            },
            {
                path: "admin/news-categories/:id",
                name: "NewsCategoryShow",
                component: () => import('@/pages/admin/News/NewsCategory/NewsCategoryShow.vue'),
                props: true,
                meta: {
                    permission: "view-news-categories",
                },
            },
            // Blog CRUD
            {
                path: "manage-blogs",
                name: "Blog",
                component: () => import('@/pages/admin/Blog/Blog.vue'),
                meta: {
                    permission: "view-blog"
                },
            },
            {
                path: "blogs/:id",
                name: "ShowBlog",
                component: () => import('@/pages/admin/Blog/ShowBlog.vue'),
                props: true,
                meta: {
                    permission: "view-blog"
                },
            },
            {
                path: "edit-blogs/:id",
                name: "UpdateBlog",
                component: () => import('@/pages/admin/Blog/UpdateBlog.vue'),
                props: true,
                meta: {
                    permission: "edit-blog"
                },
            },
            {
                path: "create-blogs",
                name: "CreateBlog",
                component: () => import('@/pages/admin/Blog/CreateBlog.vue'),
                meta: {
                    permission: "create-blog"
                },
            },

            {
                path: "blog-categories",
                name: "BlogCategoryIndex",
                component: () => import('@/pages/admin/Blog/BlogCategory/BlogCategory.vue'),
                meta: {
                    permission: "view-blog-categories",
                },
            },
            {
                path: "blog-categories/create",
                name: "BlogCategoryCreate",
                component: () => import('@/pages/admin/Blog/BlogCategory/BlogCategoryCreate.vue'),
                meta: {
                    permission: "create-blog-categories",
                },
            },
            {
                path: "blog-categories/edit/:id",
                name: "UpdateBlogCategory",
                component: () => import('@/pages/admin/Blog/BlogCategory/BlogCategoryEdit.vue'),
                props: true,
                meta: {
                    permission: "edit-blog-categories",
                },
            },
            {
                path: "admin/blog-categories/:id",
                name: "BlogCategoryShow",
                component: () => import('@/pages/admin/Blog/BlogCategory/BlogCategoryShow.vue'),
                props: true,
                meta: {
                    permission: "view-blog-categories",
                },
            },
            // Menu manager
            {
                path: "menus",
                name: "MenuManager",
                component: () => import('@/pages/admin/menu/MenusIndex.vue'),
                meta: {
                    permission: "manage-menus",
                },
            },
            {
                path: "menu/view/:id",
                name: "ShowMenu",
                component: () => import('@/pages/admin/menu/MenuManager.vue'),
                meta: {
                    permission: "manage-menus",
                },
                props: true,
            },
            {
                path: "manage-galleries",
                name: "Gallery",
                component: () => import('@/pages/admin/Gallery/Gallery.vue'),
                meta: {
                    permission: "view-galleries"
                },
            },
            {
                path: "galleries/:id",
                name: "ShowGallery",
                component: () => import('@/pages/admin/Gallery/ShowGallery.vue'),
                props: true,
                meta: {
                    permission: "view-galleries"
                },
            },
            {
                path: "edit-galleries/:id",
                name: "UpdateGallery",
                component: () => import('@/pages/admin/Gallery/UpdateGallery.vue'),
                props: true,
                meta: {
                    permission: "edit-galleries"
                },
            },
            {
                path: "create-gallery",
                name: "CreateGallery",
                component: () => import('@/pages/admin/Gallery/CreateGallery.vue'),
                meta: {
                    permission: "create-galleries"
                },
            },
            {
                path: "manage-events",
                name: "Events",
                component: () => import('@/pages/admin/Event/Event.vue'),
                meta: {
                    permission: "view-events"
                },
            },
            {
                path: "events/:id",
                name: "ShowEvent",
                component: () => import('@/pages/admin/Event/ShowEvent.vue'),
                props: true,
                meta: {
                    permission: "view-events"
                },
            },
            {
                path: "edit-events/:id",
                name: "UpdateEvent",
                component: () => import('@/pages/admin/Event/UpdateEvent.vue'),
                props: true,
                meta: {
                    permission: "edit-events"
                },
            },
            {
                path: "create-events",
                name: "CreateEvent",
                component: () => import('@/pages/admin/Event/CreateEvent.vue'),
                meta: {
                    permission: "create-events"
                },
            },
            {
                path: "event-categories",
                name: "EventCategoryIndex",
                component: () => import('@/pages/admin/Event/EventsCategory/EventCategory.vue'),
                meta: {
                    permission: "view-events-categories",
                },
            },
            {
                path: "event-categories/create",
                name: "EventCategoryCreate",
                component: () => import('@/pages/admin/Event/EventsCategory/EventCategoryCreate.vue'),
                meta: {
                    permission: "create-events-categories",
                },
            },
            {
                path: "event-categories/edit/:id",
                name: "UpdateEventCategory",
                component: () => import('@/pages/admin/Event/EventsCategory/EventCategoryEdit.vue'),
                props: true,
                meta: {
                    permission: "edit-events-categories",
                },
            },
            {
                path: "event-categories/:id",
                name: "EventCategoryShow",
                component: () => import('@/pages/admin/Event/EventsCategory/EventCategoryShow.vue'),
                props: true,
                meta: {
                    permission: "view-events-categories",
                },
            },
            {
                path: "manage-notices",
                name: "Notices",
                component: () => import('@/pages/admin/Notice/Notice.vue'),
                meta: {
                    permission: "view-notices"
                },
            },
            {
                path: "notices/:id",
                name: "ShowNotice",
                component: () => import('@/pages/admin/Notice/ShowNotice.vue'),
                props: true,
                meta: {
                    permission: "view-notices"
                },
            },
            {
                path: "edit-notices/:id",
                name: "UpdateNotice",
                component: () => import('@/pages/admin/Notice/UpdateNotice.vue'),
                props: true,
                meta: {
                    permission: "edit-notices"
                },
            },
            {
                path: "create-notices",
                name: "CreateNotice",
                component: () => import('@/pages/admin/Notice/CreateNotice.vue'),
                meta: {
                    permission: "create-notices"
                },
            },
            {
                path: "manage-players",
                name: "Players",
                component: () => import('@/pages/admin/Player/Player.vue'),
                meta: {
                    permission: "view-players"
                },
            },
            {
                path: "players/:id",
                name: "ShowPlayer",
                component: () => import('@/pages/admin/Player/ShowPlayer.vue'),
                props: true,
                meta: {
                    permission: "view-players"
                },
            },
            {
                path: "edit-players/:id",
                name: "UpdatePlayer",
                component: () => import('@/pages/admin/Player/UpdatePlayer.vue'),
                props: true,
                meta: {
                    permission: "edit-players"
                },
            },
            {
                path: "create-players",
                name: "CreatePlayer",
                component: () => import('@/pages/admin/Player/CreatePlayer.vue'),
                meta: {
                    permission: "create-players"
                },
            },
            {
                path: "manage-results",
                name: "Results",
                component: () => import('@/pages/admin/Result/Result.vue'),
                meta: {
                    permission: "view-results"
                },
            },
            {
                path: "results/:id",
                name: "ShowResult",
                component: () => import('@/pages/admin/Result/ShowResult.vue'),
                props: true,
                meta: {
                    permission: "view-results"
                },
            },
            {
                path: "edit-results/:id",
                name: "UpdateResult",
                component: () => import('@/pages/admin/Result/UpdateResult.vue'),
                props: true,
                meta: {
                    permission: "edit-results"
                },
            },
            {
                path: "create-results",
                name: "CreateResult",
                component: () => import('@/pages/admin/Result/CreateResult.vue'),
                meta: {
                    permission: "create-results"
                },
            },
            {
                path: "home-sections",
                name: "HomeSections",
                component: () => import('@/pages/admin/Section/HomeSections.vue'),
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "manage-sections",
                name: "Section",
                component: () => import('@/pages/admin/Section/Section.vue'),
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "client-testimonials",
                name: "TestimonialsSection",
                component: () => import('@/pages/admin/Section/TestimonialsSection.vue'),
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "edit-sections/:id",
                name: "UpdateSection",
                component: () => import('@/pages/admin/Section/UpdateSection.vue'),
                props: true,
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "banner-sliders",
                name: "Sliders",
                component: () => import('@/pages/admin/Sliders/Sliders.vue'),
                props: true,
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "edit-sliders/:id",
                name: "UpdateSlider",
                component: () => import('@/pages/admin/Sliders/UpdateSlider.vue'),
                props: true,
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "create-sliders",
                name: "CreateSlider",
                component: () => import('@/pages/admin/Sliders/CreateSlider.vue'),
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "manage-committee-members",
                name: "CommitteeMembers",
                component: () => import('@/pages/admin/CommitteeMember/CommitteeMembers.vue'),
                props: true,
                meta: {
                    permission: "manage-committee-members"
                },
            },
            {
                path: "edit-committee-members/:id",
                name: "UpdateCommitteeMembers",
                component: () => import('@/pages/admin/CommitteeMember/UpdateCommitteeMembers.vue'),
                props: true,
                meta: {
                    permission: "manage-committee-members"
                },
            },
            {
                path: "create-committee-members",
                name: "CreateCommitteeMembers",
                component: () => import('@/pages/admin/CommitteeMember/CreateCommitteeMembers.vue'),
                meta: {
                    permission: "manage-committee-members"
                },
            },
            {
                path: "manage-brands",
                name: "Brands",
                component: () => import('@/pages/admin/Catalog/Brand/Brand.vue'),
                meta: {
                    permission: "view-brands"
                },
            },
            {
                path: "brands/:id",
                name: "ShowBrand",
                component: () => import('@/pages/admin/Catalog/Brand/ShowBrand.vue'),
                props: true,
                meta: {
                    permission: "view-brands"
                },
            },
            {
                path: "edit-brands/:id",
                name: "UpdateBrand",
                component: () => import('@/pages/admin/Catalog/Brand/UpdateBrand.vue'),
                props: true,
                meta: {
                    permission: "edit-brands"
                },
            },
            {
                path: "create-brands",
                name: "CreateBrand",
                component: () => import('@/pages/admin/Catalog/Brand/CreateBrand.vue'),
                meta: {
                    permission: "create-brands"
                },
            },
            {
                path: "manage-coupons",
                name: "Coupons",
                component: () => import('@/pages/admin/Catalog/Coupon/Coupons.vue'),
                meta: {
                    permission: "view-coupons"
                },
            },
            {
                path: "manage-reviews",
                name: "Reviews",
                component: () => import('@/pages/admin/Catalog/Review/Reviews.vue'),
                meta: {
                    permission: "view-reviews"
                },
            },
            {
                path: "manage-customers",
                name: "Customers",
                component: () => import('@/pages/admin/Catalog/Customer/Customers.vue'),
                meta: {
                    permission: "view-customers"
                },
            },
            {
                path: "create-customer",
                name: "CreateCustomer",
                component: () => import('@/pages/admin/Catalog/Customer/CreateCustomer.vue'),
                meta: {
                    permission: "create-customers"
                },
            },
            {
                path: "edit-customer/:id",
                name: "UpdateCustomer",
                component: () => import('@/pages/admin/Catalog/Customer/UpdateCustomer.vue'),
                props: true,
                meta: {
                    permission: "edit-customers"
                },
            },
            {
                path: "customer-ledger/:id",
                name: "CustomerLedger",
                component: () => import('@/pages/admin/Catalog/Customer/CustomerLedger.vue'),
                props: true,
                meta: {
                    permission: "view-customers"
                },
            },
            {
                path: "manage-orders",
                name: "Orders",
                component: () => import('@/pages/admin/Catalog/Order/Orders.vue'),
                meta: {
                    permission: "view-orders"
                },
            },
            {
                path: "view-order/:id",
                name: "OrderView",
                component: () => import('@/pages/admin/Catalog/Order/OrderView.vue'),
                props: true,
                meta: {
                    permission: "view-orders"
                },
            },
            {
                path: "edit-coupons/:id",
                name: "UpdateCoupon",
                component: () => import('@/pages/admin/Catalog/Coupon/UpdateCoupon.vue'),
                props: true,
                meta: {
                    permission: "edit-coupons"
                },
            },
            {
                path: "create-coupons",
                name: "CreateCoupon",
                component: () => import('@/pages/admin/Catalog/Coupon/CreateCoupon.vue'),
                meta: {
                    permission: "create-coupons"
                },
            },
            {
                path: 'newsletters',
                name: 'NewsletterList',
                component: () => import('@/pages/admin/Newsletter/NewsletterList.vue'),
                meta: { permission: 'view-newsletters', title: 'Newsletters' }
            },
            {
                path: 'email-send',
                name: 'EmailSend',
                component: () => import('@/pages/admin/EmailSend/EmailSend.vue'),
                meta: { title: 'Send Email' }
            },
            {
                path: 'fund-requests',
                name: 'FundRequestList',
                component: () => import('@/pages/admin/FundRequest/FundRequestList.vue'),
                meta: { title: 'Fund Requests' }
            },
            {
                path: 'color-families',
                name: 'ColorFamilyList',
                component: () => import('@/pages/admin/ColorFamily/ColorFamilyList.vue'),
                meta: { title: 'Color Families' }
            },
            {
                path: "offers",
                name: "Offers",
                component: () => import('@/pages/admin/Catalog/Offer/Offers.vue'),
                meta: {
                    permission: "view-offers"
                },
            },
            {
                path: "offers/create",
                name: "CreateOffer",
                component: () => import('@/pages/admin/Catalog/Offer/CreateOffer.vue'),
                meta: {
                    permission: "create-offers"
                },
            },
            {
                path: "offers/edit/:id",
                name: "UpdateOffer",
                component: () => import('@/pages/admin/Catalog/Offer/UpdateOffer.vue'),
                props: true,
                meta: {
                    permission: "edit-offers"
                },
            },
            {
                path: "shipping-methods",
                name: "ShippingList",
                component: () => import('@/pages/admin/Shipping/ShippingList.vue'),
                meta: {
                    permission: "view-shipping-methods"
                },
            },
            {
                path: "shipping-methods/:id/settings",
                name: "ShippingSettings",
                component: () => import("../pages/admin/Shipping/ShippingSettings.vue"),
                meta: { permission: "view-shipping-methods" }
            },

            // Geo Zones
            {
                path: "geo-zones",
                name: "GeoZones",
                component: () => import('@/pages/admin/Localisation/GeoZone/GeoZoneList.vue'),
                meta: { permission: "view-geo-zones" }
            },
            {
                path: "geo-zones/create",
                name: "CreateGeoZone",
                component: () => import('@/pages/admin/Localisation/GeoZone/CreateGeoZone.vue'),
                meta: { permission: "create-geo-zones" }
            },
            {
                path: "geo-zones/:id/edit",
                name: "UpdateGeoZone",
                component: () => import('@/pages/admin/Localisation/GeoZone/UpdateGeoZone.vue'),
                meta: { permission: "edit-geo-zones" }
            },
            {
                path: "payment-methods",
                name: "PaymentList",
                component: () => import('@/pages/admin/Payment/PaymentList.vue'),
                meta: {
                    permission: "view-payment-methods"
                },
            },
            {
                path: "payment-methods/:id/settings",
                name: "PaymentSettings",
                component: () => import('@/pages/admin/Payment/PaymentSettings.vue'),
                props: true,
                meta: {
                    permission: "edit-payment-methods"
                },
            },
            {
                path: "modules",
                name: "Modules",
                component: () => import('@/pages/admin/Module/ModuleList.vue'),
                meta: { permission: "view-modules" }
            },
            {
                path: "modules/:id/settings",
                name: "ModuleSettings",
                component: () => import('@/pages/admin/Module/ModuleSettings.vue'),
                meta: { permission: "edit-modules" }
            },
            {
                path: "manage-product-categories",
                name: "ProductCategories",
                component: () => import('@/pages/admin/Catalog/ProductCategory/ProductCategory.vue'),
                meta: {
                    permission: "view-product-categories"
                },
            },
            {
                path: "product-categories/:id",
                name: "ShowProductCategory",
                component: () => import('@/pages/admin/Catalog/ProductCategory/ShowProductCategory.vue'),
                props: true,
                meta: {
                    permission: "view-product-categories"
                },
            },
            {
                path: "edit-product-categories/:id",
                name: "UpdateProductCategory",
                component: () => import('@/pages/admin/Catalog/ProductCategory/UpdateProductCategory.vue'),
                props: true,
                meta: {
                    permission: "edit-product-categories"
                },
            },
            {
                path: "create-product-categories",
                name: "CreateProductCategory",
                component: () => import('@/pages/admin/Catalog/ProductCategory/CreateProductCategory.vue'),
                meta: {
                    permission: "create-product-categories"
                },
            },
            {
                path: "manage-attribute-groups",
                name: "AttributeGroups",
                component: () => import('@/pages/admin/Catalog/AttributeGroup/AttributeGroups.vue'),
                meta: {
                    permission: "view-attribute-groups"
                },
            },
            {
                path: "manage-options",
                name: "Options",
                component: () => import('@/pages/admin/Catalog/Option/Options.vue'),
                meta: {
                    permission: "view-options"
                },
            },
            {
                path: "manage-filter-options",
                name: "FilterOptions",
                component: () => import('@/pages/admin/Catalog/FilterOption/FilterOptions.vue'),
                meta: {
                    permission: "view-options"
                },
            },
            {
                path: "products",
                name: "Products",
                component: () => import('@/pages/admin/Catalog/Product/Products.vue'),
                meta: {
                    permission: "view-products"
                },
            },
            {
                path: "products/create",
                name: "CreateProduct",
                component: () => import('@/pages/admin/Catalog/Product/CreateProduct.vue'),
                meta: {
                    permission: "create-products"
                },
            },
            {
                path: "products/update/:id",
                name: "UpdateProduct",
                component: () => import('@/pages/admin/Catalog/Product/UpdateProduct.vue'),
                meta: {
                    permission: "edit-products"
                },
            },
            {
                path: "products/advanced",
                name: "AdvancedProducts",
                component: () => import('@/pages/admin/Catalog/Product/AdvancedProducts.vue'),
                meta: {
                    permission: "edit-products"
                },
            },
            {
                path: "email-campaigns",
                name: "EmailCampaigns",
                component: () => import('@/pages/admin/EmailSend/EmailCampaigns.vue'),
                meta: {
                    permission: "send-emails"
                },
            },
        ],
    },
    ],
},
{
    path: "/unauthorized",
    name: "Unauthorized",
    component: () => import('@/pages/Unauthorized.vue'),
},
{
    path: "/:pathMatch(.*)*",
    name: "NotFound",
    component: () => import('@/pages/NotFound.vue'),
},
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    const isHttpOnly = import.meta.env.VITE_IS_HTTPONLY === 'true';
    const token = localStorage.getItem("token");
    const isAuthenticated = localStorage.getItem("isAuthenticated") === 'true';
    const role = localStorage.getItem("role");

    authStore.token = token;
    authStore.role = role;

    // 1. Require authentication
    const hasAuth = isHttpOnly ? isAuthenticated : !!token;
    if (to.meta.requiresAuth && !hasAuth) {
        // redirect to role‑specific login, or fallback
        const loginRoute = to.meta.role ? `/${to.meta.role}/login` : "/login";
        return next(loginRoute);
    }

    // 2. Role mismatch
    if (to.meta.role && role !== to.meta.role) {
        const loginRoute = `/${to.meta.role}/login`;
        return next(loginRoute);
    }

    // 3. Hydrate role and permissions on load/reload if authenticated
    if (hasAuth && authStore.permissions.length === 0) {
        try {
            await authStore.fetchRoleAndPermissions();
        } catch (err) {
            authStore.resetAuth();
            const loginRoute = to.meta.role ? `/${to.meta.role}/login` : "/admin/login";
            return next(loginRoute);
        }
    }

    // 4. Permission check
    const requiredPermission = to.meta.permission;
    if (requiredPermission) {
        if (!authStore.hasPermission(requiredPermission)) {
            return next({
                name: "Unauthorized"
            });
        }
    }

    next();
});
export default router;
