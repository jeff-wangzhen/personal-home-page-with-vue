import Vue from "vue";
import Router from "vue-router";
import store from "./store";

import introduction from "./views/introduction.vue";
const messages = () => import("./views/messages.vue");
const NotFound = () => import("./views/NotFound.vue");

if (!window.VueRouter) Vue.use(Router);
Router.prototype.goBack = function() {
    this.isBack = true;
    window.history.go(-1);
};
var router = new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes: [
        {
            path: "/introduction",
            name: "introduction",

            redirect: "/"
        },

        {
            path: "/",
            name: "root",

            component: introduction
        },
        {
            path: "/messages",
            name: "messages",

            component: messages
        },
        {
            path: "*",
            name: "404",

            component: NotFound
        }
    ],
    linkActiveClass: "actived",
    "eslint-disable": true
});
router.beforeEach(function(to, from, next) {
    var pathObj = store.getters.pathObj;
    let toTndex = pathObj.pathArr.indexOf(to.path);
    let fromTndex = pathObj.pathArr.indexOf(from.path);
    if (toTndex === -1) {
        pathObj.pathArr.push(to.path);
        toTndex = pathObj.pathArr.length - 1;
    } else if (fromTndex === pathObj.pathArr.length - 1) {
        pathObj.pathArr.pop(fromTndex);
    } else {
        // document.title = pathObj.titleArr[toTndex];
    }
    const compare = toTndex > fromTndex;

    store.dispatch("setTransitionObj", {
        transitionName: compare ? "transitionRight" : "transitionLeft"
    });

    next();
});
export default router;
