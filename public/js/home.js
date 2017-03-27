

    $(document).ready(function () {

        $( document ).idleTimer(9000);

        
        updateTime();
        setInterval(updateTime, 1000);

        setInterval(weatherUp, 3000);
        setInterval(weatherDown, 4000);
        
    });

    
        $( document ).on( "idle.idleTimer", function(event, elem, obj){
            $('#sao-is-body').addClass('mini-navbar');
            $('.logo-element').addClass('animated rotateIn');
        });
        
        $( document ).on( "active.idleTimer", function(event, elem, obj, triggerevent){
            $('#sao-is-body').removeClass('mini-navbar');
            $('.logo-element').removeClass('animated rotateIn'); 
        });

    

   


    function weatherUp(){
        $('#weather-icon').addClass('animated swing');
    }

    function weatherDown(){
        $('#weather-icon').removeClass('animated swing');
    }

	function updateTime(){
		$('#time').html(moment().format('dddd, Do of MMMM  YYYY, h:mm:ss A'));
	}