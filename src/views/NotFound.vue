<template>
    <div>
        <p>
            不好意思~这个页面没有哦
            <br />
            想看到什么？欢迎告诉我~
        </p>
    </div>
</template>

<script>
// @ is an alias to /src

export default {
    name: "NotFound",
    metaInfo: {
        title: "页面不存在",
        meta: []
    },
    components: {}
};
</script>
<style lang="scss" scoped>
div {
    height: 100%;
}
p {
    margin: 0 auto; /*水平居中*/

    text-align: center;
}
</style>
