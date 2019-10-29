import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        transitionObj: { transitionName: "transitionLeft" },
        pathObj: {
            transitionName: "transitionLeft",
            arr: ["introduction", "messages", ""],
            pathArr: ["/", "/introduction", "/messages", ""],
            titleArr: ["王振的个人主页", "王振的个人主页", "留言板"],
            activeArr: [false, false, false, false],
        },
    }, getters: {
        transitionName: state => state.transitionObj,
        pathObj: state => state.pathObj,
    },
    mutations: {
        setTransitionObj(state, obj) {
            state.transitionObj = Object.assign({}, state.transitionObj, obj);
        },
        setPathObj(state, obj) {
            state.pathObj = Object.assign({}, state.pathObj, obj);
        },
    },
    actions: {
        setTransitionObj(context, obj) {
            context.commit("setTransitionObj", obj);
        },
        setPathObj(context, obj) {
            context.commit("setPathObj", obj);
        },
    },
});