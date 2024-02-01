<div class="debugbar">
    <div class="">
        <button class="btn btn--primary mb-2 debug-btn">DEBUG BAR</button>
    </div>

    <div class="data ms-1 p-2">
        <?php
            $route = null;

            foreach(viser_system_instance()->bindValue['routes'] as $index => $data){

                if(count($data) == 1){
                    if($data[key($data)]['action'][1] == debug_backtrace()[5]['function']){
                        $route = key($data);
                        $routeName = $route;
                    }
                }else{
                    foreach($data as $key => $value){  
                        if($value['action'][1] == debug_backtrace()[5]['function']){ 
                            $route = $key;
                            $routeName = $key;
                        }
                    } 
                }
            } 

            $route =  viser_route($route);

            $action = (array) $route; 
            $action  = (array) $action['action'];
            $action = $action[0].'@'.$action[1];

            echo '<pre>'; 
                print_r('<b>Method</b> '.$route->method);  
                echo('<br/>');
                print_r('<b>Middleware</b> '.  implode(', ', (array) $route->middleware));  
                echo('<br/>'); 
                print_r('<b>Controller</b> '.  $action);  
                echo('<br/>'); 
                print_r('<b>Route</b> '.  $routeName);   
                echo('<br/>');
                print_r('<b>View </b> '.$result = implode("/", array_slice(explode("\\", rtrim(VISERLAB_ROOT, "/")), -2)).'/'.debug_backtrace()[4]['args'][0]); 
                // print_r('<b>View </b> '.debug_backtrace()[3]['object']->viewPath.'/'.debug_backtrace()[4]['args'][0]); 
            echo '</pre>'; 
        ?>
    </div>
</div>

<style>
    .debugbar {
        position: fixed;
        bottom: 0;
        left: 257px;
    }
    .data{
        border: 1px solid #ded8d8;
        background-color: #f3f3f9;
        margin-bottom: -141px
    }
    @media (max-width: 991px) {
        .debugbar {
            left: 5px;
        }
    }
</style>

<script>
    jQuery(document).ready(function($) {
        "use strict";
        $('.debug-btn').on('click', function(){
            if($(this).hasClass('show')){
                $('.debugbar').css('bottom', 0);
                return $(this).removeClass('show');
            }

            $('.debugbar').css('bottom', '141px');
            $(this).addClass('show');
        });
    })
</script>