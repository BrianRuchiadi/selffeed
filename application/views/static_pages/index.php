<html>
    <head>
        <title> SelfFeed </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/index.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/profile.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/css/style.css">
        <style>
            @import url('https://fonts.googleapis.com/css?family=Open+Sans:800');
            @import url('https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700'); 
            @import url('https://fonts.googleapis.com/css?family=Prociono');
            @import url('https://fonts.googleapis.com/css?family=Cormorant+Garamond:600');
            @import url('https://fonts.googleapis.com/css?family=Dosis:800');
            @import url('https://fonts.googleapis.com/css?family=Roboto:100');
            @import url('https://fonts.googleapis.com/css?family=Cardo');

        </style>
        <script>
        var is_user = 'false';
        var email = '';
        
        function close_register(){
            $('.register_pop_up_wrapper').hide();
            $('#map').hide();
            $('.register_pop_up_wrapper').css('z-index', '1000');
        }
            
        function open_register(){
            $('.register_pop_up_wrapper').show();
            $('.register_pop_up_wrapper').css('z-index', '1000000');
            $('.back_button').hide();
            $('#form_section_1').show();    
        }
            
        function open_sign_in(){
            $('.sign_in_pop_up_wrapper').show();
            $('.sign_in_1').show();
            $('.sign_in_pop_up_wrapper').css('z-index', '1000000'); 
        }
        
        function close_sign_in(){
            $('.sign_in_pop_up_wrapper').hide();
            $('.sign_in_1').hide();
            $('.sign_in_2').hide();
            $('.sign_in_pop_up_wrapper').css('z-index', '1000');
            $('#login_error_messages').html();
            $('#login_email').css('border','1px solid #C6C6C6');
            $('#login_password').css('border', '1px solid #C6C6C6');
        }
        
        function section_2(){
            
            if($('#register_email').val() == ''){
                $('.register_errors').html('Email is required');
                $('#register_email').css('border', '1px solid red');
            }
            else if(!checkEmail($('#register_email').val())){
                $('.register_errors').html('Email is invalid');
                $('#register_email').css('border', '1px solid red');
            }
            
            else{
                $('.register_errors').html('Please wait for verification');
                $('#register_email').css('border', '1px solid #C6C6C6');
                
                isUser($('#register_email').val());    
    
                setTimeout(function(){
                    if($('#email_input').val() == 0){
                        $('#register_email_error').html('Email already registered');  
                    }else{
                        $('.register_errors').html('');             
                        $('#form_section_1').hide();
                        $('#form_section_2').show();
                        $('.back_button').show();
                        currentPosition += 1;
                    }
                }, 2000);
               
            }
        }
        

        
            
        function section_3(){
            currentPosition += 1;
            if($('#register_address').val() == ''){
                $('#register_address_error').html('Address is required');
            }else{
                $('#register_address_error').html('');
                $('#address_input').val($('#register_address').val());
                $('#register_address_textarea').val($('#register_address').val());
                $('#form_section_2').hide();
                $('#form_section_3').show();
            }
            
        }
            
        function section_4(){
            currentPosition += 1;
            
            $('#address_input').val($('#register_address_textarea').val());
            $('#city_input').val($('#register_city').val());
            $('#post_code_input').val($('#register_post_code').val());
            $('#state_input').val($('#register_state').val());
   
            $('#form_section_3').hide();
            $('#form_section_4').show();
        }
            
        function back_button(){
            $('#form_section_' + currentPosition).hide();
                
                currentPosition -= 1;
                if(currentPosition != 1){
                    $('.back_button').show();
                }
                else{
                    $('.back_button').hide();
                }
                
            $('#form_section_' + currentPosition).show();
        }
        
        function login()
        {
            
            if($('#login_email').val() == ''){
                $('#login_error_messages').html('Email is required');
                $('#login_email').css('border','1px solid red');
            }
            else if($('#login_password').val() == ''){
                $('#login_error_messages').html('Password is required');
                $('#login_email').css('border','1px solid #C6C6C6');
                $('#login_password').css('border','1px solid red');
            }
            else if(!checkEmail($('#login_email').val())){
                $('#login_error_messages').html('Email is invalid');
                $('#login_email').css('border', '1px solid red');
            }
            else{
                
                var email = $('#login_email').val();
                var password = $('#login_password').val();
                $('#login_error_messages').html('');
                $('#login_email').css('border','1px solid #C6C6C6');
                $('#login_password').css('border', '1px solid #C6C6C6');
                $.ajax({
                        type : "POST",
                        url : "<?php echo base_url(); ?>index.php/Account/login",
                        data : {email : email, password : password},
                        success : function(result){
                                          var result = JSON.parse(result);
                                           
                                          if(result["result"]["status"] == false){
                                              $('#login_error_messages').html('Credential is invalid');
                                              $('#login_email').css('border','1px solid red');
                                              $('#login_password').css('border','1px solid red');
                                          }
                                          else{
                                              window.location.replace("<?php echo base_url(); ?>index.php/Menu");
                                              $('#login_error_messages').html('');
                                              $('#login_email').css('border', '1px solid #C6C6C6');
                                              $('#login_password').css('border', '1px solid #C6C6C6');
                                          }
                        }
                });

            }
        }
        
        function checkEmail(email){
            var regex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
            if(regex.test(email)){
                return true;          
            }
            return false;
        }
        
        function isUser(email){
        
            $.ajax({
                        type : "POST",
                        url : "<?php echo base_url(); ?>index.php/Account/check_user",
                        data : {email : email},
                        success : function(result){
                           
                                          var result = JSON.parse(result);
                                          
                                          if(result.count == 0 ){
                                                // new user
                                            $('#email_input').val(result.email);                      
                                          }else{
                                            $('#email_input').val(0);           
                                          }
                        }
                });

        }
        
        function forgot_password(){
            $('.sign_in_1').hide();
            $('.sign_in_2').show();
        }
        
        function registration(){
            $('#register_first_name').css('border', '1px solid #C6C6C6');
            $('#register_contact_no').css('border', '1px solid #C6C6C6');
            $('#register_password').css('border', '1px solid #C6C6C6');
            
            if($('#register_first_name').val() == ''){
                $('#register_personal_details_error').html('First Name is required');
                $('#register_first_name').css('border', '1px solid red');
            }
            else if($('#register_contact_no').val() == ''){
                $('#register_personal_details_error').html('Contact Number is required');
                $('#register_contact_no').css('border', '1px solid red');
            }
            else if($('#register_password').val() == ''){
                $('#register_personal_details_error').html('Password is required');
                $('#register_password').css('border', '1px solid red');
            }else{
                $('#first_name_input').val($('#register_first_name').val());
                $('#last_name_input').val($('#register_last_name').val());
                $('#contact_no_input').val($('#register_contact_no').val());
                $('#password_input').val($('#register_password').val());
                
                var email = $('#email_input').val();
                var address = $('#address_input').val();
                var city = $('#city_input').val();
                var state = $('#state_input').val();
                var post_code = $('#post_code_input').val();
                var first_name = $('#first_name_input').val();
                var last_name = $('#last_name_input').val();
                var contact_no = $('#contact_no_input').val();
                var password = $('#password_input').val();
                
                $.ajax({
                        type : "POST",
                        url : "<?php echo base_url(); ?>index.php/Account/register",
                        data : {
                                email : email,
                                address : address,
                                city : city,
                                state : state,
                                post_code : post_code,
                                first_name : first_name,
                                last_name : last_name,
                                contact_no : contact_no,
                                password : password
                                },
                        success : function(result){

                                          var result = JSON.parse(result);
                                          var email = result.email;
                                          var password = result.password;
                                        
                                          $.ajax({
                                                  type : "POST",
                                                  url : "<?php echo base_url(); ?>index.php/Account/login",
                                                  data : {email : email, password : password},
                                                  success : function(result){
                                                            var result = JSON.parse(result);
                                           
                                                            if(result["result"]["status"] == true){
                                                                window.location.replace("<?php echo base_url(); ?>index.php/Menu");
                                                            }
                                                          
                                                }
                                            });
                                    
                        }
                });
                
               
            }
        }
        
        function send_reset_password(){
            var email = $('#reset_email').val();

            $.ajax({
                    type : "POST",
                    url : "<?php echo base_url(); ?>index.php/Account/send_reset_email",
                    data : {email : email},
                    success : function(result){
                                result = JSON.parse(result);
                                console.log(result);
                                
                                if(result.valid == true){
                                    $('#login_error_messages_2').css('color', 'blue');
                                    $('#login_error_messages_2').html('Information has been sent to your email!');
                                }else{
                                    $('#login_error_messages_2').css('color', 'red');
                                    $('#login_error_messages_2').html(result.email_invalid);
                                }
                        }
                });
        }
        
        $(document).ready(function(){
            if($("body").scrollTop() > 0){
                $('#header').css("background-color", "white");
                $('.center a').css("color", "#1A1A1A");
                $('.right a').css("color", "#1A1A1A");
                $('.right a').css("border-color", "#1A1A1A");
                $('#header').css("opacity", "1");
                $('#header').css("box-shadow", "1px 1px 5px #7F7F7F");
            }else{
                $('#header').css("opacity", 1);
                $('.center a').css("color", "white");
                $('.right a').css("color", "white");
                $('.right a').css("border-color", "white");
                $('#header').css("background-color", "transparent");
                $('#header').css("box-shadow", "none");
            }
          
            $('.button').css('z-index', '10000');
            $('.text_link').css('z-index', '100000');
            currentPosition = 1;
            
            $('.sign_in_1').hide();
            $('.sign_in_2').hide();
            $('.sign_in_pop_up_wrapper').hide();
            $('.register_pop_up_wrapper').hide();
            $('#form_section_1').hide();
            $('#form_section_2').hide();
            $('#form_section_3').hide();
            $('#form_section_4').hide();
            
            <?php if($register){ ?>
            open_register();     
            <?php } ?>
                
            <?php if($login){ ?>
            open_sign_in();
            <?php } ?>
            $(window).scroll(function(){
                console.log('part_1 ' + $("#part_1").offset().top);
                console.log('body ' + $("body").scrollTop());
         
                $('#part_1').css("opacity",  0 + $(window).scrollTop() / $('.about_us_wrapper').height())
            });

            $(window).bind("mousewheel",function(){
                
                if($("body").scrollTop() > 0){
                    $('#header').css("background-color", "#1a1a1a");
                    $('.center a').css("color", "white");
                    $('.right a').css("color", "white");
                    $('.right a').css("border-color", "white");
                    $('#header').css("opacity", "1");
                    $('#header').css("box-shadow", "1px 1px 5px #7F7F7F");
                }else{
                    $('#header').css("opacity", 1);
                    $('.center a').css("color", "white");
                    $('.right a').css("color", "white");
                    $('.right a').css("border-color", "white");
                    $('#header').css("background-color", "transparent");
                    $('#header').css("box-shadow", "none");
                }
                var scrollPercentage = 100 * $(window).scrollTop() / ($(document).height() - $(window).height());
                if(scrollPercentage < 32.6){
                    $('#animation').css('position' , 'absolute');
                    $('#animation').css('top', '130px');
                    $('#animation').css('right', '20px');
                }
                if(scrollPercentage >= 32.6 && scrollPercentage <= 68.3){
                    $('#animation').css('position' , 'fixed');
                }
                if(scrollPercentage < 40.1){
                    $('#animation').css('background-image', 'url(../Image/sleffeed-animation-final/sleffeed1.gif)');

                }
                if(scrollPercentage >= 40.1 && scrollPercentage < 54.1){
                    $('#animation').css('background-image', 'url(../Image/sleffeed-animation-final/sleffeed2.gif)');
                }
               
                if(scrollPercentage >= 54.1){
                    $('#animation').css('background-image', 'url(../Image/sleffeed-animation-final/sleffeed3.gif)');
                }
                if(scrollPercentage > 65.3){
                    $('#animation').css('top', 'auto');
                    $('#animation').css('position', 'absolute');
                    $('#animation').css('bottom', '40px');
                    $('#animation').css('right', '20px');
                    $('#animation').css('display', 'block');
                }
                
                if($(window).scrollTop() <= 609){               
                    $('#second_arrangement').css('visibility', 'hidden');
                    $('#first_arrangement').css('visibility', 'visible');
                }
                if($(document).scrollTop() > 0){
                    $('#header').css("background-color", "#000000");
                    $('#header').css("opacity", "0.9");
                } else{
                    $('#header').css("opacity", 1);
                    $('#header').css("background-color", "transparent");
                }
             
                if($(window).scrollTop() > 609){
                    $('#second_arrangement').css('visibility', 'visible');
                    $('#first_arrangement').css('visibility', 'hidden');
                }
                
            });
        });
        </script>

        <style type="text/css">
            .container{
                height:100%;
                width:100%;
                border-bottom: 1px solid #eee;
                box-sizing: border-box;
                display: table;
                background-color: white;
            }
            .section{
                width: 40%;
                height: 100%;
                box-sizing: border-box;
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            }
            #image-changer {
                display: inline-block;
                width: 400px;
                height: 400px;
                background-size: 100%;
                background-image: url('https://d16cs9nbg8x6iq.cloudfront.net/s/img/home01.gif')
            }
        </style>
    </head>
    <body>
        <div class="register_pop_up_wrapper" id="register_main">
            <input type="hidden" id="email_input">
            <input type="hidden" id="address_input">
            <input type="hidden" id="city_input">
            <input type="hidden" id="post_code_input">
            <input type="hidden" id="state_input">
            <input type="hidden" id="first_name_input">
            <input type="hidden" id="last_name_input">
            <input type="hidden" id="contact_no_input">
            <input type="hidden" id="password_input">
            
            <img src="<?php echo base_url(); ?>./Image/close.png"  height="20px" width="20px" class="close_button" onclick="close_register();"/>
            <img src="<?php echo base_url(); ?>./Image/back.png" height="20px" width="20px" class="back_button" onclick="back_button()" />
            <div class="register_header"> SELFFEED</div>
            
            <!-- section 1 -->
            <div id="form_section_1">
                <div class="register_description">
                    <h2>
                        <hr>
                        <span>LET'S GET <br>STARTED</span>
                        <hr>
                    </h2>
                    <p>Enter your email address.</p>
                </div>
                <div class="register_errors" id="register_email_error"></div>
                <div class="register_box">
                    <input type="email" name="email" id="register_email" placeholder="Email Address" required>
                </div>
                <div class="next_button_wrapper">
                    <button onclick="section_2()">NEXT</button>
                </div>
                
            </div>
            <!-- end of section 1 -->
            <!-- section 2 -->
            <div id="form_section_2">
                <div class="register_description_2">
                    <hr>
                    <p> Let's see if we can deliver to you<br> Enter your street address. </p>
                    <div class="register_errors" id="register_address_error"></div>
                    <input type="text" name="address" placeholder="Street Address" id="register_address" required>
                </div>
                <div class="google_map_display">
                    <img id="map" src="https://maps.googleapis.com/maps/api/staticmap?key=AIzaSyB5tYQsg1eiZdM_4BCwwYQmRGIXzmtEemY&center=3.0675501000248766,101.60387815000001&zoom=14&format=png&maptype=roadmap&style=element:geometry%7Ccolor:0x212121&style=element:labels.icon%7Cvisibility:off&style=element:labels.text.fill%7Ccolor:0x757575&style=element:labels.text.stroke%7Ccolor:0x212121&style=feature:administrative%7Celement:geometry%7Ccolor:0x757575&style=feature:administrative.country%7Celement:labels.text.fill%7Ccolor:0x9e9e9e&style=feature:administrative.land_parcel%7Cvisibility:off&style=feature:administrative.locality%7Celement:labels.text.fill%7Ccolor:0xbdbdbd&style=feature:poi%7Celement:labels.text.fill%7Ccolor:0x757575&style=feature:poi.park%7Celement:geometry%7Ccolor:0x181818&style=feature:poi.park%7Celement:labels.text.fill%7Ccolor:0x616161&style=feature:poi.park%7Celement:labels.text.stroke%7Ccolor:0x1b1b1b&style=feature:road%7Celement:geometry.fill%7Ccolor:0x2c2c2c&style=feature:road%7Celement:labels.text.fill%7Ccolor:0x8a8a8a&style=feature:road.arterial%7Celement:geometry%7Ccolor:0x373737&style=feature:road.highway%7Celement:geometry%7Ccolor:0x3c3c3c&style=feature:road.highway.controlled_access%7Celement:geometry%7Ccolor:0x4e4e4e&style=feature:road.local%7Celement:labels.text.fill%7Ccolor:0x616161&style=feature:transit%7Celement:labels.text.fill%7Ccolor:0x757575&style=feature:water%7Celement:geometry%7Ccolor:0x4fa9f2&style=feature:water%7Celement:labels.text.fill%7Ccolor:0x3d3d3d&size=480x360" />
                </div>
                <button class="next_address" onclick="section_3()">NEXT</button>
                
            
            </div>
            <!-- end of section 2 -->
            <!-- section 3 -->
            <div id="form_section_3">
                <div class="register_description_3">
                    <hr>
                    <p> Great! We can deliver to you.</p>
                </div>
                <div class="address_detail">
                    <textarea name="address" placeholder="Street Address" id="register_address_textarea" required>
                        
                    </textarea>
                    <input type="text" name="city" id="register_city" placeholder="City">
                    <div class='double_input'>
                      <input type="text" name="post_code" id="register_post_code" placeholder="Post Code">
                      <select name="state" id="register_state">
                            <option value="johor"> Johor </option>
                            <option value="kedah"> Kedah </option>
                            <option value="kelantan"> Kelantan </option>
                            <option value="malacca"> Malacca </option>
                            <option value="negeri_sembilan"> Negeri Sembilan </option>
                            <option value="pahang"> Pahang </option>
                            <option value="penang"> Penang </option>
                            <option value="perak"> Perak </option>
                            <option value="perlis"> Perlis </option>
                            <option value="sabah"> Sabah </option>
                            <option value="sarawak"> Sarawak </option>
                            <option value="selangor" selected> Selangor </option>
                            <option value="terengganu"> Terengganu </option>
                      </select>
                    </div>
                </div>
                <button class="next_details" onclick="section_4()">USE THIS ADDRESS</button>
                    
            </div>
            <!-- end of section 3 -->
            <!-- section 4 -->
            <div id="form_section_4">
                <div class="register_description_4">
                    <h2>
                        <hr>
                         <span>ALMOST THERE</span>
                        <hr>
                    </h2>
                </div>
                <div class="personal_details">
                    <div class="register_errors" id="register_personal_details_error"></div>
                    <div class='double_input'>
                        <input type="text" placeholder="First Name" name="first_name" id="register_first_name" required>
                        <input type="text" placeholder="Last Name" name="last_name" id="register_last_name">
                    </div>
                    <input type="text" placeholder="Phone" name="contact_no" id="register_contact_no" required>
                    <input type="password" placeholder="Password" name="password" id="register_password" required>
                </div>
                
                <button class="next_details" onclick="registration()">SEE MENU</button>
            </div>
            <!-- end of section 4 -->
        </div>
        
        <div class="sign_in_pop_up_wrapper">
            
            <img src="<?php echo base_url(); ?>./Image/close.png"  height="20px" width="20px" class="close_button" onclick="close_sign_in();"/>

            <div class="register_header"> SELFFEED</div>
            
            <div class="sign_in_1">
                <div class="sign_in_description">
                    <h2>
                        <hr>
                        <span>SIGN IN</span>
                        <hr>
                    </h2>
                    <p>Delicious food, prepared by our
                        best chefs, 
                        delivered to you when you want it.
                    </p>
                </div>
                <div id="login_error_messages"></div>
                <div class="login_inputs">
                    <input type="email" placeholder="Email Address" id="login_email">
                    <input type="password" placeholder="Password" id="login_password">
                </div>
                <div class="sign_in_button_wrapper" id="sign_in_button_wrapper_height">
                    <button onclick="login()" id="sign_in_button_margin">SIGN IN</button>
                </div>
                <div class="forget_password">
                    <p id="click_cursor"><a onclick="forgot_password();">Forgot Password</a></p>
                </div>
            </div>
            <div class="sign_in_2">
                <div class="sign_in_description">
                    <h2>
                        <hr>
                        <span>FORGOT YOUR PASSWORD</span>
                        <hr>
                    </h2>
                    <p>Enter your email, and we’ll send you instructions for resetting it.</p>
                </div>
                <div id="login_error_messages_2"></div>
                <div class="login_inputs">
                    <input type="email" placeholder="Email Address" id="reset_email"> 
                </div>
                <div class="sign_in_button_wrapper" id="sign_in_button_wrapper_height">
                    <button onclick="send_reset_password()" id="sign_in_button_margin">SEND ME RESET INSTRUCTIONS</button>
                </div>
            </div>
        </div>
        
        <div class="wrapper"> 
            <div id="header">
                <div class="content-width">
                    <div class="header-line">
                        <div class="left"></div>
                        <div class="center"><a href="#">SELFFEED</a></div>
                        <div class="right"></div>
                    </div>
                </div>
            </div>
            
            <div class="video_wrapper">
                <video autoplay loop class="video_display" id="load_video">
                    <source src="<?php echo base_url(); ?>Video/main_intro.mp4" type="video/mp4" id>
                    <source src="<?php echo base_url(); ?>Video/main_intro.ogv" type="video/ogv" id>
                    <source src="<?php echo base_url(); ?>Video/main_intro.ogg" type="video/ogg" id>
                    <source src="<?php echo base_url(); ?>Video/main_intro.ogg" type="video/webm" id>
                </video>
                <div class="centered-content" style="opacity : 0.99;">
                    <h1>
                        <span id="faded"> 
                            <div class="title2">
                                The ingredients for your cooking experience
                            </div>
                        </span>
                    </h1>
                </div>
                <div class="button_arrangement" id="first_arrangement">
                    <a class="button" onclick="open_register();">Get Started</a>
                    <a class="text_link" onclick="open_sign_in();" style="border-bottom : 1px dotted white;">Already a member? Sign in </a>
                </div>  
            </div>
            
            <div class="contents">
                <div class="about_us_wrapper">
                    <p id="part_1">SelfFeed is the latest innovation that bridges the gap between you and the perfect
                    cooking experience! With an amazing roster of delicious recipes that you can choose from, we'll get and
                    prep all the ingredients accordingly. So all you need to do is cook !</p>
                    <p id="part_2">We believe that cooking is for everyone. And with our fool-proof recipes, it'll work with 
                    anyone from a novice to a five-star chef! What's more is that through this we're making an effort to tackle
                    and curb the food spoilage and eventual wastage problem! So why wait? Get yours today!</p>
                    <div class="button_arrangement" id="second_arrangement">
                        <a class="button" onclick="open_register();" id="change_color">Get Started</a>
                        <a class="text_link" onclick="open_sign_in();">Already a member? Sign in </a>
                    </div>         
                </div>
                <div id="step_animation_wrapper">
                    <div class="med_box">
                        <div class="animation_holder" id="animation_1"></div>
                    </div>
                    <div class='each_step'>
                        <h1> EAT </h1>
                        <p>Have a look through what we are offering today and take a pick! We'll then
                           prep ingredients according to the recipe and arrange for it to be delivered
                           for you.</p>
                        <div id="linkmenu" style=" line-height: 40px;" onclick="open_register()">
                            <a onclick="open_register();" > Get Started</a>
                        </div>
                        
                    </div>
                   
                    <div class="med_box">
                        <div class="animation_holder" id="animation_2"></div>
                    </div>
                    <div class='each_step'>
                        <h1> SIT BACK </h1>
                        <p>While you do your things,we'll do ours:Preparing. Our technology let us receive
                            exactly what you ordered, prepare it with care, and deliver it to you in a swift way.</p>
                        <div id="linkmenu" style=" line-height: 40px;" onclick="open_register()">
                            <a onclick="open_register();" > Get Started</a>
                        </div>
                        
                    </div>
                    
                    <div class="med_box" >
                        <div class="animation_holder" id="animation_3"></div>
                    </div>
                    <div class='each_step'>
                        <h1> COOKING </h1>
                        <p>With you not having to go through the painstaking process of prepping,just
                           follow the simple steps on our fool-proof recipes and voila, you're the 
                           master chef! What's left to do is eat!</p>
                        <div id="linkmenu" style="line-height: 40px;" onclick="open_register()">
                            <a onclick="open_register();" > Get Started</a>
                        </div>
                        
                    </div>
                    
                    <div id="animation"></div>
                </div>
                <div class="wearehere">
                    <div class="med_box" >
                        <div class="animation_holder" id="map"></div>
                    </div>
                    <div class='each_step'>
                        <h1> We're Here </h1>
                        <p>Serving instant meal to you in Klang Valley. Add your address to see
                           how we can serve you.</p>
                        <div id="linkmenu" style=" line-height: 40px;" onclick="open_register()">
                            <a onclick="open_register();" > Get Started</a>
                        </div>
                        <div class="map_place">
                        </div>
                    </div>
                </div>
                
                <div class="about_menu_wrapper">
                    <div class="centered-content">
                        <h1> Meet Our Kitchen </h1>
                        <p>"Culinary masterminds, incredible ingredients. Thought and care, 
                            from our kitchen to your door, every day."</p>
                    </div>
                
                    <div class="button_arrangement">
                        <a class="button_no_transition" href="<?php echo base_url(); ?>index.php/Menu">See Today's Menu</a>
                        <a class="text_link_no_transition"  onclick="open_sign_in()">Already a member? Sign in </a>
                    </div>                 
                </div>
 
                <footer style="background-color: black; color: white; text-align: center;">
                    <div style="vertical-align: middle;">
                        <nav class="navbar" style="margin:auto;">
                              <div class="container-fluid" align="center">
                                    <ul class="nav navbar-nav">
                                        <li class="active" style="margin: auto;"><a href="#"><div class="linkFooter">Selffeed for Android</div></a></li>
                                        <li><a class="footer" href="#"><div class="linkFooter">Selffeed for IOs</div></a></li>
                                        <li><a class="footer"href="<?php echo base_url(); ?>index.php/Informations/business"><div class="linkFooter">Business</div></a></li>
                                        <li><a class="footer"href="<?php echo base_url(); ?>index.php/Informations/questionAndAnswer"><div class="linkFooter">QA</div></a></li>
                                        <li><a class="footer"href="<?php echo base_url(); ?>index.php/Help"><div class="linkFooter">Contact Us</div></a></li>
                                        <li><a class="footer"href="<?php echo base_url(); ?>index.php/Informations/career"><div class="linkFooter">Career</div></a></li>
                                        <li><a class="footer"href="#"><div class="linkFooter">Term of Use</div></a></li>
                                        <li><a class="footer"href="#"><div class="linkFooter">Privacy Policy</div></a></li>
                                        <li><a class="footer" href="#" class="text-muted"><div class="linkFooter" style="border:none;">&copy; 2016 Selffeed</div></a></li>
                                        <!--
                                        <li><a class="footer"ref="#" ><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                        <li><a class="footer" href="#" ><i class="fa fa-twitter" aria-hidden="true"></i></i></a></li>
                                        <li><a class="footer" href="#" ><i class="fa fa-youtube" aria-hidden="true"></i></i></a></li> -->        
                                    </ul>
                              </div>
                        </nav>  
                    </div>
                </footer>
            </div>
        </div>
    </body>
    <!--
    <script type="text/javascript">
        
        var sHome = $("#section-home");
        var sAbout = $("#section-about");
        var sOrder = $("#section-order");
        var sSitBack = $("#section-sit-back");
        var sEat = $("#section-eat");
        var sMap = $("#section-map");
        var containerList = $(".container");
        var imageChanger = $("#image-changer");

        $(window).scroll(function(){
            var windowTop = $(window).scrollTop();

            //update coordinate ke semua elemen 
            for(var i=0;i<containerList.length;i++){
                containerList.eq(i).attr('coord-top',containerList.eq(i).offset().top-windowTop);
            }

            // dia jadi fixed ada saat posisi sOrder ada dipaling atas dan s eat tidak berada paling atas
            if(sOrder.attr('coord-top')<0 && sEat.attr('coord-top')>0){
                imageChanger.attr('is-fixed','true');
            }else{
                imageChanger.attr('is-fixed','false');
            }

            //validasi, kalau is-fixed = true maka cssnya diubah 
            if(imageChanger.attr('is-fixed')=='true'){
                imageChanger.css({
                    position:'fixed',
                    top:imageChanger.offset().top-windowTop,
                    left:imageChanger.offset().left
                })
            }else{
                imageChanger.css({
                    position:'inherit'
                })
            }

            //START OF : pindahin gambar ke masing masing container
            if(sOrder.attr('coord-top')<0){
                imageChanger.appendTo(sOrder.find('.image-changer-loader'));
            }

            if(sSitBack.attr('coord-top')<0){
                imageChanger.appendTo(sSitBack.find('.image-changer-loader'));
            }

            if(sEat.attr('coord-top')<0){
                imageChanger.appendTo(sEat.find('.image-changer-loader'));
            }
            //END OF : pindahin gambar ke masing masing container

            //validasi gambar
            var halfScreenSize = ($(window).height()/2);

            if(sEat.attr('coord-top') < halfScreenSize && sEat.attr('data-image')!=imageChanger.css('background-image')){
                imageChanger.css('background-image',sEat.attr('data-image'));
            }else if(sSitBack.attr('coord-top') < halfScreenSize && sSitBack.attr('data-image')!=imageChanger.css('background-image')){
                imageChanger.css('background-image',sSitBack.attr('data-image'));
            }else if(sOrder.attr('coord-top') < halfScreenSize && sOrder.attr('data-image')!=imageChanger.css('background-image')){
                imageChanger.css('background-image',sOrder.attr('data-image'));
            }

        });
    </script>
    -->
</html>