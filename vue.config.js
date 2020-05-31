// 代码压缩
// gzip压缩
const CompressionWebpackPlugin = require("compression-webpack-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");
// 是否为生产环境
const isProduction = process.env.NODE_ENV !== "development";

// 本地环境是否需要使用cdn
const devNeedCdn = true;

// cdn链接
const cdn = {
    // cdn：模块名称和模块作用域命名（对应window里面挂载的变量名称）
    externals: {
        vue: "Vue",
        vuex: "Vuex",
        "vue-router": "VueRouter"
    },
    // cdn的css链接
    css: [],
    // cdn的js链接
    js: [
        "https://cdn.bootcdn.net/ajax/libs/vue/2.6.11/vue.min.js",
        "https://cdn.bootcdn.net/ajax/libs/vuex/3.2.0/vuex.min.js",
        "https://cdn.bootcdn.net/ajax/libs/vue-router/3.2.0/vue-router.min.js"
    ]
};

// path依赖
const path = require("path");

// 查找文件方法
const resolve = (dir) => {
    return path.join(__dirname, dir);
};

module.exports = {
    productionSourceMap: false,
    chainWebpack: (config) => {
        // ============压缩图片 start============
        // config.module
        //     .rule("images")
        //     .use("image-webpack-loader")
        //     .loader("image-webpack-loader")
        //     .options({ bypassOnDebug: true })
        //     .end();
        // ============压缩图片 end============

        // ============注入cdn start============
        config.plugin("html").tap((args) => {
            args[0].cdn = {};
            // cdn css 无论在本地还是生产，都会注入
            if (cdn.css.length) args[0].cdn.css = cdn.css;

            // 生产环境或本地需要cdn时，才注入cdn
            if (isProduction || devNeedCdn) args[0].cdn = cdn;
            return args;
        });
        // ============注入cdn start============

        // 别名配置
        config.resolve.alias
            .set("assets", resolve("src/assets"))
            .set("components", resolve("src/components"));
    },
    configureWebpack: (config) => {
        // 用cdn方式引入，则构建时要忽略相关资源
        if (isProduction || devNeedCdn) config.externals = cdn.externals;
        // 生产环境相关配置
        if (isProduction) {
            const productionGzipExtensions = ["html", "js", "css"];
            config.plugins = config.plugins.concat([
                new CopyWebpackPlugin({
                    patterns: [
                        {
                            from: __dirname + "/php",
                            to: __dirname + "/dist/grwz-vue/php"
                        }
                    ]
                }),
                new CompressionWebpackPlugin({
                    filename: "[path].gz[query]",
                    algorithm: "gzip",
                    test: new RegExp(
                        "\\.(" + productionGzipExtensions.join("|") + ")$"
                    ),
                    threshold: 10240, // 只有大小大于该值的资源会被处理 10240
                    minRatio: 0.8, // 只有压缩率小于这个值的资源才会被处理
                    deleteOriginalAssets: false // 删除原文件
                })
            ]);

            // gzip压缩

            // 公共代码抽离
            config.optimization = {
                splitChunks: {
                    cacheGroups: {
                        vendor: {
                            chunks: "all",
                            test: /node_modules/,
                            name: "vendor",
                            minChunks: 1,
                            maxInitialRequests: 5,
                            minSize: 0,
                            priority: 100
                        },
                        common: {
                            chunks: "all",
                            test: /[\\/]src[\\/]js[\\/]/,
                            name: "common",
                            minChunks: 2,
                            maxInitialRequests: 5,
                            minSize: 0,
                            priority: 60
                        },
                        styles: {
                            name: "styles",
                            test: /\.(sa|sc|c)ss$/,
                            chunks: "all",
                            enforce: true
                        },
                        runtimeChunk: {
                            name: "manifest"
                        }
                    }
                }
            };
        }
    },
    // SASS配置
    css: {
        loaderOptions: {
            sass: {
                // data: ''
            }
        }
    },
    publicPath: "/grwz-vue/",
    outputDir: "./dist/grwz-vue/", // 输出文件目录
    devServer: {
        open: true,
        host: "127.0.0.1",
        port: "37354",
        https: false,
        hot: true,
        hotOnly: false,
        //下面的proxy地址就是php文件的地址
        proxy: {
            "/grwz-vue": {
                target: "https://wz.loveli.top/",
                changeOrigin: true,
                ws: true,
                pathRewrite: {
                    // "^/api": ""
                }
            }
        }
    }
};
