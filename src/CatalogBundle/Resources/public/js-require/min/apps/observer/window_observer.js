define(["app"],function(t){return t.module("Observer.Window",function(t,e,i,n,o,r){var s=800,d=o(window).width(),u="window:desktop",w="window:mobile";t.setTriggers=function(){s>=d?(g("mobile"),t.trigger(w)):(g("desktop"),t.trigger(u)),o(window).on("resize",function(e){d=o(window).width(),s>=d&&"desktop"===t.getStatus()?(t.trigger(w),g("mobile")):d>s&&"mobile"===t.getStatus()&&(t.trigger(u),g("desktop"))})};var g=function(e){t.status=e};t.getStatus=function(){return t.status}}),t.Observer.Window});