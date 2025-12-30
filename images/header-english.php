<?php
include_once __DIR__ . "/redirects-en.php";
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
    <?php if(is_front_page()||is_page_template('page-templates/technology.php')){?>
    <!--
`  └╙╜╬╬╬╬╬╬╬╬╬╖╖                                                                                                                
         ╙╬┤┤┤┤┤┤┤┐                                                                                                               
         ╔╬╬┤┤┤┤┤╬                                                                                                               
        ╬╬╬╬╬┤┤╬╜                                                                                                                 
      ╓╬╬╬╬╬╬╬╬└          ╬╬─  ╬╬╬   ╬╬  ╓╦╬╩╩╩╬╦  └╩╩╩╩╬╬╦    ╩╩╩╩╩╩┘  ╙╩╩╩╩╬╬╦   ╙╬╬   ╬╬╩╩╬╬┐  ╓╬╜   ║╬─  ║╬╜  ╔╬┘     ╙╩╩╩╩╬╬╖
     ╬╬╬╬╬╬╬╬╜           ╔╬┘  ╓╬╜╬╬ ║╬  ╔╬╜             ╓╬╬   ╖╖╖╖╖╖    ╓╖    ║╬─  ╬╬   ╬╬╖╖╦╬╩   ╬╬   ╓╬╜   ╬╬  ┌╬╜      ╖╖    ╬╬
   ╓╬╬╬╬╬╬╬╬            ╓╬╜  ╓╬╜ ╙╬╬╬╜  ╬╬        ╓╬╩╩╬╬╜└   ║╬╜╙╙╙─   ┌╬╜   ╓╬╩  ║╬─  ╔╬╜  ╙╬┤  ╬╬═  ╓╬╩   ╬╬─  ╬╬      ║╬─   ╬╬╜
  ╬╬╬╬╬╬╬╬╜             ╬╬   ╬╬   ╚╬╩   └╩╬╬╬╬╩   ╬╬  ╙╬╬   ╓╬╬╬╬╬╬─   ╬╬╬╬╬╩╜   ╓╬╜  ╓╬╬╬╬╬╬╜   ╙╬╬╬╬╩╜   ║╬╜  ╬╬╬╬╬╬╜ ╓╬╬╬╬╬╩╜  
 -->   
    
    <?php } ?>
<head>

    <?php favicons(); ?>


    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    
     <!--    Marketo    -->
    <?php
    if (!is_front_page()) { ?>
        <script src="https://go.incredibuild.com/js/forms2/js/forms2.min.js"></script>
    <?php
    }
    ?>
    <script type="text/javascript">
	(function() {
		var didInit = false;
		function initMunchkin() {
			if(didInit === false) {
				didInit = true;
				Munchkin.init('915-OAR-847');
			}
		}
		var s = document.createElement('script');
		s.type = 'text/javascript';
		s.async = true;
		s.src = '//munchkin.marketo.net/munchkin.js';
		s.onreadystatechange = function() {
			if (this.readyState == 'complete' || this.readyState == 'loaded') {
				initMunchkin();
			}
		};
		s.onload = initMunchkin;
		document.getElementsByTagName('head')[0].appendChild(s);
		})();
	</script>
    <!--    End Marketo    -->
    
    
    
    
    <?php wp_head(); ?>

    <?php
    /**
     * Add CN Fonts
     */
    if(is_chinese_site()) {
        ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700;900&display=swap" rel="stylesheet">
        <?php
    } else {
        // Do Nothing
    }
    ?>


	
	
	
	
    <!--Start ZoomInfo Script-->
    <script>
        (function () {
          var zi = document.createElement('script');
          zi.type = 'text/javascript';
          zi.async = true;
          zi.referrerPolicy = 'unsafe-url';
          zi.src = 'https://ws.zoominfo.com/pixel/oQhMQMWZAjk8Zt97B1gh';
          var s = document.getElementsByTagName('script')[0];
          s.parentNode.insertBefore(zi, s);
        })();
      </script>
      <!--End ZoomInfo Script-->
    <?php
    //Global GTM Code (Requested by Wang Hao)
    ?>
    <!-- Global site tag (gtag.js) - Google Ads: 10907019000 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10907019000"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-10907019000');
    </script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-PKBHC42');</script>
    <!-- End Google Tag Manager -->

    <?php
    // Google Tag Manager
    if(is_chinese_site()) {
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-KQVSND3');</script>
        <!-- End Google Tag Manager -->
        <?php
    } else {
        ?>
        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NS2B6X4');</script>
        <!-- End Google Tag Manager -->
        <?php
    }
    ?>

    <?php
    if(!is_chinese_site()) { ?>
        <!-- Matomo Tag Manager -->
        <script>
        var _mtm = window._mtm = window._mtm || [];
        _mtm.push({'mtm.startTime': (new Date().getTime()), 'event': 'mtm.Start'});
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.async=true; g.src='https://cdn.matomo.cloud/incredibuildcn.matomo.cloud/container_ybzNzP2o.js'; s.parentNode.insertBefore(g,s);
        </script>
        <!-- End Matomo Tag Manager -->
    <?php
    } ?>

<script src="https://cdn.userway.org/widget.js" data-account="prbt1ipXqE"></script>
</head>

<body <?php body_class(); ?>>

<style>


@import url('https://fonts.googleapis.com/css2?family="Poppins", sans-serif:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
body{
    overflow-x: hidden;
}
#primary-menu a {  font-family: "Poppins", sans-serif;}
.button-l a {
    position: relative;
    margin-left: 6px;
    margin-right: 6px;
    text-decoration: none;
    display: inline-flex;
    padding: 10px 18px;
    justify-content: center;
    align-items: center;
    gap: 10px;
    border-radius: 6px;
    background: #FFCC18;
    color: #171E37;
    text-align: center;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    font-weight: 500;
}

.button-l a:before {
content: '';
background: linear-gradient(45deg, #1effae, #671fff,#0094ff,#fff);
position: absolute;
top: -2px;
left:-2px;
background-size: 400%;
z-index: -1;
filter: blur(5px);
width: calc(100% + 4px);
height: calc(100% + 4px);
animation: glowing 20s linear infinite;
opacity: 0;
transition: opacity .3s ease-in-out;
border-radius: 10px;
}

.button-l a:active {
background: #FFCC18;
}

.button-l a:active:after {
background: transparent;
}

.button-l a:hover:before {
opacity: 1;
}
.button-l a.grey:after { background: #B4B4B4;}
.button-l a:after {
z-index: -1;
content: '';
position: absolute;
width: 100%;
height: 100%;
background: #FFCC18;
left: 0;
top: 0;
border-radius: 10px;
}
.button-l.line a {
background-color: #1E2955;
color:#fff;   
 outline: 1px solid #fff;

}
@keyframes glowing {
0% { background-position: 0 0; }
50% { background-position: 400% 0; }
100% { background-position: 0 0; }
}

.menuDescription{
    display: block;
    color: #A2A2A2;
    font-family: "Poppins", sans-serif;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: 22px;
    text-decoration: none;
    padding-left: 23px;
    max-width: 270px;
}
.navBlock {max-width:1273px; margin:auto;}
#masthead-n{background: #1E2955; box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, 0.10);}

#primary-menu-wrap{display: flex;    height: 80px;justify-content: space-between;}
#primary-menu {display: flex;gap: 25px; align-self: center;height: 100%;}
#primary-menu li.menu-item-has-children.depth-0 {padding-right: 17px;background-image: url('/wp-content/themes/incredibuild/images/mnuarr.svg'); background-repeat: no-repeat;background-position: right center;    align-items: center;
    display: flex;    height: 100%;} 
    #primary-menu li.depth-0 {align-self: center;align-items: center;display: flex;height: 100%;    margin-top: 6px;}

.site-branding {align-self: center;}
#util-menu {display:flex;    align-self: center;align-items: center; }
#primary-menu li.depth-0 a {color:#fff;text-decoration:none;    box-sizing: border-box;font-size: 15px;}
#primary-menu li.depth-1 a {color:#000;}
#primary-menu li.depth-2 a {color:#000;}


.sub-menu.dropdown-menu.ul-dept-0 .sc {
    max-width: 590px;
    width: 100%;
    border: 1px solid #C3C3C3;

background: #EAEAEA;
    display: flex;
    flex-wrap: wrap;
    margin-left: auto;margin-left: 34px;
    align-self: stretch;
    flex-direction: column;
}



#primary-menu li.menu-item-has-children.depth-0.open .sub-menu.dropdown-menu.ul-dept-0 {display: flex;}
.sub-menu.dropdown-menu.ul-dept-0 {position: absolute;
    top: 74px;
    background-color: #fff;
    width:100%;
    display: none;
    color: #000;
    flex-direction: row;    
    max-width: 1273px;
  z-index: 10;
    left: 50%;
    transform: translateX(-50%);    justify-content: space-between;    align-items: flex-start;}
   
    #primary-menu .sub-menu.dropdown-menu.ul-dept-0 li.depth-1 a {
        color: #828282;
    border-bottom: 1px solid #C3C3C3;
    display: flex;
    height: 64px;
    font-family: "Poppins", sans-serif;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: 28px;
    text-decoration: none;
    flex-direction: column-reverse;
    padding-bottom: 6px;
    box-sizing: border-box;
    }
    #primary-menu .sub-menu.dropdown-menu.ul-dept-0 li.depth-2 a {    border-bottom: none;
    height: auto;
    color: #000;
    display: inline-block;
    padding: 10px 0;
    box-sizing: border-box;}
    #primary-menu .sub-menu.dropdown-menu.ul-dept-0 li.depth-2 a:hover .navMainLink{color:#204CE1; text-decoration: underline;}
    #primary-menu .sub-menu.dropdown-menu.ul-dept-0 li.depth-2 a:hover svg {color:#204CE1;}
    .sub-menu.dropdown-menu.ul-dept-0:after{
        content:" ";
        background-color: #fff;
        height: 100%;
        width:100%;
        left:  -99%;
    z-index: -1;
        position: absolute;
    }
    #primary-menu .sub-menu.dropdown-menu.ul-dept-0 li.depth-2 a img {margin-right: 8px;}
    .sub-menu.dropdown-menu.ul-dept-0:before {
    content: " ";
 

background: #EAEAEA;
    height: 100%;
    width: 100%;
    position: absolute;
    right:  -99%;
    z-index: -1;
}

#primary-menu-wrap .zivwashere {padding:0 38px ;width:100%;box-sizing: border-box;}
#primary-menu-wrap .zivwashereTitle{width:100%;
    color: #828282;
    padding:0 38px ;
    display: flex;
    height: 64px;
    font-family: "Poppins", sans-serif;
    font-size: 15px;
    font-style: normal;
    font-weight: 400;
    line-height: 28px;
    text-decoration: none;
    flex-direction: column-reverse;
    padding-bottom: 6px;
    box-sizing: border-box;
}
#primary-menu .sub-menu.dropdown-menu.ul-dept-0 li.depth-2 a img {max-height: 20px;vertical-align: middle;}
#primary-menu li.depth-0 a.addon {
    color: #000;
    display: flex;
    /* flex-wrap: wrap; */
    flex-direction: column-reverse;
    width: 100%;
    align-items: baseline;
    border-top: 1px solid #c3c3c3;
    padding: 19px 0 25px 0;

    width: 100%;
}
#primary-menu li.depth-0 a.addon.Blog  {  flex-direction: row-reverse;
    align-items: center;
    justify-content: left;   gap: 22px;}
#primary-menu li.depth-0 a.addon.Blog span{ margin-left:20px;}
#primary-menu li.depth-0 a.addon{
    color: #171E37;
text-decoration: none;
font-family: "Poppins", sans-serif;
font-size: 14px;
font-style: normal;
font-weight: 400;
line-height: 22px;
}
body.bright #primary-menu li.depth-0 a.addon,body.bright #primary-menu li.depth-0 a.addon span{ color: #171E37;} 
body.bright #primary-menu li.depth-0 a, body.bright #primary-menu li.depth-0 a span{color: #fff;}
body.bright #primary-menu li.depth-1 a, body.bright #primary-menu li.depth-1 a span{color: #171E37;}
body.bright #primary-menu li.depth-2 a, body.bright #primary-menu li.depth-2 a span{color:#171E37;}
#primary-menu li.depth-0 a.addon.Blog img {max-width: 188px;height:auto;border-radius: 6px;}

#primary-menu li.depth-0 a.addon.Customers img {
    max-height: 56px;


    width: auto;
    margin-bottom: 8px;
}

li.depth-1 {flex: 1;padding-bottom: 24px;}
/*
#masthead * img {height:auto;}
*/
#util-menu li.pll-parent-menu-item{

    display: flex;
    flex-wrap: wrap;
    flex-direction: column;
    position: relative;  
    background-image: url(/wp-content/themes/incredibuild/images/Globe.png);
    padding: 10px;
    background-position: 20px 20px;
    background-repeat: no-repeat;
}
/*
#util-menu li a[href="#pll_switcher"]{     height: 120px;
    background-image: url(/wp-content/themes/incredibuild/img/earth.png);
    text-indent: -9999px;
    background-repeat: no-repeat;
    background-position: 20px 73px;}
    */
    .pll-parent-menu-item .sub-menu {    position: absolute;
    top: 64px;
    background-color: #fff;
    display: none; 
    left: 0;
   /*  width: 160%;*/
    padding: 10px;
    left: -1620%;
    width: 1270px;
    min-height: 160px;

    }
    .pll-parent-menu-item .sub-menu:before{
    content: " ";
    background: #EAEAEA;
    height: 100%;
    width: 100%;
    position: absolute;
    right: -53%;
    z-index: 1;
    top: 0;
    border-left: 1px solid #C3C3C3;
}

    .pll-parent-menu-item .sub-menu:after{
    content: " ";
    background-color: #fff;
    height: 100%;
    width: 100%;
    left: -99%;
    z-index: 0;
    position: absolute;
    top: 0;
}
    #util-menu li a[href="#pll_switcher"]{height: 40px;width: 40px;text-indent: -9999px; }
    .pll-parent-menu-item .sub-menu li {height: 30px;}
    .pll-parent-menu-item:hover  .sub-menu {display: block;}
    .pll-parent-menu-item .sub-menu a {border-bottom: none;
    height: auto;
    color: #000;
    display: inline-block;
    padding: 10px 0;
    text-decoration: none;}
    .pll-parent-menu-item:hover  .sub-menu a {border-bottom: none;
    height: auto;
    color: #000;
    display: inline-block;
    padding: 10px 0;
    text-decoration: underline;

}

.navCntnr {display:none ;}

.menu-toggle, .sub-menu-close {
    display: block;
    position: absolute;
    top: 13px;
    right: 5px;
    background: transparent;
    border: 0;
    height: 34px;
    width: 34px;
}

    @media screen and (max-width:1300px) {
        .navBlock {max-width: 1203px;}
        .sub-menu.dropdown-menu.ul-dept-0  {max-width: 1203px;}
    }

@media screen and (max-width:1000px) {
    .pll-parent-menu-item .sub-menu:before,.pll-parent-menu-item .sub-menu:after {display:none;}
    .pll-parent-menu-item .sub-menu {min-height:auto ;}
    .site-branding>a {float:left;margin-top: 6px;}
    .sub-menu.dropdown-menu.ul-dept-0:before,.sub-menu.dropdown-menu.ul-dept-0:after{display:none;}
   #site-navigation {
        position: fixed;
    top: 0;
    width: 100%;
    z-index: 1500;
    }

    .site-branding {    align-self: center;
    width: 100%;
    height: 60px;
    padding-left: 8%;
    padding-top: 22px;}
    .navCntnr {
    display: block;
    position: absolute;
    right: 30px;
    top: 10px;
}
#primary-menu-wrap {display: flex;height: auto;flex-direction: column;}


#primary-menu {
    flex-direction: column;
    background: #fff;
    width: 100%;
}
#primary-menu
#util-menu { flex-direction: column;}
.site-branding {align-self: center;width: 100%;height: 60px;background: #1E2955;}
#primary-menu li.menu-item-has-children.depth-0,#primary-menu li.depth-0 {width: 100%;
    display: flex;
    flex-direction: column;

}
#primary-menu li.depth-0 a { color: #000;width: 100%;}
#primary-menu li.menu-item-has-children.depth-0.open .sub-menu.dropdown-menu.ul-dept-0 { display: block;}
.sub-menu.dropdown-menu.ul-dept-0 {position: initial;}
.sub-menu.dropdown-menu.ul-dept-0{transform: none;}
.sub-menu.dropdown-menu.ul-dept-0 {border-top:none;}
.sub-menu.dropdown-menu.ul-dept-0 .sc {margin-left: 0;}
#primary-menu-wrap .zivwashere {padding: 0 0;}
#primary-menu {
    padding: 10px 0;
}
#primary-menu li.depth-0 a{ padding-left:30px; }
.sub-menu.dropdown-menu.ul-dept-1 {padding-left:30px;}

#primary-menu li.menu-item-has-children.depth-0 {
    padding-right:0px;}
    #primary-menu .sub-menu.dropdown-menu.ul-dept-0 li.depth-1 a {    margin-bottom: 20px;}
    #primary-menu .sub-menu.dropdown-menu.ul-dept-0 li.depth-2 a {    margin-bottom:10px;}
    #primary-menu li.menu-item-has-children.depth-0 {background-position: 96%;background-image: url(/wp-content/uploads/2023/07/menu_down.svg);}
      
            #site-navigation.n-main-navigation.menu-opened #util-menu li.pll-parent-menu-item {background-position: 96%;background-image: url(/wp-content/uploads/2023/07/menu_down.svg);}

.kav {
    height: 2px;
    background-color: #fff;
    position: relative;
    transition: 0.3s all;
    transform: rotate(0);
    z-index: 15;
}
.kav1 {
    width: 22px;
    bottom: 6px;
}
.kav2 {
    width: 22px;
}
.kav3 {
    width: 22px;
    top: 6px;
}
.menu-opened .kav1 {
    transform: rotate(45deg);
    bottom: -1px;
    width: 21px;
  }
  .menu-opened .kav2 {
    opacity: 0;
  }
  .menu-opened .kav3 {
    width: 21px;
    transform: rotate(-45deg);
    top: -3px;
  }
  #primary-menu {display:none;}
  #util-menu {display:none;flex-direction: column;background: #fff;width: 100%;padding: 10px;}
  #util-menu li.hide {display:none;}
  #site-navigation.n-main-navigation.menu-opened #primary-menu, #site-navigation.n-main-navigation.menu-opened #util-menu  {display:flex;}
  #util-menu li.pll-parent-menu-item {width:100%;}
  .pll-parent-menu-item:hover .sub-menu {
    display: unset ;
}
#util-menu li a[href="#pll_switcher"] {text-indent: unset; color: #000;  visibility: hidden;
    position: relative;}
    #util-menu li a[href="#pll_switcher"]:after {
    visibility: visible;
    position: absolute;
    top: 0;
    left: 0;
  content: 'Language';
  padding-left: 19px;
}
#util-menu li.open a[href="#pll_switcher"]:after { padding-left: 9px;}
.pll-parent-menu-item .sub-menu {position: unset;}
#util-menu li.pll-parent-menu-item .sub-menu {display: none;}

#util-menu li.pll-parent-menu-item.open .sub-menu  {display:block;}

.n-main-navigation.menu-opened{
    height: 100%;
    position: absolute;
    width: 100%;
    background: #fff;
    overflow: scroll;
    top: 0;
    left: 0;
    z-index: 100000;
}
#site-navigation.n-main-navigation.menu-opened #util-menu {width:100%;}
#site-navigation.n-main-navigation.menu-opened #util-menu li  {width:100%;}
#site-navigation.n-main-navigation.menu-opened #util-menu li.button-l a {width:100%;box-sizing: border-box;}
}


#primary-menu .active, .dot:hover {    background-color: transparent;}

</style>

<?php
//Global GTM Code (Requested by Wang Hao)
?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PKBHC42"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php
// Google Tag Manager
if(is_chinese_site()) {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KQVSND3"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
} else {
    ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NS2B6X4"
                height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->
    <?php
}
?>


<?php
    if(!is_page_template('page-templates/survey-lp.php') && (!is_singular('landing_page') || (is_singular('landing_page') && get_field('display_site_header') == true))) :
?>
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'incredibuild' ); ?></a>
	<?php floating_bar(); ?>
	<header id="masthead-n" class="site-header">
<div id="primary-menu-wrap-wrap">
        <div class="navBlock">
		<!-- .site-branding -->

		<nav id="site-navigation" class="n-main-navigation" aria-label="Main Navigation">
	
   
    <div class="navCntnr">
    <button class="sub-menu-close" aria-controls="opened-sub-menu" aria-label="<?php esc_html_e( 'Close Sub-Menu', 'incredibuild' ); ?>"></button>
			<button class="menu-toggle" aria-controls="primary-menu-wrap" aria-expanded="false" aria-label="<?php esc_html_e( 'Open Primary Menu', 'incredibuild' ); ?>">
                <div class="kav kav1"></div>
                <div class="kav kav2"></div>
                <div class="kav kav3"></div>
            </button>
            </div>
            
            <div id="primary-menu-wrap">
            <div class="site-branding">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="Go to homepage">
				<img src="<?php echo get_stylesheet_directory_uri().'/images/incredibuild_logo.svg'; ?>" alt="Incredibuild" aria-label="Incredibuild Company Logo">
			</a>
		</div>
                <?php
                                  wp_nav_menu(
                                    array(
                                        'theme_location' => 'menu-1',
                                        'menu_id'        => 'primary-menu',
                                        'container' => 'ul',
                                        'walker'		 => new My_Custom_Nav_Walker()
                                   )
                                );
                ?>

<?php
                                  wp_nav_menu(
                                    array(
                                        'theme_location' => 'utils',
                                        'menu_id'        => 'util-menu',
                                        'container' => 'ul'
                                   )
                                );
                ?>
            </div>
     
		</nav> 
        </div></div>
	</header><!-- #masthead -->

<?php
    endif;
  
?>