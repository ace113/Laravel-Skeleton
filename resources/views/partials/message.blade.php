@if ($message = Session::get('success'))
    <div style="padding: 1rem 0;">
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <span class="fa fa-info-circle"> Success! </span> {{ $message }}
        </div>
    </div>   
@endif

@if ($message = session::get('status'))
    <div style="padding: 1rem 0;">
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <span class="fa fa-info-circle"> Success! </span> {{ $message }}
        </div>
    </div>   
@endif

@if ($message = Session::get('error'))
    <div style="padding: 1rem 0;">
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <span class="fa fa-info-circle"> Error! </span> {{ $message }}
        </div>
    </div>    
@endif

@if ($message = Session::get('warning'))
    <div style="padding: 1rem 0;">
        <div class="alert alert-warning alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <span class="fa fa-info-circle"> Warning! </span> {{ $message }}
        </div>
    </div>    
@endif

@if ($message = Session::get('info'))
    <div style="padding: 1rem 0;">
        <div class="alert alert-info alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <span class="fa fa-info-circle"> Info! </span> {{ $message }}
        </div>
    </div>    
@endif