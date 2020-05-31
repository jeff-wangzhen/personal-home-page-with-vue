const plugins = [];
// console.log(333333333, process);
// 判断当前环境，正是环境和测试环境移除console.log
if (
    process.env.NODE_ENV === "production" ||
    process.env.NODE_ENV === "staging"
) {
    plugins.push("transform-remove-console");
}

module.exports = {
    "presets": ["@vue/app"],
    plugins: plugins
};
