<?php require_once('database.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ajax Dependent Select Box</title>
    <!-- for-mobile-apps -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Fancy Sliding Form Widget Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
        function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- //for-mobile-apps -->
    <!-- js -->
    <script src="js/jquery-2.1.3.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/sliding.form.js"></script>
    <!-- //js -->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <link href='//fonts.googleapis.com/css?family=Lora:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <script src="jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#country').on('change',function()
            {
                var countryID =$(this).val();
                if(countryID)

                {
                    $.ajax
                    ({
                        type:'POST',
                        url:'ajax.php',
                        data:'country_id='+countryID,
                        success:function(html)
                        {

                            $('#state').html(html);
                            $('#city').html('<option value="">Select State First</option>');
                        }


                    });
                }else
                {
                    $('#state').html('<option value="">Select Country First</option>');
                    $('#city').html('<option value="">Select State First</option>');



                }

            })

            $('#state').on('change',function()
            {
                var stateID =$(this).val();
                if(stateID)

                {
                    $.ajax
                    ({
                        type:'POST',
                        url:'ajax.php',
                        data:'state_id='+stateID,
                        success:function(html)
                        {

                            $('#city').html(html);
                        }


                    });
                }else
                {
                    $('#city').html('<option value="">Select State First</option>');




                }

            })

        });




    </script>
</head>
<body>
<div class="main">
    <h1>Dependent Select Box(Jquery and Ajax)</h1>
    <div id="wrapper" class="w3ls_wrapper w3layouts_wrapper">
        <div id="steps" style="margin:0 auto;" class="agileits w3_steps">
            <form id="formElem" name="formElem" action="#" method="post" class="w3_form w3l_form_fancy">

                <fieldset class="step w3_agileits">
                    <legend>Ajax Dependent Select Box</legend>
                    <p>

                        <?php
                        $query=$db->query("Select * From countries Where status='1' ORDER BY country_name ASC");
                        $rowcount=$query->num_rows;

                        ?>
                        <!-- Select Box for county where data is fetch through select query!-->
                        <label for="country">Country</label>
                        <select name="country" id="country" >
                            <option value="">Select Country</option>
                            <?php
                            if($rowcount>0){

                                while($row=$query->fetch_assoc()){
                                    echo '<option value="'.$row['country_id'].'">'.$row['country_name'].'</option>';
                                }

                            }
                            else{
                                echo '<option value="">Country Not Available</option>';

                            }
                            ?>

                        </select>
                    </p>
                    <!-- Select Box for state where data is fetch through ajax -->
                    <p>
                        <label for="state">State</label>
                        <select name="state" id="state" >
                            <option value="">Select State</option>
                        </select>
                    </p>
                    <!-- Select Box for city where data is fetch through ajax !-->
                    <p>
                        <label for="city">City</label>
                        <select name="city" id="city" >
                            <option value="">Select City</option>
                        </select>
                    </p>

                </fieldset>


            </form>
        </div>
        <div>
            Hi Guys, Php Hurdles is once again here to help all the Php Developers with one more interesting topic i.e.Dynamic Dependent Select Box (Jquery And Ajax).We Use Ajax to move data and fetch results within different pages without page refreshment.</br>In this tutorial we have used simple coding so that the topic can be understood by more and more young developers.So all the developers please try it.
        </div>
    </div>
    <div class="agileits_copyright">
        <p>© 2016 Fancy Sliding Form Widget. All rights reserved | Design by <a href="http://w3layouts.com">W3layouts</a></p>
    </div>
</div>
</body>
</html>