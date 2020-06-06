<template>
    <div ref="mescroll" class="mescroll">
        <div>
            <div>
                <div id="leavemessage">既已到此，何不留言</div>
                <div class="quill-wrap">
                    <quill-editor
                        v-model="content"
                        ref="myQuillEditor"
                        :options="editorOption"
                    ></quill-editor>
                </div>
                <div id="flex" ref="submitLine">
                    <b-input-group>
                        <b-form-select
                            v-model="contactType"
                            :options="options"
                            slot="prepend"
                        ></b-form-select>
                        <b-form-input v-model="contactMethod"></b-form-input>
                    </b-input-group>

                    <b-button
                        variant="primary"
                        @click="submit"
                        :disabled="disabled"
                    >
                        {{ submitButton }}
                    </b-button>
                </div>

                <div id="messages-box-big">
                    <li
                        class="messages-box"
                        v-for="item in messages"
                        :key="item.id"
                    >
                        <div
                            class="messageContent"
                            v-html="item.messageContent"
                        ></div>
                        <footer class="message-footer">
                            <address>
                                <span>
                                    {{ item.province }}
                                    {{ item.city }} </span
                                >&emsp;
                                <span class="message-contactType">
                                    {{ item.contactType }}
                                    {{ item.contactMethod }}
                                </span>
                            </address>

                            <time class="message-time">
                                {{ item.microtime | formatTime }}
                            </time>
                        </footer>
                    </li>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MeScroll from "mescroll.js";
import "mescroll.js/mescroll.min.css";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import BackToTop from "../components/backToTop";
import { ImageDrop } from "quill-image-drop-module";
import { quillEditor, Quill } from "vue-quill-editor";
import { container, ImageExtend, QuillWatch } from "quill-image-extend-module";
// var Delta = Quill.import("delta");
Quill.register("modules/ImageExtend", ImageExtend);
//convert img links to actual images

Quill.register("modules/imageDrop", ImageDrop);

export default {
    components: { BackToTop, quillEditor, MeScroll },
    filters: {
        formatTime: function(value) {
            function addZero(val) {
                if (val < 10) {
                    return "0" + val;
                } else {
                    return val;
                }
            }
            var dataTime = "";
            var data = new Date();
            data.setTime(value);
            var year = data.getFullYear();
            var month = addZero(data.getMonth() + 1);
            var day = addZero(data.getDate());
            var hour = addZero(data.getHours());
            var minute = addZero(data.getMinutes());
            var second = addZero(data.getSeconds());

            dataTime =
                year +
                "-" +
                month +
                "-" +
                day +
                " " +
                hour +
                ":" +
                minute +
                ":" +
                second;

            return dataTime; //将格式化后的字符串输出到前端显示
        }
    },
    data() {
        return {
            myBackToTopStyle: {
                "right": "10px",
                "bottom": "10px",
                "width": "40px",
                "height": "40px",
                "border-radius": "20px",
                "line-height": "40px",
                "background-image":
                    "url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADcAAAA3CAMAAACfBSJ0AAAAA3NCSVQICAjb4U/gAAAAS1BMVEX///+kpKSJiYmkpKSJiYmkpKSJiYmkpKSJiYmkpKSJiYmkpKSJiYmkpKSJiYmkpKSJiYmkpKSkpKSJiYmkpKSkpKSJiYmkpKSJiYmh9zwTAAAAGXRSTlMAEREiIjMzRERVVWZmd3eIiJmqqrvMzN3dvHZN/QAAAAlwSFlzAAALEgAACxIB0t1+/AAAABx0RVh0U29mdHdhcmUAQWRvYmUgRmlyZXdvcmtzIENTNXG14zYAAAIlSURBVEiJjZbbloMgDEVrKbWUOlSEyv9/6RgCKiGo56GrCziGHW653RhJPdoZ5ayW3JBavfFzKW/6U5dyMyenu0subwcNGmwO7lTTJRKU1WLfqnOz4G0KP23qbmFwEmzIIfaN/EeTc6h7Yodr51xGdMPaxqOkdSNjHLiPfbhvF1NV0KKpLVBjHLZLjvBMtGcI4clE9FvmYIFGMuT+W3y/O2kFRrsP72hKpgCaSGvntpl2MEu6AJ+AoogSZooxdAMO9WIQMYMQmuySCIf6PcouAVDwp2fCTWETRTSJcKzD/YW9/uqAkPx9ZlGvUIogwqphgsqd8vgRH0GEPPbxt5zmFKhKRBEjLVH9ARyH6IHMETwKxyBaWAlyNCo4BhEO3Y2kpYZLiLsdrmvft2EL4XvkezdtIbzbvgYcRaS+ewuOIGZf3tVtuBIRdjYshj2HKxCjZYy79AyuQIwHQudL4vFM+lTjP7kr+nB/yuraf1a+8jpMkXw695d9Dk+CobfZiU+mFZD00j3xrXEcCXjsW++zeF3byz67XdiuPBOPiWp3+Pp5S6MsX5kjieJNiK/MYYGS1JUvV8e9f5zM9qpgePbNZ23lWqvTsiAXBqSGUUcVEc7JMrZk9LQ22KQ9a8tlluUrH4k1GltoCSwGbd2p0OUaGB2WaEudqrYRQuU6dminLVeSUIDapfy0a/nZAlhBxpnTiSvG1Jaa9LXNe+v6paD3abY9i/UPr3Np1ijS2w8AAAAASUVORK5CYII=')",
                "background-size": "contain"
            },
            loading: false,
            firstId: Number.MAX_SAFE_INTEGER,
            lastId: Number.MAX_SAFE_INTEGER,
            allLoaded: false,
            messages: [],
            submitButton: "提交",
            disabled: false,
            contactType: "undefinedContactMethod",
            contactMethod: "",
            content: "",
            editorOption: {
                debug: "false",

                placeholder: "Compose an epic...",
                readOnly: true,
                theme: "snow",
                modules: {
                    imageDrop: true,
                    ImageExtend: {
                        loading: true,
                        name: "myfile",
                        size: 1,
                        sizeError: () => {
                            this.$Toast({
                                message: `文件大小不能超过2M`,
                                iconClass: "icon icon-error"
                            });
                        },
                        action: "/grwz-vue/php/fileupload.php",
                        response: (res) => {
                            return res.path;
                        },
                        error: () => {
                            this.$Toast({
                                message: `上传失败，请稍后重试`,
                                iconClass: "icon icon-error"
                            });
                        }
                    },
                    toolbar: {
                        container: container,
                        handlers: {
                            "image": function() {
                                QuillWatch.emit(this.quill.id);
                            }
                        }
                    }
                }
            },
            selected: "undefinedContactMethod",
            options: [
                {
                    value: "undefinedContactMethod",
                    text: "联系方式",
                    reg: /.*/
                },
                {
                    value: "email",
                    text: "电子邮箱",
                    reg:
                        "^[A-Za-z0-9\\u4e00-\\u9fa5]+@[a-zA-Z0-9_-]+(.[a-zA-Z0-9_-]+)+$"
                },
                { value: "QQ", text: "QQ", reg: "^[1-9][0-9]{4,}$" },
                {
                    value: "wechat",
                    text: "微信",
                    reg: "^[a-zA-Z][a-zA-Z0-9_-]{5,19}$"
                },
                {
                    value: "phone",
                    text: "手机",
                    reg: "^\\d{11}$"
                }
            ],
            fullscreenLoading: false,
            mescroll: null,
            newArr: [] // 数据列表
        };
    },
    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill;
        }
    },
    watch: {
        loading(val) {
            console.log("loading = ", val);
        }
    },
    mounted() {
        // this.pageResize();
        // window.onresize = () => {
        //     //调用methods中的事件
        //     this.throttle(this.pageResize());
        // };
        // let that = this;
        // this.$data.loading = true;
        // that.downCallback();
        this.mescroll = new MeScroll(this.$refs.mescroll, {
            // 在mounted生命周期初始化mescroll,以确保您配置的dom元素能够被找到.
            down: {
                auto: true, // 是否在初始化完毕之后自动执行下拉回调callback; 默认true
                callback: this.downCallback // 下拉刷新的回调
            },
            up: {
                auto: false, // 是否在初始化时以上拉加载的方式自动加载第一页数据; 默认false
                callback: this.upCallback, // 上拉回调,此处可简写; 相当于 callback: function (page) { upCallback(page); }
                page: {
                    num: 0, // 当前页码,默认0,回调之前会加1,即callback(page)会从1开始
                    size: 10 // 每页数据的数量
                },
                noMoreSize: 5, // 如果列表已无数据,可设置列表的总数量要大于等于5条才显示无更多数据;避免列表数据过少(比如只有一条数据),显示无更多数据会不好看
                toTop: {
                    offset: 500,
                    // 配置回到顶部按钮
                    src: require("../assets/mescroll/mescroll-totop.png")
                    // src: "../assets/images/me.png"
                }
            }
        });
    },
    beforeRouteEnter(to, from, next) {
        // 如果没有配置回到顶部按钮或isBounce,则beforeRouteEnter不用写
        next((vm) => {
            if (vm.mescroll) {
                // 恢复到之前设置的isBounce状态
                if (vm.mescroll.lastBounce != null)
                    vm.mescroll.setBounce(vm.mescroll.lastBounce);
                // 滚动到之前列表的位置(注意:路由使用keep-alive才生效)
                if (vm.mescroll.lastScrollTop) {
                    vm.mescroll.setScrollTop(vm.mescroll.lastScrollTop);
                    setTimeout(() => {
                        // 需延时,因为setScrollTop内部会触发onScroll,可能会渐显回到顶部按钮
                        vm.mescroll.setTopBtnFadeDuration(0); // 设置回到顶部按钮显示时无渐显动画
                    }, 16);
                }
            }
        });
    },
    beforeRouteLeave(to, from, next) {
        // 如果没有配置回到顶部按钮或isBounce,则beforeRouteLeave不用写
        if (this.mescroll) {
            this.mescroll.lastBounce = this.mescroll.optUp.isBounce; // 记录当前是否禁止ios回弹
            this.mescroll.setBounce(true); // 允许bounce
            this.mescroll.lastScrollTop = this.mescroll.getScrollTop(); // 记录当前滚动条的位置
            this.mescroll.hideTopBtn(0); // 隐藏回到顶部按钮,无渐隐动画
        }
        next();
    },
    methods: {
        throttle(func, wait = 300, type = 1) {
            if (type === 1) {
                var previous = 0;
            } else if (type === 2) {
                var timeout;
            }
            return function() {
                let context = this;
                let args = arguments;
                if (type === 1) {
                    let now = Date.now();

                    if (now - previous > wait) {
                        func.apply(context, args);
                        previous = now;
                    }
                } else if (type === 2) {
                    if (!timeout) {
                        timeout = setTimeout(() => {
                            timeout = null;
                            func.apply(context, args);
                        }, wait);
                    }
                }
            };
        },
        pageResize() {
            this.$refs.mescroll.style.top =
                this.$refs.submitLine.offsetTop +
                this.$refs.submitLine.clientHeight +
                // 60 +
                "px";
            console.log(
                "mounted",
                this.$refs.mescroll,
                this.$refs.mescroll.style,
                this.$refs.mescroll.style.top,
                "r",
                this.$refs.submitLine.offsetTop,
                "r",
                this.$refs.submitLine.clientHeight,
                "g"
            );
        },
        getMessages(start, length, lastest = false) {
            var that = this;
            console.log("start", start);
            return new Promise((resolve, reject) => {
                this.$axios
                    .get("/php/getMessages.php", {
                        params: {
                            start,
                            length,
                            lastest:
                                lastest === undefined
                                    ? start === Number.MAX_SAFE_INTEGER - 10
                                    : lastest
                        }
                    })
                    .then(function(response) {
                        //console.log(
                        //     start,
                        //     length,
                        //     lastest,
                        //     response,
                        //     that.$data
                        // );
                        if (!response.data.messages) return;
                        let length = response.data.messages.length;
                        if (length > 0) {
                            console.log("end a5xios", that.loading, "tt");
                            if (lastest)
                                that.$data.lastId = Math.max(
                                    that.$data.lastId,
                                    response.data.messages[0].id
                                );
                            that.$data.firstId = Math.min(
                                that.$data.firstId,
                                parseInt(response.data.messages[length - 1].id)
                            );
                            if (response.data.allLoaded === true)
                                that.$data.allLoaded = true;

                            return resolve(
                                that.maskMessages(response.data.messages)
                            );
                        }

                        //console.log("resolving");
                    })
                    .catch(function(error) {
                        return reject(error);
                    });
            });
        },
        maskMessages(messages) {
            var that = this;
            var options = that.$data.options;
            for (var i = messages.length - 1; i > -1; i--) {
                if (!messages[i].id) {
                    messages[i].id = "temp" + Math.random(0, 100);
                }

                // messages.contactMethod=messages[messages.]
                for (var j = options.length - 1; j > 0; j--) {
                    if (messages[i].contactType === options[j].value) {
                        messages[i].contactType = options[j].text;
                    }
                }
                if (messages[i].contactType === options[0].value) {
                    if (
                        messages[i].contactMethod &&
                        messages[i].contactMethod !== ""
                    ) {
                        messages[i].contactType = "未指定";
                    } else messages[i].contactType = "";
                }
            }
            // //console.log(9);

            return messages;
        },
        compare(prop) {
            return function(obj1, obj2) {
                console.log("qqq", prop, obj1[prop]);
                if (obj1[prop][0] === "t" || obj2[prop][0] === "t") return 0;
                var val1 = obj1[prop];
                var val2 = obj2[prop];
                return val2 - val1;
            };
        },
        unique(array) {
            array = array.sort(this.compare("id"));
            // 对象去重方法
            var allArr = []; //建立新的临时数组
            for (var i = array.length - 1; i > -1; i--) {
                var flag = true;
                for (var j = 0; j < allArr.length; j++) {
                    if (
                        array[i]["id"][0] === "t" ||
                        array[i].id == allArr[j].id
                    ) {
                        flag = false;
                    }
                }
                if (flag) {
                    allArr.unshift(array[i]);
                }
            }
            // //console.log("all", allArr);
            return allArr;
        },
        // 上拉回调 page = {num:1, size:10}; num:当前页 ,默认从1开始; size:每页数据条数,默认10
        upCallback(page) {
            let that = this;
            console.log(
                "bottom",
                this.firstId,
                page,
                this.$data.loading,
                this.$data.allLoaded,
                this.$data.firstId === Number.MAX_SAFE_INTEGER
            );
            if (this.$data.loading) return this.mescroll.endErr();
            // 联网加载数据
            if (this.$data.allLoaded || this.$data.firstId < 10) {
                return this.mescroll.endErr();
            }
            console.log("this.mescroll.version=" + this.mescroll.version);
            this.loading = true;
            this.getMessages(that.$data.firstId - 10, 10).then(
                (res) => {
                    console.log("res", res);
                    let temp = that.$data.messages;
                    temp = temp.concat(res);
                    that.$data.messages = that.unique(temp);
                    //console.log("dfdssdfxd", this.$data.messages);
                    that.mescroll.endSuccess(
                        temp.length,
                        !that.$data.allLoaded
                    );
                    that.$nextTick(function() {
                        that.loading = false;
                        that.mescroll.endSuccess();
                    });
                },
                () => {
                    that.$Toast({
                        message: "加载失败，请稍后重试",
                        iconClass: "icon icon-error"
                    });
                    that.$nextTick(function() {
                        that.loading = false; //输出：修改后的值
                        that.mescroll.endErr();
                    });

                    console.log("end", that.$data.loading);
                }
            );
        },
        // upCallback(page) {
        //     // 联网加载数据

        // },
        /* 下拉刷新的回调 */
        downCallback() {
            console.log("top", this.$data.lastId);
            this.getMessages(this.$data.lastId, 10, true).then(
                (res) => {
                    console.log("res1", res);
                    let temp = this.$data.messages;
                    temp = temp.concat(res);
                    this.$data.messages = this.unique(temp);
                    this.$nextTick(function() {
                        this.mescroll.endSuccess();
                        this.loading = false;
                    });
                },
                (err) => {
                    console.log(err);
                    this.$Toast({
                        message: "加载失败，请稍后重试",
                        iconClass: "icon icon-error"
                    });
                    this.$nextTick(function() {
                        this.mescroll.endErr();
                        this.loading = false;
                    });

                    // 执行失败的回调函数
                }
            );
        },

        /* 联网加载列表数据
     在您的实际项目中,请参考官方写法: http://www.mescroll.com/api.html#tagUpCallback
     请忽略getListDataFromNet的逻辑,这里仅仅是在本地模拟分页数据,本地演示用
     实际项目以您服务器接口返回的数据为准,无需本地处理分页.
    * */
        getListDataFromNet(pageNum, pageSize, successCallback, errorCallback) {
            // 延时一秒,模拟联网
            setTimeout(function() {
                try {
                    if (pageNum === 0) {
                        // 此处模拟下拉刷新返回的数据
                        var id = new Date().getTime();
                        var newObj = {
                            title: "【新增新闻】 标题" + id,
                            content: "新增新闻的内容",
                            id: id
                        };
                        successCallback && successCallback(newObj);
                    } else {
                        // 此处模拟上拉加载返回的数据
                        var newArr = [];
                        for (var i = 0; i < pageSize; i++) {
                            var upIndex = (pageNum - 1) * pageSize + i + 1;
                            newArr.push({
                                title:
                                    "【新闻" +
                                    upIndex +
                                    "】 标题标题标题标题标题标题",
                                content:
                                    "内容内容内容内容内容内容内容内容内容内容",
                                id: upIndex
                            });
                        }
                        successCallback && successCallback(newArr);
                    }
                } catch (e) {
                    // 联网失败的回调
                    errorCallback && errorCallback();
                }
            }, 1000);
        },

        scrollToTop() {
            console.log("scrollToTop", this.$refs.scrollContainer.scrollTop);
            this.$refs["scrollContainer"].scrollTo();
        },
        onEditorChange({ html }) {
            //console.log("editor change!", quill, html, text);
            this.content = html;
        },
        checkContactMethod() {
            var options = this.$data.options;
            // var that = this;
            this.$data.contactMethod = this.$data.contactMethod.trim();
            for (var j = options.length - 1; j > -1; j--) {
                if (this.$data.contactType === options[j].value) {
                    if (
                        !new RegExp(options[j].reg).test(
                            this.$data.contactMethod
                        )
                    ) {
                        this.$Toast({
                            message: `联系方式格式不正确`,
                            iconClass: "icon icon-error"
                        });
                        return false;
                    }
                }
            }
            return true;
        },
        maskContackMethod(string) {
            //console.log("qaz   ", string.length);
            if (string.length < 3) return "**";
            if (string.length > 5) return "*****";
            return (
                string.substr(0, 1) +
                "*".repeat(string.length - 2) +
                string.substr(string.length - 1, 1)
            );
        },
        submit() {
            //console.log("222222222", this.$data.content);
            // var that = this;
            // Loading.service({ fullscreen: true });
            if (this.$data.content.replace(/<(?!img).*?>/g, "").trim() === "") {
                // this.$message({
                //     showClose: true,
                //     message: "内容不能为空！",
                //     type: "error"
                // });
                this.$Toast({
                    message: "内容不能为空！",
                    iconClass: "icon icon-error"
                });

                return;
            }
            if (!this.checkContactMethod()) {
                return;
            }
            this.$Indicator.open({
                text: "提交中...",
                spinnerType: "fading-circle"
            });
            var tempMessage = {
                //这里是发送给后台的数据
                "messageContent": this.$data.content,
                "contactType": this.$data.contactType,
                "contactMethod": this.$data.contactMethod,
                "microtime": Date.now()
            };
            this.$axios({
                method: "post",
                url: "/php/submitMessages.php",
                data: this.qs.stringify(tempMessage)
            })
                .then((response) => {
                    this.$Indicator.close();
                    //这里使用了ES6的语法
                    if (response.data.code === 1) {
                        this.$Toast({
                            message: "提交成功！",
                            iconClass: "icon icon-success"
                        });
                    }
                    this.$data.content = "";
                    tempMessage["contactMethod"] = this.maskContackMethod(
                        tempMessage["contactMethod"]
                    );
                    this.$data.messages.unshift(
                        this.maskMessages([tempMessage])[0]
                    );
                    //console.log(this.$data.messages);
                })
                .catch((error) => {
                    this.$Indicator.close();
                    this.$Toast({
                        message: `提交失败  ${error}`,
                        iconClass: "icon icon-error"
                    });
                });
        }
    }
};
</script>

<style scoped>
/*以fixed的方式固定mescroll的高度*/
.mescroll {
    position: fixed;
    bottom: 0;
    top: 0;
    height: auto;
}

.header {
    z-index: 9990;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 44px;
    line-height: 44px;
    text-align: center;
    border-bottom: 1px solid #eee;
    background-color: white;
}

.header .btn-left {
    position: absolute;
    top: 0;
    left: 0;
    padding: 12px;
    line-height: 22px;
}

.header .btn-right {
    position: absolute;
    top: 0;
    right: 0;
    padding: 0 12px;
}

.mescroll .notice {
    font-size: 14px;
    padding: 20px 0;
    border-bottom: 1px solid #eee;
    text-align: center;
    color: #555;
}

.news-list li {
    padding: 16px;
    border-bottom: 1px solid #eee;
}

.news-list .new-content {
    font-size: 14px;
    margin-top: 6px;
    margin-left: 10px;
    color: #666;
}
</style>

<style>
.ql-container.ql-snow .ql-editor {
    line-height: normal;
    height: 150px;
}
.ql-snow .ql-tooltip[data-mode="link"]::before {
    content: "请输入链接地址:";
}
.ql-snow .ql-tooltip.ql-editing a.ql-action::after {
    border-right: 0px;
    content: "保存";
    padding-right: 0px;
}

.ql-snow .ql-tooltip[data-mode="video"]::before {
    content: "请输入视频地址:";
}

.ql-snow .ql-picker.ql-size .ql-picker-label::before,
.ql-snow .ql-picker.ql-size .ql-picker-item::before {
    content: "14px";
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="small"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="small"]::before {
    content: "10px";
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="large"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="large"]::before {
    content: "18px";
}
.ql-snow .ql-picker.ql-size .ql-picker-label[data-value="huge"]::before,
.ql-snow .ql-picker.ql-size .ql-picker-item[data-value="huge"]::before {
    content: "32px";
}

.ql-snow .ql-picker.ql-header .ql-picker-label::before,
.ql-snow .ql-picker.ql-header .ql-picker-item::before {
    content: "文本";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="1"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="1"]::before {
    content: "标题1";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="2"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="2"]::before {
    content: "标题2";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="3"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="3"]::before {
    content: "标题3";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="4"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="4"]::before {
    content: "标题4";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="5"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="5"]::before {
    content: "标题5";
}
.ql-snow .ql-picker.ql-header .ql-picker-label[data-value="6"]::before,
.ql-snow .ql-picker.ql-header .ql-picker-item[data-value="6"]::before {
    content: "标题6";
}

.ql-snow .ql-picker.ql-font .ql-picker-label::before,
.ql-snow .ql-picker.ql-font .ql-picker-item::before {
    content: "标准字体";
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="serif"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="serif"]::before {
    content: "衬线字体";
}
.ql-snow .ql-picker.ql-font .ql-picker-label[data-value="monospace"]::before,
.ql-snow .ql-picker.ql-font .ql-picker-item[data-value="monospace"]::before {
    content: "等宽字体";
}
#disabledMsg.el-button.is-disabled,
.el-button.is-disabled:focus,
.el-button.is-disabled:hover {
    color: #bfd9d8;
    background-color: #eef6f6;
    border-color: #d1e5e5;
}
.mint-loadmore-text {
    font-size: 0.8rem;
}
</style>

<style lang="scss">
#pullDown,
#pullUp {
    background: #fff;
    min-height: 100%;
    line-height: 40px;
    margin: 20px;
    font-weight: 700;
    font-size: 14px;
    color: #888;
    text-align: center;
}
#messages-box-big {
    // height: 100px;
    margin: 0 10px;
    // overflow: visible;
    .messages-box {
        list-style-type: none;
        border-bottom: 1px solid #e1e4e6;
    }
    .messageContent {
        font-size: 14px;
        word-break: keep-all;
        word-wrap: break-word;
        white-space: pre-wrap;
        padding-top: 10px;
        padding-bottom: 50px;
        background: #fff;
        text-align: left;
        img {
            max-width: 100%;
        }
    }

    .message-footer {
        border: none;
        text-align: left;
        // display: flex;
        justify-content: space-between;
        overflow: auto;
    }
    .message-time {
        float: right;
        text-align: right;
    }
}
#flex {
    display: flex;
    justify-content: space-between;
    font-size: 0.6rem;
}
#flex .custom-select,
#flex > .form-control {
    width: auto;
    font-size: 0.6rem;
}
#flex input {
    max-width: 10rem;
    font-size: 0.6rem;
}
#flex > button {
    flex: 0 1 100px;
    margin-left: 1rem;
    font-size: 0.6rem;
}
#leavemessage {
    // margin-top: 2.5rem;
    font-family: 华文行楷, 微软雅黑, serif;
    font-size: 1em;
    font-weight: 900;
    color: #00cc33;
    text-shadow: 2px 2px 6px #000;
    font-style: oblique;

    padding: 10px;
    text-align: center;
}
#nomore {
    font-size: 0.8rem;
    margin: 1rem;
    text-align: center;
}

.message-footer {
    font-size: 0.7rem;
    address {
        display: inline;
    }
}
.icon-error:before {
    content: "\2716";
}
.icon-success:before {
    content: "\2714";
}
</style>
