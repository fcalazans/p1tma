<!--TMA
Student Name: Fabio H. Calazans Silveira.
Student ID: 13503878
Username: fcalaz01
Modulo Name: Web Programming using PHP - P1.
Tutor: Ian Hollender.
-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TMA Script | Dynamic webpage</title>
</head>
<body>
    <?php require_once 'includes/functions.php';?>

<?php

    // Title of the Document.
    echo '<header><h1>TMA Sample Output for all Data Files</h1>';

    # Initialization.
    // Define arrays to hold data from each file.
    $fileData = array();
    $fileNames = array();
    $files = array();
    $moduleCode = array();
    $moduleTitle = array();
    $moduleTutor = array();
    $moduleDate = array();

    // Create a handle
    $handle = opendir('data');

    // Open directory and read contents.
    while (false !== ($file = readdir($handle))) {

        // Check if file extension is valid to read
        if (is_file('data/' . $file)) {
            $path_extension = pathinfo($file);
            if ($path_extension['extension'] != 'txt') {
                echo "<p>P1 TMA data $file : INVALID FILE EXTENSION- should be .txt</p>";
            }
            if ($path_extension['extension'] == 'txt') {
                $fileNames[] = pathinfo($file, PATHINFO_FILENAME);
                $files[] = $file;
            }
        }
    }

    // Close handle.
    closedir($handle);

    // Displaying header information.
    $newArr = array();

    foreach ($files as $key => $value) {
        $handle = fopen('data/' . $files[$key], 'r');
        $index = 0;
        $studentID = array();
        $studentMark = array();

        while (!feof($handle)) {
            $fileData = fgetcsv($handle);

            if ($index == 0) {
                // $moduleHeader = $fileData;

                $moduleCode[] = $fileData[0];
                $moduleTitle[] = $fileData[1];
                $moduleTutor[] = $fileData[2];
                $moduleDate[] = $fileData[3];
            } else {
                $studentID[] = $fileData[0];
                $studentMark[] = $fileData[1];
            }
            $index++;
        }
        // Display Module Header Data title.
        echo "<p>Module Header Data...</p>";

        // Display file name.
        echo "File name : " . $files[$key] . "<br/>";
        // Header.
        validateHeader($moduleCode[$key], $moduleTitle[$key], $moduleTutor[$key], $moduleDate[$key]);
        echo "</header>";

        // Display Student ID and Mark Array.
        echo "<section><p>Student ID and Mark data read from file...</p>";
        studentData($studentID, $studentMark);
        echo "</section>";

        // Display the ID"s and to be included.
        echo "<section><p>ID's and module marks to be included...</p>";
        studentDataIncluded($studentID, $studentMark);
        echo "</section>";

        // Display Statistical Analysis of the module marks.
        echo "<section><P>Statistical Analysis of module marks...</P>";
        analytics($studentID, $studentMark);
        echo "</section>";

        // End of Document
        echo "<footer><hr></footer> ";
        $headerErrorCheck = 0;
    }

?>
</body>
</html>