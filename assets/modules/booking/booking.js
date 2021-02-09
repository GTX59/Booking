$(function(){
		var today = truncateDate(new Date());
		var max= new Date;
		max.setDate(max.getDate() + plusdays);
		var active=today;
		pickmeup.defaults.locales['ru'] = {
			days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
			daysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
			daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
			months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
			monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек']
		};
		pickmeup('.calendar', {
			flat : true,
			calendars : calendars,
			format	: 'd-m-Y',
			locale : 'ru',
			min : today,
			max : max,
			render : function (date) {
				if (holidays.indexOf(date.getDate()+'-'+(date.getMonth()+1))>-1){
					return {disabled : true, class_name : 'pmu-holiday'}
				}
				if (weekends.indexOf(date.getDay())>-1){
					return { disabled : true, class_name : 'pmu-weekend'}
				}
				return {};
			}
		});
		booktimes('.booktimes',active.getDay());
		let $times=$('.booktimes1 span');
		getbooking(active);
		$('.calendar').on('pickmeup-change', function (e) {
			active=e.detail.date;
			getbooking(active);
			booktimes('.booktimes',active.getDay());
			$times=$('.booktimes1 span');
			getbooking(active);
		});
		if(manager){
			$(document).on('click','.booktimes1 span',function(){
				let map='';
				let day=active.getDay();
				$(this).toggleClass('disabled');
				for(var i=0;i<$times.length;i++){
					if($times.eq(i).hasClass('disabled')){
						map+='1';
					}else{
						map+='0'
					}
				}
				$.ajax({
					type:'post',
					url:MODX_SITE_URL+'assets/modules/booking/module.php', 
					data:{record:active.getTime(),value:map},
					success:function(response){
						for (var i=0;i<$times.length;i++){
							if(response[i]==1){
								$times.eq(i).addClass('disabled');
								console.log('1 ');
							}else{
								$times.eq(i).removeClass('disabled');
								console.log('0 !');
							}
						}
					},
					error:function(){
						console.log('AJAX error recording!');
					}
				});
			});
			$('#setup').on('click',function(){
				if(!confirm('Сбросить настройки на значения по умолчанию?'))return;
				$.ajax({
					type:'post',
					url:MODX_SITE_URL+'/assets/modules/booking/module.php', 
					data:{setup:1},
					success:function(response){
						alert(response);
						window.location.reload(true);
					},
					error:function(){
						alert('AJAX error setup!');
					}
				});
			});
		}
		function getbooking(d){
			let date=d?d.getTime():now.getTime();
			console.log(date);
			$times.addClass('disabled');
			$.ajax({
				type:'post',
				url:MODX_SITE_URL+'assets/modules/booking/module.php', 
				data:{date:date},
				success:function(response){
					for (var i=0;i<$times.length;i++){
						$times.attr('data-date',active.getDate() + '-' + (active.getMonth() + 1) + '-' + active.getFullYear());
						if(response.length<$times.length || response[i]==0)$times.eq(i).removeClass('disabled');console.log('null!');
					}
				},
				error:function(){
					console.log('AJAX error getbooking!');
				}
			});
		}
		function truncateDate(date) {
			return new Date(date.getFullYear(), date.getMonth(), date.getDate());
		}
		function booktimes(el,day){
			var html='';
			intervals[day].split(',').forEach(function(item, i, arr){
				html+='<span class="disabled" data-call="#bookform" data-time="'+item+'">'+item+'</span>';
			});
			$(el).html('<div class="booktimes1">'+html+'</div>');
		}
	});
