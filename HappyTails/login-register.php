<?php
require('config.php');
//if action occurs (login/register button)
if (isset($_GET['action'])) {
    switch (strtolower($_GET['action'])) {
        case 'register':
            //user clicked register, try to create new acccount
            if (!(empty($_POST['input_userName']) || empty($_POST['input_pw']) || empty($_POST['input_firstName']) || empty($_POST['input_lastName']) || empty($_POST['input_email']) || empty($_POST['input_city']) || empty($_POST['input_state']))) {

                //if the appropriate fields are set, creat a new client object
                $client = new Client('user', $_POST['input_userName'], $_POST['input_pw'], $_POST['input_firstName'], $_POST['input_lastName'], $_POST['input_email'], $_POST['input_phoneNumber'], $_POST['input_city'], $_POST['input_state']
                );

                //check account availability
                if ($client->accountAvailable($conn)) {

                    if ($client->addClient($conn)) {

                        //account creation was succesful, login user
                        $client->login($conn);
                    }
                } else {
                    //something went wrong display the form again
                    unset($_GET['action']);
                }
            } else {
                $_SESSION['error'] = "Error with supplied fields, please make sure all required fields are filled.";
                unset($_GET['action']);
            }
            break;
        case 'login':
            //user attempted to login
            $client = new Client('', $_POST['loginUser'], $_POST['loginPass'], '', '', '', '', '', '');
            //try to login user
            if (!$client->login($conn)) {
                echo "<script>alert('login failed, please try again.')</script>";
            }
            break;
        case 'logout':
            Client::logout();
            break;
    }
}

$output .= '</div>';
echo $output;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Login / Register</title>

        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Carousel CSS -->
        <link href="styles/carousel.css" rel="stylesheet">

        <!-- Custom Page CSS -->
        <link href="styles/elements.css" rel="stylesheet">
        <link href="styles/login-register.css" rel="stylesheet">

        <!-- Bootstrap core JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>

        <!-- Happy Tails JavaScript -->
        <script src="js/happyTails.js"></script>

        <!-- FONTS -->
        <link href='http://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Fredericka+the+Great' rel='stylesheet' type='text/css'>
    </head>

    <!-- HEADER
    ================================================== -->
    <body>


        <div class="container-fluid" style="padding: 0px;">
            <div class="jumbotron" style="margin: 0; padding: 10px; background-color: #333333; color: #fff; border-radius: 0px">
                <div class="text-center">San Francisco State University, CSC648: Software Engineering Group 4</div>
            </div>
            <div class="jumbotron" style="margin: 0; height: 160px; padding: 15px;">
                <row>
                    <div class="col-lg-10 header-title">
                        <a href="index.php"><span><span style="font-family: 'Fredericka the Great' , cursive; color: #b90504; font-size: 70pt">Happy Tails</span><span style="font-family: 'Rock Salt'; font-size: 15pt">&nbsp;&nbsp;Pet Adoption</span></span></a>
                    </div>

                    <div class="col-lg-2 pull-right header-login">
                        <!-- Only show Account link if user is logged in -->
                        <?php
                        if (!Client::loggedIn()) {
                            echo ' <a href="login-register.php">Login / Register</a><br>';
                        } else {
                            echo '<a href="account.php">My Account</a><br>';
                            echo '<a href="login-register.php?action=logout">Logout</a>'; 
                        }
                        ?>    
                    </div>
                </row>
            </div>



            <!-- NAVBAR
                ================================================== -->

            <nav class="navbar navbar navbar-static-top" style="margin: 0">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div> 
                    <div id="navbar" class="nav navbar-collapse collapse active">
                        <div class="row">
                            <div class="col-sm-3 menu-item text-center" id="search" onclick="setActive('search-dropdown')">
                                <a href="#search.php">Search</a>                               
                            </div>
                            <div class="col-sm-2 menu-item text-center" style="  border-left: 3px solid #ac2925;" >
                                <a href="post-adoption.php">Put Up For Adoption</a>
                            </div>
                            <div class="col-sm-2 menu-item text-center" style="  border-left: 3px solid #ac2925;   border-right: 3px solid #ac2925">
                                <a href="care-info.php">Pet Care Info</a>
                            </div>
                            <div class="col-sm-2 menu-item text-center" style="  border-right: 3px solid #ac2925; ">
                                <a href="about.php">About Us</a>
                            </div>
                            <div class="col-sm-3 menu-item text-center">
                                <a href="contact.php">Contact</a>
                            </div>
                        </div> 

                    </div>
                </div>
            </nav>

            <!-- DROPDOWN SEARCH DIV -->
            <div id="search-dropdown" role="menubar" class="search-div"  style="font-size: 15pt; text-decoration-color: #333333; font-weight: 800; margin: auto; padding: 10px; margin-top: -1px">
                <div class="row search-background">
                    <form action="search.php" method="post" enctype="multipart/form-data">
                        <div class="col-sm-3">
                            <div class="dropdown">
                                <span style="padding-right: 10px">Type:</span>
                                <select class="btn btn-default" id="type" name="type" style="float: right" onchange="populateBreeds();">
                                    <option value="" selected="selected">All</option>
                                    <option value="dog">Dog</option>
                                    <option value="cat">Cat</option>
                                </select>
                            </div>
                            <div class="divider"></div>
                            <div class="dropdown">
                                <span style="padding-right: 10px">Age Group:</span>
                                <select class="btn btn-default" name="age" style="float: right; margin-top: 3px">
                                    <option value="" selected="selected">All</option>
                                    <option value="puppy/kitten">Puppy/Kitten</option>
                                    <option value="young">Young</option>
                                    <option value="adult">Adult</option>
                                    <option value="senior">Senior</option>Age:  
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="dropdown">
                                <span style="padding-right: 10px">Breed:</span>
                                <select class="btn btn-default" name="breed" id="breed" style="float: right">
                                    <option value="" selected="selected">All</option>
                                    <!-- other options added when type changes -->
                                </select>
                            </div>
                            <div class="dropdown">
                                <span style="padding-right: 10px">Sex:</span>
                                <select class="btn btn-default" name="sex" style="float: right; margin-top: 3px">
                                    <option value="" selected="selected">All</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="dropdown">
                                <span style="padding-right: 10px">Size:</span>
                                <select class="btn btn-default" name="size" style="float: right">
                                    <option value="" selected="selected">All</option>
                                    <option value="small">Small</option>
                                    <option value="medium">Medium</option>
                                    <option value="large">Large</option>
                                </select>
                            </div>
                            <div class="dropdown">
                                <span style="padding-right: 10px">Color:</span>
                                <select class="btn btn-default" name="color" style="float: right; margin-top: 3px">
                                    <option value="" selected="selected">All</option>
                                    <option value="Other">Other</option>
                                    <option value="Black">Black</option>
                                    <option value="White">White</option>
                                    <option value="Yellow">Yellow</option>
                                    <option value="Brown">Brown</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="dropdown">
                                <span style="padding-right: 10px">Location(state):</span>
                                <select class="btn btn-default" name="state" style="float: right">
                                    <option value="" selected="selected">All</option>
                                    <option value="AL"> AL </option>
                                    <option value="AK"> AK </option>
                                    <option value="AZ"> AZ </option>
                                    <option value="AR"> AR </option>
                                    <option value="CA"> CA </option>
                                    <option value="CO"> CO </option>
                                    <option value="CT"> CT </option>
                                    <option value="DE"> DE </option>
                                    <option value="FL"> FL </option>
                                    <option value="GA"> GA </option>
                                    <option value="HI"> HI </option>
                                    <option value="ID"> ID </option>
                                    <option value="IL"> IL </option>
                                    <option value="IN"> IN </option>
                                    <option value="IA"> IA </option>
                                    <option value="KS"> KS </option>
                                    <option value="KY"> KY </option>
                                    <option value="LA"> LA </option>
                                    <option value="ME"> ME </option>
                                    <option value="MD"> MD </option>
                                    <option value="MA"> MA </option>
                                    <option value="MI"> MI </option>
                                    <option value="MN"> MN </option>
                                    <option value="MS"> MS </option>
                                    <option value="MO"> MO </option>
                                    <option value="MT"> MT </option>
                                    <option value="NE"> NE </option>
                                    <option value="NV"> NV </option>
                                    <option value="NH"> NH </option>
                                    <option value="NJ"> NJ </option>
                                    <option value="NM"> NM </option>
                                    <option value="NY"> NY </option>
                                    <option value="NC"> NC </option>
                                    <option value="ND"> ND </option>
                                    <option value="OH"> OH </option>
                                    <option value="OK"> OK </option>
                                    <option value="OR"> OR </option>
                                    <option value="PA"> PA </option>
                                    <option value="RI"> RI </option>
                                    <option value="SC"> SC </option>
                                    <option value="SD"> SD </option>
                                    <option value="TN"> TN </option>
                                    <option value="TX"> TX </option>
                                    <option value="UT"> UT </option>
                                    <option value="VT"> VT </option>
                                    <option value="VA"> VA </option>
                                    <option value="WA"> WA </option>
                                    <option value="WV"> WV </option>
                                    <option value="WI"> WI </option>
                                    <option value="WY"> WY </option>
                                </select>
                            </div>
                            <div class="checkbox">
                                <span style="text-align: left; font-weight: 800">Service Animal?</span>
                                <input type="checkbox" name="serviceAnimal" value="1" style="margin-left:15px; margin-top: 8px">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <a class="search-button"> <!-- href="search.php"> -->
                                <input type ="submit" class="btn btn-primary btn-sm" style="margin-top: -5px" name="search" value="FIND MY PET!">
                            </a>
                        </div>
                    </form>
                </div>                    
            </div>
        </div>
    </div>
    <div id="carousel-divider"></div>


        <!-- LOGIN / REGISTER -->

    <body>
        <div class="container">

            <div class="row">
                <h3 align="center" style="font-family: 'Fredericka the Great' , cursive; color: #b90504; font-size: 30pt; border-bottom: 2px solid #cccccc">Login / Register</h3>
            </div>
            <div class="hor-divider"></div>
            <div id="wrap">
                <div class="form-group">
                    <div class="searchable-container">
                        <div class="items col-xs-5 col-sm-5 col-md-3 col-lg-3">
                            <div class="info-block block-info clearfix">
                                <div class="bizcontent">
                                    <form class="form-signin" action="login-register.php?action=login" method="post">
                                        <h2 class="form-signin-heading">Sign in</h2>
                                        <label for="inputUsername" class="sr-only">Username</label>
                                        <input type="username" id="inputUsername" name="loginUser" class="form-control" placeholder="Username" tabindex="-1" required autofocus>
                                        <label for="inputPassword" class="sr-only">Password</label>
                                        <input type="password" id="inputPassword" name="loginPass" class="form-control" placeholder="Password" tabindex="0" required>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" value="remember-me"> Remember me
                                            </label>
                                        </div>
                                        <input type="submit" name="signIn" id="signIn" value="Sign In" class="btn btn-primary pull-right">
                                    </form>  
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="span6">

                    <form role="form"  id="registration_form" action="login-register.php?action=register" method="post">
                        <fieldset>
                            <div class="col-lg-6">
                                <h2 class="form-signin-heading">Register</h2>
                                <div class="well well-sm"><strong></span>You must fill out every field.</strong></div>

                                <div class="form-group">
                                    <label for="InputUserName">Username</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                        <input type="text" class="form-control" name="input_userName" id="input_name" tabindex="1" placeholder="User Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="InputFirstName">First Name</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                        <input type="text" class="form-control" name="input_firstName" id="input_name" tabindex="2" placeholder="First Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="InputLastName">Last Name</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                        <input type="text" class="form-control" name="input_lastName" id="input_name" tabindex="3" placeholder="Last Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="InputEmail">Enter Email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                        <input type="email" class="form-control" id="input_email_first" name="input_email" tabindex="4" placeholder="example@domain.com" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="input_c_email">Confirm Email</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                        <input type="email" class="form-control" id="input_email_second" name="input_confirm_email" tabindex="5" placeholder="example@domain.com" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="input_pw">Enter Password</label>
                                    <div class="input-group">
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                        <input type="password" title="at least eight symbols containing at least one number, one lower, and one upper letter" class="form-control" id="input_pw" name="input_pw" tabindex="6" placeholder="Enter password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                    </div>
                                    <div class="form-group">
                                        <p></p>
                                        <label for="input_c_pw">Confirm Password</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-resize-vertical"></span></span>
                                            <input type="password" class="form-control" id="input_confirm_pw" name="input_confirm_pw" tabindex="7" placeholder="Confirm password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="InputPhoneNumber">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                            <input type="text" class="form-control" name="input_phoneNumber" id="input_phoneNumber" tabindex="8" placeholder="Phone Number">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="InputCity">City</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                            <input type="text" class="form-control" name="input_city" id="input_city" tabindex="9" placeholder="City">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="InputState">State</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                            <input type="text" class="form-control" name="input_state" id="input_state" tabindex="10" placeholder="State">
                                        </div>
                                    </div>

                                    <!--Checkbox for terms and conditions-->
                                    <label id="terms"> Do you accept our 
                                        <span>
                                            <a href="pdf/terms&conditions.pdf" download="terms&conditions.pdf">terms and conditions</a><span>&nbsp;&nbsp;</span>
                                        </span> 
                                        <span>
                                            <input type="checkbox" name="accept_privacy" value="privacy"></input>
                                        </span>
                                    </label>
                                            </div>

                                            <input type="submit" name="register" id="btn_register" value="Register" class="btn btn-primary pull-right" onclick="">
                                            </div>
                                            </fieldset>
                                            </form>

                                            <div class="col-lg-6" id="confirmationbox">
                                                <div class="col-lg-6">
                                                    <div class="alert alert-success" id="success" style="display:none">
                                                        <strong><span class="glyphicon glyphicon-ok"></span> Success! You have been registered!</strong>
                                                    </div>
                                                </div>
                                            </div>

                                            </div>
                                            </div>
                                            </div>
                                            <!-- FOOTER -->
                                            <div class="container-fluid panel-footer footer" style="padding: 0">
                                                <div class="jumbotron" style="margin: 0; height: 140px; padding: 10px; background-color: #e8e8e8;">
                                                    <span class="divider"><br></span>
                                                </div>
                                                <div class="jumbotron" style="margin: 0; height: 40px; padding: 10px; background-color: #333333;">
                                                    <footer>
                                                        <p class="pull-right"><a href="#">Back to top</a></p>
                                                        <p>&copy; 2015 Happy Tails, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
                                                    </footer>
                                                </div>
                                            </div>

                                            
                                <script>   
                                    /************************************************
                                     Makes sure that you can't write different passwords
                                     ************************************************/
                                    var password = document.getElementById("input_pw")
                                            , confirm_password = document.getElementById("input_confirm_pw");

                                    function validatePassword() {
                                        if (password.value != confirm_password.value) {
                                            confirm_password.setCustomValidity("Passwords Don't Match");
                                        }
                                        else {
                                            confirm_password.setCustomValidity('');
                                        }
                                    }

                                    password.onchange = validatePassword;
                                    confirm_password.onkeyup = validatePassword;


                                    /************************************************
                                     Makes sure that you can't write different emails
                                     ************************************************/
                                    var email = document.getElementById("input_email_first")
                                            , confirm_email = document.getElementById("input_email_second");

                                    function validateEmail() {
                                        if (email.value != confirm_email.value) {
                                            confirm_email.setCustomValidity("Emails don't match");
                                        }
                                        else {
                                            confirm_email.setCustomValidity('');
                                        }
                                    }

                                    email.onchange = validateEmail;
                                    confirm_email.onkeyup = validateEmail;
                                </script>

                                            <!-- Makes the successbox appear when button is pressed-->
                                            <?php
                                            if (isset($_POST['reg'])) {
                                                echo "<script>$('#success').slideDown()</script>";
                                                }
                                                if(Client::loggedIn()) {
                                                    echo "<script>alert('You have been logged in as "."{$_SESSION['username']}"."');</script>";
                                                }
                                            ?>
                                            </body>

                                            </html>
                                            

