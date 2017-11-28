<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css">

        <!-- Styles -->
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="page-header">
                    <h1>
                        <a href="{{ url('/') }}">Ductn Mozenda</a>
                    </h1>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Danh sách file excel trên máy chủ</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-hover table-striped table-condensed">
                                <tr>
                                    <th>File name</th>
                                    <th style="text-align: right;">Size</th>
                                    <th>Last Modified</th>
                                    <th>Action</th>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <a href="">
                                            abc
                                        </a>
                                    </td>
                                    <td style="text-align: right;">
                                        <small style="color: #666666;">
                                            abc
                                        </small>
                                    </td>
                                    <td>
                                        <small style="color: #666666;">
                                            abc
                                        </small>
                                    </td>
                                    <td>
                                        <form action="#" method="post">
                                            <input type="hidden" name="file" value="test">
                                            <button type="submit" name="download" value="1" class="btn btn-success btn-xs">
                                                <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
                                            </button>
                                            <button type="submit" name="delete" value="1" class="btn btn-danger btn-xs">
                                                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <form class="panel panel-info" method="post" action="" enctype="multipart/form-data">
                        <div class="panel-heading">
                            <label class="panel-title" for="exampleInputFile">Tải lên:</label>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <input type="file" id="fileToUpload" name="fileToUpload">
                                <p class="help-block">Chọn file excel để tải lên.</p>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" name="fileUploaded" value="ok" class="btn btn-default">Tải lên</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
</html>
