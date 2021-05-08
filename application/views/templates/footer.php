</script>
        <script src="vendors/jquery-1.9.1.js"></script>
        <link href="vendors/datepicker.css" rel="stylesheet" media="screen">
        <script src="vendors/bootstrap-datepicker.js"></script>
        <!-- datepickers -->
    </body>
    <style type="text/css">
   #loader {
        border: 5px solid #f3f3f3; /* Light grey */
        border-top: 5px solid #C0C0C0; /* Blue */
        border-radius: 50%;
        width:20px;
        height:20px;
        position:absolute;
        left:50%; /* centers the loading animation horizontally one the screen */
        top:50%;
        margin:-100px 0 0 -100px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    #preloader {
        position:fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        background-color: #000000; /* change if the mask should have another color then white */
        z-index:99; /* makes sure it stays on top */
        opacity: 0.5;
    }
    </style>

</html>
