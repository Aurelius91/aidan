/*!
        jquery.responsiveGallery.js
        v 1.0
        David
        http://www.CodingSerf.com
*/

;(function($){
    $.fn.responsiveGallery = function(option){
        var opts = $.extend({}, $.fn.responsiveGallery.defaults, option),
            $rgWrapper = this,
            $rgItems = $rgWrapper.find('li'), //.responsiveGallery-item
            $rgImage = $rgItems.find('img'),
            rgItemsLength = $rgItems.length,
            support3d = Modernizr.csstransforms3d,
            support2d = Modernizr.csstransforms,
            supportBlur = Modernizr.cssfilters,
            rgCurrentIndex = 0,
            rgShowCount = 5,
            rgTansCSS = [],
            animatDuration = opts.animatDuration,
            isAnimating = false,
            submit = false,
            touchX = 0;

//        function getTransform3dCSS(tx,ty,ry,zIndex,opacity,visibility,scale,blur){
//            return {
//                '-webkit-transform'    : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg) scale('+scale+')',
//                '-moz-transform'    : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg) scale('+scale+')',
//                '-o-transform'        : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg) scale('+scale+')',
//                '-ms-transform'        : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg) scale('+scale+')',
//                'transform'            : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg) scale('+scale+')',
//                'z-index'            : zIndex,
//                'opacity'            : opacity,
//                'visibility'        : visibility,
//                '-webkit-filter'    : 'blur('+blur+'px)',
//                'filter'            : 'blur('+blur+'px)'
//            };
//        }

            function setImageWidth(width){
//                console.log('kepanggil');
//                this.find('img').css("width", width+'%');
                $rgImage.css("width", width+'%');
            }

//        $($rgWrapper).on('touchstart touchmove', function(e){
//            prevent native touch activity like scrolling
//            e.preventDefault();
//        });


        function getTransform3dCSS(tx,ty,ry,zIndex,opacity,visibility,blur,width){
//            setImageWidth(width);
            return {
                '-webkit-transform'     : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg)',
                '-moz-transform'        : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg)',
                '-o-transform'          : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg)',
                '-ms-transform'         : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg)',
                'transform'             : 'translateX('+tx+') translateZ('+ty+'px) rotateY('+ry+'deg)',
                'z-index'               : zIndex,
                'opacity'               : opacity,
                'visibility'            : visibility,
                '-webkit-filter'        : 'blur('+blur+'px)',
                'filter'                : 'blur('+blur+'px)',
                'w'                     : width
            };
        }

        function getTransform2dCSS(t,s,originX,originY,opacity,visibility,blur,width){
            return {
                '-webkit-transform'         : 'translate('+t+') scale('+s+')',
                '-moz-transform'            : 'translate('+t+') scale('+s+')',
                '-o-transform'              : 'translate('+t+') scale('+s+')',
                '-ms-transform'             : 'translate('+t+') scale('+s+')',
                'transform'                 : 'translate('+t+') scale('+s+')',

                '-webkit-transform-origin'  : originX+' '+originY,
                '-moz-transform-origin'     : originX+' '+originY,
                '-ms-transform-origin'      : originX+' '+originY,
                '-o-transform-origin'       : originX+' '+originY,
                'transform-origin'          : originX+' '+originY,

                'opacity'                   : opacity,
                'visibility'                : visibility,
                '-webkit-filter'        : 'blur('+blur+'px)',
                'filter'                : 'blur('+blur+'px)',
                'w'                     : width
            };
        }

        function getTransitionCSS(time,ease){
            return {
                '-webkit-transition'    : 'all '+time+'s '+ease,
                '-moz-transition'       : 'all '+time+'s '+ease,
                '-ms-transition'        : 'all '+time+'s '+ease,
                '-o-transition'         : 'all '+time+'s '+ease,
                'transition'            : 'all '+time+'s '+ease,
            }
        }

        function getTransform7CSS(){
            var cssArray;

            if(support3d){
                cssArray = [
                    getTransform3dCSS('-100%',    -400,     40,    -1,    0,    'hidden', 5, 80),
                    getTransform3dCSS('0',        -350,     45,    -1,    1,    'visible', 5, 80),

                    getTransform3dCSS('100%',     -300,     45,     0,    1,    'visible', 5, 100),
                    getTransform3dCSS('200%',     -200,     40,     1,    1,    'visible', 2, 120),
                    getTransform3dCSS('300%',        0,      0,     2,    1,    'visible', 0, 170),
                    getTransform3dCSS('400%',     -200,    -40,     1,    1,    'visible', 2, 120),
                    getTransform3dCSS('500%',     -300,    -45,     0,    1,    'visible', 5, 100),

                    getTransform3dCSS('600%',     -350,    -45,    -1,    1,    'visible', 5, 80),
                    getTransform3dCSS('700%',     -400,    -40,    -1,    0,    'hidden', 5, 80)
                ];
            } else if(support2d){
                cssArray = [
                    getTransform2dCSS('-100%',    0.6,    '100%',      '50%',    0,    'hidden', 5, 80),
                    getTransform2dCSS(    '0',    0.6,    '100%',      '50%',    1,    'visible', 5, 80),

                    getTransform2dCSS('100%',     0.7,    '100%',      '50%',    1,    'visible', 5, 100),
                    getTransform2dCSS('200%',     0.8,     '50%',      '50%',    1,    'visible', 2, 120),
                    getTransform2dCSS('300%',     1,       '50%',      '50%',    1,    'visible', 0, 170),
                    getTransform2dCSS('400%',     0.8,     '50%',      '50%',    1,    'visible', 2, 120),
                    getTransform2dCSS('500%',     0.7,      '0%',      '50%',    1,    'visible', 5, 100),

                    getTransform2dCSS('600%',     0.6,      '0%',      '50%',    1,    'visible', 5, 80),
                    getTransform2dCSS('700%',     0.6,      '0%',      '50%',    0,    'hidden', 5, 80)
                ];
            }

            return cssArray;
        }

        function getTransform5CSS(){
            var cssArray;

            if(support3d){
                cssArray = [
                    getTransform3dCSS('-100%',    -400,      45,     -1,    0,    'hidden', 5, 100),

                    getTransform3dCSS('0',        -300,      45,      0,    1,    'visible', 5, 100),
                    getTransform3dCSS('100%',     -200,      45,      1,    1,    'visible', 2, 120),
                    getTransform3dCSS('200%',     0,          0,      2,    1,    'visible', 0, 170),
                    getTransform3dCSS('300%',     -200,     -45,      1,    1,    'visible', 2, 120),
                    getTransform3dCSS('400%',     -300,     -45,      0,    1,    'visible', 5, 100),

                    getTransform3dCSS('500%',     -400,     -45,     -1,    0,    'hidden', 5, 100)
                ];
            } else if(support2d){
                cssArray = [
                    getTransform2dCSS('-100%',    0.6,    '100%',     '50%',    0,    'hidden', 5, 100),

                    getTransform2dCSS('0',        0.7,    '100%',     '50%',    1,    'visible', 5, 100),
                    getTransform2dCSS('100%',     0.8,     '50%',     '50%',    1,    'visible', 2, 120),
                    getTransform2dCSS('200%',       1,     '50%',     '50%',    1,    'visible', 0, 170),
                    getTransform2dCSS('300%',     0.8,     '50%',     '50%',    1,    'visible', 2, 120),
                    getTransform2dCSS('400%',     0.7,      '0%',     '50%',    1,    'visible', 5, 100),

                    getTransform2dCSS('500%',     0.6,      '0%',     '50%',    0,    'hidden', 5, 100)
                ];
            }

            return cssArray;
        }

        function getTransform3CSS(){
            var cssArray;

            if(support3d){
                cssArray = [
                    getTransform3dCSS('-100%',    -400,     45,     0,    0,    'hidden', 2, 100),

                    getTransform3dCSS('0',        -300,     45,     1,    1,    'visible', 2, 100),
                    getTransform3dCSS('100%',        0,      0,     2,    1,    'visible', 0, 130),
                    getTransform3dCSS('200%',     -300,    -45,     1,    1,    'visible', 2, 100),

                    getTransform3dCSS('300%',     -400,    -45,     0,    0,    'hidden', 2, 100)
                ];
            } else if(support2d){
                cssArray = [
                    getTransform2dCSS('-100%',    0.65,    '100%',     '50%',    0,    'hidden', 2, 100),

                    getTransform2dCSS(    '0',     0.8,    '50%',      '50%',    1,    'visible', 2, 100),
                    getTransform2dCSS( '100%',       1,    '50%',      '50%',    1,    'visible', 0, 130),
                    getTransform2dCSS( '200%',     0.8,    '50%',      '50%',    1,    'visible', 2, 100),

                    getTransform2dCSS('300%',     0.65,    '0%',       '50%',    0,    'hidden', 2, 100)
                ];
            }

            return cssArray;
        }

        function getTransform1CSS(){
            var cssArray;

            if(support3d){
                cssArray = [
                    getTransform3dCSS('-100%',     -300,     45,      0,     0,    'hidden', 1, 100),

                    getTransform3dCSS(   '0%',        0,      0,      2,     1,    'visible', 0, 100),

                    getTransform3dCSS(  '100%',    -300,     -45,     0,     0,    'hidden', 1, 100)
                ];
            } else if(support2d){
                cssArray = [
                    getTransform2dCSS('-100%',     0.65,    '100%',      '50%',    0,    'hidden', 1, 100),

                    getTransform2dCSS(    '0',        1,     '50%',      '50%',    1,    'visible', 0, 100),

                    getTransform2dCSS( '100%',     0.65,      '0%',      '50%',    0,    'hidden', 1, 100)
                ];
            }

            return cssArray;
        }
        function setSectionItems(fun){
            var $items = [];

            $items[0] = $rgItems.eq(rgCurrentIndex-1);
            fun(0,$items[0]);
            for (var i=1;i<=rgShowCount+1;i++) {
                var next = rgCurrentIndex+i-1;
                if(next>=rgItemsLength){
                    next = next - rgItemsLength;
                }
                $items[i] = $rgItems.eq(next);
                fun(i,$items[i]);
            }
        }

        function getCenterItem(direction){
            var click = 0;

            $.each($rgItems, function(key, rgItems) {
                if (click > 0) {
                    return;
                }

                var blurValue = $(this).css('filter');
                var zIndexValue = $(this).css('z-index');

                if(supportBlur && blurValue=='blur(0px)'){
                    if(direction == 1){
                        var tempat = ($(this).next().attr('data-location') != null) ? $(this).next().attr('data-location') : $('.responsiveGallery-item').first().attr('data-location');
                        var produk = ($(this).next().attr('data-name') != null) ? $(this).next().attr('data-name') : $('.responsiveGallery-item').first().attr('data-name');

                        $('h1.product-name').text(produk+',');
                        $('h4.product-location').text(tempat);

                        click += 1;
                    }
                    else if(direction == -1){
                        var tempat = ($(this).prev().attr('data-location') != null) ? $(this).prev().attr('data-location') : $('.responsiveGallery-item').last().attr('data-location');
                        var produk = ($(this).prev().attr('data-name') != null) ? $(this).prev().attr('data-name') : $('.responsiveGallery-item').last().attr('data-name');

                        $('h1.product-name').text(produk+',');
                        $('h4.product-location').text(tempat);

                        click += 1;
                    }
                    else{
                        if ($(window).width() >1000) {
                            var tempat = $('.responsiveGallery-item').eq(2).attr('data-location');
                            var produk = $('.responsiveGallery-item').eq(2).attr('data-name');
                        }
                        else if (($(window).width() > 560) && ($(window).width()<=1000)) {
                            var tempat = $('.responsiveGallery-item').eq(1).attr('data-location');
                            var produk = $('.responsiveGallery-item').eq(1).attr('data-name');
                        }
                        else{
                            var tempat = $('.responsiveGallery-item').eq(0).attr('data-location');
                            var produk = $('.responsiveGallery-item').eq(0).attr('data-name');
                        }

                        $('h1.product-name').text(produk+',');
                        $('h4.product-location').text(tempat);
                    }
                }
                else{
                    if(zIndexValue == '2' ){
                        if(direction == 1){
                            var tempat = ($(this).next().attr('data-location') != null) ? $(this).next().attr('data-location') : $('.responsiveGallery-item').first().attr('data-location');
                            var produk = ($(this).next().attr('data-name') != null) ? $(this).next().attr('data-name') : $('.responsiveGallery-item').first().attr('data-name');
                        }
                        else if(direction == -1){
                            var tempat = ($(this).prev().attr('data-location') != null) ? $(this).prev().attr('data-location') : $('.responsiveGallery-item').last().attr('data-location');
                            var produk = ($(this).prev().attr('data-name') != null) ? $(this).prev().attr('data-name') : $('.responsiveGallery-item').last().attr('data-name');
                        }
                        else{
                            if ($(window).width() >1000) {
                                var tempat = $('.responsiveGallery-item').eq(2).attr('data-location');
                                var produk = $('.responsiveGallery-item').eq(2).attr('data-name');
                            }
                            else if (($(window).width() > 560) && ($(window).width()<=1000)) {
                                var tempat = $('.responsiveGallery-item').eq(1).attr('data-location');
                                var produk = $('.responsiveGallery-item').eq(1).attr('data-name');
                            }
                            else{
                                var tempat = $('.responsiveGallery-item').eq(0).attr('data-location');
                                var produk = $('.responsiveGallery-item').eq(0).attr('data-name');
                            }
                        }

                        $('h1.product-name').text(produk+',');
                        $('h4.product-location').text(tempat);

                    }
//                    else{
//                        alert(zIndexValue);
//                    }
                }
            });
        }

        function moveGallery(direction){
            isAnimating = true;

            rgCurrentIndex = direction + rgCurrentIndex;
            if(rgCurrentIndex < 0){
                rgCurrentIndex = rgItemsLength - 1;
            }
            if(rgCurrentIndex >= rgItemsLength){
                rgCurrentIndex = 0;
            }
            setSectionItems(function(i,$item){
                $item.css(rgTansCSS[i]);
                var css = rgTansCSS[i].w+'%';
                $item.find('.gambar').css('width', css);
            });

            setTimeout(function(){
                isAnimating = false;
            },animatDuration);

            getCenterItem(direction);
        }

        opts.$btn_next.on('click',function(e){
            !isAnimating && moveGallery(+1);
        });


//        opts.$btn_next.unbind().click(function(e) {
//            !isAnimating && moveGallery(+1);
//            e.stopPropagation();
//        });
//
//
//        opts.$btn_prev.unbind().click(function(e) {
//            !isAnimating && moveGallery(-1);
//            e.stopPropagation();
//        });

        opts.$btn_prev.on('click',function(e){
            !isAnimating && moveGallery(-1);
        });


//        $rgWrapper.on('touchstart',function(e){
        $rgItems.on('touchstart',function(e){
            var touch = e.originalEvent.touches[0];
            touchX = touch.pageX;
        }).on('touchend touchcancel',function(e){
            var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0],
                touchGap = touch.pageX - touchX;

            if(touchGap>5){ //swipe right
                opts.$btn_prev.trigger('click');
            }
            if(touchGap<-5){ //swipe left
                opts.$btn_next.trigger('click');
            }
        });

        $(window).on('resize', function(e){
            $rgItems.removeAttr('style');

            var wrapperWidth = $rgWrapper.width(),
                itemWidth = $rgItems.eq(0).width();

            rgShowCount = Math.round(wrapperWidth/itemWidth);

            if(rgShowCount === 1){
                rgTansCSS = getTransform1CSS();
            } else if(rgShowCount === 3){
                rgTansCSS = getTransform3CSS();
            } else if(rgShowCount === 5){
                rgTansCSS = getTransform5CSS();
            } else if(rgShowCount === 7){
                rgTansCSS = getTransform7CSS();
            } else {
                return;
            }

            rgCurrentIndex = 0;

            moveGallery(0);
            setTimeout(function(){
                $rgItems.css(getTransitionCSS(animatDuration/1000, 'ease-in-out'));
            },10);

        }).trigger('resize');

        return this;
    };
    $.fn.responsiveGallery.defaults = {
        animatDuration: 400,
        $btn_prev: $('.responsiveGallery-btn_prev'),
        $btn_next: $('.responsiveGallery-btn_next')
    };
})(jQuery);
