$(document).ready(function() {
    app.init();
});

var app = {

    init: function() {
        var setup = this.setup;

        switch(pageID) {
            case 'home':
                setup.homepage();
            break;
            case 'aboutpage':
                setup.aboutpage();
                setup.buildingLocationMaps();
            break;
            case 'locationpage':
                setup.locationpage();
                setup.buildingLocationMaps();
            break  
            case 'location.show':
                setup.selectedbuildingpage();
                setup.buildingLocationMaps();       
            break;
            case 'location.reservation':
                setup.buildingLocationMaps();       
            break;
            case 'gallerypage':
                setup.gallerypage();       
            break;

            default: 
                setup.homepage();
                break;
        }

        setup.bindEvents();
        setup.vendors();

        app.generalAnimation.fadeinOnload();
    },

    setup: {

        controller: new ScrollMagic.Controller(),

        homepage: function() {

            initBannerSlider();
            initTabClick();
            initTabContentSlider();
            initBuildingImageSlider();
            initAmenitiesSlider();
            initFrame4BuildingSlider();
            initScrollableY();

            function initScrollableY()
            {
                if($(".tab__header > .tab__header_item").length >= 7) {
                    $(".tab__header").addClass('scroll-y');
                }
            }

            function initBannerSlider()
            {
                let slider = $('.banner__slider');

                slider.slick(app.slick.default(arrow = false, dots = true, prev = '',next = '',autoplay = true, fade = true));
            }

            function initTabClick(){
                
                var tab_btn = $('.building__tabs .tab__header_item'),
                    tab_content = $('.tab__content_item');


                /*Add active class on first tab */
                tab_btn.first().addClass('active');
                tab_content.first().show();

                tab_btn.on('click', function(){

                    /* Tab button */
                    let selected_btn = $(this).addClass('active');
                    tab_btn.not(selected_btn).removeClass('active');

                    /* Tab content */
                    let tab_id = $(this).data('tab-id');
                    let selected_content = $('.tab__content_item[data-tabcontent-id='+tab_id+']');
                    selected_content.show()
                    $('.tab__content_item').not(selected_content).hide();   

                    // Manually refresh positioning of slick
                    $('.tab__content_slider .slick-track, .tab__content_slider .slick-active').css({'width':'100%'});
                    $('.tab__content_slider').slick('setPosition'); 
                });
            }

            function initTabContentSlider()
            {
                // let slider = $('.tab__content_slider');
                // let sliderHolder = $('.tab__content');

                // slider.slick(app.slick.default(arrow = false, dots = true, autoplay = false));
                
                $('.tab__content_slider').slick({
                  infinite: true,
                  slidesToShow: 1,
                  slidesToScroll: 1,
                  arrows: true,
                  nextArrow: '<i class="ion ion-chevron-right"></i>',
                  prevArrow: '<i class="ion ion-chevron-left"></i>',
                });
                
                

                // $('#prev').click(function(){
                //     $('.tab__content_slider').slick('slickPrev');
                // })

                // $('#next').click(function(){
                //   $('.tab__content_slider').slick('slickNext');
                // })
            }

            function initBuildingImageSlider()
            {
                let slider = $('.building_img_slider');
                let sliderHolder = $('.tab__content_img_col');

                slider.slick(app.slick.default(arrow = false,prev = '',next = '',autoplay = true));
            }

            function initAmenitiesSlider()
            {
                let slider = $('.amenities__icons_slider');
                let sliderHolder = $('.amenities__icons');

                slider.slick(app.slick.default(arrow = true, dots = false, prev = $('#prev',sliderHolder), next = $('#next',sliderHolder), autoplay = true, fade = false, rows = 6));
            }

            function initFrame4BuildingSlider()
            {
                let slider = $('#homepage .frame4__left_slider');
                let sliderHolder = $('#homepage .frame4');
                
                slider.slick(app.slick.default(arrow = false, dots = true, prev = $('#prev',sliderHolder), next = $('#next',sliderHolder), autoplay = true, fade = true, rows = 1));

            }

        },

        aboutpage: function(){},

        locationpage: function(){},

        selectedbuildingpage: function(){

            let location_image = $('#selected_building_page .location__image');

            location_image.hover(function(){

                $('.location__image .dim').removeClass('show');
                $('.location__image .dim').not($(this).find('.dim')).addClass('show');
            }, function(){
                $('.location__image .dim').removeClass('show');
                
            });
        },

        gallerypage: function(){
        },

        buildingLocationMaps: function(){

            /* Pass all buidings data */
            var locations = $all_buildings;
            
            /* Initialize first locations */
            var myLat = locations[0].latitude,
                myLng = locations[0].longitude;

            /* Map pins */
            var red_pin = 'images/pin/pin-red.svg',
                gray_pin = 'images/pin/pin-gray.svg';
            
            var marker,
                infowindow = new google.maps.InfoWindow();

            
            loadFirstLocation();

            /* Load first location */
            function loadFirstLocation() {

                var map = new google.maps.Map(document.getElementById('building_location_map'), {
                    zoom: 15,
                    center: {lat: myLat, lng: myLng},
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                loadLocationMarkers(locations, map);
            }

            function loadLocationMarkers(locations, map)
            {
                for (var i = 0; i < locations.length; i++) {  

                    marker = new google.maps.Marker({
                    map: map,
                    animation: google.maps.Animation.DROP,
                    position: {lat: locations[i].latitude, lng: locations[i].longitude},
                    icon: renderPinColor(locations[i].availability)
                    });
                
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                        infowindow.setContent(locations[i].name);
                        infowindow.open(map, marker);
                    }
                    })(marker, i));
                
                }
            }

            function renderPinColor(availability)
            {
                let available = 1, comingsoon = 0;

                if (availability == available) return red_pin;
                else if(availability == comingsoon)  return gray_pin;
            }

        },

        bindEvents: function() {


            initImageLazyLoad();
            initOnScroll();
            initMenuDropdown();
            initNavIcon();
            initDisableContactNumberUpDownKeys();
            initGalleryPage();

            function initDisableContactNumberUpDownKeys() {
                
                // Disable up and down keys.
                $('.contact_no').on('keydown', function(e) {
                    if ( e.which == 38 || e.which == 40 )
                        e.preventDefault();
                });  
            }


            function initNavIcon(){
                
                $('#nav-icon1').click(function(){
                    $(this).toggleClass('open');

                    if (pageID == 'locationpage' || pageID == 'location.show')
                    {
                        $('#nav-icon1 span').toggleClass('bg-dark-blue');   
                    }
                    
                    $('.mobile__panel').toggleClass('show');
                    $('header .location__route .svg__logo .cls-1').toggleClass('open');
                });
            }

            function initMenuDropdown(){

                let btn = $('.location__dropdown_icon').on('click', function(){
                    $(this).toggleClass('show');
                    $(this).parent().find('.location__dropdown_content').fadeToggle('fast');
                });
            }

            function initOnScroll() {

                $(window).on('scroll', function(e) {
                    var self = $(this),
                    height = self.height(),
                    top = self.scrollTop();
                    height = $('.frame1').height();

                    // if($(window).width() > 768) {

                        if (top >= height) {
                            $('header').addClass('on-scroll');
                        } else {
                            $('header').removeClass('on-scroll');
                        }
                    // }
                    
                });
            }


            function initImageLazyLoad(){

                const observer = lozad();
                observer.observe();
            }

            function initGalleryPage() {
                $('.building__item').lightGallery({
                    selector:'.building__img',
                    exThumbImage: 'data-src',
                    thumbnail:true,
                    animateThumb: true,
                    showThumbByDefault: true
                });
            }

            
        },
        vendors: function() {},

        contact: function() {

            var marker,
                myLat = 14.90285713048802,
                myLng = 120.85237118924172;

            var pin = {
                url: 'themes/main/images/pin.png', // url
                scaledSize: new google.maps.Size(200, 75), // scaled size
                // origin: new google.maps.Point(0,0), // origin
                // anchor: new google.maps.Point(0, 0) // anchor
            };

            initMap();
            
            app.form.init($('#contactForm'), $('#contactBtn'), 'form/contact/send');


            function initMap() {


              var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 18,
                center: {lat: myLat+ 0.00025, lng: myLng}
              });

              marker = new google.maps.Marker({
                map: map,
                draggable: false,
                animation: google.maps.Animation.DROP,
                position: {lat: myLat, lng: myLng},
                icon: pin
              });
              marker.addListener('click', toggleBounce);

            }

            function toggleBounce() {
              if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
              } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
              }
            }

        },
    },

    generalAnimation: {
        /**
        * ANIMATION: Fade in effect on page load.
        * - To take effect, add this classname: js-fadeIn-onload
        **/
        fadeinOnload: function() {

            $('.js-fadeIn-onload').each(function() {
                var tl = new TweenMax.fromTo(this, 0.6, 
                    {opacity: 0, y: 35, transformOrigin: "bottom", transformStyle: "preserve-3d"}, 
                    // {opacity: 0, y: 25, transformOrigin: "top", transformStyle: "preserve-3d", ease: Power1.easeIn}, 
                    {opacity: 1, y: 0, ease: Power1.easeOut})
                    // {opacity: 1, y: 0, ease: Power1.easeOut})

                var scene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: 1,
                    reverse: true,
                })
                .setTween(tl)
                .addTo(app.setup.controller)
            });
        },

        /**
        * ANIMATION: Fade in effect
        * - To take effect, add this classname: js-fadeIn
        **/
        fadein: function() {
            $('.js-fadeIn').each(function() {
                var tl = new TweenMax.fromTo(this, 0.6, 
                    {opacity: 0, y: 35, transformOrigin: "bottom", transformStyle: "preserve-3d"}, 
                    // {opacity: 0, y: 25, transformOrigin: "top", transformStyle: "preserve-3d", ease: Power1.easeIn}, 
                    {opacity: 1, y: 0, ease: Power1.easeOut})
                    // {opacity: 1, y: 0, ease: Power1.easeOut})

                var scene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .8,
                    reverse: true,
                })
                .setTween(tl)
                .addTo(app.setup.controller)
            });

        },

        /**
        * ANIMATION: Continuous fade in & scale effect
        * - To take effect, add these classnames: 
                js-staggerTrigger (holder/container)
                js-staggerZoom (element)
        **/
        staggerFadeZoom: function() {
            $('.js-staggerTrigger').each(function() {
                var icon = $(this).find('.js-staggerZoom');
                var tween = new TimelineMax().staggerTo(icon, 0.7, {opacity: 1, scale: 1, ease: Power1.ease}, 0.12);

                var scene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: 0.5,
                    reverse: true,  
                })
                .setTween(tween)
                .addTo(app.setup.controller)
            });

        },

        animateScale: function(){

            $('.animate-opacity').each(function() {
                var tl = new TimelineMax({force3D:true})
                .fromTo(this, 3,
                    { opacity: 0, ease:Power0.easeIn },
                    { opacity: 1, ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .7,
                    })
                    .setTween(tl)
                    .addTo(app.setup.controller);
            });

            $('.animate-right').each(function() {

                var tl = new TimelineMax({force3D:true})
                .fromTo(this, 2,
                    { x: "-30%", opacity: 0, ease:Power0.easeIn },
                    { x: "0%", opacity:1, ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .7,
                    })
                    .setTween(tl)
                    .addTo(app.setup.controller);
            });

            $('.animate-left').each(function() {

                var tl = new TimelineMax({force3D:true})
                .fromTo(this, 2,
                    { x: "30%", opacity: 0, ease:Power0.easeIn },
                    { x: "0%", opacity:1, ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .7,
                    })
                    .setTween(tl)
                    .addTo(app.setup.controller);
            });
            
            $('.animate-width').each(function() {
                var tl = new TimelineMax({force3D:true})
                .fromTo(this, 3,
                    { width: "0%", ease:Power0.easeIn },
                    { width: "60%", ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .7,
                    })
                    .setTween(tl)
                    .addTo(app.setup.controller);
            });

            $('.animate-width-50').each(function() {
                var tl = new TimelineMax({force3D:true})
                .fromTo(this, 3,
                    { width: "0%", ease:Power0.easeIn },
                    { width: "50%", ease:Power0.easeIn })

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .7,
                    })
                    .setTween(tl)
                    .addTo(app.setup.controller);
            });

            $('.animate-stagger-holder').each(function() {
            var tl = new TimelineMax({repeat:0, repeatDelay:0.5, force3D:true});
            tl.staggerFrom(".animate-stagger-item", 0.5, {scale:0}, 0.5,)
              .staggerTo(".animate-stagger-item", 0.5, {scale:1}, 0.5,)

                var fadeScene = new ScrollMagic.Scene({
                    triggerElement: this,
                    triggerHook: .7,
                    })
                    .setTween(tl)
                    .addTo(app.setup.controller);
            });

        },


        /**
        * ANIMATION: Parallax Effect
        * - To take effect, add this classname: js-parallax 
        **/
        parallax: function() {
            $('.js-parallax').each(function(index, elem) {
                var parallaxTl = new TimelineMax()
                    .set(elem, {y: "50%", transformStyle: "preserve-3d"})
                    .to(elem, 1, {y: "0%", ease: Power0.easeNone})


                app.scrollMagic.duration(elem, 1, "150%", parallaxTl);


                // var scene = new ScrollMagic.Scene({
                //     triggerElement: elem,
                //     triggerHook: 1,
                //     duration: '150%',
                //     reverse: true,
                // })
                // .setTween(tl.to(elem, 1, { y: '0%', ease:Power0.easeNone}))
                // .addTo(app.setup.controller);
            });
        },

        /**
        * ANIMATION: Specifically, for floating button (back to top).
        * - To take effect, add this id: floatingBtn 
        * - Specify the destination when clicked.
        **/
        floatingBtn: function() {
            var tween = TweenMax.from("#floatingBtn", 0.3, {autoAlpha: 0, scale: 0.7});

            var scene = new ScrollMagic.Scene({triggerElement: "#floatingBtn"})
                .setTween(tween)
                .setPin("#floatingBtn")
                .addTo(app.setup.controller);

            $('#floatingBtn').click(function() {
                TweenMax.to(window, 0.5, {scrollTo: {y: '.frame', offsetY: 150}});
            });
        },
    },

    slick: {
        default: function(arrowsBool, dotsBool, prev, next, autoplay = true, fade = false, rows = 1) {
            return {
                rows: rows,
                arrows: arrowsBool,
                dots: dotsBool,
                infinite: true,
                fade:fade,
                // cssEase: 'linear',
                speed: 800,
                autoplay: autoplay,
                autoplaySpeed: 5000,
                slidesToShow: 1,
                slidesToScroll: 1,
                prevArrow: prev,
                nextArrow: next,
                //optional: to change the dots into numbers.
            }
        },

        byTwo: function(prev, next) {
            return {
                dots: false,
                arrows: true,
                infinite: false,
                speed: 800,
                autoplay: true,
                autoplaySpeed: 5000,
                slidesToShow: 2,
                slidesToScroll: 1,
                focusOnSelect: true,
                pauseOnFocus: true,
                prevArrow: prev,
                nextArrow: next,
                responsive: [
                    {
                        breakpoint: 695,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }   
                    }
                ]
            }
        },

        byThree: function(prev, next, centerBool) {
            return {
                centerMode: centerBool,
                centerPadding: 0,
                dots: false,
                arrows: true,
                infinite: false,
                speed: 800,
                autoplay: true,
                autoplaySpeed: 5000,
                slidesToShow: 3,
                slidesToScroll: 1,
                focusOnSelect: true,
                pauseOnFocus: true,
                prevArrow: prev,
                nextArrow: next,
                responsive: [
                    {
                        breakpoint: 1100,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }   
                    },
                    {
                        breakpoint: 801,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }   
                    },
                    {
                        breakpoint: 401,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }   
                    }
                ]
            }
        },

        byFour: function(prev, next) {
            return {
                dots: false,
                arrows: true,
                infinite: false,
                speed: 800,
                autoplay: true,
                autoplaySpeed: 5000,
                slidesToShow: 4,
                slidesToScroll: 1,
                focusOnSelect: true,
                pauseOnFocus: true,
                prevArrow: prev,
                nextArrow: next,
                responsive: [
                    {
                        breakpoint: 1100,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }   
                    },
                    {
                        breakpoint: 801,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }   
                    },
                    {
                        breakpoint: 401,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }   
                    }
                ]
            }
        },

        byFive: function(prev, next) {
            return {
                dots: false,
                arrows: true,
                infinite: false,
                speed: 800,
                autoplay: true,
                autoplaySpeed: 5000,
                slidesToShow: 5,
                slidesToScroll: 1,
                focusOnSelect: true,
                pauseOnFocus: true,
                prevArrow: prev,
                nextArrow: next,
                responsive: [
                    {
                        breakpoint: 1100,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 1
                        }   
                    },
                    {
                        breakpoint: 801,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }   
                    },
                    {
                        breakpoint: 401,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }   
                    }
                ]
            }
        },
    },

    form: {
        /**
        * SENDING FORM
        * - Identify the form name, button name, the url (controller route), and if you want to 'refresh' the page. 
        **/
        init: function(formName, btnName, routeVal, boolean) {
            var form = formName,
                btn = btnName,
                route = routeVal,
                bool = boolean;

            form.validate({
                submitHandler: function(form) {
                    swal({
                        title: 'Sending ...',
                        text: 'Please wait.',
                        // timer: 2000,
                        onOpen: function () {
                            swal.showLoading()
                        }
                    })
                    var vars = $(form).serialize();
                    $.post(baseHref + route, vars, function(data) {
                        switch(data.status) {
                            case 0:
                                setMessage(false,data.message);
                            break;
                            case 1: 
                                setMessage(true,data.message);
                                $(form).trigger('reset');
                                if(bool == true) {
                                    setTimeout(function(){
                                       window.location.reload(1);
                                    }, 2200);
                                }

                            break;
                        }

                    }, 'json');
                }
            });

            $(btn).on('click', function(e) {
                e.preventDefault();
                form.submit();
            });

            function setMessage(status, msg) {
                if(status) {
                    swal('',msg,'success')
                } else {
                    swal('',msg,'error')
                }
            }
        },
    },  
};