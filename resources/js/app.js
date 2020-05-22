/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from "vue";
import VueHtml5Editor from "vue-html5-editor";
if (document.getElementById("html5-editor")) {
    var editorOpt = {
        // 全局组件名称，使用new VueHtml5Editor(options)时该选项无效
        // global component name
        name: "vue-html5-editor",
        // 是否显示模块名称，开启的话会在工具栏的图标后台直接显示名称
        // if set true,will append module name to toolbar after icon
        showModuleName: false,
        // 自定义各个图标的class，默认使用的是font-awesome提供的图标
        // custom icon class of built-in modules,default using font-awesome
        icons: {
            text: "fa fa-pen",
            color: "fas fa-paint-brush",
            font: "fas fa-font",
            align: "fa fa-align-justify",
            list: "fa fa-list",
            link: "fas fa-link",
            unlink: "fas fa-link",
            tabulation: "fa fa-table",
            image: "far fa-file",
            hr: "fa fa-minus",
            eraser: "fa fa-eraser",
            undo: "fa-undo fa",
            "full-screen": "fa fa-arrows-alt",
            info: "fa fa-info"
        },
        // 配置图片模块
        // config image module
        image: {
            // 文件最大体积，单位字节  max file size
            sizeLimit: 512 * 1024,
            // 上传参数,默认把图片转为base64而不上传
            // upload config,default null and convert image to base64
            upload: {
                url: null,
                headers: {},
                params: {},
                fieldName: "file"
            },
            // 压缩参数,默认使用localResizeIMG进行压缩,设置为null禁止压缩
            // compression config,default resize image by localResizeIMG (https://github.com/think2011/localResizeIMG)
            // set null to disable compression
            compress: {
                width: 1600,
                height: 1600,
                quality: 80
            },
            // 响应数据处理,最终返回图片链接
            // handle response data，return image url
            uploadHandler(responseText) {
                //default accept json data like  {ok:false,msg:"unexpected"} or {ok:true,data:"image url"}
                var json = JSON.parse(responseText);
                console.log(json);
                if (json.error == 1) {
                    alert(json.msg);
                } else {
                    return json.data;
                    // return json.data
                }
            }
        },
        // 语言，内建的有英文（en-us）和中文（zh-cn）
        //default en-us, en-us and zh-cn are built-in
        language: "fa-ir",
        // 自定义语言
        i18n: {
            //specify your language here
            "fa-ir": {
                align: "ترازبندی",
                image: "تصویر",
                list: "لیست",
                link: "لینک",
                unlink: "حذف لینک",
                table: "جدول",
                font: "فونت",
                "full screen": "تمام صفحه",
                text: "متن",
                eraser: "پاک‌کن",
                info: "اطلاعات",
                color: "رنگ",
                "please enter a url": "یک آدرس وارد کنید",
                "create link": "ایجاد لینک",
                bold: "درشت",
                italic: "کج",
                underline: "زیرخط",
                "strike through": "خط‌خورده",
                subscript: "اندیس",
                superscript: "توان",
                heading: "سربرگ",
                "font name": "نام فونت",
                "font size": "سایز فونت",
                "left justify": "مرتب سازی از چپ",
                "center justify": "مرتب‌سازی از وسط",
                "right justify": "مرتب‌سازی از راست",
                "ordered list": "لیست مرتب",
                "unordered list": "لیست نامرتب",
                "fore color": "رنگ جلو",
                "background color": "رنگ زمینه",
                "row count": "متن خام",
                "column count": "تعداد ستون",
                save: "ذخیره",
                upload: "آپلود",
                progress: "پیشرفت",
                unknown: "ناشناخته",
                "please wait": "صبر کنید",
                error: "خطا",
                abort: "لغو",
                reset: "بازیابی"
            }
        },
        // 隐藏不想要显示出来的模块
        // the modules you don't want
        hiddenModules: [],
        // 自定义要显示的模块，并控制顺序
        // keep only the modules you want and customize the order.
        // can be used with hiddenModules together
        visibleModules: [
            "text",
            "align",
            "list",
            "link",
            "unlink",
            "tabulation",
            "hr",
            "eraser",
            "undo"

            // "full-screen",
        ],
        // 扩展模块，具体可以参考examples或查看源码
        // extended modules
        modules: {
            //omit,reference to source code of build-in modules
        }
    }
    Vue.use(VueHtml5Editor, editorOpt)
    var app = new Vue({
        el: '#app',
        methods: {
          EditorChange: function(evt) {
            this.$refs.message_text.innerText = evt;
          }
        }
    });
    var content = $("#html5-editor").attr("default_content")
    $('.vue-html5-editor .content').html(content)
}
