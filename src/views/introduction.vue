<template>
    <div id="introduction">
        <div class="banner text-center">
            <div class="myname text-center">王&emsp;振</div>
            <div class="htmlname">的个人主页</div>
        </div>

        <b-row>
            <b-col sm>
                <img
                    src="../assets/images/me.png"
                    class="img-circle"
                    alt="王振"
                    title="王振"
                />
            </b-col>
        </b-row>
        <!--调整内容位置，以使中间不至留大片空白-->
        <div>
            <b-table responsive stacked :items="items"></b-table>
        </div>

        <div>
            <b-card class="text-center" title="个人自述" sub-title="2016年作">
                <b-card-text class="text-justify" v-html="p1"></b-card-text>
                <b-card-text class="text-justify" v-html="p2"></b-card-text>
                <b-card-text class="text-justify" v-html="p3"></b-card-text>
                <b-card-text class="text-justify" v-html="p4"></b-card-text>
                <b-card-text class="text-justify" v-html="p5"></b-card-text>
            </b-card>
        </div>
        <footer id="mainApp">
            <address v-html="footer"></address>
        </footer>
    </div>
</template>

<script>
export default {
    name: "introduction",
    metaInfo: {
        title: "王振的个人主页",
        meta: []
    },
    data() {
        var that = this;
        return {
            p1:
                "我出生于江西省上饶县，自从初中开始，我的成绩就不怎么好。初中的时候，在老师们的熏陶下，感觉似乎只有上重点中学才能实现多年的大学梦想，可惜我成绩不佳不能被县里的重点中学录取。所以，我一直倾慕重点中学的同学，在我眼中，他们都是人才，我又何德何能，岂能追及！",
            p2:
                "后来我还是和他们一起参加高考，但是，成绩不能满足升学的愿望。于是只好去复读了。",
            p3:
                "现在我考进了一所大学，受着高等教育，终于体会到了幼时梦想的地方的现实版本，身边也有一些从重点中学来的人。通过与他们的交往，我感觉到，所谓的重点中学，并不是那么高不可攀。",
            p4:
                "不管怎样，人之生于世，不能总是仰望别人的高度，生命是自己的，要为自己活着，为自己努力。",
            p5:
                "一个坚强的人，无论身处何时何地，都不会因外界环境而改变自己的意志与操守。",
            items: [
                {
                    姓名: "王振",
                    性别: "男",
                    血型: "AB",
                    生日: "1997-09-12",
                    虚度人生: that.dateComputed() + "日",
                    出生地: "江西省 上饶市 上饶县",
                    现居地: "重庆市 沙坪坝区 虎溪镇"
                }
            ],
            footer: "加油进步的程序员"
        };
    },
    methods: {
        dateComputed() {
            var date1 = "1997/09/12 00:00:00"; //开始时间
            var date2 = new Date(); //结束时间
            var date3 = date2.getTime() - new Date(date1).getTime(); //时间差的毫秒数
            var days = Math.floor(date3 / (24 * 3600 * 1000));
            return days;
        }
    },
    components: {}
};
</script>

<style lang="scss" scoped>
.img-circle {
    display: block;
    width: 200px;
    height: 280px;
    border-radius: 30px;
    margin: 1rem auto;
}

.banner {
    font-size: 2rem;
    /*设置字体大小*/
    color: #0f0;
    /*设置字体颜色*/
}
table {
    font-family: 宋体;
    font-size: 0.8rem;

    div {
        text-align: left;
    }
    tbody > tr > :last-child {
        border-bottom: solid #dee2e6 3px;
    }
}
.row {
    margin: 0 !important;
}
.card-text {
    font-size: 0.8rem;
    text-indent: 1.6rem;
}
</style>
