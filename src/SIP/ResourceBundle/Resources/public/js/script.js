var calendarSwiper;

// JS шаблонизатор --------------------------------------
(function(){
    var cache = {};

    this.tmpl = function tmpl(str, data){
        // Выяснить, мы получаем шаблон или нам нужно его загрузить
        // обязательно закешировать результат
        var fn = !/\W/.test(str) ?
            cache[str] = cache[str] ||
                tmpl(document.getElementById(str).innerHTML) :

            // Сгенерировать (и закешировать) функцию,
            // которая будет служить генератором шаблонов
            new Function("obj",
                "var p=[],print=function(){p.push.apply(p,arguments);};" +

                    // Сделать данные доступными локально при помощи with(){}
                    "with(obj){p.push('" +

                    // Превратить шаблон в чистый JavaScript
                    str
                        .replace(/[\r\t\n]/g, " ")
                        .split("<%").join("\t")
                        .replace(/((^|%>)[^\t]*)'/g, "$1\r")
                        .replace(/\t=(.*?)%>/g, "',$1,'")
                        .split("\t").join("');")
                        .split("%>").join("p.push('")
                        .split("\r").join("\\'")
                    + "');}return p.join('');");

        // простейший карринг(термин функ. прог. - прим. пер.)
        // для пользователя
        return data ? fn( data ) : fn;
    };
})();
// JS шаблонизатор --------------------------------------

$(function($){

	var body_var = $('body');

	$('.humburger').on('click', function(){

		body_var.toggleClass('menu_open');

		return false;
	});

});

$(window).on('load', function(){

	if($('.mason').length){
		//$('.mason').masonry({
		//	itemSelector: '.mason_box'
		//});

		var $grid = $('.mason').isotope({
			// main isotope options
			itemSelector: '.mason_box',
			// set layoutMode
			layoutMode  : 'masonry',
			// options for cellsByRow layout mode

			// options for masonry layout mode
			masonry: {
				columnWidth: '.mason_sizer'
			}
		});

	}

	/*	$('.cal_cell').on('mousemove', function(e){
	 var firedEl = $(this);

	 console.log(e);

	 firedEl.find('.cal_hover_info').show();

	 }).on('mouseleave', function(e){
	 var firedEl = $(this);

	 console.log(e);

	 firedEl.find('.cal_hover_info').hide();

	 });*/

	if($(window).width() < 1024) initCalSwiper();

});

$(window).resize(function(){

	if($('.calendar_holder').length){
		if($(window).width() > 1023){

			if(calendarSwiper !== void 0){
				calendarSwiper.destroy();
			}

			$('.calendar_holder').attr('style', '');
		} else{
			initCalSwiper();
		}
	}

});

function initCalSwiper(){

	if($('.swiper').length && calendarSwiper == void 0){

		console.log(calendarSwiper);

		calendarSwiper = new Swiper('.swiper', {
			setWrapperSize     : true,
			slidesPerView      : 'auto',
			paginationClickable: true,
			spaceBetween       : 0,
			freeMode           : true,
			wrapperClass       : 'calendar_holder',
			slideClass         : 'cal_cell',
			onDestroy          : function(swiper, e, r){
				console.log(swiper, e, r);
			}
		});
	}

}