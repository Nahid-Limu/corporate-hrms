{{ Html::script('corporate/js/jquery-1.10.2.min.js') }}
{{ Html::script('corporate/js/jquery-migrate-1.2.1.min.js') }}
{{ Html::script('corporate/js/jquery-ui.js') }}
{{ Html::script('corporate/vendors/bootstrap/js/bootstrap.min.js') }}
{{ Html::script('corporate/vendors/bootstrap-toggle/js/bootstrap-toggle.js') }}
{{ Html::script('corporate/js/datatable.js') }}
{{ Html::script('corporate/vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js') }}
{{ Html::script('corporate/js/html5shiv.js') }}
{{ Html::script('corporate/js/respond.min.js') }}
{{ Html::script('corporate/vendors/metisMenu/jquery.metisMenu.js') }}
{{ Html::script('corporate/vendors/slimScroll/jquery.slimscroll.js') }}
{{ Html::script('corporate/vendors/jquery-cookie/jquery.cookie.js') }}
{{ Html::script('corporate/vendors/iCheck/icheck.min.js') }}
{{ Html::script('corporate/vendors/iCheck/custom.min.js') }}
{{ Html::script('corporate/vendors/jquery-news-ticker/jquery.news-ticker.js') }}
{{ Html::script('corporate/js/jquery.menu.js') }}
{{ Html::script('corporate/vendors/jquery-pace/pace.min.js') }}
{{ Html::script('corporate/vendors/holder/holder.js') }}
{{ Html::script('corporate/vendors/responsive-tabs/responsive-tabs.js') }}
{{ Html::script('corporate/js/main.js') }}
{{ Html::script('corporate/js/select2.js') }}
{{ Html::script('corporate/vendors/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
{{ Html::script('corporate/vendors/bootstrap-daterangepicker/daterangepicker.js') }}
{{ Html::script('corporate/vendors/moment/moment.js') }}
{{ Html::script('corporate/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}
{{ Html::script('corporate/vendors/bootstrap-timepicker/js/bootstrap-timepicker.js') }}
{{ Html::script('corporate/js/sweetalert.min.js') }}
{{ Html::script('corporate/vendors/nicescrollbar/js/jquery.nicescroll.min.js') }}
{{ Html::script('corporate/js/scroll_bar.js') }}



<script>
  {{--  $(window).load(function(){

	 $('[data-toggle="tooltip"]').tooltip();
	var url = window.location;
	$('ul.nav li').removeClass('active');
	$('ul.nav a[href="'+ url +'"]').parents('li').addClass('active');
  });  --}}

//	$('.modal').on('show.bs.modal', function (e) {
//	   $('.modal .modal-dialog').attr('class', 'modal-dialog  flipInY animated');
//	})
//	$('.modal').on('hide.bs.modal', function (e) {
//	 $('.modal .modal-dialog').attr('class', 'modal-dialog  flipOutY  animated');
//	})

  $(".scroll-body").niceScroll({
	  cursorwidth:12,
	  cursoropacitymin:0.4,
	  cursorcolor:'#707E97',
	  cursorborder:'none',
	  cursorborderradius:4,
	  autohidemode:'leave',

  });
  {{--  $(".scroll_body_sidebar").niceScroll({
	cursorwidth:12,
	cursoropacitymin:0.4,
	cursorcolor:'#707E97',
	cursorborder:'none',
	cursorborderradius:4,
	autohidemode:'leave',

});  --}}


  
	$("#profile-form-type").click(function(){
	  $("#profile-form-content").toggle();
	});
	$("#profile-form-type-1").click(function(){
		$("#profile-form-content-1").toggle();
	});
	$("#profile-form-type-2").click(function(){
		$("#profile-form-content-2").toggle();
	});  
 
</script>


