<?php
require('config.php');   

if(isset($_GET['animal_id']))
   {
       $animal_id=$_GET['animal_id'];
       $newAccount = new Account('','','');
       $result = $newAccount->removePosting($conn, $_SESSION['client_id'], $animal_id);
       echo 'Record successfully deleted';    
    if($result)
    {
        header('location:edit-posting.php');
    }
   }

    if (Client::loggedIn()) {        
        $output .= 'You are currently logged in as: ' . $_SESSION['username'] . '. 
            <h4>do you want to <a href="login-register.php?action=logout">logout</a>?</h4>';
        $output .= '<h3> your client id is: ' . $_SESSION['client_id'];
    }
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

        <title>Delete</title>

        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Carousel CSS -->
        <link href="styles/carousel.css" rel="stylesheet">

        <!-- Custom Page CSS -->
        <link href="styles/elements.css" rel="stylesheet">
        <link href="styles/account.css" rel="stylesheet">
        
        <!-- Bootstrap core JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.js"></script>

        <!-- Happy Tails JavaScript -->
        <script src="js/happyTails.js"></script>

        
        <!-- FONTS -->
        <link href='http://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Fredericka+the+Great' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
        

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
                         <a href="login-register.php">Login / Register</a><br>                    </div>
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
                                    <option value="black">Black</option>
                                    <option value="white">White</option>
                                    <option value="yellow">Yellow</option>
                                    <option value="brown">Brown</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="dropdown">
                                <span style="padding-right: 10px">Location(state):</span>
                                <select class="btn btn-default" name="state" style="float: right">
                                    <option value="" selected="selected">All</option>
                                    <option value="CA">CA</option>
                                    <option value="NV">NV</option>
                                    <option value="NY">NY</option>
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
    
    <div id="carousel-divider"></div>
<hr>
                <h3 id="edit_account">Delete account posting</h3>

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

    </body>
</html>