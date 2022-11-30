<!doctype html>
<html lang="en">

<head>
    <title>e-OJT aCCeSs | Password Recovery</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

    <link href="../img/icon/ccs_logo.png" rel="icon">

    <!-- Custom fonts for this template -->
    <link href="../coordinator/vendor1/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="../login-page-bootstrap-design/css/style.css">

</head>

<style type="text/css">
    /*@import url('https"//fonts.googleapis.com/css?family=Poppins'):*/

    .indicator {
        height: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: 10px 0;
        display: none;

    }

    .indicator span {
        width: 100%;
        height: 100%;
        background: lightgrey;
        border-radius: 5px;
    }

    .indicator span.medium {
        margin: 0 3px;
    }

    .indicator span:before {
        content: '';
        position: absolute;
        width: 33%;
        height: 6%;
        border-radius: 5px;
    }

    .indicator span.active.weak:before {
        background-color: #ff4747;
    }

    .indicator span.active.medium:before {
        background-color: orange;
    }

    .indicator span.active.strong:before {
        background-color: #23ad5c;
    }

    .text_indicator {
        font-weight: 500;
        margin-bottom: 10px;
        display: none;
    }

    .text_indicator.weak {
        color: #ff4747;
    }

    .text_indicator.medium {
        color: orange;
    }

    .text_indicator.strong {
        color: #23ad5c;
    }

    .want_to_sign_in:hover {
        text-decoration: underline;
        color: #800000;
    }

    .mystyle {
        opacity: 98%;
        background: url('../img/lspu_bg.jpg');
        background-repeat: no-repeat;
        background-size: 100% 100%;

    }

    .link_ {
        color: orange;
    }

    .link_:hover {
        text-decoration: underline;
    }

    .errorWrap {
        color: black;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #dd3d36;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    .succWrap {
        color: black;
        padding: 10px;
        margin: 0 0 20px 0;
        background: #fff;
        border-left: 4px solid #5cb85c;
        -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
        box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
    }

    #email {
        border: 2px solid gray;
        color: #333333;
        background: white;
    }

    #email:focus {
        color: black;
        border: 1px solid #800000;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
    }

    #new_password {
        border: 2px solid gray;
        color: #333333;
        background: white;
    }

    #new_password:focus {
        color: black;
        border: 1px solid #800000;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
    }

    #confirm_password {
        border: 2px solid gray;
        color: #333333;
        background: white;
    }

    #confirm_password:focus {
        color: black;
        border: 1px solid #800000;
        box-shadow: none;
        outline-offset: 0px;
        outline: none;
    }

    #recover {
        background: #800000;
    }

    #recover:hover {
        background: #990000;
    }
</style>

<body class="mystyle">

    <script>
        function preback() {
            window.history.forward();
        }
        setTimeout("preback()", 0);
        window.onunload = function() {
            null;
        }
    </script>

    <div style="padding: 1px; background: rgba(0, 0, 0, 0.8);">

        <div style="margin-left: 10px;">
            <a href="https://lspu.edu.ph/" target="_blank"><b>lspu.edu.ph </b><img src="../img/icon/lspu_logo.png" width="30px" height="30px;"></a>
        </div>
    </div>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <!-- <h2 class="heading-section" style="font-family: Sans-serif; font-weight: bold; color: orange; text-shadow: 2px 2px 5px black;">CCS OJT Web Portal - Student</h2> -->
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="text-wrap p-4 p-lg-7 text-center d-flex align-items-center order-md-last" style="background: #800000;">
                            <div class="text w-100">
                                <img src="../img/icon/ccs_logo.png" width="100px" height="100px;">
                                <h2>Welcome to e-OJT aCCeSs Web Portal</h2>
                                <p>Password Recovery</p>
                            </div>
                        </div>
                        <div class="login-wrap p-4 p-lg-5" style="opacity: 95%">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4" style="font-weight: bold;"><i class="fas fa-user-shield"></i> Password Recovery</h3>
                                </div>
                            </div>

                            <form action="password_reset_code.php" class="signin-form" method="post">
                                <input type="" name="password_token" hidden="" value="<?php if (isset($_GET['token'])) {
                                                                                            echo $_GET['token'];
                                                                                        } ?>">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Your Email Address</label>
                                    <input id="email" type="text" readonly="" style="border-radius: 5px 5px 5px 5px;" class="form-control" name="email" autocomplete="off" value="<?php if (isset($_GET['email'])) {
                                                                                                                                                                                        echo $_GET['email'];
                                                                                                                                                                                    } ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="name">New Password</label>
                                    <input type="password" style="border-radius: 5px 5px 5px 5px;" maxlength="" id="new_password" name="new_password" onkeyup="trigger()" class="form-control" placeholder="Enter New Password" required>
                                    <div class="indicator">
                                        <span class="weak"></span>
                                        <span class="medium"></span>
                                        <span class="strong"></span>
                                    </div>
                                    <div class="text_indicator"></div>
                                </div>

                                <script>
                                    const indicator = document.querySelector(".indicator");
                                    const input = document.querySelector("#new_password");
                                    const weak = document.querySelector(".weak");
                                    const medium = document.querySelector(".medium");
                                    const strong = document.querySelector(".strong");
                                    const text = document.querySelector(".text_indicator");
                                    let regExpWeak = /[a-z]/;
                                    let regExpMedium = /\d+/;
                                    let regExpStrong = /.[!,@,#,$,%,^,&,*,?,_,~,-,(,)]/;

                                    function trigger() {
                                        if (input.value != "") {
                                            indicator.style.display = "block";
                                            indicator.style.display = "flex";
                                            if (input.value.length <= 3 && (input.value.match(regExpWeak) || input.value.match(regExpMedium) || input.value.match(regExpStrong))) no = 1;
                                            if (input.value.length >= 6 && ((input.value.match(regExpWeak) && input.value.match(regExpMedium)) || (input.value.match(regExpMedium) && input.value.match(regExpStrong)) || (input.value.match(regExpWeak) && input.value.match(regExpStrong)))) no = 2;
                                            if (input.value.length >= 8 && input.value.match(regExpWeak) && input.value.match(regExpMedium) && input.value.match(regExpStrong)) no = 3;
                                            if (no == 1) {
                                                weak.classList.add("active");
                                                text.style.display = "block";
                                                text.textContent = "Your password is too weak. Please contains symbols, number, and uppercase letter.";
                                                text.classList.add("weak");
                                            }
                                            if (no == 2) {
                                                medium.classList.add("active");
                                                text.textContent = "Your password is medium. Password must be atleast 8 characters. ";
                                                text.classList.add("medium");
                                            } else {
                                                medium.classList.remove("active");
                                                text.classList.remove("medium");
                                            }
                                            if (no == 3) {
                                                weak.classList.add("active");
                                                medium.classList.add("active");
                                                strong.classList.add("active");
                                                text.textContent = "Great! Your password is strong.";
                                                text.classList.add("strong");
                                                document.getElementById("recover").disabled = false;
                                            } else {
                                                strong.classList.remove("active");
                                                text.classList.remove("strong");
                                                document.getElementById("recover").disabled = true;
                                            }
                                            showBtn.style.display = "block";
                                            showBtn.onclick = function() {
                                                if (input.type == "password") {
                                                    input.type = "text";
                                                    showBtn.textContent = "HIDE";
                                                    showBtn.style.color = "#23ad5c";
                                                } else {
                                                    input.type = "password";
                                                    showBtn.textContent = "SHOW";
                                                    showBtn.style.color = "#000";
                                                }
                                            }
                                        } else {
                                            indicator.style.display = "none";
                                            text.style.display = "none";
                                            showBtn.style.display = "none";
                                        }
                                    }
                                </script>

                                <div class="form-group mb-3">
                                    <label class="label" for="name">Confirm Password</label>
                                    <input type="password" style="border-radius: 5px 5px 5px 5px;" maxlength="" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                                    <div class="">
                                        <span id="message" style="font-weight: 400;"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" name="password_update" id="recover" class="form-control btn btn-primary submit px-3" style="border-radius: 5px 5px 5px 5px;">Recover Your Password <i class="fas fa-key"></i></button>
                                </div>

                                <div class="form-group d-md-flex">
                                    <div class="w-50 text-left">

                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="../index.php" class="want_to_sign_in">Want to Sign In?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="sticky-footer bg" style="background: rgba(128, 0, 0, .8); margin-top: 0px; padding: 29.5px; ">
        <div class="container my-auto">
            <div class="copyright text-center my-auto" style="color: ghostwhite;">
                <span style="font-size: 14px; font-family: verdana;">e-OJT aCCeSs: OJT RECORDS MONITORING SYSTEM OF COLLEGE OF COMPUTER STUDIES - LSPU MAIN CAMPUS <B>V.2</B><br>© Copyright 2021. All Rights Reserved.</span><a class="link_" target="_blank" rel="" href="https://www.facebook.com/groups/1004436723245418/"> College of Computer Studies</a> - <a target="_blank" rel="" href="https://lspu.edu.ph/" class="link_"> LSPU-SCC</a>
            </div>
        </div>
    </footer>

    <script type="text/javascript">
        $('#new_password, #confirm_password').on('keyup', function() {
            if ($('#new_password').val() == $('#confirm_password').val()) {
                $('#message').html('Password is Matched!').css('color', 'green');
                document.getElementById("recover").disabled = false;
            }
            if ($('#new_password').val() != $('#confirm_password').val()) {
                $('#message').html('Password Does Not Matched!').css('color', 'red');
                document.getElementById("recover").disabled = true;
            }
            if ($('#new_password').val() == "" && $('#confirm_password').val() == "") {
                $('#message').html('').css('color', 'red');
                document.getElementById("recover").disabled = true;
            }
        });
    </script>


    <script src="login-page-bootstrap-design/js/jquery.min.js"></script>
    <script src="login-page-bootstrap-design/js/popper.js"></script>
    <script src="login-page-bootstrap-design/js/bootstrap.min.js"></script>
    <script src="login-page-bootstrap-design/js/main.js"></script>

</body>

</html>