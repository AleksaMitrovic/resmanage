$(document).ready(function(){
  //InputMask
	$("#phone_number_1").mask("(+)381-061-999-9999");
  //iCheck Plugin
    $('.radio-price-type input').on('ifUnchecked ifCreated', function(event){
		var vis_id = 1;
      if(this.id === "fixed-type")
      	vis_id = !vis_id;
      $('#fixed-price').prop('disabled',!vis_id);
      $('#hourly-price').prop('disabled',vis_id); 
      $('#hours-per-week').prop('disabled',vis_id);
      
      if(vis_id == 0){
      	$('#fixed-price').val("");
      }
      else{
      	$('#hourly-price').val("");
        $('#hours-per-week').val("");
        $('#reportrange').attr('disabled','')
      }
    }).iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });

    $('.radio-company-type input').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'iradio_square-red',
      increaseArea: '20%'
    });
/*  
    $('.radio-project-status input').iCheck({
      checkboxClass: 'icheckbox_square-red',
      radioClass: 'iradio_square-red',
      increaseArea: '20%'
    });
*/
    //daterangepicker
    
    var end = moment().add(290, 'days');
    var start = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $("input[name='start_at']").val(start.format('YYYY-MM-DD HH:mm:ss'));
        $("input[name='end_at']").val(end.format('YYYY-MM-DD HH:mm:ss'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end
    }, cb);

    cb(start, end);
    
   $("input[name='date_end_picker']").daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 1930,
      maxYear: parseInt(moment().format('YYYY'),10) + 10
    }, function(start, end, label) {
      $("input[name='pro_end_date']").val(start.format('YYYY-MM-DD HH:mm:ss'));
    });
    $("input[name='tax_date_picker']").daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 1930,
      maxYear: parseInt(moment().format('YYYY'),10) + 10
    }, function(start, end, label) {
      $("input[name='taxed_date']").val(start.format('YYYY-MM-DD'));
    });
    $("input[name='report_date_picker']").daterangepicker({
      singleDatePicker: true,
      showDropdowns: true,
      minYear: 1930,
      maxYear: parseInt(moment().format('YYYY'),10) + 10
    }, function(start, end, label) {
      window.location.href = start.format('YYYY-MM-DD');
    });
    //Menu Scroll
    function stickyMenu(){
      $(window).scrollTop()>75?$(".c-layout-header-fixed").addClass("c-page-on-scroll"):$(".c-layout-header-fixed").removeClass("c-page-on-scroll");
    }
    $(window).scroll(function(){stickyMenu()});
    //Page translation
});