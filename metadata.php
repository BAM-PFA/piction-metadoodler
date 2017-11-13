<?php
echo "<html><body>STARTING";

include 'ftp.php';

$targetdir = '/Users/michael/Sites/pictionHelper/uploads/';
echo $_POST['tagarray'];
echo $_FILES;
echo "<pre>"; 
 print_r($_POST); 
echo "/<pre>"; 

$METADATA = "FILENAME,BAMPFA.TITLE,BAMPFA.ARTIST,BAMPFA.YEAR,EVENTS.DC-COVERAGE,EVENTS.DC-PUBLISHER,EVENTS.RELATED_EXHIBITIONS,EVENTS.EVENT_LOCATION,EVENTS.DC-DESCRIPTION,EVENTS.DC-TYPE,EVENTS.DC-SUBJECT,EVENTS.TOPICAL_SUBJECT,EVENTS.ORGANIZER,EVENTS.DC-CONTRIBUTOR,EVENTS.DC-RIGHTS,EVENTS.DC-AUTHOR,EVENTS.TAGS,EVENTS.BAM_PFA_CAPTION,EVENTS.RESTRICTIONS,EVENTS.DC-CREATOR,FILM.BAM_PFA_CAPTION,FILM.DC-CONTRIBUTOR,FILM.DC-CREATOR,FILM.DC-DESCRIPTION,FILM.DC-PUBLISHER,FILM.DC-RIGHTS,FILM.DC-SUBJECT,FILM.DC-TYPE,FILM.RESTRICTIONS,FILM.TAGS,GALLERY EXHIBITION.ARTWORK_CREDIT_LINE,GALLERY EXHIBITION.ARTWORK_MEDIUM,GALLERY EXHIBITION.BAM_PFA_CAPTION,GALLERY EXHIBITION.CURATOR,GALLERY EXHIBITION.DC-CONTRIBUTOR,GALLERY EXHIBITION.DC-COVERAGE,GALLERY EXHIBITION.DC-CREATOR,GALLERY EXHIBITION.DC-DESCRIPTION,GALLERY EXHIBITION.DC-PUBLISHER,GALLERY EXHIBITION.DC-RIGHTS,GALLERY EXHIBITION.DC-TITLE,GALLERY EXHIBITION.DC-TYPE,GALLERY EXHIBITION.EXHIBITION LOCATION,GALLERY EXHIBITION.FULL_EXHIBIT_DATE,GALLERY EXHIBITION.PHOTO_CREDIT,GALLERY EXHIBITION.RESTRICTIONS,GALLERY EXHIBITION.TAGS\n";
$metadataFields = array("bampfatitle","bampfaartist","bampfayear","eventfulldate","eventseries","eventrelatedex","eventlocation","eventdescription","eventtype","eventpeople","eventsubject","eventorganizer","eventimagesource","eventimagecopyright","eventphotocredit","eventbampfacaption","eventrestrictions","eventtagarray","eventuploader","filmbampfacaption","filmcontrib","filmuploader","filmdescription","filmseries","filmrights","filmpeople","filmtype","filmtagarray","filmrestrictions","exhcreditline","exhmedium","exhcaption","exhcurator","exhsource","exhyearofexh","exhuploader","exhdescription","exhnameofexh","exhcopyright","exhartworktitle","exhimagetype","exhlocation","exhfulldates","exhphotocredit","exhtagarray","exhrestrictions");
$category = $_POST['category'];
$ftpDir = "K:\\ftp_ucbcspace\BAMPFA\\zz_hothothotfolders\\" . $category . "\\";
echo "<div> THIS IS POST: ".getcwd()."</div>";

//  ------  MOVE FILES -------------
foreach($_FILES['file']['tmp_name'] as $key => $tmp_name ){
    $file_name = $_FILES['file']['name'][$key];
    // $file_name = preg_replace('/\s+/', '_', $file_name);
    $file_tmp = $_FILES['file']['tmp_name'][$key];
    $basename = basename($file_name);
    echo $file_name;
    // ----- GENERATE CSV VALUES ----------
    $filepath =  $ftpDir . $basename;
    echo $filepath;
    foreach($metadataFields as $field){
        if (!isset($_POST[$field])){
            $$field = "";
            if (strpos($$field, 'array')){
                $$field = array();
            }
        }
        else $field = $_POST[$field];

    }
    
    $eventtags = implode(";", $eventtagarray);    
    $filmtags = implode(";", $filmtagarray);
    $exhtags = implode(";", $exhtagarray);

    $METADATA .= "$filepath,$bampfatitle,$bampfaartist,$bampfayear,$eventfulldate,$eventseries,$eventrelatedex,$eventlocation,$eventdescription,$eventtype,$eventpeople,$eventsubject,$eventorganizer,$eventimagesource,$eventimagecopyright,$eventphotocredit,$eventtags,$eventbampfacaption,$eventrestrictions,$eventuploader,$filmbampfacaption,$filmcontrib,$filmuploader,$filmdescription,$filmseries,$filmrights,$filmpeople,$filmtype,$filmrestrictions,$filmtags,$exhcreditline,$exhmedium,$exhcaption,$exhcurator,$exhsource,$exhyearofexh,$exhuploader,$exhdescription,$exhnameofexh,$exhcopyright,$exhartworktitle,$exhimagetype,$exhlocation,$exhfulldates,$exhphotocredit,$exhrestrictions,$exhtags\n";

    ftpFile($file_tmp,$ftpDir,$basename);

}

$metaCSVname = "/Users/michael/Sites/pictionHelper/uploads/metadata.csv";
file_put_contents($metaCSVname, $METADATA);
ftpFile($metaCSVname,$ftpDir,"metadata.csv");

?>
