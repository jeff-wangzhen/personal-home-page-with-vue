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

        <footer id="mainApp">
            <address v-html="footer"></address>
        </footer>
    </div>
</template>

<script>
export default {
    data() {
        return {
            footer: `加油进步的程序员`
            // classObject: { "active-class": (console.log(this), "d") }
        };
    },
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

nav {
    display: flex;
    top: 0;
    position: sticky;
    background-color: #fff;
    z-index: 1;
    .nav-item {
        padding: 0.5rem 1rem;
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

            display: block;
        }
    }
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
}

#app {
    min-height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.router {
    width: 100%;
    overflow-x: hidden;
    transition: all 0.5s ease;
}
.slide-left-enter,
.slide-right-leave-active {
    opacity: 0;
    transform: translateX(100%);
}

.slide-left-leave-active,
.slide-right-enter {
    opacity: 0;
    transform: translateX(-100%);
}
</style>
