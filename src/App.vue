<template>
    <div id="app">
        <nav>
            <router-link to="/introduction" class="nav-item">
                基本信息
            </router-link>

            <router-link to="/messages" class="nav-item">
                留言板
            </router-link>
        </nav>

        <transition :name="$store.getters.transitionName">
            <keep-alive>
                <router-view class="router"></router-view>
            </keep-alive>
        </transition>
    </div>
</template>

<script>
export default {
    created() {
        console.log(this.$route, this.$router);
    },
    mounted() {},
    methods: {
        // addActive() {},
        goBack() {
            // 点击后退
            this.$router.go(-1);
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

html,
body {
    margin: 0;
    padding: 0;
    height: 100%;
}

#app {
    position: relative;

    margin: auto;
    max-width: 750px;
    height: 100%;
    overflow-x: hidden;
    max-height: 100%;
}

nav {
    display: flex;
    top: 0;
    left: 0;
    height: 2.5rem;
    width: 100%;
    line-height: 2.5rem;
    position: fixed;
    background-color: #fff;
    z-index: 1;
    .nav-item {
        flex-basis: 0;
        -ms-flex-positive: 1;
        flex-grow: 1;
        text-align: center;
        display: block;
        transition: all 0.5s ease;
        background-color: floralwhite;
        width: 50%;
        &.actived {
            color: #ffffff;
            background-color: rgb(204, 232, 207);

            border-radius: 5px;
        }
    }
}
footer#mainApp {
    font-size: 0.8rem;
    text-align: center;
    border-top: 10px groove skyblue;
    // flex:none;
}
.router {
    // position: absolute;
    // top: 0;
    width: 100%;
    // transition: all 0.3s ease;
    padding-top: 2.5rem;
    // width: 100%;
    overflow-x: hidden;
    // transition: all 21s ease;
}
.slide-right-enter-active,
.slide-right-leave-active,
.slide-left-enter-active,
.slide-left-leave-active {
    will-change: transform;
    transition: all 0.5s linear;
    height: 100%;
    top: 0px;
    position: absolute;
    backface-visibility: hidden;
    perspective: 1000;
}
.slide-left-enter {
    transform: translate3d(100%, 0, 0);
}
.slide-left-leave-active {
    transform: translate3d(-100%, 0, 0);
}
.slide-right-enter {
    transform: translate3d(-100%, 0, 0);
}
.slide-right-leave-active {
    transform: translate3d(100%, 0, 0);
}
</style>
