<template>
    <div id="app">
        <nav>
            <b-nav tabs justified>
                <b-nav-item
                    @click="goIntroduction()"
                    :class="{ actived: pathObj.activeArr[0] }"
                >
                    基本信息
                </b-nav-item>

                <b-nav-item
                    @click="goMessages()"
                    :class="{ actived: pathObj.activeArr[1] }"
                >
                    留言板
                </b-nav-item>
            </b-nav>
        </nav>

        <transition :name="transitionName">
            <keep-alive>
                <router-view></router-view>
            </keep-alive>
        </transition>

        <footer id="mainApp">
            <address v-html="footer"></address>
        </footer>
    </div>
</template>

<script>
import store from "./store";

export default {
    metaInfo: {
        title: "44",
        meta: []
    },
    data() {
        return {
            footer: `加油进步的程序员`
            // classObject: { "active-class": (console.log(this), "d") }
        };
    },
    created() {
        // console.log(this.$route, this.$router);
        if (this.$route.name === "root") {
            this.pathObj.activeArr[0] = true;
            return;
        }
        for (let i = this.pathObj.arr.length - 2; i > -1; i--) {
            if (this.$route.name === this.pathObj.arr[i]) {
                this.pathObj.activeArr[i] = true;

                break;
            }
        }
        // console.log(this.pathObj.activeArr);
        //this.pathObj.flag = this.pathObj.arr.indexOf(this.$route.path) === "-1" ? false : true;
    },
    mounted() {},
    methods: {
        // addActive() {},
        goBack() {
            // 点击后退
            this.$router.go(-1);
        },
        goIntroduction() {
            this.pathObj.activeArr = [false, false, false, false];
            this.pathObj.activeArr[0] = true;
            this.$router.push({ path: "/introduction" });
        },
        goMessages() {
            this.pathObj.activeArr = [false, false, false, false];
            this.pathObj.activeArr[1] = true;
            this.$router.push({ path: "/messages" });
        },
        goLogin() {
            this.pathObj.activeArr = [false, false, false, false];
            this.pathObj.activeArr[2] = true;
            this.$router.push({ path: "/home/first" });
        }
    },
    computed: {
        transitionName() {
            return store.getters.transitionName.transitionName;
        },
        pathObj() {
            return store.getters.pathObj;
        }
    },
    watch: {
        "$route.path": function(newVal) {
            this.pathObj.flag = this.pathObj.pathArr.indexOf(newVal) >= 5;
        }
    }
};
</script>

<style lang="scss">
@media only screen and (min-width: 280px) {
    html {
        font-size: 125% !important;
    }
}

@media only screen and (min-width: 750px) {
    html {
        font-size: 150% !important;
    }
}

@media only screen and (min-width: 1242px) {
    html {
        font-size: 187.5% !important;
    }
}

.nav-item {
    transition: all 0.5s ease;
    background-color: floralwhite;
}

.nav-tabs .nav-link {
    display: block;
    padding-left: 0;
    padding-right: 0;
    text-align: center; // height: 100%;
    a {
        text-decoration: none;
    }

    .active:hover {
        color: #fff;
    }
}

.nav-item.actived {
    color: #ffffff;
    background-color: rgb(204, 232, 207);

    border-radius: 5px;

    display: block;
}

nav {
    top: 0;
    position: sticky;
    background-color: #fff;
    z-index: 1;
}

footer#mainApp {
    font-size: 0.8rem;
    text-align: center;
    border-top: 10px groove skyblue;
    // flex:none;
}

html,
body {
    margin: 0;
    padding: 0;
    height: 100%;
    width: 100%;
    overflow-x: hidden;
}

#app {
    min-height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    touch-action: auto;
}

.transitionRight-enter {
    opacity: 0;
    top: 2.5rem;
    transform: translateX(100%);
    position: absolute;
}

.transitionRight-leave-to {
    opacity: 0;
    top: 2.5rem;
    transform: translateX(-100%);
    position: absolute;
}

.transitionRight-enter-active,
.transitionRight-leave-active,
.transitionLeft-enter-active,
.transitionLeft-leave-active {
    top: 2.5rem;
    transition: all 0.5s ease;
    width: 100%;
    position: absolute;
}

.transitionLeft-enter {
    opacity: 0;
    top: 2.5rem;
    position: absolute;
    transform: translateX(-100%);
}

.transitionLeft-leave-to {
    top: 2.5rem;
    opacity: 0;
    transform: translateX(100%);
    position: absolute;
}
</style>
