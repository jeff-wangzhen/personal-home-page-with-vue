import Vue from "vue";
import Router from "vue-router";
import store from "./store";

import introduction from "./views/introduction.vue";
const messages = () => import("./views/messages.vue");
const NotFound = () => import("./views/NotFound.vue");

if (!window.VueRouter) Vue.use(Router);
let routes = [
    {
        path: "/",
        name: "root",
        redirect: "/introduction",
        meta: { keepAlive: true }
    },
    {
        path: "/introduction",
        name: "introduction",
        component: introduction,
        meta: { keepAlive: true }
    },

    {
        path: "/messages",
        name: "messages",
        component: messages,
        meta: { keepAlive: true }
    },
    {
        path: "*",
        name: "404",
        component: NotFound,
        meta: { keepAlive: true }
    }
];
function scrollBehavior(to, from, savedPosition) {
    console.log(923423423, savedPosition);
    if (savedPosition) {
        return savedPosition;
    } else {
        if (from.meta.keepAlive) {
            from.meta.savedPosition = Math.floor(
                document.body.scrollTop ||
                    document.documentElement.scrollTop ||
                    window.pageXOffset
            );
        }
        console.log(333, from.meta, to.meta);
        return { x: 0, y: to.meta.savedPosition || 0 };
    }
}
console.log(scrollBehavior);
var router = new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes,
    linkActiveClass: "actived",
    scrollBehavior
});
router.beforeEach(function(to, from, next) {
    // document.getElementsByTagName("body")[0].style.overflowX = "hidden";
    // console.log(
    //     4444444444,
    //     to,
    //     document.getElementsByTagName("body")[0].style.overflowX
    // );
    var top = Math.floor(
        document.body.scrollTop ||
            document.documentElement.scrollTop ||
            window.pageXOffset
    );
    console.log(top, store);
    let routesPath = routes.map((item) => item.path);
    let toTndex = routesPath.indexOf(to.path);
    let fromTndex = routesPath.indexOf(from.path);

    const compare = toTndex > fromTndex;

    store.dispatch("setTransitionName", {
        transitionName: compare ? "slide-left" : "slide-right"
    });

    next();
});
export default router;
