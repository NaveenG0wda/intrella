<?php

?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <style>
        .darken {
            filter: brightness(60%) saturate(120%) !important;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            box-shadow: inset 0 -2px 0 #2fb380;
        }


        .bg-transparent.scrolled {
                background: #8cc53d !important;
                transition: .1s ease-in;
            }
        
    </style>
</head>
<body>
        <div class="min-vh-100 d-flex flex-column">

            <nav class="navbar fixed-top navbar-expand-lg bg-transparent">
                <div class="container-fluid">
                    <a class="navbar-brand text-white lead" href="#">
                    <img src="images/image.png" width="125" alt="logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link fs-6 active text-white" aria-current="page" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link fs-6 text-white" href="http://intrella.in/contact.html">Contact Us</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link text-white" href="user/index.php">User</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="employee/index.php">Employee</a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </nav>


            <div id="carouselExampleSlidesOnly" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-pause="false">
                <div class="carousel-inner">
                    <div class="carousel-item active" data-bs-interval="5000">
                        <img src="images/slider2.jpg" class="d-block max-vh-100 w-100" />
                        <div class="carousel-caption d-none d-md-block">
                        </div>
                    </div>
                </div>
            </div>



            <div class="gradient-custom-2 container-fluid pt-4 pb-3 ">
                <!-- <h4 class="text-center mb-2 fw-light text-light">Find your new place with Real Estate
                </h4>
                <p class="text-center fst-italic text-white">
                    Fusce risus metus, placerat in consectetur eu, porttitor a est sed sed
                    <br />
                    dolor lorem cras adipiscing
                </p> -->
            </div>

            <div class="bg-white container-fluid pt-4 pb-3">
                <h4 class="text-center mb-5 fw-light fs-4 text-green text-decoration-underline tug-2">Our Services
                </h4>
                <div class="row pt-3 justify-content-evenly">
                    <!-- <div class="col-md-3 text-center">
                        <i class="fa-solid fa-location-dot fa-3x text-green"></i>
                        <p class="mt-3 fs-5 lead text-green">Find places anywhere in the world</p>
                    </div> -->
                    <div class="col-md-3 text-center">
                        <a href="user/index.php" class="text-decoration-none">
                            <i class="fa-solid fa-user-group fa-3x text-green"></i>
                            <p class="mt-3 fs-5 lead text-green">Users</p>
                        </a>
                    </div>
                    <div class="col-md-3 text-center">
                        <a href="employee/index.php" class="text-decoration-none">
                            <i class="fa-sharp fa-solid fa-user-tie fa-3x text-green"></i>
                            <p class="mt-3 fs-5 lead text-green">Employees</p>
                        </a>
                    </div>
                    <!-- <div class="col-md-3 text-center">
                        <i class="fa-solid fa-cloud-arrow-up fa-3x text-green"></i>
                        <p class="mt-3 fs-5 lead text-green">With agent account you can list properties</p>
                    </div> -->
                </div>
            </div>


            <div class="flex-grow-1"></div>

            <footer class="gradient-custom-2 text-white text-center">
              Intrella <span id="year"></span>
            </footer>



        </div>

    <script src="js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>

    <script>
        $(function () {
            $(window).scroll(function () {
                $('nav').toggleClass('scrolled', $(this).scrollTop() > ($('#carouselExampleSlidesOnly').height() - $('nav').height()));
            });
            
            $("#year").html(new Date().getFullYear());
        })
    </script>
</body>
</html>
