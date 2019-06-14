<!-- BEGIN::Foot -->
<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>
<!-- end::Scroll Top -->

<!-- begin::Quick Nav -->
<ul class="m-nav-sticky" style="margin-top: 30px;">
    <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Activation" data-placement="left">
        <a href="/contract/shopping-cart"><i class="la la-cart-arrow-down"></i></a>
    </li>
    <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Documentation" data-placement="left">
        <a href="https://keenthemes.com/metronic/documentation.html" target="_blank"><i class="la la-code-fork"></i></a>
    </li>
    <li class="m-nav-sticky__item" data-toggle="m-tooltip" title="Support" data-placement="left">
        <a href="https://keenthemes.com/forums/forum/support/metronic5/" target="_blank"><i class="la la-life-ring"></i></a>
    </li>
</ul>
<!-- begin::Quick Nav -->

<!--begin::Global Theme Bundle -->
<script src="{{ asset('metronic/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{ asset('metronic/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>
<!--end::Global Theme Bundle

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
-->

<!-- Javascript Files -->
<script type="text/javascript" src="{{ asset('raleway/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/jquery.easing.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/jquery.mixitup.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/scrollReveal.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/owl.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/jquery.magnific-popup.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/jquery.snippet.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/jquery.fitvids.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/style-switcher.js')}}"></script><!-- Remove for production -->
<script type="text/javascript" src="{{ asset('raleway/js/activate-snippet.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/skrollr.min.js')}}"></script>

<!-- On Scroll Animations - scrollReveal.js -->
<script>
    var config = {
        easing: 'hustle',
        mobile:  true,
        delay:  'onload'
    }
    window.sr = new scrollReveal( config );
</script>

<!-- Slider Revolution JS -->
<script type="text/javascript" src="{{ asset('raleway/revolution/js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/jquery.themepunch.revolution.min.js')}}"></script>

<!-- Slider Revolution Extensions (Load Extensions only on Local File Systems The following part can be removed on Server for On Demand Loading) -->
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.actions.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.carousel.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.kenburn.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.layeranimation.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.migration.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.parallax.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/revolution/js/extensions/revolution.extension.video.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('raleway/js/main.js')}}"></script>

<!-- Slider Revolution Main -->
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery("#slider1").revolution({
            sliderType:"standard",
            startDelay:2500,
            spinner:"spinner2",
            sliderLayout:"auto",
            viewPort:{
                enable:false,
                outof:'wait',
                visible_area:'100%'
            }
            ,
            delay:9000,
            navigation: {
                keyboardNavigation:"off",
                keyboard_direction: "horizontal",
                mouseScrollNavigation:"off",
                onHoverStop:"off",
                arrows: {
                    style:"erinyen",
                    enable:true,
                    hide_onmobile:true,
                    hide_under:600,
                    hide_onleave:true,
                    hide_delay:200,
                    hide_delay_mobile:1200,
                    left: {
                        h_align:"left",
                        v_align:"center",
                        h_offset:30,
                        v_offset:0
                    },
                    right: {
                        h_align:"right",
                        v_align:"center",
                        h_offset:30,
                        v_offset:0
                    }
                }
                ,
                touch:{
                    touchenabled:"on",
                    swipe_treshold : 75,
                    swipe_min_touches : 1,
                    drag_block_vertical:false,
                    swipe_direction:"horizontal"
                }
                ,
                bullets: {
                    enable:true,
                    hide_onmobile:true,
                    hide_under:600,
                    style:"hermes",
                    hide_onleave:true,
                    hide_delay:200,
                    hide_delay_mobile:1200,
                    direction:"horizontal",
                    h_align:"center",
                    v_align:"bottom",
                    h_offset:0,
                    v_offset:30,
                    space:5
                }
            },
            gridwidth:1240,
            gridheight:497
        });
    });
</script>

<!-- END::Foot -->