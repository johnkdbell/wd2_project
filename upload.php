<?php
    function file_upload_path($original_filename, $upload_subfolder_name = 'avatars')
    {
       $current_folder = dirname(__FILE__);
       $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
       return join(DIRECTORY_SEPARATOR, $path_segments);
    }

    function file_is_an_image($temporary_path, $new_path)
    {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = getimagesize($temporary_path)['mime'];
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }

    $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

    if ($image_upload_detected)
    { 
        $image_filename       = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename);

        if (file_is_an_image($temporary_image_path, $new_image_path))
        { 
            move_uploaded_file($temporary_image_path, $new_image_path);

            require_once('connect.php');
            session_start();
            
            $query = "INSERT INTO project_blog_users (userAvatar) VALUES (:userAvatar)";
            $statement = $db->prepare($query);
            $statement->bindValue(':userAvatar', $new_image_path);

            print_r($new_image_path);
        }
    }

?>