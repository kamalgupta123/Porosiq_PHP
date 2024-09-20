<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
    <style>
 
    input[type="file"] {
        display: none !important;
    }
    .btn-success{    width:100%;    font-size: 22px;
        font-weight: bold;}
    .navbar-brand img{width:80%;}
    .well label, .well label img{width:100%;cursor:pointer;}
    .well{  background: #f6f6f6;
        border-top: 5px solid #479b25;}
    
    .custom-text{font-size:16px;display:none;}
    @media only screen and (max-width:767px){
    
    .header-text h1 {
        font-size: 20px;
        font-weight: bold;
        color: #03828a;
    }
    .well{padding:5px;width:100%;}
    #myform {
    margin-left: 0px;
        margin-right: 0px;
    }
    }
    
    </style>
</head>
<body>
    <div class="container proface-features">
    
    <div class="row">

    <div class="col-md-12"> 
    <h2>Combine multiple PDF Files or Images into a single PDF document without having to install any software.</h2>
    <div class="col-md-6"> 
    
    <div class="header-text single_like" >

    <p ><b>Step-1: </b>Select up to 20 PDF Files or images from your computer or drag them to the drop area. </p>
    <p ><b>Step-2: </b>Automatically download combine pdf file.</p>  
    </div>
    </div>
    <div class="col-md-6"> 
    <fieldset class="well">
        <form action="<?php echo base_url();?>welcome/combineImagePdf" name="myform" id="myform" method="post" enctype="multipart/form-data">
            <center><p class="custom-text">You have selected <span class="count-file">0</span> files</p></center>

                    <label for="file"><img src="<?php echo base_url();?>uploads/tools/drag-drop-file-upload.jpg" alt="drag-drop-file-upload"></label>
                                        <input type="file" name="files[]" id="file" multiple accept="image/png, image/jpeg,image/jpg,application/pdf" required/>
                
                    <input type="submit" name="submit" id="submit" value="SUBMIT" class="btn btn-success check"/>
                
        </form>
        </fieldset>
    </div>

    </div>
    </div>
    </div>
    <script>
        $(document).ready(function(){
        $("input#file").change(function(){
        var files = $(this)[0].files;
        if(files.length > 0){
        $(".count-file").text(files.length);
        $(".count-file").css("font-weight","bold");
        $(".count-file").css("color","red");
        $(".custom-text").css("display","block");
        $(".successerror-message").css("display","none");
        }
        });


        $("#submit").click(function(){

        $(".custom-text").text("Please Wait....");
        $(".custom-text").css("color","red");
        setTimeout(function () {
        $(".custom-text").text("");

        }, 2000);

        });

        });
    </script>
</body>
</html>