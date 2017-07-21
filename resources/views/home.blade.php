@extends('layouts.app')

@section('content')
@if (Session::has('flash_notification.message'))
    <div class="alert alert-{{ Session::get('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        {{ Session::get('success') }}
    </div>
@endif

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('sending') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="col-md-4 control-label">Subject</label>

                            <div class="col-md-6">
                                <input id="subject" type="subject" class="form-control" name="subject" value="{{ old('subject') }}" required autofocus>

                                @if ($errors->has('subject'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('subject') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                            <label for="body" class="col-md-4 control-label">Message</label>

                            <div class="col-md-6">
                                <textarea name="body" class="form-control" required>
                                    This is my test.
                                </textarea>

                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">File</label>

                            <div class="col-md-6">
                                <label for="file" class="btn btn-success">Choose File</label><br>
                                <input id="file" style="display: none" type="file" class="form-control"required><br>
                                <div id="render"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
        $(document).ready(function(event) {

          $("input#file").on('change',function(event){ 
              var data = this;
              var image_holder = $("#render");   
              return imageCircle(data,image_holder);
              
          });
          
          // image live time showing function  
          function imageCircle(data,image_holder){
            
            var imgPath = data.value;
            var countFiles = data.files.length;   
            var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
            var file_name = data.files[0].name;
            if (typeof(FileReader) != "undefined") {
                  //loop for each file selected for uploaded.
                  for (var i = 0; i < countFiles; i++)
                  {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                      var img = e.target.result;          
                      $("<img />", {
                        "src": e.target.result,
                        "style":"padding:5px;height:80px;width:80px"               
                      }).appendTo(image_holder);
                      $('<input type="hidden" name="files[]" value="'+img+'">').appendTo(image_holder);
                    }
                    image_holder.show(); 
                    reader.readAsDataURL(data.files[i]);
                  }
                } else {
                alert("This browser does not support FileReader.");
                }
            }
        });
    </script> 
@endsection
