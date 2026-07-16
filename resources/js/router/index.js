import AdminLayout from "@/layouts/AdminLayout.vue";
import AdminUserUpdate from "@/pages/admin/users/AdminUserUpdate.vue";
import AdminLogin from "@/pages/admin/auth/Login.vue";
import AdminDashboard from "@/pages/admin/auth/Profile.vue";
import Dashboard from "@/pages/admin/Dashboard.vue";
import RolePermission from "@/pages/admin/users/ManageUser.vue";
import CreatePage from "@/pages/admin/Pages/CreatePage.vue";
import Pages from "@/pages/admin/Pages/Pages.vue";
import ShowPage from "@/pages/admin/Pages/ShowPage.vue";
import UpdatePages from "@/pages/admin/Pages/UpdatePages.vue";
import CreatePost from "@/pages/admin/Post/CreatePost.vue";
import Post from "@/pages/admin/Post/Post.vue";
import ShowPost from "@/pages/admin/Post/ShowPost.vue";
import UpdatePost from "@/pages/admin/Post/UpdatePost.vue";
import RolePermissionManager from "@/pages/admin/users/RolePermissionManager.vue";
import GeneralSettings from "@/pages/admin/Settings/GeneralSettings.vue";

import NotFound from "@/pages/NotFound.vue";
import Unauthorized from "@/pages/Unauthorized.vue";
import {
    useAuthStore
} from "@/store/auth";
import {
    createRouter,
    createWebHistory
} from "vue-router";
import MenuManager from "../pages/admin/menu/MenuManager.vue";
import MenusIndex from "../pages/admin/menu/MenusIndex.vue";
import NewsCategoryEdit from "../pages/admin/News/NewsCategory/NewsCategoryEdit.vue";
import NewsCategory from "../pages/admin/News/NewsCategory/NewsCategory.vue";
import NewsCategoryCreate from "../pages/admin/News/NewsCategory/NewsCategoryCreate.vue";
import NewsCategoryShow from "../pages/admin/News/NewsCategory/NewsCategoryShow.vue";
import CategoryEdit from "../pages/admin/Post/Category/CategoryEdit.vue";
import CategoryCreate from "../pages/admin/Post/Category/CategoryCreate.vue";
import Category from "../pages/admin/Post/Category/Category.vue";
import CategoryShow from "../pages/admin/Post/Category/CategoryShow.vue";
import Gallery from "../pages/admin/Gallery/Gallery.vue";
import ShowGallery from "../pages/admin/Gallery/ShowGallery.vue";
import UpdateGallery from "../pages/admin/Gallery/UpdateGallery.vue";
import CreateGallery from "../pages/admin/Gallery/CreateGallery.vue";
import EventCategory from "../pages/admin/Event/EventsCategory/EventCategory.vue";
import EventCategoryCreate from "../pages/admin/Event/EventsCategory/EventCategoryCreate.vue";
import EventCategoryEdit from "../pages/admin/Event/EventsCategory/EventCategoryEdit.vue";
import EventCategoryShow from "../pages/admin/Event/EventsCategory/EventCategoryShow.vue";
import CreateEvent from "../pages/admin/Event/CreateEvent.vue";
import UpdateEvent from "../pages/admin/Event/UpdateEvent.vue";
import ShowEvent from "../pages/admin/Event/ShowEvent.vue";
import Event from "../pages/admin/Event/Event.vue";
import CreateNotice from "../pages/admin/Notice/CreateNotice.vue";
import UpdateNotice from "../pages/admin/Notice/UpdateNotice.vue";
import ShowNotice from "../pages/admin/Notice/ShowNotice.vue";
import Notice from "../pages/admin/Notice/Notice.vue";
import CreateNews from "../pages/admin/News/CreateNews.vue";
import UpdateNews from "../pages/admin/News/UpdateNews.vue";
import ShowNews from "../pages/admin/News/ShowNews.vue";
import News from "../pages/admin/News/News.vue";
import Result from "../pages/admin/Result/Result.vue";
import ShowResult from "../pages/admin/Result/ShowResult.vue";
import UpdateResult from "../pages/admin/Result/UpdateResult.vue";
import CreateResult from "../pages/admin/Result/CreateResult.vue";
import Blog from "../pages/admin/Blog/Blog.vue";
import ShowBlog from "../pages/admin/Blog/ShowBlog.vue";
import UpdateBlog from "../pages/admin/Blog/UpdateBlog.vue";
import CreateBlog from "../pages/admin/Blog/CreateBlog.vue";
import BlogCategory from "../pages/admin/Blog/BlogCategory/BlogCategory.vue";
import BlogCategoryCreate from "../pages/admin/Blog/BlogCategory/BlogCategoryCreate.vue";
import BlogCategoryEdit from "../pages/admin/Blog/BlogCategory/BlogCategoryEdit.vue";
import BlogCategoryShow from "../pages/admin/Blog/BlogCategory/BlogCategoryShow.vue";
import UpdateSection from "../pages/admin/Section/UpdateSection.vue";
import Section from "../pages/admin/Section/Section.vue";
import Sliders from "../pages/admin/Sliders/Sliders.vue";
import CreateSlider from "../pages/admin/Sliders/CreateSlider.vue";
import UpdateSlider from "../pages/admin/Sliders/UpdateSlider.vue";
import CommitteeMembers from "../pages/admin/CommitteeMember/CommitteeMembers.vue";
import UpdateCommitteeMembers from "../pages/admin/CommitteeMember/UpdateCommitteeMembers.vue";
import CreateCommitteeMembers from "../pages/admin/CommitteeMember/CreateCommitteeMembers.vue";
import CreatePlayer from "../pages/admin/Player/CreatePlayer.vue";
import UpdatePlayer from "../pages/admin/Player/UpdatePlayer.vue";
import ShowPlayer from "../pages/admin/Player/ShowPlayer.vue";
import Player from "../pages/admin/Player/Player.vue";
import Brand from "../pages/admin/Catalog/Brand/Brand.vue";
import CreateBrand from "../pages/admin/Catalog/Brand/CreateBrand.vue";
import UpdateBrand from "../pages/admin/Catalog/Brand/UpdateBrand.vue";
import ShowBrand from "../pages/admin/Catalog/Brand/ShowBrand.vue";
import ProductCategory from "../pages/admin/Catalog/ProductCategory/ProductCategory.vue";
import CreateProductCategory from "../pages/admin/Catalog/ProductCategory/CreateProductCategory.vue";
import UpdateProductCategory from "../pages/admin/Catalog/ProductCategory/UpdateProductCategory.vue";
import ShowProductCategory from "../pages/admin/Catalog/ProductCategory/ShowProductCategory.vue";

import AttributeGroups from "../pages/admin/Catalog/AttributeGroup/AttributeGroups.vue";
import Options from "../pages/admin/Catalog/Option/Options.vue";

const routes = [{
    path: "/admin",
    children: [{
        path: "login",
        name: "AdminLogin",
        component: AdminLogin
    },
    {
        path: "",
        prefix: "admin",
        component: AdminLayout,
        meta: {
            requiresAuth: true,
            role: "admin"
        },

        children: [

            {
                path: "",
                name: "Dashboard",
                component: Dashboard,
                meta: {
                    permission: "view-dashboard"
                },
            },

            {
                path: "admin-profile",
                name: "adminProfile",
                component: AdminDashboard,
                meta: {
                    permission: "view-dashboard"
                },
            },

            // Role & Permission Management
            {
                path: "manage-admins-roles",
                name: "RolePermission",
                component: RolePermission,
                meta: {
                    permission: "view-users"
                }, // viewing admins/roles
            },
            {
                path: "admins/:id/edit",
                name: "AdminUserUpdate",
                component: AdminUserUpdate,
                meta: {
                    permission: "update-users"
                },
            },
            {
                path: "manage-role-permissions",
                name: "RolePermissionManager",
                component: RolePermissionManager,
                meta: {
                    permission: "update-user-role"
                }, // updating role permissions
            },

            // Pages CRUD
            {
                path: "manage-pages",
                name: "Pages",
                component: Pages,
                meta: {
                    permission: "view-pages"
                },
            },
            {
                path: "pages/:id",
                name: "ShowPage",
                component: ShowPage,
                props: true,
                meta: {
                    permission: "view-pages"
                },
            },
            {
                path: "edit-pages/:id",
                name: "UpdatePages",
                component: UpdatePages,
                props: true,
                meta: {
                    permission: "edit-pages"
                },
            },
            {
                path: "create-page",
                name: "CreatePage",
                component: CreatePage,
                meta: {
                    permission: "create-pages"
                },
            },
            // Posts CRUD
            {
                path: "manage-posts",
                name: "Posts",
                component: Post,
                meta: {
                    permission: "view-posts"
                },
            },
            {
                path: "posts/:id",
                name: "ShowPost",
                component: ShowPost,
                props: true,
                meta: {
                    permission: "view-posts"
                },
            },
            {
                path: "edit-posts/:id",
                name: "UpdatePost",
                component: UpdatePost,
                props: true,
                meta: {
                    permission: "edit-posts"
                },
            },
            {
                path: "create-posts",
                name: "CreatePost",
                component: CreatePost,
                meta: {
                    permission: "create-posts"
                },
            },

            // Settings
            {
                path: "generale-settings",
                name: "GeneralSettings",
                component: GeneralSettings,
                meta: {
                    permission: "update-settings"
                },
            },

            {
                path: "categories",
                name: "CategoryIndex",
                component: Category,
                meta: {
                    permission: "view-categories",
                },
            },
            {
                path: "categories/create",
                name: "CategoryCreate",
                component: CategoryCreate,
                meta: {
                    permission: "create-categories",
                },
            },
            {
                path: "categories/:id/edit",
                name: "UpdateCategory",
                component: CategoryEdit,
                props: true,
                meta: {
                    permission: "edit-categories",
                },
            },
            {
                path: "admin/categories/:id",
                name: "CategoryShow",
                component: CategoryShow,
                props: true,
                meta: {
                    permission: "view-categories",
                },
            },
            // News CRUD
            {
                path: "manage-news",
                name: "News",
                component: News,
                meta: {
                    permission: "view-news"
                },
            },
            {
                path: "news/:id",
                name: "ShowNews",
                component: ShowNews,
                props: true,
                meta: {
                    permission: "view-news"
                },
            },
            {
                path: "edit-news/:id",
                name: "UpdateNews",
                component: UpdateNews,
                props: true,
                meta: {
                    permission: "edit-news"
                },
            },
            {
                path: "create-news",
                name: "CreateNews",
                component: CreateNews,
                meta: {
                    permission: "create-news"
                },
            },

            {
                path: "news-categories",
                name: "NewsCategoryIndex",
                component: NewsCategory,
                meta: {
                    permission: "view-news-categories",
                },
            },
            {
                path: "news-categories/create",
                name: "NewsCategoryCreate",
                component: NewsCategoryCreate,
                meta: {
                    permission: "create-news-categories",
                },
            },
            {
                path: "news-categories/edit/:id",
                name: "UpdateNewsCategory",
                component: NewsCategoryEdit,
                props: true,
                meta: {
                    permission: "edit-news-categories",
                },
            },
            {
                path: "admin/news-categories/:id",
                name: "NewsCategoryShow",
                component: NewsCategoryShow,
                props: true,
                meta: {
                    permission: "view-news-categories",
                },
            },
            // Blog CRUD
            {
                path: "manage-blogs",
                name: "Blog",
                component: Blog,
                meta: {
                    permission: "view-blog"
                },
            },
            {
                path: "blogs/:id",
                name: "ShowBlog",
                component: ShowBlog,
                props: true,
                meta: {
                    permission: "view-blog"
                },
            },
            {
                path: "edit-blogs/:id",
                name: "UpdateBlog",
                component: UpdateBlog,
                props: true,
                meta: {
                    permission: "edit-blog"
                },
            },
            {
                path: "create-blogs",
                name: "CreateBlog",
                component: CreateBlog,
                meta: {
                    permission: "create-blog"
                },
            },

            {
                path: "blog-categories",
                name: "BlogCategoryIndex",
                component: BlogCategory,
                meta: {
                    permission: "view-blog-categories",
                },
            },
            {
                path: "blog-categories/create",
                name: "BlogCategoryCreate",
                component: BlogCategoryCreate,
                meta: {
                    permission: "create-blog-categories",
                },
            },
            {
                path: "blog-categories/edit/:id",
                name: "UpdateBlogCategory",
                component: BlogCategoryEdit,
                props: true,
                meta: {
                    permission: "edit-blog-categories",
                },
            },
            {
                path: "admin/blog-categories/:id",
                name: "BlogCategoryShow",
                component: BlogCategoryShow,
                props: true,
                meta: {
                    permission: "view-blog-categories",
                },
            },
            // Menu manager
            {
                path: "menus",
                name: "MenuManager",
                component: MenusIndex,
                meta: {
                    permission: "manage-menus",
                },
            },
            {
                path: "menu/view/:id",
                name: "ShowMenu",
                component: MenuManager,
                meta: {
                    permission: "manage-menus",
                },
                props: true,
            },
            {
                path: "manage-galleries",
                name: "Gallery",
                component: Gallery,
                meta: {
                    permission: "view-galleries"
                },
            },
            {
                path: "galleries/:id",
                name: "ShowGallery",
                component: ShowGallery,
                props: true,
                meta: {
                    permission: "view-galleries"
                },
            },
            {
                path: "edit-galleries/:id",
                name: "UpdateGallery",
                component: UpdateGallery,
                props: true,
                meta: {
                    permission: "edit-galleries"
                },
            },
            {
                path: "create-gallery",
                name: "CreateGallery",
                component: CreateGallery,
                meta: {
                    permission: "create-galleries"
                },
            },
            {
                path: "manage-events",
                name: "Events",
                component: Event,
                meta: {
                    permission: "view-events"
                },
            },
            {
                path: "events/:id",
                name: "ShowEvent",
                component: ShowEvent,
                props: true,
                meta: {
                    permission: "view-events"
                },
            },
            {
                path: "edit-events/:id",
                name: "UpdateEvent",
                component: UpdateEvent,
                props: true,
                meta: {
                    permission: "edit-events"
                },
            },
            {
                path: "create-events",
                name: "CreateEvent",
                component: CreateEvent,
                meta: {
                    permission: "create-events"
                },
            },
            {
                path: "event-categories",
                name: "EventCategoryIndex",
                component: EventCategory,
                meta: {
                    permission: "view-events-categories",
                },
            },
            {
                path: "event-categories/create",
                name: "EventCategoryCreate",
                component: EventCategoryCreate,
                meta: {
                    permission: "create-events-categories",
                },
            },
            {
                path: "event-categories/edit/:id",
                name: "UpdateEventCategory",
                component: EventCategoryEdit,
                props: true,
                meta: {
                    permission: "edit-events-categories",
                },
            },
            {
                path: "event-categories/:id",
                name: "EventCategoryShow",
                component: EventCategoryShow,
                props: true,
                meta: {
                    permission: "view-events-categories",
                },
            },
            {
                path: "manage-notices",
                name: "Notices",
                component: Notice,
                meta: {
                    permission: "view-notices"
                },
            },
            {
                path: "notices/:id",
                name: "ShowNotice",
                component: ShowNotice,
                props: true,
                meta: {
                    permission: "view-notices"
                },
            },
            {
                path: "edit-notices/:id",
                name: "UpdateNotice",
                component: UpdateNotice,
                props: true,
                meta: {
                    permission: "edit-notices"
                },
            },
            {
                path: "create-notices",
                name: "CreateNotice",
                component: CreateNotice,
                meta: {
                    permission: "create-notices"
                },
            },
            {
                path: "manage-players",
                name: "Players",
                component: Player,
                meta: {
                    permission: "view-players"
                },
            },
            {
                path: "players/:id",
                name: "ShowPlayer",
                component: ShowPlayer,
                props: true,
                meta: {
                    permission: "view-players"
                },
            },
            {
                path: "edit-players/:id",
                name: "UpdatePlayer",
                component: UpdatePlayer,
                props: true,
                meta: {
                    permission: "edit-players"
                },
            },
            {
                path: "create-players",
                name: "CreatePlayer",
                component: CreatePlayer,
                meta: {
                    permission: "create-players"
                },
            },
            {
                path: "manage-results",
                name: "Results",
                component: Result,
                meta: {
                    permission: "view-results"
                },
            },
            {
                path: "results/:id",
                name: "ShowResult",
                component: ShowResult,
                props: true,
                meta: {
                    permission: "view-results"
                },
            },
            {
                path: "edit-results/:id",
                name: "UpdateResult",
                component: UpdateResult,
                props: true,
                meta: {
                    permission: "edit-results"
                },
            },
            {
                path: "create-results",
                name: "CreateResult",
                component: CreateResult,
                meta: {
                    permission: "create-results"
                },
            },
            {
                path: "manage-sections",
                name: "Section",
                component: Section,
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "edit-sections/:id",
                name: "UpdateSection",
                component: UpdateSection,
                props: true,
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "banner-sliders",
                name: "Sliders",
                component: Sliders,
                props: true,
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "edit-sliders/:id",
                name: "UpdateSlider",
                component: UpdateSlider,
                props: true,
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "create-sliders",
                name: "CreateSlider",
                component: CreateSlider,
                meta: {
                    permission: "manage-frontend"
                },
            },
            {
                path: "manage-committee-members",
                name: "CommitteeMembers",
                component: CommitteeMembers,
                props: true,
                meta: {
                    permission: "manage-committee-members"
                },
            },
            {
                path: "edit-committee-members/:id",
                name: "UpdateCommitteeMembers",
                component: UpdateCommitteeMembers,
                props: true,
                meta: {
                    permission: "manage-committee-members"
                },
            },
            {
                path: "create-committee-members",
                name: "CreateCommitteeMembers",
                component: CreateCommitteeMembers,
                meta: {
                    permission: "manage-committee-members"
                },
            },
            {
                path: "manage-brands",
                name: "Brands",
                component: Brand,
                meta: {
                    permission: "view-brands"
                },
            },
            {
                path: "brands/:id",
                name: "ShowBrand",
                component: ShowBrand,
                props: true,
                meta: {
                    permission: "view-brands"
                },
            },
            {
                path: "edit-brands/:id",
                name: "UpdateBrand",
                component: UpdateBrand,
                props: true,
                meta: {
                    permission: "edit-brands"
                },
            },
            {
                path: "create-brands",
                name: "CreateBrand",
                component: CreateBrand,
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
                path: "manage-product-categories",
                name: "ProductCategories",
                component: ProductCategory,
                meta: {
                    permission: "view-product-categories"
                },
            },
            {
                path: "product-categories/:id",
                name: "ShowProductCategory",
                component: ShowProductCategory,
                props: true,
                meta: {
                    permission: "view-product-categories"
                },
            },
            {
                path: "edit-product-categories/:id",
                name: "UpdateProductCategory",
                component: UpdateProductCategory,
                props: true,
                meta: {
                    permission: "edit-product-categories"
                },
            },
            {
                path: "create-product-categories",
                name: "CreateProductCategory",
                component: CreateProductCategory,
                meta: {
                    permission: "create-product-categories"
                },
            },
            {
                path: "manage-attribute-groups",
                name: "AttributeGroups",
                component: AttributeGroups,
                meta: {
                    permission: "view-attribute-groups"
                },
            },
            {
                path: "manage-options",
                name: "Options",
                component: Options,
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
        ],
    },
    ],
},
{
    path: "/unauthorized",
    name: "Unauthorized",
    component: Unauthorized,
},
{
    path: "/:pathMatch(.*)*",
    name: "NotFound",
    component: NotFound,
},
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore();

    const token = localStorage.getItem("token");
    const role = localStorage.getItem("role");

    authStore.token = token;
    authStore.role = role;

    // 1. Require authentication
    if (to.meta.requiresAuth && !token) {
        // redirect to role‑specific login, or fallback
        const loginRoute = to.meta.role ? `/${to.meta.role}/login` : "/login";
        return next(loginRoute);
    }

    // 2. Role mismatch
    if (to.meta.role && role !== to.meta.role) {
        const loginRoute = `/${to.meta.role}/login`;
        return next(loginRoute);
    }

    // 3. Permission check
    const requiredPermission = to.meta.permission;
    if (requiredPermission) {
        try {
            await authStore.fetchRoleAndPermissions();
        } catch (err) {
            const loginRoute = role ? `/${role}/login` : "/login";
            return next(loginRoute);
        }
    }

    if (requiredPermission && !authStore.hasPermission(requiredPermission)) {
        return next({
            name: "Unauthorized"
        });
    }
    next();
});
export default router;
