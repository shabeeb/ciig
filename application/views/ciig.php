<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Welcome to CIIgniter</title>

        <style type="text/css">



            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #eee;
            }

            .form-signin {
                //max-width: 330px;
                padding: 15px;
                margin: 0 auto;
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin .checkbox {
                font-weight: normal;
            }
            .form-signin .form-control {
                position: relative;
                height: auto;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
                padding: 10px;
                font-size: 16px;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="email"] {
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>






        <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="">
            <meta name="author" content="">
            <link rel="icon" href="../../favicon.ico">

          

            <!-- Bootstrap core CSS -->
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

            <!-- Optional theme -->
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

            <!-- Latest compiled and minified JavaScript -->
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <!-- Custom styles for this template -->
            <link href="signin.css" rel="stylesheet">


        </head>

        <body>

            <div class="container">

                <form name="" action="" class="form-signin"  method="post">
                    <h2 class="form-signin-heading" >Welcome to CI-Igniter!</h2>
                    <?php echo validation_errors(); ?>
                    <div id="body" class="col-lg-3">
                        <label>Table Name</label>  <input type="text" name="tname"  class="form-control" placeholder="Table Name" value="<?php echo set_value('tname'); //echo $tname = empty($tname) ? "" : $tname; ?>" >
                    </div>
                    <div id="body" class="col-lg-3">
                        <label>Controller Name</label> 
                        <input type="text"  class="form-control" placeholder="Controller Name" name="cname" value="<?php echo set_value('cname'); //echo $cname = empty($cname) ? "" : $cname; ?>">
                    </div>
                    <div id="body"  class="col-lg-3">
                        <label>Form title</label>  <input type="text" name="fname"  class="form-control"   placeholder="Form title" value="<?php echo set_value('fname'); //echo $fname = empty($fname) ? "" : $fname; ?>" >
                    </div>
                    <br />
                    <div id="body"  class="col-lg-2">
                        <input type="submit" name="submit" class="btn btn-lg btn-primary btn-block" value="submit">
                    </div>

                    <div id="body"  class="col-lg-2">
                        <input type="submit" name="download" class="btn btn-lg btn-primary btn-block" value="Dowload">
                    </div>
                </form>


                <div class="col-lg-12 ">

                    <?php
                    if (isset($model)) {
                        ?>
                        <h3> Model</h3><h4><?php echo $modelname . '.php'; ?></h4>
                        <textarea class="textarea" rows="28" cols="50" style="width: 100%;">
                            <?php echo $model; ?>
                        </textarea> 
                    <?php } ?>




                    <?php
                    if (isset($controller)) {
                        ?>
                        <h3> Controller</h3><h4><?php echo $controllername . '.php'; ?></h4>
                        <textarea class="textarea" rows="28" cols="50" style="width: 100%;">
                            <?php echo $controller; ?>
                        </textarea> 
                        <?php } ?>





<?php
if (isset($view_create)) {
    ?>
                        <h3>Create Form</h3> <h4><?php echo $create_viewname . '.php'; ?></h4>
                        <textarea class="textarea" rows="28" cols="50" style="width: 100%;">
                        <?php echo $view_create; ?>
                        </textarea> 
                        <?php } ?>

                    <?php
                    if (isset($view_list)) {
                        ?>
                        <h3>List Form</h3>  <h4><?php echo $listviewname . '.php'; ?></h4>
                        <textarea class="textarea" rows="28" cols="50" style="width: 100%;">
                        <?php echo $view_list; ?>
                        </textarea> 
<?php } ?>


                    <?php
                    if (isset($view_header)) {
                        ?>
                        <h3>Header structure</h3><h4><?php echo $header . '.php'; ?></h4>
                        <textarea class="textarea" rows="28" cols="50" style="width: 100%;">
                        <?php echo $view_header; ?>
                        </textarea> 
                    <?php } ?>

                        <?php
                        if (isset($view_footer)) {
                            ?>
                        <h3>List Form</h3><h4><?php echo $footer . '.php'; ?></h4>
                        <textarea class="textarea" rows="28" cols="50" style="width: 100%;">
                        <?php echo $view_footer; ?>
                        </textarea> 
                    <?php } ?>





                </div>




            </div> <!-- /container -->
            <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>

            <!-- Bootstrap core JavaScript
            ================================================== -->
            <!-- Placed at the end of the document so the pages load faster -->
        </body>
    </html>




