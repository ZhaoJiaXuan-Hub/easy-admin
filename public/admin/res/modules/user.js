/**
 * user demo
 */
 
layui.define('form', function(exports){
  var $ = layui.$
  ,layer = layui.layer
  ,laytpl = layui.laytpl
  ,setter = layui.setter
  ,view = layui.view
  ,admin = layui.admin
  ,form = layui.form;

  var $body = $('body');
  
  //更换图形验证码
  $body.on('click', '#LAY-user-get-vercode', function(){
    var othis = $(this);
    this.src = setter.server.url+'system/account/auth/captcha?t='+ new Date().getTime()
  });
  
  //对外暴露的接口
  exports('user', {});
});