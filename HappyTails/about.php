<?php
require('config.php');
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

        <title>About us</title>

        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

        <!-- Carousel CSS -->
        <link href="styles/carousel.css" rel="stylesheet">

        <!-- Custom Page CSS -->
        <link href="styles/elements.css" rel="stylesheet">

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
                            <div id="search" class="col-sm-2 menu-item text-center" onclick="setActive('search-dropdown')">
                                <a href="#search.php">Search</a>                               
                            </div>
                            <div id="post" class="col-sm-3 menu-item text-center" style="  border-left: 3px solid #ac2925;" >
                                <a href="post-adoption.php">Put Up For Adoption</a>
                            </div>
                            <div id="care" class="col-sm-2 menu-item text-center" style="  border-left: 3px solid #ac2925;   border-right: 3px solid #ac2925">
                                <a href="care-info.php">Pet Care Info</a>
                            </div>
                            <div id="about" class="col-sm-2 menu-item text-center menu-item-active" style="  border-right: 3px solid #ac2925; ">
                                <a href="about.php">About Us</a>
                            </div>
                            <div id="contact" class="col-sm-3 menu-item text-center">
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
    </div>
    <div id="carousel-divider"></div>


           <!-- ABOUT US -->
    <div class="container marketing">
        <div class="row">
            <h3 align="center" style="font-family: 'Fredericka the Great' , cursive; color: #b90504; font-size: 30pt; border-bottom: 2px solid #cccccc">About us</h3>
        </div>
        <div class="hor-divider"></div>
        <div class="row">
            <div class="col-lg-12" align="center" style="padding-bottom: 20px;">
                <div class="img-rounded" style="width:1000px; height:330px; background-color: pink;">
                    <p style="text-align: left; font-size: 18px; font-family: Verdana; padding: 5px;">
                        Happy Tails is a team of five software developers working towards building an attractive and convenient online interface for people
                        who are looking forward to adopt a pet and also those who are looking out for a suitable new home to give up their pet for adoption.
                        We facilitate the adoption of young and old animals who are in desperate need of new homes. We have
                        a wide variety to pets to choose from. Attractive photographs and videos make the pet viewing and searching experience enjoyable.
                        Care is taken to keep the process straight-forward and simple so as to enable users across all age-groups to use the application
                        without seeking external help. 
                        <br/>
                        Happy Tails hopes to create awareness among people about the ease of adoption with its application strategies. Our team aims to establish a personal connection
                        with adopters, pets and pet-owners by providing them clear and specific details to make this process of adoption simpler. We also make sure to protect the privacy 
                        of the users to prevent them from being harassed. 
                        <br/>
                        <strong>Disclaimer: </strong>We do not accept liability for any kind of loss or harm caused by any animal listed in our pages. 
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container marketing">
        <div class="row">
            <div class="col-lg-4">
                <img class="img-circle" src="images/Alex.jpg" alt="Generic placeholder image" width="140" height="140">
                <p>kibis858@gmail.com</p>
            </div>
            <div class="col-lg-4">
                <div class="img-rounded" style="width:680px; height:260px; background-color: pink;">
                    <p style="text-align: center; font-size: 20px; font-family: Verdana">Aleksandr Kibis</p>
                    <p style="text-align: left; font-size: 18px; font-family: Verdana; padding: 5px;">
                        Alex is an undergraduate student at San Francisco State University pursuing Computer Science. 
                        He previously worked as an Administrative Professional at Booz Allen Hamilton doing security testing and web administration. 
                        He currently works at 21Tech as an IT Intern focusing on SQL QA and Debugging. 
                        Born in Russia, he moved to the US during childhood. 
                        His future prospects include multimedia web applications, distributed computing, machine learning, and artificial intelligence.
                        Alex serves as the <strong>Chief Executive Officer</strong> at Happy Tails!
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <img class="img-circle" src="images/John.jpg" alt="Generic placeholder image" width="140" height="140">
                <p>santos.john24@gmail.com</p>
            </div>
            <div class="col-lg-4">
                <div class="img-rounded" style="width:680px; height:260px; background-color: pink;">
                    <p style="text-align: center; font-size: 20px; font-family: Verdana">John Santos</p>
                    <p style="text-align: left; font-size: 18px; font-family: Verdana; padding: 5px;">
                        John is a undergrad computer science student. He chose the major because he believes that since we are living in the information era, knowing lots of things in technology is a big advantage. 
                        He is interested in starting his own company later on in his life. He wants it to be something remarkable that will bring a change in the world. 
                        He is also interested in knowing different technologies and enhance his coding skills. 
                        John serves as the <strong>Chief Technology Officer</strong> of Happy Tails!
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <img class="img-circle" src="images/James.jpg" alt="Generic placeholder image" width="140" height="140">
                <p>j.klinkhammer@yahoo.com</p>
            </div>
            <div class="col-lg-4">
                <div class="img-rounded" style="width:680px; height:260px; background-color: pink;">
                    <p style="text-align: center; font-size: 20px; font-family: Verdana">James Klinkhammer</p>
                    <p style="text-align: left; font-size: 18px; font-family: Verdana; padding: 5px;">
                        James is an Undergraduate Computer Science major at San Francisco State University. 
                        Originally from the Central valley, he transferred to SF State in August of 2013. 
                        He will be graduating with a B.S. in Computer Science in the Fall of 2015.
                        He currently works as an intern for Xyicon in Napa,CA. 
                        His current interests include software development, motorcycles, and Dota. 
                        James serves as the <strong>Business Analyst</strong> of Happy Tails!
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <img class="img-circle" src="images/Mats.jpg" alt="Generic placeholder image" width="140" height="140">
                <p>matsjens1@gmail.com</p>
            </div>
            <div class="col-lg-4">
                <div class="img-rounded" style="width:680px; height:260px; background-color: pink;">
                    <p style="text-align: center; font-size: 20px; font-family: Verdana">Mats Jensen</p>
                    <p style="text-align: left; font-size: 18px; font-family: Verdana; padding: 5px;">
                        Mats is a 23 year old undergraduate student of Computer Science. He hails from Oslo, Norway where he is a 2nd year student at University College in Oslo and Akershus. 
                        He is studying programming and system development. 
                        He is spending the spring semester of 2015 at the San Francisco State University. 
                        His interests include web-design, software development, basketball and music. Mats serves as the <strong>Senior Software Engineer</strong> at Happy Tails!
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <img class="img-circle" src="images/Harini.jpg" alt="Generic placeholder image" width="140" height="140">
                <p>parth.harini@gmail.com</p>
            </div>
            <div class="col-lg-4">
                <div class="img-rounded" style="width:680px; height:260px; background-color: pink;">
                    <p style="text-align: center; font-size: 20px; font-family: Verdana">Harini Parthasarathy</p>
                    <p style="text-align: left; font-size: 18px; font-family: Verdana; padding: 5px;">
                        Harini is a graduate student of Computer Science at the San Francisco State University. 
                        She holds a degree in Instrumentation Technology from the VT university in Bangalore, India.
                        Prior to joining SFSU, she worked at JP Morgan Chase as a Technical Operations Engineer.
                        Her interests include web designing, traveling, reading and music. 
                        She is also the author of a couple of books and some short stories. 
                        Harini serves as the <strong>User Experience Lead</strong> at Happy Tails!
                    </p>
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

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>                    

    <!-- Happy Tails JavaScript -->
    <script src="js/happyTails.js"></script>
    <script language="javascript" type="text/javascript">

        // Turn off carousel auto-slide
        $('.carousel').carousel({
            interval: false
        });                            

    </script>

</head>
</html>
</script>
</body>
</html>
