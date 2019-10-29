module.exports = {
    // build结果到的相对于服务器根目录地址，
    // 因为是本地打包，dev项目是/grwz-vue/，
    // 结果会输出到/grwz-vue/dist/中
    // 所以最终访问http://127.0.0.1/grwz-vue/dist/
    publicPath: "/grwz-vue/dist/",
    outputDir: "dist",    // 输出文件目录
    devServer: {
        open: true,
        host: "127.0.0.1",
        port: "37354",
        https: false,
        hotOnly: false,
        //下面的proxy地址就是php文件的地址
        proxy: {
            "/grwz-vue": {
                target: "https://127.0.0.1/",
                changeOrigin: true,
                ws: true,
                pathRewrite: {
                    // "^/api": ""
                }
            }
        }
    }
};
