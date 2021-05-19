<?php
    $ClientName = $_GET['ClientName'];
    $path = 'JoinImages\uploads';
    $files = array_diff(scandir($path), array('.', '..'));
    $filesArray = (array) null;
    // Getting array of photos with client name
    foreach ($files as $file_to_delete)
    {
        if(str_contains (basename($file_to_delete, ".d").PHP_EOL, $ClientName ))
        {
            array_push($filesArray, $file_to_delete);
        }
    }
    // Getting photo with greatest id
    $file_to_delete = $filesArray[0];
    for($i=1;$i<count($filesArray);$i++)
    {
        $NameArrayAux = explode('_', $filesArray[$i]);
        $CurrentFileID = $NameArrayAux[count($NameArrayAux)-1];
        $NameArrayAux2 = explode('_', $file_to_delete);
        $FileToDeleteID =  $NameArrayAux2[count($NameArrayAux2)-1];
        if(intval($CurrentFileID > $FileToDeleteID))
            $file_to_delete = $filesArray[$i];
    }
    // Deleting the photo
    unlink($path."\\".$file_to_delete);
?>