<?php
require_once('config.php');

//client can only access post-adoption if logged in
if (!Client::loggedIn()) {
    echo "<script type='text/javascript'>alert('You must be logged in to post a profile.');
    location.href='login-register.php';</script>";
    exit;
}
//check for form data
$success = FALSE;
if (isset($_GET['action'])) {
    if (!(empty($_POST['type']) ||
            empty($_POST['name']) ||
            empty($_POST['sex']) ||
            empty($_POST['age']) ||
            empty($_POST['breed']) ||
            empty($_POST['color']) ||
            empty($_POST['size']) ||
            empty($_POST['description']) ||
            empty($_POST['city']) ||
            empty($_POST['state']) ||
            empty($_FILES) ||
            !isset($_FILES['image']))) {
        
        if (isset($_POST['isServiceAnimal'])) {
            $service = 'yes';
        } else {
            $service = 'no';
        }

        //create new Animal from form data
        $animal = new Animal($_POST['type'], 
                             $_POST['name'], 
                             $_POST['sex'], 
                             $_POST['age'], 
                             $_POST['breed'], 
                             $_POST['color'], 
                             $_POST['size'], 
                             $service, 
                             $_POST['description'], 
                             $_POST['city'], 
                             $_POST['state'], 
                             $_SESSION['client_id']);
        //add animal to db
        if ($animal->addAnimal($conn)) {
            $fp = fopen($_FILES['image']['tmp_name'], 'rb');
            $animalId = $conn->lastInsertId();
            $date = date('Y-m-d H:i:s');

            //create new image if animal was successfully created
            $media = new Media('image', 
                               $_FILES['image']['name'], 
                               $_FILES['image']['type'], 
                               $fp, $_FILES['image']['size'], 
                               $date, 
                               $animalId);
            //add image to db
            if ($media->addMedia($conn)) {
                $success = TRUE;
                $message = "You've successfully created your pet's profile.";
            } else { /* failure uploading image */
                $message = "Something went wrong uploading your image, please try again later.";
            }
        } else {/* failure uploading pet */
            $message = "Something went wrong, please try again later.";
        }
    } else {
       $message = "Please fill out all required fields.";
    }
    echo "<script type='text/javascript'>alert('$message');</script>";
    if($success){
        header('Location: pet-profile.php?animal_id=' . "{$animalId}");
        exit;
    }
}
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

        <title>Post Adoption</title>

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

        <!-- Script for toggling visibility of elements by id --> 
        <script type="text/javascript">

            function toggler(divId) {
                $("#" + divId).toggle();
            }

        </script>

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
                            <div id="post" class="col-sm-3 menu-item text-center menu-item-active" style="  border-left: 3px solid #ac2925;" >
                                <a href="post-adoption.php">Put Up For Adoption</a>
                            </div>
                            <div id="care" class="col-sm-2 menu-item text-center" style="  border-left: 3px solid #ac2925;   border-right: 3px solid #ac2925">
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

        <!-- POST ADOPTION CONTENT -->
        <div class="container" style="margin-bottom: 20px">
            <div class="row">
		<h3 align="center" style="font-family: 'Fredericka the Great' , cursive; color: #b90504; font-size: 30pt; border-bottom: 2px solid #cccccc">Put Up For Adoption</h3>
            </div>
            <div class="hor-divider"></div>
            <form role="form" id="adoption_form" action="post-adoption.php?action=submit" method="post" enctype="multipart/form-data">
            <div class="col-lg-6">
                <div class="img-rounded" style="width: 500px; height: 600px; background-color: pink;">
                    <div class="row">
                        
                        <p align="center" style="font-family: 'Fredericka the Great' , cursive; color: #b90504; font-size: 20pt;">Pet's details</p>
                    </div>
                    <p align="left" style="color: red; padding-left: 10px">Required *</p>
                    <div class="col-lg-6" style="padding:15px">
                        <div class="row">
                            <div class="col-lg-4" style="padding:10px">
                                <strong>Name:</strong> <span style="color:red">*</span>
                                <input type="text" placeholder="Pet's name" name="name" style="width: 150px">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4" style="padding:10px">
                                <strong>Type:</strong> <span style="color:red">*</span>
                                <select name ="type" id="typeUp" style="width: 150px" onchange="populateBreeds();">
                                    <option></option>
                                    <option>dog</option>
                                    <option>cat</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4" style="padding:10px">
                                <strong>Sex:</strong> <span style="color:red">*</span>
                                <select name="sex" style="width: 150px">
                                    <option>male</option>
                                    <option>female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4" style="padding:10px">
                                <strong>Breed:</strong> <span style="color:red">*</span>
                                <select name="breed" id="breedUp" style="width: 150px">
                                    <option>select a type first</option>   
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4" style="padding:10px">
                                <strong>Age:</strong> <span style="color:red">*</span>
                                <select name="age" style="width: 150px">
                                    <option>puppy/kitten</option>
                                    <option>young</option>
                                    <option>adult</option>
                                    <option>senior</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4" style="padding:10px">
                                <strong>Color:</strong>
                                <select name="color" style="width: 150px">
                                    <option>Other</option>
                                    <option>Black</option>
                                    <option>Brown</option>
                                    <option>White</option>
                                    <option>Yellow</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4" style="padding:10px">
                                <strong>Size:</strong> <span style="color:red">*</span>
                                <select name="size" style="width: 150px">
                                    <option>small</option>
                                    <option>medium</option>
                                    <option>large</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" style="padding:15px">
                        <div class="row">
                            <div class="col-lg-6" style="padding:10px">
                                <strong>City:</strong> <span style="color:red">*</span>
                                <input type="text" name="city" size="20">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6" style="padding:10px">
                                <strong>State:</strong> <span style="color:red">*</span>
                                <select name="state" style="width: 150px">
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
                        </div> 

                        <div class="row">
                            <div class="col-lg-7" style="padding:10px">
                                <strong>Service Animal?</strong> <input type="checkbox" name="service">
                            </div>
                        </div>    

                        <div class="row">
                            <div class="col-lg-7" style="padding:10px">
                                <strong>Upload Photo:</strong> <span style="color:red">*</span>
                                <input type="file" name="image" id="image">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6" style="padding:10px">
                                <strong>Upload Video:</strong>
                                <input type="file" name="videoUpload">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
            <div class="img-rounded" style="width: 500px; height: 600px; background-color: pink;">
                <div class="row">
                        <p align="center" style="font-family: 'Fredericka the Great' , cursive; color: #b90504; font-size: 20pt;">Description</p>
                </div>
                <p align="left" style="color: red; padding-left: 10px">Required *</p>
                <div class="col-lg-6" style="padding: 15px;">
                    <div class="row">
                        <div class="col-lg-6" style="padding:10px;">
                            <strong>Description</strong> <span style="color:red">*</span>
                            <textarea name="description" placeholder="Describe your pet. Is it friendly with kids? Other cats or dogs? Let people know." form="adoption_form" rows="12" cols="50"></textarea>
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-lg-6" style="padding:10px">
                        <button type="submit" class="btn btn-lg btn-primary" name="submit">Put up for Adoption</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
            </form>
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
        <script src="js/happyTails.js"></script>
    </body>
</html>