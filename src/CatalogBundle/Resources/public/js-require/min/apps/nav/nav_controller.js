define(["app","apps/nav/nav_view","entities/nav_element"],function(n){n.module("NavApp",function(n,e,t,o,i,l){n.Controller={listNavElements:function(){var t=e.request("nav:elements");return t.then(function(t){var o=new n.NavElements({collection:t});o.on("childview:page:elect",function(n,t){"Цены"===t.get("name")?window.location.href=t.get("url"):e.ContentApp.Controller.showContent(t)}),e.navRegion.show(o)})}}})});