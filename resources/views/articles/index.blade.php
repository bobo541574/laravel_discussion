@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center my-1">
        <div class="col-md-3">
            @include('layouts.left')
        </div>
        <div class="col-md-6">
            @include('layouts.article')
        </div>
        <div class="col-md-3">
            @include('layouts.right')
        </div>
    </div>
</div>
    
@endsection

@push('script')
    <script type="text/javascript">

        function readMore(article) { 
            let id = article.id;
            let content = article.body;
            let read_more = "";
            read_more += `${content}`;
            $(".card #read_more_"+id).html(read_more);
        }

         // $.getJSON('https://get.geojs.io/v1/ip/geo.json', function(data) {
             //     // let client_info = JSON.stringify(data, null, 2);
             //     console.log(JSON.stringify(data, null, 2));
             // });
    </script>
@endpush

