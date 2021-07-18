
<!-- footer  -->
<script src="{{asset('js/jquery-3.4.1.min.js') }}"></script>
<!-- popper js -->
<script src="{{asset('js/popper.min.js') }}"></script>
<!-- bootstarp js -->
<script src="{{asset('js/bootstrap.min.js') }}"></script>
<!-- sidebar menu  -->
<script src="{{asset('js/metisMenu.js') }}"></script>
<!-- waypoints js -->
<script src="{{asset('vendors/count_up/jquery.waypoints.min.js') }}"></script>
<!-- waypoints js -->
<script src="{{asset('vendors/chartlist/Chart.min.js') }}"></script>
<!-- counterup js -->
<script src="{{asset('vendors/count_up/jquery.counterup.min.js') }}"></script>

<!-- nice select -->
<script src="{{asset('vendors/niceselect/js/jquery.nice-select.min.js') }}"></script>
<!-- owl carousel -->
<script src="{{asset('vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>

<!-- responsive table -->
<script src="{{asset('vendors/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('vendors/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('vendors/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('vendors/datatable/js/buttons.flash.min.js') }}"></script>
<script src="{{asset('vendors/datatable/js/jszip.min.js') }}"></script>
<script src="{{asset('vendors/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{asset('vendors/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{asset('vendors/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{asset('vendors/datatable/js/buttons.print.min.js') }}"></script>

<!-- datepicker  -->
<script src="{{asset('vendors/datepicker/datepicker.js') }}"></script>
<script src="{{asset('vendors/datepicker/datepicker.en.js') }}"></script>
<script src="{{asset('vendors/datepicker/datepicker.custom.js') }}"></script>

<script src="{{asset('js/chart.min.js') }}"></script>
<script src="{{asset('vendors/chartjs/roundedBar.min.js') }}"></script>

<!-- progressbar js -->
<script src="{{asset('vendors/progressbar/jquery.barfiller.js') }}"></script>
<!-- tag input -->
<script src="{{asset('vendors/tagsinput/tagsinput.js') }}"></script>
<!-- text editor js -->
<script src="{{asset('vendors/text_editor/summernote-bs4.js') }}"></script>
<script src="{{asset('vendors/am_chart/amcharts.js') }}"></script>

<!-- scrollabe  -->
<script src="{{asset('vendors/scroll/perfect-scrollbar.min.js') }}"></script>
<script src="{{asset('vendors/scroll/scrollable-custom.js') }}"></script>

<!-- vector map  -->
<script src="{{asset('vendors/vectormap-home/vectormap-2.0.2.min.js') }}"></script>
<script src="{{asset('vendors/vectormap-home/vectormap-world-mill-en.js') }}"></script>

<!-- apex chrat  -->
<script src="{{asset('vendors/apex_chart/apex-chart2.js') }}"></script>
<script src="{{asset('vendors/apex_chart/apex_dashboard.js') }}"></script>

<script src="{{asset('vendors/echart/echarts.min.js') }}"></script>


<script src="{{asset('vendors/chart_am/core.js') }}"></script>
<script src="{{asset('vendors/chart_am/charts.js') }}"></script>
<script src="{{asset('vendors/chart_am/animated.js') }}"></script>
<script src="{{asset('vendors/chart_am/kelly.js') }}"></script>
<script src="{{asset('vendors/chart_am/chart-custom.js') }}"></script>
<!-- custom js -->
<script src="{{asset('js/dashboard_init.js') }}"></script>
<script src="{{asset('js/custom.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert', 'info') }}";
    console.log(type);


    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif

</script>