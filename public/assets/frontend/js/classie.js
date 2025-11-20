/* ********************** */
/* ***JS MENU outside** */
/* ********************** */
// window.addEventListener('click', function(e){
//     if (document.getElementById('js-open-menu-mobie').contains(e.target)){
//         document.getElementById('menu-mobile').classList.add('open');
//     } else{
//         document.getElementById('menu-mobile').classList.remove('open');
//     }
// });

// $.sidebarMenu($('.sidebar-menu'));
// var button_open_menu = document.getElementById('js-open-menu-mobie');
// if(button_open_menu != null){
//     var menu_mobile = document.getElementById('menu-mobile');
//     button_open_menu.addEventListener('click', function(){
//         menu_mobile.classList.add('open');
//     });
// }

/* ********************** */
/* ******Scollmenu***** */
/* ********************** */
// var menu = document.querySelector('.menu-head'),
// current_menu = 'true';
// window.addEventListener('scroll', () =>{
//     if(window.pageYOffset > 64){
//         if(current_menu == 'true'){
//             current_menu = 'false';
//             menu.classList.add('fixed');
//             document.querySelector('body').classList.add('mt-14');
//         }
//     }
//     else if (window.pageYOffset < 64){
//         if(current_menu == 'false'){
//             current_menu = 'true';
//             menu.classList.remove('fixed');
//             document.querySelector('body').classList.remove('mt-14');
//         }
//     }
// }, {passive: true})

/* ********************** */
/* *******Scroll top***** */
/* ********************** */
// var up = document.getElementById('up'),
// trangthai = 'true';
// window.addEventListener('scroll',function(){
//   if(window.pageYOffset > 800){
//     if(trangthai == 'true'){
//       trangthai = 'false';
//       up.classList.add('show');
//     }
//   }
//   else if (window.pageYOffset < 800){
//     if(trangthai == 'false'){
//     trangthai = 'true';
//     up.classList.remove('show');
//     }
//   }
// })
// $("a[href='#up']").click(function() {
//   $("html, body").animate({ scrollTop: 0 }, "slow");
//   return false;
// });