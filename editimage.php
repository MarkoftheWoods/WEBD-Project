<?php
  /*******************
  * WEBD Final Project - EditImage page
  * Name:     Mark Woods
  * Date:     April 8, 2020
  ********************/ 

  function valid_image_type($tmp_name)
  {
      $allowed_mime_types = ['image/gif', 'image/jpeg', 'image/png'];        
      $mime_type = mime_content_type($tmp_name);
        
      return in_array($mime_type, $allowed_mime_types);
  }
  
  function get_mime_extension($filename)
  {
    $return_value = "";
    Switch (mime_content_type($filename))
    {
      Case 'image/gif':
          $return_value = ".gif";
          break;
      Case 'image/jpeg':
          $return_value = ".jpg";
          break;
      Case 'image/png':
          $return_value = ".png";
          break;
    }
    return $return_value;
  }

  //Set the fighterID if not already set
  if (!(isset($fighterID)))
  {
    $fighterList = getAllFighters($db);
    $fighter = end($fighterList);
    $fighterID = $fighter['FighterID'];
  }

  // If a file was uploaded without errors
  if (isset($_FILES['image']) && ($_FILES['image']['error'] === 0))
  {
    $tmp_name = $_FILES['image']['tmp_name'];

    if (valid_image_type($tmp_name))
    {
      $imageURL   = $fighterID . get_mime_extension($tmp_name);
      $newfilepath = "images\\" .  $imageURL;
      move_uploaded_file($tmp_name, $newfilepath);

      $resized_image = new \Gumlet\ImageResize($newfilepath);
      $resized_image->resizeToWidth(200);
      $resized_image->save($newfilepath);

      $query = "INSERT into image (FighterID, ImageURL)
                        VALUES(:fighterid, :imageURL)";
                   
      $insertImage = $db->prepare($query);
      $insertImage->bindValue(':fighterid', $fighterID);
      $insertImage->bindValue(':imageURL', $imageURL);

      if ($insertImage->execute())
      {
        $filemessage = "Successfully added an image.";
      }
      else
      {
        $filemessage = "The image was not uploaded";
      }
    }
    else
    {
      $filemessage = "The image you submitted was not a valid image file.";
    }
  }
  else
  {
    $imageURL = null;
  }

  if (!isset($_FILES['image']) && (isset($_POST['deleteimage'])))
  {
    $imageURL = getImageURL($fighterID, $db);
    if ($_POST['deleteimage'] == 'on')
    {
      $query = "DELETE FROM image WHERE FighterID = :fighterid";
                   
      $statement = $db->prepare($query);
      $statement->bindValue(':fighterid', $fighterID);
      
      if ($statement->execute())
      {
        unlink("images/" . $imageURL);
        $filemessage = "Deleted image.";
      }
    }
  }

?>