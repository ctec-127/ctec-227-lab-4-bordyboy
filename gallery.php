<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/58eadb60b2.js" crossorigin="anonymous"></script>
</head>
<!-- <span class=\"badge badge-pill badge-dark p-0\"><i class=\"fas fa-times-circle fa-2x text-danger\"></i></span> -->
<body>
    
    <?php
    // display images function
    function display_images()
    {
        // start at current directory
        $dir = "uploads";
        if (is_dir($dir)) {
            if ($dir_handle = opendir($dir)) {
                while ($filename = readdir($dir_handle)) {
                    if (!is_dir($filename) && $filename != '.DS_Store') {
                        $filename = rawurlencode($filename);
                        // echo "<div class=\"text-center col-3\"><div class=\"pic mb-5\"><img class=\"img-fluid\" src=\"uploads/$filename\" alt=\"A photo\"></div>";
                        echo "
                        <div class=\"card mr-3 mt-3\" >
                            <img class=\"card-img-top\" src=\"uploads/$filename\" alt=\"Card image cap\">
                            <div>                          
                                <a href=\"gallery.php?file=$filename\" id=\"delete\" class=\"\">
                                    <i class=\"fas fa-times fa-2x text-danger\"></i>                        
                                </a>
                            </div>
                        </div>";
                        // echo "<a href=\"gallery.php?file=$filename\">Delete this picture </a></div>";                    
                    }
                } // end while
                // close the directory now that we are done with it
                closedir($dir_handle);
            } // end if
        } // end if
    }
    
    
    ?>


    <?php

    // Define these errors in an array
    $upload_errors = array(
        UPLOAD_ERR_OK                 => "No errors.",
        UPLOAD_ERR_INI_SIZE          => "Larger than upload_max_filesize.",
        UPLOAD_ERR_FORM_SIZE         => "Larger than form MAX_FILE_SIZE.",
        UPLOAD_ERR_PARTIAL             => "Partial upload.",
        UPLOAD_ERR_NO_FILE             => "Please select a file to upload",
        UPLOAD_ERR_NO_TMP_DIR         => "No temporary directory.",
        UPLOAD_ERR_CANT_WRITE         => "Can't write to disk.",
        UPLOAD_ERR_EXTENSION         => "File upload stopped by extension."
    );

    if ($_SERVER['REQUEST_METHOD'] == "GET"){
        if (isset($_GET['file'])){
            unlink("uploads/" . $_GET['file']);
            header("Location: gallery.php#gallery");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // what file do we need to move?
        $tmp_file = $_FILES['file_upload']['tmp_name'];

        // set target file name
        // basename gets just the file name
        $target_file = basename($_FILES['file_upload']['name']);
        // $target_file = str_replace(' ','_', $target_file);
        // set upload folder name
        $upload_dir = 'uploads';

        // Now lets move the file
        // move_uploaded_file returns false if something went wrong
        if (move_uploaded_file($tmp_file, $upload_dir . "/" . $target_file)) {
            $message = "File uploaded successfully";
        } else {
            $error = $_FILES['file_upload']['error'];
            $message = $upload_errors[$error];
        } // end of if
    }
    ?>
    
    <div class="container-fluid">
        <form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="text-center">
                                <h1 class="control-label text-white">Image Gallery</h1>
                            </div>
                            <div class="preview-zone hidden ">
                                <div class="box box-solid">
                                    <div class="box-header with-border preview-background">
                                        <div><b class="text-white">Preview</b></div>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-danger btn-xs remove-preview">
                                                <i class="fa fa-times"></i> Reset This Form
                                            </button>
                                        </div>
                                    </div>
                                    <div class="box-body preview-background"></div>
                                </div>
                            </div>
                            <div class="dropzone-wrapper">
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    <p>Choose an image file or drag it here.</p>
                                </div>
                                <input type="file" name="file_upload" class="dropzone">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right">Upload</button>
                        <?php
                        if (!empty($message)) {
                            echo "<p id=\"alert\" class=\"alert alert-primary mt-4\">{$message}</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </form>

        <div id="gallery" class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex flex-wrap flex-row align-items-center justify-content-center">
                    <?php display_images(); ?>
                </div>
            </div>
        </div>
    </div>
    

    <script src="script.js"></script>
</body>

</html>