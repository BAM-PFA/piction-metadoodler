<?php
echo "<html><body>";

include 'ftp.php';

// --- INITIALIZE METADATA.CSV COLUMNS
$HEADERS = "FILENAME|BAMPFA.TITLE|BAMPFA.ARTISTFILMMAKER|BAMPFA.YEAR|EVENTS.DC-COVERAGE|EVENTS.DC-PUBLISHER|EVENTS.RELATED_EXHIBITIONS|EVENTS.EVENT_LOCATION|EVENTS.DC-DESCRIPTION|EVENTS.DC-TYPE|EVENTS.DC-SUBJECT|EVENTS.TOPICAL_SUBJECT|EVENTS.ORGANIZER|EVENTS.DC-CONTRIBUTOR|EVENTS.DC-RIGHTS|EVENTS.DC-AUTHOR|EVENTS.TAGS|EVENTS.BAM_PFA_CAPTION|EVENTS.RESTRICTIONS|EVENTS.DC-CREATOR|FILM.BAM_PFA_CAPTION|FILM.DC-CONTRIBUTOR|FILM.DC-CREATOR|FILM.DC-DESCRIPTION|FILM.DC-PUBLISHER|FILM.DC-RIGHTS|FILM.DC-SUBJECT|FILM.DC-TYPE|FILM.RESTRICTIONS|FILM.TAGS|GALLERY EXHIBITION.ARTWORK_CREDIT_LINE|GALLERY EXHIBITION.ARTWORK_MEDIUM|GALLERY EXHIBITION.BAM_PFA_CAPTION|GALLERY EXHIBITION.CURATOR|GALLERY EXHIBITION.DC-CONTRIBUTOR|GALLERY EXHIBITION.DC-COVERAGE|GALLERY EXHIBITION.DC-CREATOR|GALLERY EXHIBITION.DC-DESCRIPTION|GALLERY EXHIBITION.DC-PUBLISHER|GALLERY EXHIBITION.DC-RIGHTS|GALLERY EXHIBITION.DC-TITLE|GALLERY EXHIBITION.DC-TYPE|GALLERY EXHIBITION.EXHIBITION LOCATION|GALLERY EXHIBITION.FULL_EXHIBIT_DATE|GALLERY EXHIBITION.PHOTO_CREDIT|GALLERY EXHIBITION.RESTRICTIONS|GALLERY EXHIBITION.TAGS|XMP.USAGETERMS";
// METADATA_VALUES WILL HAVE EACH ELEMENT IN THE ARRAY AS A ROW TO BE OUTPUT TO CSV
$METADATA_VALUES = [];
$metadataFieldNames = array("bampfatitle","bampfaartist","bampfayear","eventfulldate","eventseries","eventrelatedex","eventlocation","eventdescription","eventtype","eventpeople","eventsubject","eventorganizer","eventimagesource","eventimagecopyright","eventphotocredit","eventbampfacaption","eventrestrictions","eventtagarray","eventuploader","filmbampfacaption","filmcontrib","filmuploader","filmdescription","filmseries","filmrights","filmpeople","filmtype","filmtagarray","filmrestrictions","exhcreditline","exhmedium","exhbampfacaption","exhcurator","exhsource","exhyearofexh","exhuploader","exhdescription","exhnameofexh","exhcopyright","exhartworktitle","exhimagetype","exhlocation","exhfulldates","exhphotocredit","exhtagarray","exhrestrictions","exhrights");

// get the category for the FTP destination and metadata.csv creation
$category = $_POST['category'];
echo "<div><b>".$category."</b></div>";
$ftpDir = "zz_hothothotfolders\\" . $category;

//  ------  GET TEMP FILES -------------
foreach($_FILES['file']['tmp_name'] as $key => $tmp_name ){
    $file_name = $_FILES['file']['name'][$key];
    $file_tmp = $_FILES['file']['tmp_name'][$key];
    $basename = basename($file_name);

    // sniff the file MIME type for use in accepting/rejecting a file
    $file_mime = mime_content_type($file_tmp);
    $good_mimes_bro = array('image/tiff','image/jpeg','image/png','image/gif');
    if (in_array($file_mime, $good_mimes_bro)){
        // ----- ASSIGN METADATA VALUES ----------
        $filepath =  "K:\\ftp_ucbcspace\\BAMPFA\\" . $ftpDir . "\\" . $basename;
        foreach($metadataFieldNames as $field){
            // SET EMPTY $_POST VALUES TO EMPTY STRING OR ARRAY
            if (!isset($_POST[$field])){
                if (strpos($field, 'array')){
                    $$field = array('');
                } else {
                $$field = '';                       
                }
            } else {
                $$field = $_POST[$field];
            }
        }
        
        // squash the category tag arrays into a string with semicolon separated values
        if (isset($eventtagarray[0])){
            $eventtags = implode(";", $eventtagarray);      
        }
        if (isset($filmtagarray[0])){
            $filmtags = implode(";", $filmtagarray); 
        }
        if (isset($exhtagarray[0])){
            $exhtags = implode(";", $exhtagarray);      
        }

        // add a row for each file to the metadata value array
        array_push($METADATA_VALUES,"$filepath|$bampfatitle|$bampfaartist|$bampfayear|$eventfulldate|$eventseries|$eventrelatedex|$eventlocation|$eventdescription|$eventtype|$eventpeople|$eventsubject|$eventorganizer|$eventimagesource|$eventimagecopyright|$eventphotocredit|$eventtags|$eventbampfacaption|$eventrestrictions|$eventuploader|$filmbampfacaption|$filmcontrib|$filmuploader|$filmdescription|$filmseries|$filmrights|$filmpeople|$filmtype|$filmrestrictions|$filmtags|$exhcreditline|$exhmedium|$exhbampfacaption|$exhcurator|$exhsource|$exhyearofexh|$exhuploader|$exhdescription|$exhnameofexh|$exhcopyright|$exhartworktitle|$exhimagetype|$exhlocation|$exhfulldates|$exhphotocredit|$exhrestrictions|$exhtags|$exhrights");
        //  ------- END ASSIGN METADATA VALUES ----
        //
        //  ------- FTP THE FILE ---------
        ftpFile($file_tmp,$ftpDir,$basename);

    } else {
        echo "YOU TRIED TO UPLOAD A FILE (" . $basename . ") THAT IS NOT RECOGNIZED AS AN IMAGE. EITHER TRY AGAIN, OR YOU ARE A HACKER, SO GO AWAY.<br/>";
    }
}

// the output csv is stored locally, so that people working throughout the day can add to it before it gets uploaded to Piction
// 
date_default_timezone_set('America/Los_Angeles');
$today = date('Y-m-d');
$metaCSVname = getcwd() . "/uploads/" . $today . "_" . $category . "_metadata.csv";

// -------- IF METADATA CSV ALREADY EXISTS, APPEND TO IT, OTHERWISE CREATE IT 
if (file_exists($metaCSVname)){
    $metadataArray = array($METADATA_VALUES);
    print_r($metadataArray);
    $file = fopen($metaCSVname,"a+");
    foreach ($metadataArray as $line){
        fputcsv($file,explode(',',$line));
    }
    fclose($file);
} else{
    // ADD HEADERS AS FIRST ELEMENT IN VALUE ARRAY IF THE FILE DOESN'T EXIST YET
    array_unshift($METADATA_VALUES, $HEADERS);
    $file = fopen($metaCSVname,"a+");
    foreach ($METADATA_VALUES as $row) {
        echo $row;
        fputcsv($file,explode('|',$row));
    }
    fclose($file);
}

// FTP the new or updated metadata.csv
ftpFile($metaCSVname,$ftpDir,"metadata.csv");

?>
