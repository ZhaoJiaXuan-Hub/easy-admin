layui.config({
    base: 'res/', // 静态资源所在路径
    version: '1.9.0'
}).use('index', function () {
    var layer = layui.layer;
    var admin = layui.admin;
    layer.ready(function () {
    });
});