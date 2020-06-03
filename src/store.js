import Vue from "vue";
import Vuex from "vuex";

if (!window.Vuex) Vue.use(Vuex);
export default new Vuex.Store({
    state: {
        transitionName: "slide-right"
    },
    getters: {
        transitionName: (state) => state.transitionName
    },
    mutations: {
        setTransitionName(state, transitionName) {
            state.transitionName = transitionName;
        }
    },
    actions: {
        setTransitionName(context, obj) {
            context.commit("setTransitionName", obj.transitionName);
        }
    }
});
