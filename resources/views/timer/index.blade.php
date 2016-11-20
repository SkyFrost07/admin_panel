@extends('layouts.frontend')

@section('content')
<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
        <h1 class="page-header">Timer</h1>
        <hr />
        <?php
        $minute = 15;
        $second = 0;
        if ($start_time) {
            $diff_time = time() - $start_time;
            $curr_test = 15*60 - $diff_time;
            if ($curr_test > 0) {
                $minute = floor($curr_test/60);
                $second = $curr_test % 60;
            }
        }
        ?>
        <h2 class="text-center">
            <span class="time hidden">
                <span class="minute">{{$minute < 10 ? '0'.$minute : $minute}}</span>:<span class="second">{{$second < 10 ? '0'.$second : $second}}</span>
            </span>
            <a href="#" class="start btn btn-primary">Start</a>
        </h2>
        <hr />
    </div>
</div>
@stop

@section('foot')

<script>
    (function($) {
        
        var minute = parseInt($('.minute').text());
        var second = parseInt($('.second').text());
        var interval;
        
        $('.start').click(function () {
           $(this).addClass('hidden');
           $('.time').removeClass('hidden');
           $.ajax({
              url: '/vi/set-start-time',
              type: 'GET',
              success: function (data) {
                interval = setInterval(timer, 1000);
              }
           });
        });

        function timer() {
            if (second <= 0) {
                if (minute <= 0) {
                    clearInterval(interval);
                    alert('done');
                } else {
                    minute--;
                    second = 59;
                    $('.minute').text(twoDigit(minute));
                }
            } else {
                second--;
            }
            $('.second').text(twoDigit(second));
        }
        
    })(jQuery);

    function twoDigit(n) {
        return (n < 10) ? '0'+n : n;
    }
    
</script>

@stop