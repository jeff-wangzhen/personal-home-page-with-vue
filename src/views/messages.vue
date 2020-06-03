<template>
    <div>
        <mt-loadmore
            :top-method="loadTop"
            :bottom-all-loaded="allLoaded"
            ref="loadmore"
        >
            <div id="leavemessage">
                既已到此，何不留言
            </div>
            <!-- bidirectional data binding（双向数据绑定） -->
            <!-- <quill-editor
                v-model="content"
                ref="myQuillEditor"
                :options="editorOption"
                @blur="onEditorBlur($event)"
                @focus="onEditorFocus($event)"
                @ready="onEditorReady($event)"
            >
            </quill-editor> -->
            <div class="quill-wrap">
                <quill-editor
                    v-model="content"
                    ref="myQuillEditor"
                    :options="editorOption"
                >
                </quill-editor>
            </div>
            <div id="flex">
                <b-input-group>
                    <b-form-select
                        v-model="contactType"
                        :options="options"
                        slot="prepend"
                    >
                    </b-form-select>
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

            <div
                id="messages-box-big"
                v-infinite-scroll="loadMore"
                infinite-scroll-disabled="loading"
                infinite-scroll-distance="10"
            >
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
                            <span>{{ item.province }} {{ item.city }}</span
                            >&emsp;
                            <span class="message-contactType">
                                {{ item.contactType }}
                                {{ item.contactMethod }}
                            </span>
                        </address>

                        <time class="message-time">{{
                            item.microtime | formatTime
                        }}</time>
                    </footer>
                </li>
            </div>

            <div id="pullUp" v-show="loading">
                <b-spinner variant="primary" label="Spinning"></b-spinner>
            </div>
            <div id="nomore" v-show="allLoaded">没有更多啦~~</div>
        </mt-loadmore>
        <div placement="top" content="返回顶部">
            <back-to-top
                transitionName="fade"
                :customStyle="myBackToTopStyle"
                :visibilityHeight="300"
                :backPosition="50"
            >
            </back-to-top>
        </div>
    </div>
</template>

<script>
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
    metaInfo: {
        title: "留言板112321323123",
        meta: []
    },
    components: { BackToTop, quillEditor },
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
            firstId: 0,
            lastId: 0,
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
            fullscreenLoading: false
        };
    },
    computed: {
        editor() {
            return this.$refs.myQuillEditor.quill;
        }
    },
    created() {
        // Indicator.open({
        //     text: "Loading...",
        //     spinnerType: "fading-circle"
        // });
        this.$data.loading = true;
        this.getMessages(0, 10, true).then(
            (res) => {
                this.$data.messages = res;
                this.$data.loading = false;
                // 执行成功的回调函数
            },
            () => {
                this.$Toast({
                    message: "加载失败，请稍后重试",
                    iconClass: "icon icon-error"
                });
                this.$data.loading = false;
                // 执行失败的回调函数
            }
        );
    },
    mounted() {
        window.addEventListener("pageshow", function() {
            console.log("pageshow");
        });
        window.addEventListener("pagehide", function() {
            console.log("pagehide");
        });
    },

    methods: {
        // onEditorBlur(quill) {
        //     //console.log("editor blur!", quill.getContents());
        // },
        // onEditorFocus(quill) {
        //     //console.log("editor focus!", quill);
        // },
        // onEditorReady(quill) {
        //     //console.log("editor ready!", quill);
        // },
        onEditorChange({ html }) {
            //console.log("editor change!", quill, html, text);
            this.content = html;
        },
        unique(array) {
            // 对象去重方法
            var allArr = []; //建立新的临时数组
            for (var i = 0; i < array.length; i++) {
                var flag = true;
                for (var j = 0; j < allArr.length; j++) {
                    if (array[i].id == allArr[j].id) {
                        flag = false;
                    }
                }
                if (flag) {
                    allArr.push(array[i]);
                }
            }
            // //console.log("all", allArr);
            return allArr;
        },
        loadTop() {
            this.getMessages(this.$data.lastId, 10).then(
                (res) => {
                    //console.log(this.$data.messages);
                    let temp = this.$data.messages;
                    temp = res.concat(temp);
                    this.$data.messages = this.unique(temp);
                    // this.$data.messages.splice(0, res.length);
                    // for (let i = res.length - 1; i > -1; i--) {
                    //     this.$data.messages.unshift(res[i]);
                    // }
                    //console.log(1, temp, res, this.$data.messages);
                    // 执行成功的回调函数
                },
                () => {
                    this.$Toast({
                        message: "加载失败，请稍后重试",
                        iconClass: "icon icon-error"
                    });
                    // 执行失败的回调函数
                }
            );
            // this.updateMessagesList();
            this.$refs.loadmore.onTopLoaded();
        },
        loadBottom() {
            //不知道怎么用，很容易导致无限刷新，放弃
            this.loading = true;
            this.allLoaded = true;
            //console.log("dfdssdfxd", this.$data.firstId);
            // //console.log("bottm");
            // if (this.$data.firstId < 2) return false;
            //console.log("bottm222222222");
            // this.allLoaded = true;
            this.getMessages(this.$data.firstId - 10, 10).then(
                (res) => {
                    // //console.log(this.$data.messages);
                    let temp = this.$data.messages;
                    temp = temp.concat(res);
                    this.$data.messages = this.unique(temp);
                    //console.log("dfdssdfxd", this.$data.messages);
                    this.loading = false;
                    this.allLoaded = false;
                },
                () => {
                    //console.log("dfdssdfxd", this.$data.messages);
                    this.loading = false;
                    this.allLoaded = false;
                    //console.log(error);
                }
            );
            this.loading = false;
            this.$refs.loadmore.onBottomLoaded();
            this.allLoaded = true; // 若数据已全部获取完毕
        },
        loadMore() {
            // return false;
            if (this.$data.allLoaded || this.$data.firstId === 0) {
                return false;
            }
            //console.log(9);
            this.$data.loading = true;
            this.getMessages(this.$data.firstId - 10, 10).then(
                (res) => {
                    // //console.log(this.$data.messages);
                    let temp = this.$data.messages;
                    temp = temp.concat(res);
                    this.$data.messages = this.unique(temp);
                    //console.log("dfdssdfxd", this.$data.messages);
                    this.loading = false;
                },
                () => {
                    this.$Toast({
                        message: "加载失败，请稍后重试",
                        iconClass: "icon icon-error"
                    });
                    this.loading = false;
                }
            );
        },
        maskMessages(messages) {
            var that = this;
            var options = that.$data.options;
            for (var i = messages.length - 1; i > -1; i--) {
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

        getMessages(start, length, lastest = false) {
            var that = this;
            return new Promise((resolve, reject) => {
                this.$axios
                    .get("/php/getMessages.php", {
                        params: {
                            start,
                            length,
                            lastest
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
                            if (lastest)
                                that.$data.lastId =
                                    response.data.messages[0].id;
                            that.$data.firstId = parseInt(
                                response.data.messages[length - 1].id
                            );
                            if (response.data.allLoaded === true)
                                that.$data.allLoaded = true;
                            // else that.$data.allLoaded = false;
                            // //console.log(
                            //     that.$data.allLoaded,
                            //     "leng   ",
                            //     length,
                            //     that.$data.firstId,
                            //     "firstid   ",
                            //     response.data
                            // );

                            resolve(that.maskMessages(response.data.messages));
                        }

                        //console.log("resolving");
                    })
                    .catch(function(error) {
                        reject(error);
                        // eslint-disable-next-line vue/script-indent
                    });
            });
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
            // let loadingInstance = this.$loading({
            //     lock: true,
            //     text: "提交中",
            //     spinner: "el-icon-loading",
            //     background: "rgba(0, 0, 0, 0.7)"
            //     // fullscreenLoading: false
            // });
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

                    //console.log(response.data); //请求成功返回的数据
                    // loadingInstance.close();
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

                    // loadingInstance.close();
                    // this.disabled = false;
                    // this.submitButton = "提交";
                    //console.log(error); //请求失败返回的数据
                    // eslint-disable-next-line vue/script-indent
                });
            //console.log(
            //     "提交",
            //     this.$data.content,
            //     this.$data.selected,
            //     this.$data.contactMethod
            // );
        }
    }
};
</script>

<style>
.ql-container.ql-snow .ql-editor {
    line-height: normal;
    height: 220px;
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
    margin: 0 10px;
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
    margin-top: 0;

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
