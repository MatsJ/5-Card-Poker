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

        <title>Pet Care</title>

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
                            <div id="care" class="col-sm-2 menu-item text-center menu-item-active" style="  border-left: 3px solid #ac2925;   border-right: 3px solid #ac2925">
                                <a href="care-info.php">Pet Care Info</a>
                            </div>
                            <div id="about" class="col-sm-2 menu-item text-center" style="  border-right: 3px solid #ac2925; ">
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


            <!-- PET CARE INFO -->

        <div class="container marketing">
            <div class="row">
                <h3 align="center" style="font-family: 'Fredericka the Great' , cursive; color: #b90504; font-size: 30pt; border-bottom: 2px solid #cccccc">Pet Care Info</h3>
            </div>
            <div class="hor-divider"></div>
            <div class="row">            
                <div class="col-lg-12" align="center">
                    <div class="img-rounded" style="width:1000px; height:330px; background-color: pink;margin-bottom: 15px;">
                        <p style="text-align: center; font-size: 30px; font-family: Verdana">Cats</p>
                        <p style="text-align: left; font-size: 18px; font-family: Verdana; padding-left: 5px;padding-right: 5px;">Choose right kind of food for building strong bones and teeth, adding muscle, and supplying all the energy needed for play and learning. 
                        Keep cats away from plastic and other kinds of trash. Visit a vet immediately if the cat falls sick. Use sprays to protect them from diseases. Get the cat vaccinated once a year. 
                        If the cat is unwell or recovering from a disease, speak to the vet about adjusting its food habits. 
                        Keep the cat groomed by cutting its nails at regular intervals. Brush its fur regularly. Use warm water to bath the cat but they need not be bathed often.
                        Take special care of its diet as it grows older to maintain its health and optimum body weight. They should be provided with good drinking water. Two square meals a day is recommended.
                        Kittens need more energy than adult cats. Vet doctors recommend that kittens be feed commercial milk only after four weeks of birth. 
                        Cats should be handled gently. Arrange for a clean and dray place to house the cat and also provide a litter box to maintain hygiene.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container marketing">
            <div class="row">
                <div class="col-lg-12" align="center">
                    <div class="img-rounded" style="width:1000px; height:330px; background-color: pink;margin-bottom: 15px;">
                        <p style="text-align: center; font-size: 30px; font-family: Verdana">Dogs</p>
                        <p style="text-align: left; font-size: 18px; font-family: Verdana; padding-left: 5px;padding-right: 5px;">Choose right kind of food for building strong bones and teeth, adding muscle, and supplying all the energy needed for play and learning.
                        Keep puppies away from plastic and other kinds of trash. Visit a vet immediately if the puppy falls sick. Use sprays to protect them from diseases. Spray should be done before the dog has exposure to heat.
                        Take the dog out for walk at least two times a day but avoid taking them for walks on the grass to prevent ham due to toxic lawn products. Keep water and dog-treats handy while exercising the dog.
                        Teach the dog to sit on cue and interact with people. Start teaching them manners as soon as possible. While dogs generally require one or two meals a day, puppies tend to eat at more regular intervals. 
                        Puppies should be fed high quality branded food. Avoid "people food" for puppies. Keep the dogs clean by brushing regularly. However they do not have to be bathed often. A training crate is ideal for a dog to take rest. 
                        Else make up a dog bed out of a wooden box and place a clean blanket in it.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container marketing">
            <div class="row">
                <div class="col-lg-12" align="center">
                    <div class="img-rounded" style="width:1000px; height:330px; background-color: pink;margin-bottom: 15px;">
                        <p style="text-align: center; font-size: 30px; font-family: Verdana">External Links</p>
                        <p style="text-align: center; font-size: 22px; font-family: Verdana"><a href="https://www.avma.org/">American Veterinary Medical Association</a></p>
                        <p style="text-align: center; font-size: 22px; font-family: Verdana"><a href="http://bestfriends.org/">Best Friends Animal Society</a></p>
                        <p style="text-align: center; font-size: 22px; font-family: Verdana"><a href="http://www.petclassroom.com/">Pet Classroom</a></p>
                        <p style="text-align: center; font-size: 22px; font-family: Verdana"><a href="http://pets.webmd.com/">Web MD</a></p>
                        <p style="text-align: center; font-size: 22px; font-family: Verdana"><a href="http://www.aspca.org/">ASPCA</a></p>
                        <p style="text-align: center; font-size: 22px; font-family: Verdana"><a href="http://www.petco.com/">PETCO</a></p>
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
