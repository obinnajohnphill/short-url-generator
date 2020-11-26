<?php
require('../models/ShortURL.php');
$data = new ShortURL(new Database());
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Short URL Generator</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a href="#" class="navbar-brand">Short URL Generator</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>

<div class="container">
    <div class="jumbotron">
        <h6>Application to convert long URL into a short version</h6><br/>
        <h6>Click on the short url link to redirect url or click on 'Del' button to delete url</h6><br/>
    </div>
    <div class="row">
        <div class="col-sm-6" style="background-color:lavender;">
            <h3>Person 1 Calendar</h3><br/><br/>
            <form action="/action" method="post">
                <div class="form-group">
                    <label for="long_url">Select a appointment:</label>
                    <input name="long_url" id="long_url" class="form-control" placeholder="Enter a long URL">
                </div><br/>
                <button type="submit" class="btn btn-primary">Submit</button><br/><br/>
            </form>
        </div>

        <div class="col-sm-6" style="background-color:lavenderblush;">
            <h3>Short URL Generated</h3><br/>
            <?php
              if (!empty($data->getUrlFromDB())){
            ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Long URL</th>
                    <th>Short URL</th>
                    <th>Short URL Hits</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($data->getUrlFromDB() as $url) {
                        echo "<tr>
                        <td>" . $url['long_url'] . "</td>
                        <td><a href='/redirect?code=" . $url['short_url'] . "'>" . $url['short_url'] . "</a></td>
                         <td>" .$url['hits']. "</td>
                         <td><a href='/delete?code=" . $url['short_url'] . "'><button style='background-color: red; color:white'>Del</button></a></td>
                    </tr>";
                    }
                    }else {
                        echo "<tr>You have not yet generated any short URL</tr>";
                    }
                ?>
                </form>
                </tbody>
            </table>
            <br/>
        </div>
    </div>
</div>

</body>
</html>


