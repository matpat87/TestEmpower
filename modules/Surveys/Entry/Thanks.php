<?php

$surveyName = !empty($_REQUEST['name']) ? $_REQUEST['name'] : 'Survey';
// APX Custom Codes: OnTrack #1634 Survey Module -- START
$themeObject = SugarThemeRegistry::current();
$companyLogoURL = $themeObject->getImageURL('company_logo.png');
// APX Custom Codes: OnTrack #1634 Survey Module -- END

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?= $surveyName; ?>
        <?=
        // APX Custom Codes: Added Survey Preview Mode -- START
        (isset($_REQUEST['preview_mode']))
            ? "[PREVIEW MODE]"
            : ""
        // APX Custom Codes: Added Survey Preview Mode -- END
        ?>
    </title>

    <link href="themes/SuiteP/css/bootstrap.min.css" rel="stylesheet">
    <link href="custom/include/javascript/rating/rating.min.css" rel="stylesheet">
    <link href="custom/include/javascript/datetimepicker/jquery-ui-timepicker-addon.css" rel="stylesheet">
    <link href="include/javascript/jquery/themes/base/jquery.ui.all.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <!-- APX Custom Codes: OnTrack #1634 Survey Module -- START -->
    <div class="row">
        <div class="col-md-12 text-center">
            <img style="height: 300px; width: 100%; object-fit: contain; margin-left: -20px;" src="<?php echo $companyLogoURL ?>"/>
        </div>
    </div>
    <!-- APX Custom Codes: OnTrack #1634 Survey Module -- END -->
    <div class="row well">
        <div class="col-md-offset-2 col-md-8">
            <h1><?= $surveyName; ?></h1>
            <!-- APX Custom Codes: Added Survey Preview Mode -- START -->
            <?= (isset($_REQUEST['preview_mode']))
                ? "<div class='alert alert-danger' role='alert'>
                        <h5 class='alert-heading' style='margin: 0;'>THIS SURVEY IS CURRENTLY IN PREVIEW MODE. ANY FORM SUBMISSIONS WILL NOT BE SAVED.</h5>
                       </div>"
                : ""
            ?>
            <!-- APX Custom Codes: Added Survey Preview Mode -- END -->
            <h5>Thanks for completing this survey.</h5>
        </div>
    </div>
</div>
<script src="include/javascript/jquery/jquery-min.js"></script>
<script src="include/javascript/jquery/jquery-ui-min.js"></script>
</body>
</html>